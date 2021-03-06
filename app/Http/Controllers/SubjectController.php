<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Repositories\SubjectRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;
use App\Models\Subject;
use DB;
use Alert;

class SubjectController extends AppBaseController
{
    /** @var  SubjectRepository */
    private $subjectRepository;

    public function __construct(SubjectRepository $subjectRepo)
    {
        $this->subjectRepository = $subjectRepo;
    }

    /**
     * Display a listing of the Subject.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $subjects = $this->subjectRepository->all();

        return view('subjects.index')
            ->with('subjects', $subjects);
    }

    /**
     * Show the form for creating a new Subject.
     *
     * @return Response
     */
    public function create()
    {
        return view('subjects.create');
    }

    /**
     * Store a newly created Subject in storage.
     *
     * @param CreateSubjectRequest $request
     *
     * @return Response
     */
    public function store(CreateSubjectRequest $request)
    {
        $input = $request->all();
        $input['slug'] = str_replace(' ', '-', $input['title']);
        $input['slug'] = preg_replace("/\s+/", "",strtolower($input['slug']) );   
        $input['created_by']=auth()->user()->id;
        // dd($input);
        $subject = $this->subjectRepository->create($input);

        Alert::success('Subject saved successfully.');

        return redirect(route('subjects.index'));
    }

    /**
     * Display the specified Subject.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $subject = $this->subjectRepository->find($id);

        if (empty($subject)) {
            Flash::error('Subject not found');

            return redirect(route('subjects.index'));
        }

        return view('subjects.show')->with('subject', $subject);
    }

    /**
     * Show the form for editing the specified Subject.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $subject = $this->subjectRepository->find($id);

        if (empty($subject)) {
            Flash::error('Subject not found');

            return redirect(route('subjects.index'));
        }

        return view('subjects.edit')->with('subject', $subject);
    }

    /**
     * Update the specified Subject in storage.
     *
     * @param int $id
     * @param UpdateSubjectRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSubjectRequest $request)
    {
        
        $input = $request->all();
        // dd($input);
        $subject = $this->subjectRepository->find($id);
        $validator_title = Subject::where('title',$input['title'])->first(); 
        if (empty($subject)) {
            Flash::error('Subject not found');
    
            return redirect(route('subjects.index'));
        }
        if($validator_title['id'] == $id){
            $input['slug'] = str_replace(' ', '-', $input['title']);
            $input['slug'] = preg_replace("/\s+/", "",strtolower($input['slug']) );   
            $input['created_by']=auth()->user()->id;
            $subject = $this->subjectRepository->update($input, $id);
        }else{
            $validated = $request->validate([
                'title' => 'unique:subjects,title'
            ]);
        }

        Alert::success('Subject updated successfully.');

        return redirect(route('subjects.index'));
    }

    /**
     * Remove the specified Subject from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $subject = $this->subjectRepository->find($id);

        if (empty($subject)) {
            Flash::error('Subject not found');

            return redirect(route('subjects.index'));
        }

        $this->subjectRepository->delete($id);
        Alert::success('Berhasil', 'Data Berhasil dihapus');

        // Alert::success('Subject deleted successfully.');

        return redirect(route('subjects.index'));
    }
}
