<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('flashcard', [App\Http\Controllers\Frontend\FlashcardCategoriesController::class, 'index'])->name('flashcard.index');

Route::resource('flashcard-categories', App\Http\Controllers\Frontend\FlashcardCategoriesController::class);
Route::get('flashcard-selected/{id}', [App\Http\Controllers\Frontend\FlashcardCategoriesController::class, 'selected'])->name('flashcard.selected');
Route::post('flashcard-selected-count', [App\Http\Controllers\Frontend\FlashcardCategoriesController::class, 'selected_count'])->name('flashcard.selected.count');
 
Route::get('flashcard-second-categories/{id}', [App\Http\Controllers\Frontend\FlashcardCategoriesController::class, 'second_categories'])->name('flashcard.second.categories');
Route::get('flashcard-third-categories/{id}', [App\Http\Controllers\Frontend\FlashcardCategoriesController::class, 'third_categories'])->name('flashcard.third.categories');
Route::get('flashcard-fourth-categories/{id}', [App\Http\Controllers\Frontend\FlashcardCategoriesController::class, 'fourth_categories'])->name('flashcard.fourth.categories');

Route::get('flashcard-second-categories-answer/{id}', [App\Http\Controllers\Frontend\FlashcardCategoriesController::class, 'second_categories_answer'])->name('flashcard.second.categories.answer');
Route::get('flashcard-third-categories-answer/{id}', [App\Http\Controllers\Frontend\FlashcardCategoriesController::class, 'third_categories_answer'])->name('flashcard.third.categories.answer');
Route::get('flashcard-fourth-categories-answer/{id}', [App\Http\Controllers\Frontend\FlashcardCategoriesController::class, 'fourth_categories_answer'])->name('flashcard.fourth.categories.answer');

Route::post('flashcard-selected-answer-count', [App\Http\Controllers\Frontend\FlashcardCategoriesController::class, 'selected_answer_count'])->name('flashcard.selected.answer.count');

Route::get('flashcard-unselected/{id}', [App\Http\Controllers\Frontend\FlashcardCategoriesController::class, 'unselected'])->name('flashcard.unselected');

Route::resource('flashcard-question', App\Http\Controllers\Frontend\FlashcardQuestionController::class);

Route::post('flashcard-start', [App\Http\Controllers\Frontend\FlashcardQuestionController::class, 'start'])->name('flashcard.start');
// Route::get('flashcard-start', [App\Http\Controllers\Frontend\FlashcardQuestionController::class, 'start'])->name('flashcard.start.get');
Route::get('flashcard-question/{id}', [App\Http\Controllers\Frontend\FlashcardQuestionController::class, 'show'])->name('flashcard.start.show');

Route::get('flashcard-subject/{id}', [App\Http\Controllers\Frontend\FlashcardSubjectController::class, 'index'])->name('flashcard.subject.all');
Route::get('flashcard-subject-single/{id}', [App\Http\Controllers\Frontend\FlashcardSubjectController::class, 'show'])->name('flashcard.subject.single');

Route::post('flashcard-answer', [App\Http\Controllers\Frontend\FlashcardAnswerController::class, 'store'])->name('flashcard.answer.store');

Route::post('/class-detail/banner/{slug}', [App\Http\Controllers\Frontend\UploadController::class, 'banner'])->name('classroom.detail.banner');

Route::get('/flashcard-categories-json/{id}', [App\Http\Controllers\Frontend\FlashcardCategoriesController::class, 'json'])->name('flashcard.categories.json');


Route::group(['middleware' => ['role:student|teacher|owner']], function () {

    // bookmark
    Route::post('add-boomark', [App\Http\Controllers\Frontend\BookmarkController::class, 'store'])->name('add_boomark');
    Route::post('remove-boomark', [App\Http\Controllers\Frontend\BookmarkController::class, 'destroy'])->name('remove_boomark');

    Route::post('/submit-quiz', [App\Http\Controllers\Frontend\QuizController::class, 'submitQuiz'])->name('submitQuiz');
    Route::get('all-quiz/{slug}/{id}', [App\Http\Controllers\Frontend\QuezzesController::class, 'index'])->name('allquiz');

    // upload avatar
    Route::post('avatar-upload', [App\Http\Controllers\Frontend\UserController::class, 'avatar_upload'])->name('avatar_upload');
    // update profile
    Route::post('update-profile/{id}', [App\Http\Controllers\Frontend\UserController::class,'updateProfile'])->name('updateProfile');

    // teacher assignment
    Route::get('create-assignment/{slug}', [App\Http\Controllers\Frontend\AssignmentController::class, 'create'])->name('createAssignment');
    Route::post('store-assignment', [App\Http\Controllers\Frontend\AssignmentController::class, 'store'])->name('storeAssignment');
    Route::get('edit-assignment/{slug}/{id}', [App\Http\Controllers\Frontend\AssignmentController::class, 'edit'])->name('editAssignment');
    Route::post('update-assignment/{id}', [App\Http\Controllers\Frontend\AssignmentController::class, 'update'])->name('updateAssignment');
    Route::get('destroy-assignment/{id}', [App\Http\Controllers\Frontend\AssignmentController::class, 'destroy'])->name('destroyAssignment');

    //assignment teacher
    Route::get('all-assignment/{slug}/{id}', [App\Http\Controllers\Frontend\AssignmentController::class, 'index'])->name('allAssignment');
    Route::post('store-grade/{slug}', [App\Http\Controllers\Frontend\AssignmentController::class, 'gradeStore'])->name('gradeStore');

    //teacher resources
    Route::get('create-resources/{slug}', [App\Http\Controllers\Frontend\ResourcesController::class, 'create'])->name('createResources');
    Route::post('store-resources', [App\Http\Controllers\Frontend\ResourcesController::class, 'store'])->name('storeResources');
    Route::get('edit-resources/{slug}/{id}', [App\Http\Controllers\Frontend\ResourcesController::class, 'edit'])->name('editResources');
    Route::post('update-resources/{id}', [App\Http\Controllers\Frontend\ResourcesController::class, 'update'])->name('updateResources');
    Route::get('destroy-resources/{id}', [App\Http\Controllers\Frontend\ResourcesController::class, 'destroy'])->name('destroyResources');

    //teacher Quezzes
    Route::get('create-quezzes/{slug}', [App\Http\Controllers\Frontend\QuezzesController::class, 'create'])->name('createQuezzes');
    Route::post('store-quezzes', [App\Http\Controllers\Frontend\QuezzesController::class, 'store'])->name('storeQuezzes');
    Route::get('edit-quezzes/{slug}/{id}', [App\Http\Controllers\Frontend\QuezzesController::class, 'edit'])->name('editQuezzes');
    Route::post('update-quezzes/{id}', [App\Http\Controllers\Frontend\QuezzesController::class, 'update'])->name('updateQuezzes');
    Route::get('destroy-quezzes/{id}', [App\Http\Controllers\Frontend\QuezzesController::class, 'destroy'])->name('destroyQuezzes');

    //teacher Question
    Route::get('create-question/{slug}/{id}', [App\Http\Controllers\Frontend\QuestionController::class, 'create'])->name('createQuestion');
    Route::post('store-question/{slug}/{id}', [App\Http\Controllers\Frontend\QuestionController::class, 'store'])->name('storeQuestion');
    Route::get('edit-question/{slugClass}/{slugQuiz}/{id}', [App\Http\Controllers\Frontend\QuestionController::class, 'edit'])->name('editQuestion');
    Route::post('update-question/{slug}/{id}', [App\Http\Controllers\Frontend\QuestionController::class, 'update'])->name('updateQuestion');
    Route::get('destroy-question/{slug}/{quiz_id}/{id}', [App\Http\Controllers\Frontend\QuestionController::class, 'destroy'])->name('destroyQuestion');
    Route::get('quiz/all-question/{slug}/{id}', [App\Http\Controllers\Frontend\QuestionController::class, 'index'])->name('showAllQuestion');
    Route::get('get-choice-item/{id}', [App\Http\Controllers\QuestionChoiceItemController::class,'getChoiceItem']);

    // owner classroom
    Route::get('create-classroom', [App\Http\Controllers\Frontend\ClassroomController::class,'createClassroom'])->name('createClassroom');
    Route::post('store-classroom', [App\Http\Controllers\Frontend\ClassroomController::class,'storeClassroom'])->name('storeClassroom');
    Route::get('edit-classroom/{slug}', [App\Http\Controllers\Frontend\ClassroomController::class,'editClassroom'])->name('editClassroom');
    Route::post('update-classroom/{id}', [App\Http\Controllers\Frontend\ClassroomController::class,'updateClassroom'])->name('updateClassroom');
    Route::get('delete-classroom/{slug}', [App\Http\Controllers\Frontend\ClassroomController::class,'destroyClassroom'])->name('destroyClassroom');

    //owner classroom user
    Route::get('user-classroom/{slug}', [App\Http\Controllers\Frontend\UserController::class,'index'])->name('showUser');
    Route::post('store-teacher/{slug}', [App\Http\Controllers\Frontend\UserController::class,'store'])->name('storeTeacher');
    Route::get('delete-teacher/{slug}/{id}', [App\Http\Controllers\Frontend\UserController::class,'destroy'])->name('destroyTeacher');


    Route::get('/home', [App\Http\Controllers\Frontend\HomeController::class, 'index'])->name('home');
    Route::get('/discover', [App\Http\Controllers\Frontend\DiscoverController::class, 'index'])->name('discover');
    Route::get('/discover/ajax', [App\Http\Controllers\Frontend\DiscoverController::class, 'ajaxRequest'])->name('ajax.request');
    Route::get('/class-detail/{slug}', [App\Http\Controllers\Frontend\ClassroomController::class, 'show'])->name('classroom.detail');
    Route::get('/class-work-detail/{slug}/{id}', [App\Http\Controllers\Frontend\ClassroomController::class, 'classWork'])->name('class.work.detail');
    Route::post('/class-work-detail/{slug}/{id}', [App\Http\Controllers\Frontend\ClassroomController::class, 'discussions'])->name('class.work.discussions');


    Route::post('/upload-assigment', [App\Http\Controllers\Frontend\UploadController::class, 'assignment'])->name('upload.assignment');
    Route::get('/quizzes/quiz/{id}', [App\Http\Controllers\Frontend\QuizController::class, 'quiz'])->name('class.quiz');

    Route::get('/classes', [App\Http\Controllers\Frontend\ClassesController::class, 'index'])->name('classes');

    Route::get('/get-question/{id}', [App\Http\Controllers\Frontend\QuizController::class, 'getQuestion'])->name('getQuestion');
    Route::get('/get-quiz/{id}', [App\Http\Controllers\Frontend\QuizController::class, 'getQuiz'])->name('getQuiz');
    Route::get('/join-classroom/{slug}', [App\Http\Controllers\Frontend\ClassroomController::class, 'joinClassroom'])->name('joinClassroom');

    Route::get('/get-time-quiz/{id}', [App\Http\Controllers\Frontend\QuizJsonController::class, 'getTimeQuiz'])->name('getTimeQuiz');

    Route::get('backpack', [App\Http\Controllers\Frontend\BookmarkController::class, 'index'])->name('backpack');

});

Route::get('/submited-quiz/{id}', [App\Http\Controllers\Frontend\QuizController::class, 'submitedQuiz'])->name('submitedQuiz');


Route::post('set-choice-item', [App\Http\Controllers\Frontend\QuizJsonController::class, 'getChoiceItem'])->name('getChoiceItem');

Route::group(['middleware' => ['role:super'], 'prefix' => 'admin'], function () {
    //
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('admin.home');

    Route::resource('userStudents', App\Http\Controllers\UserStudentController::class);

    Route::get('get-user-students/{id}', [App\Http\Controllers\UserStudentController::class,'getuserStudents']);
    Route::get('userStudents/{id}/destroy', [App\Http\Controllers\UserStudentController::class,'destroy']);


    Route::resource('userTeachers', App\Http\Controllers\UserTeacherController::class);

    Route::resource('subjects', App\Http\Controllers\SubjectController::class);
    Route::get('subjects/destroy/{id}', [App\Http\Controllers\SubjectController::class,'destroy']);

    Route::resource('teachingPeriods', App\Http\Controllers\TeachingPeriodController::class);
    Route::get('teachingPeriods/destroy/{id}', [App\Http\Controllers\TeachingPeriodController::class,'destroy']);

    Route::resource('classrooms', App\Http\Controllers\ClassroomController::class);
    Route::get('classrooms/destroy/{id}', [App\Http\Controllers\ClassroomController::class,'destroy']);
    Route::get('get-classrooms/{id}', [App\Http\Controllers\ClassroomController::class,'getClassroom']);

    Route::resource('classroomUsers', App\Http\Controllers\ClassroomUserController::class);
    Route::get('classroomUsers/destroy/{id}', [App\Http\Controllers\ClassroomUserController::class,'destroy']);
    Route::get('classroomUsers/create/{id}', [App\Http\Controllers\ClassroomUserController::class,'create']);

    Route::resource('profiles', App\Http\Controllers\ProfileController::class);

    Route::resource('quizzes', App\Http\Controllers\QuizzesController::class);
    Route::get('quizzes/destroy/{id}', [App\Http\Controllers\QuizzesController::class,'destroy']);

    Route::resource('questions', App\Http\Controllers\QuestionController::class);
    Route::get('questions/destroy/{id}', [App\Http\Controllers\QuestionController::class,'destroy']);
    Route::post('questions/{id}/store', [App\Http\Controllers\QuestionController::class,'store'])->name('questions.store.id');
    Route::get('questions/create/{id}', [App\Http\Controllers\QuestionController::class,'create'])->name('questions.create.quiz');

    Route::resource('questionQuizzes', App\Http\Controllers\QuestionQuizzesController::class);

    Route::resource('teachables', App\Http\Controllers\TeachableController::class);

    Route::resource('questionChoiceItems', App\Http\Controllers\QuestionChoiceItemController::class);
    Route::get('get-choice-item/{id}', [App\Http\Controllers\QuestionChoiceItemController::class,'getChoiceItem']);

    Route::resource('resources', App\Http\Controllers\ResourceController::class);

    Route::resource('assignments', App\Http\Controllers\AssignmentController::class);

    Route::resource('quizAttempts', App\Http\Controllers\QuizAttemptController::class);

    Route::resource('teachableUsers', App\Http\Controllers\TeachableUserController::class);

    Route::resource('grades', App\Http\Controllers\GradeController::class);

    Route::resource('modelHasRoles', App\Http\Controllers\ModelHasRoleController::class);

    Route::resource('roles', App\Http\Controllers\RoleController::class);

    Route::resource('bookmarks', App\Http\Controllers\BookmarkController::class);

    Route::resource('flashcardCategories', App\Http\Controllers\FlashcardCategoriesController::class);

    Route::resource('flashcardQuestions', App\Http\Controllers\FlashcardQuestionController::class);

    Route::resource('flashcardSubjects', App\Http\Controllers\FlashcardSubjectController::class);


    Route::resource('flashcardCategoriesQuestions', App\Http\Controllers\FlashcardCategoriesQuestionController::class);

    Route::resource('flashcardQuestionsSubjects', App\Http\Controllers\FlashcardQuestionsSubjectController::class);

    Route::resource('flashcardAnswers', App\Http\Controllers\FlashcardAnswerController::class);
});


// Route::resource('flashcardAnswers', App\Http\Controllers\FlashcardAnswerController::class);

// Route::resource('flashcardCategories', App\Http\Controllers\FlashcardCategoriesController::class);

// Route::resource('flashcardCategoriesQuestions', App\Http\Controllers\FlashcardCategoriesQuestionController::class);

// Route::resource('flashcardQuestions', App\Http\Controllers\FlashcardQuestionController::class);

// Route::resource('flashcardQuestionsSubjects', App\Http\Controllers\FlashcardQuestionsSubjectController::class);

// Route::resource('flashcardSubjects', App\Http\Controllers\FlashcardSubjectController::class);