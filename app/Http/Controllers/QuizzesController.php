<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateQuizzesRequest;
use App\Http\Requests\UpdateQuizzesRequest;
use App\Repositories\QuizzesRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use App\Repositories\TeachableRepository;
use App\Repositories\ClassroomRepository;
use DB;

class QuizzesController extends AppBaseController
{
    /** @var  QuizzesRepository */
    private $quizzesRepository;

    public function __construct(QuizzesRepository $quizzesRepo,TeachableRepository $teachableRepo,ClassroomRepository $classroomRepo)
    {
        $this->classroomRepository = $classroomRepo;
        $this->teachableRepository = $teachableRepo;
        $this->quizzesRepository = $quizzesRepo;
    }

    /**
     * Display a listing of the Quizzes.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $quizzes = $this->quizzesRepository->all();
        return view('quizzes.index')
            ->with('quizzes', $quizzes);
    }

    /**
     * Show the form for creating a new Quizzes.
     *
     * @return Response
     */
    public function create()
    {
        $classrooms = $this->classroomRepository->all();

        return view('quizzes.create')->with('classrooms', $classrooms);
    }

    /**
     * Store a newly created Quizzes in storage.
     *
     * @param CreateQuizzesRequest $request
     *
     * @return Response
     */
    public function store(CreateQuizzesRequest $request)
    {
        $input = $request->all();
        // dd($input);
        $created_by = auth()->user()->id;
        $input['grading_method'] = "standard";
        $input['created_by'] = $created_by;
        $quizzes = $this->quizzesRepository->create($input);
        // $data;
        foreach($input['id'] as $value ){
            $data['classroom_id'] = $value;
            $data['teachable_type'] = 'quiz';
            $data['teachable_id'] = $quizzes['id'];
            $data['created_by'] = $created_by;
            $data['final_grade_weight'] = 0;
            $data['max_attempts_count'] = $input['max_attempts_count'];
            $data['order'] = 1;
            $data['pass_threshold'] = $input['pass_threshold'];
            $data['available_at'] = $input['available_at'];
            $data['expires_at'] = $input['expires_at'];

            $teachable = $this->teachableRepository->create($data);
        }
        
        // dd($data);
        Flash::success('Quizzes saved successfully.');

        return redirect(route('quizzes.index'));
    }

    /**
     * Display the specified Quizzes.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $quizzes = $this->quizzesRepository->find($id);

        if (empty($quizzes)) {
            Flash::error('Quizzes not found');

            return redirect(route('quizzes.index'));
        }

        return view('quizzes.show')->with('quizzes', $quizzes);
    }

    /**
     * Show the form for editing the specified Quizzes.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $quizzes = $this->quizzesRepository->find($id);
        $classrooms = $this->classroomRepository->all();
        $teachable = DB::table('teachables')->where('teachable_id',$id)->where('teachable_type','quiz')->select('teachables.*')->first();
        // dd($teachable);
        if (empty($quizzes)) {
            Flash::error('Quizzes not found');

            return redirect(route('quizzes.index'));
        }

        return view('quizzes.edit')->with('quizzes', $quizzes)->with('classrooms', $classrooms)->with('teachable',$teachable);
    }

    /**
     * Update the specified Quizzes in storage.
     *
     * @param int $id
     * @param UpdateQuizzesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateQuizzesRequest $request)
    {
        $quizzes = $this->quizzesRepository->find($id);
        $input = $request->all();
        dd($input);
        if (empty($quizzes)) {
            Flash::error('Quizzes not found');

            return redirect(route('quizzes.index'));
        }

        $quizzes = $this->quizzesRepository->update($request->all(), $id);

        Flash::success('Quizzes updated successfully.');

        return redirect(route('quizzes.index'));
    }

    /**
     * Remove the specified Quizzes from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $quizzes = $this->quizzesRepository->find($id);

        if (empty($quizzes)) {
            Flash::error('Quizzes not found');

            return redirect(route('quizzes.index'));
        }

        $this->quizzesRepository->delete($id);

        Flash::success('Quizzes deleted successfully.');

        return redirect(route('quizzes.index'));
    }
}
