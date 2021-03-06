<?php

namespace App\Http\Controllers\Frontend;
 
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response; 
use DB;
use \stdClass;
use Alert;
use App\Repositories\ClassroomRepository;
use App\Repositories\ClassroomUserRepository;
use App\Models\Media;
use App\Models\ClassroomUser;
use App\Models\Profile;
use App\Repositories\UserStudentRepository;
use App\Repositories\ProfileRepository;

class UserController extends AppBaseController
{   
     /** @var  ClassroomRepository */
    private $classroomRepository;
    /** @var  ClassroomUserRepository */
    private $classroomUserRepository;

    public function __construct(
        UserStudentRepository $userStudentRepo,
        ClassroomUserRepository $classroomUserRepo, 
        ProfileRepository $profileRepo,
        ClassroomRepository $classroomRepo
        )
    {
        $this->classroomRepository = $classroomRepo;
        $this->classroomUserRepository = $classroomUserRepo;
        $this->profileRepository = $profileRepo;
        $this->userStudentRepository = $userStudentRepo;
        // $this->middleware('auth');
    }

    /**
     * Display a listing of the Question.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index($slug)
    {
        $classroom = DB::table('classrooms')
                    ->select('*')
                    ->where('slug',$slug)
                    ->where('deleted_at',null)
                    ->first();

        $classroomUser = DB::table('classroom_user')
                    ->join('classrooms', 'classrooms.id', '=', 'classroom_user.classroom_id')
                    ->join('users', 'users.id', '=', 'classroom_user.user_id')
                    ->select('users.name','users.email','users.id')
                    ->where('classrooms.id',$classroom->id)
                    ->get();

        return view('frontend.owner.users.index')
                ->with('classroom', $classroom)
                ->with('classroomUser', $classroomUser);
    }
    
    public function avatar_upload(Request $request)
    { 

        $input = $request->all();
        $user_id = 2;
        $files = $request->file('file');

        $collection_name = $request->file('file')->extension();

        $input['type']   = 'image';

        $fileName = $files->getClientOriginalName();
        $name = pathinfo($fileName, PATHINFO_FILENAME);

        $data['name'] = $name;
        $data['file_name'] = $fileName;
        $data['disk'] = 'public';
        $data['collection_name'] = $collection_name;
        $data['order_column'] = '1';
        $data['media_type'] = 'user';
        $data['size'] = $files->getSize();

        $data['media_id'] =auth()->user()->id;
        $data['custom_properties'] = json_encode(array('user' => auth()->user()->id));

        Media::create($data);
        $files->move('files',$files->getClientOriginalName());

        return Response::json($data);

    }

    public function store(Request $request, $slug)
    {
        date_default_timezone_set("Asia/Makassar");

        $input = $request->all(); 
        $classroom = DB::table('classrooms')
                    ->select('*')
                    ->where('slug',$slug)
                    ->where('deleted_at',null)
                    ->first();
        
        $input['classroom_id'] = $classroom->id;
        $input['last_accesed_at'] = date('Y-m-d H:i:s');
        $classroomUser = DB::table('classroom_user') 
                    ->select('*')
                    ->where('classroom_user.classroom_id',$input['classroom_id'])
                    ->where('classroom_user.user_id',$input['user_id'])
                    ->where('classroom_user.deleted_at',null)
                    ->first();
        if($classroomUser != null){
            Alert::error('Pengajar telah terdaftar sebelumnya.');
        }else{
            ClassroomUser::create($input);
            DB::table('model_has_roles')
            ->where('model_id', $input['user_id'])
            ->update(['role_id' => 3]);
            Alert::success('Pengajar berhasil ditambahkan.');
        }

        return redirect()->route('classroom.detail', $slug); 
    }

    public function destroy($slug,$id)
    {
        $classroom = DB::table('classrooms')
                    ->select('*')
                    ->where('slug',$slug)
                    ->where('deleted_at',null)
                    ->first();

        $classroomUser = DB::table('classroom_user')
                    ->join('classrooms', 'classrooms.id', '=', 'classroom_user.classroom_id')
                    ->join('users', 'users.id', '=', 'classroom_user.user_id')
                    ->select('classroom_user.*')
                    ->where('classroom_user.classroom_id',$classroom->id)
                    ->where('classroom_user.user_id',$id)
                    ->where('classroom_user.deleted_at',null)
                    ->first();
        ClassroomUser::destroy($classroomUser->id);
        Alert::success('Pengajar berhasil dihapus.');

        return redirect()->route('classroom.detail', $slug); 

    }

    public function updateProfile(Request $request, $id)
    {
        $validated = $request->validate([ 
            'email' => "required|unique:users,email,$id",
            'name' => "required|unique:users,name,$id",
        ]);

        $data = $request->all();
        $data['user_id'] = $id; 
        $userStudent = $this->userStudentRepository->find($id); 

        $profile = $this->profileRepository->allQuery(['user_id'=> $id])->first(); 

        if($data['password'] == null){
            $data['password'] = $userStudent['password'];
        }
        else{
            $data['password'] = Hash::make($data['password']);
        }

        if (empty($userStudent)) {
            Flash::error('User Student not found');

            return redirect(route('userStudents.index'));
        }

        if(is_null($profile)){
            $validated = $request->validate([
                'phone_number' => "unique:profiles,phone_number|regex:/^([0-9\s\-\+\(\)]*)$/|min:10",
            ]);
            Profile::create($data);
        }else{
            $validated = $request->validate([
                'phone_number' => "required|unique:profiles,phone_number,$profile->id|regex:/^([0-9\s\-\+\(\)]*)$/|min:10",
            ]);
            $profile = $this->profileRepository->update($data, $profile['id']);
        }

        $userStudent = $this->userStudentRepository->update($data, $id);
        Alert::success('User Student updated successfully.');
        return back();
    }
}
