<?php

use App\Http\Livewire\Quiz\QuizForm;
use App\Http\Livewire\Quiz\QuizList;
use App\Http\Livewire\Admin\TeamForm;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Admin\AdminForm;
use App\Http\Livewire\Admin\AdminList;
use App\Http\Livewire\Admin\ClassList;
use App\Http\Livewire\Counter\Counter;
use App\Http\Controllers\HomeController;
use App\Http\Livewire\Admin\CollegeForm;
use App\Http\Livewire\Admin\CollegeList;
use App\Http\Livewire\Admin\InstuteForm;
use App\Http\Livewire\Admin\InstuteList;
use App\Http\Livewire\Admin\StudentForm;
use App\Http\Livewire\Admin\StudentList;
use App\Http\Livewire\Front\Leaderboard;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\UpdateQuizStatus;
use App\Http\Livewire\Admin\PhysicalyList;
use App\Http\Livewire\Admin\PrototypeList;
use App\Http\Livewire\Admin\SubmissonList;
use App\Http\Controllers\ProfileController;
use App\Http\Livewire\Admin\InstuteListAll;
use App\Http\Livewire\Admin\Tests\TestList;
use App\Http\Livewire\Admin\PhaseSubmission;
use App\Http\Livewire\Question\QuestionForm;
use App\Http\Livewire\Question\QuestionList;
use App\Http\Livewire\Admin\StudentListAdmin;
use App\Http\Livewire\Admin\StudentSubmisson;
use App\Http\Livewire\Admin\TeamRegistration;
use App\Http\Controllers\CertificateController;
use App\Http\Livewire\Front\Results\ResultList;
use App\Http\Livewire\Admin\PhaseSubmissionForm;
use App\Http\Livewire\Admin\PhysciallySubmissonList;
use App\Http\Livewire\Admin\ReattemptStudentListAdmin;
use App\Http\Livewire\Admin\AllowReattemptStudentListAdmin;
use App\Http\Livewire\Admin\StudentPhysciallySubmisson;
use App\Http\Livewire\Admin\SchoolStudents;
use App\Http\Livewire\Admin\SchoolStudentsParticipents;
use App\Http\Livewire\Admin\SchoolEditForm;
use App\Http\Livewire\Admin\StudentEditForm;
use App\Http\Livewire\Admin\TestimonialAdmin;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// public routes


Route::get('/otp', function(){
    return view('emails.otp_temp');
});


Route::get('/download-certificate/{test}', [CertificateController::class, 'download'])->name('download.certificate');

Route::view('about', 'content.about');
Route::view('about_competition', 'content.about_competition');
Route::view('contact_us', 'content.contact_us');
Route::view('guidelines', 'content.guidelines');
Route::view('institutes', 'content.institutes');
Route::view('rewards', 'content.rewards');
Route::view('terms_and_conditions', 'content.terms_and_conditions');

Route::middleware('guest')->group(function () {
    Route::view('thankyou/{id?}', 'content.thankyou')->name('thankyou');
    Route::view('gallery', 'content.gallery')->name('gallery');
    Route::view('notice', 'content.notice')->name('notice');
    Route::view('privacy-policy', 'content.privacy_policy')->name('privacy_policy');
    Route::view('press-release', 'content.press_release')->name('press_release');
    Route::get('testimonial', [HomeController::class, 'testimonial_form'])->name('testimonial');
    Route::post('testimonial_submit', [HomeController::class, 'testimonial_store'])->name('testimonial.store');
});



Route::get('/', [HomeController::class, 'index'])->name('home');
Route::middleware('throttle:60,1')->group(function () {
    Route::get('quiz/{quiz}', [HomeController::class, 'show'])->name('quiz.show');

});
Route::view('not-found','404.blade.php');

// protected routes
Route::middleware('auth')->group(function () {
    Route::view('congratulation', 'content.congratulation')->name('quiz.congratulation');
    Route::view('quiz-notification', 'content.quiz_notification')->name('content.quiz_notification');
    Route::get('prototypelist', PrototypeList::class)->name('prototypelist');
    Route::get('physciallylist', PhysicalyList::class)->name('physciallylist');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/info', [ProfileController::class, 'editinfo'])->name('profile.editinfo');
    Route::get('/profile/password', [ProfileController::class, 'editpassword'])->name('profile.editpassword');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/register-team', TeamRegistration::class)->name('register-team');
    Route::get('team/{id}', TeamForm::class)->name('register-form.edit');
    Route::get('/getCounter', Counter::class);
    Route::get('/phase-submissions-2', PhaseSubmission::class)->name('submissions');
    Route::get('/phase-submissions-2/create', PhaseSubmissionForm::class)->name('submissions.create');
    Route::delete('/register-team', TeamRegistration::class)->name('register-team.destroy');
    Route::get('team/create', TeamForm::class)->name('team.create');
    Route::get('myresults', ResultList::class)->name('myresults');
    Route::get('student', StudentList::class)->name('student');
    Route::post('/verify-admin/{id}', [StudentList::class, 'verifyAdmin']);
    Route::get('student/create', StudentForm::class)->name('student.create');
    Route::post('/upload-csv', [StudentList::class, 'uploadCsv'])->name('upload.csv');
    Route::post('/update_user_password', [StudentList::class, 'updatePassword'])->name('updateUserPassword');

    Route::get('results/{test}', [ResultController::class, 'show'])->name('results.show');
    Route::get('/get-user-details', [TeamForm::class, 'getUserDetails'])->name('getUserDetails');
    Route::get('leaderboard', Leaderboard::class)->name('leaderboard');
    Route::get('submissonlist', SubmissonList::class)->name('submissonlist');
    Route::post('/approve-team/{id}', [SubmissonList::class, 'approveTeam']);
    Route::post('/notapprove-team/{id}', [SubmissonList::class, 'notapproveTeam']);
    Route::get('submisson', StudentSubmisson::class)->name('submisson');
    Route::get('submisson/{prototype}/edit', StudentSubmisson::class)->name('submisson.edit');
    Route::post('/upload-prototype', [StudentSubmisson::class, 'uploadprototype'])->name('upload.prototype');
    Route::get('physciallysubmissonlist', PhysciallySubmissonList::class)->name('physciallysubmissonlist');
    Route::post('/finalapprove-team/{id}', [PhysciallySubmissonList::class, 'finalapproveTeam']);
    Route::post('/finalnotapprove-team/{id}', [PhysciallySubmissonList::class, 'finalnotapproveTeam']);
    Route::post('/finalnotapprove-team1/{id}', [PhysciallySubmissonList::class, 'finalnotapproveTeam1']);
    Route::get('student-physcially-submisson', StudentPhysciallySubmisson::class)->name('student-physcially-submisson');
    Route::get('student-physcially-submisson/{physicaly}/edit', StudentPhysciallySubmisson::class)->name('student-physcially-submisson.edit');
    Route::get('/school-export-students', [StudentList::class, 'export'])->name('export.students');
    // Route::post('/upload-physciallysubmisson', StudentPhysciallySubmisson::class)->name('upload.physciallysubmisson');

    // Admin routes
    Route::middleware('isAdmin')->group(function () {
        Route::get('/school_students', SchoolStudents::class)->name('schoolStudents');
        Route::get('/school_students_participents', SchoolStudentsParticipents::class)->name('schoolStudentsParticipents');

        Route::get('/download-student', [CertificateController::class, 'downloadUsers'])->name('download.student');
        Route::get('studentlistadmin', StudentListAdmin::class)->name('studentlistadmin');
        Route::get('reattemptlist', ReattemptStudentListAdmin::class)->name('reattemptstudentlistadmin');
        Route::get('allowreattemptlist', AllowReattemptStudentListAdmin::class)->name('allow.reattemptstudentlistadmin');
        Route::post('/student-upload-csv', [StudentListAdmin::class, 'uploadCsv'])->name('student.upload.csv');
        Route::post('/question-upload-csv', [QuestionList::class, 'uploadCsv'])->name('question.upload.csv');
        Route::post('/update-quiz-status', [UpdateQuizStatus::class, 'updateQuizStatus']);
        Route::post('/update-level2-status', [UpdateQuizStatus::class, 'updateLevel2Status']);
        Route::post('/update-level3-status', [UpdateQuizStatus::class, 'updateLevel3Status']);
        Route::post('/publish-level2-result', [PrototypeList::class, 'publishLevel2Result'])->name('publish.level2.result');
        Route::post('/unpublish-level2-result', [PrototypeList::class, 'unpublishLevel2Result'])->name('unpublish.level2.result');
        Route::post('/publish-level3-result', [PhysicalyList::class, 'publishLevel3Result'])->name('publish.level3.result');
        Route::post('/unpublish-level3-result', [PhysicalyList::class, 'unpublishLevel3Result'])->name('unpublish.level3.result');
        Route::get('questions', QuestionList::class)->name('questions');
        Route::get('questions/create', QuestionForm::class)->name('question.create');
        Route::get('questions/{question}', QuestionForm::class)->name('question.edit');
        Route::get('quizzes', QuizList::class)->name('quizzes');
        Route::get('quizzes/create', QuizForm::class)->name('quiz.create');
        Route::get('quizzes/{quiz}/edit', QuizForm::class)->name('quiz.edit');
        Route::post('/quizzes/{quiz}/copy', [QuizForm::class, 'copy'])->name('quizzes.copy');
        Route::get('admins', AdminList::class)->name('admins');
        Route::get('admins/create', AdminForm::class)->name('admin.create');
        Route::get('school/{instute}/delete', [InstuteList::class,'delete'])->name('institute.delete');
        Route::get('school', InstuteList::class)->name('institute');
        Route::get('all_schools', InstuteListAll::class)->name('all_schools');
        Route::get('school/create', InstuteForm::class)->name('institute.create');
        Route::get('school/{instute}/edit', InstuteForm::class)->name('institute.edit');
        Route::get('school_login', CollegeList::class)->name('institute_login');
        Route::post('/school-upload-csv', [CollegeList::class, 'uploadCsv'])->name('school.upload.csv');
        Route::post('/verify-school/{id}', [CollegeList::class, 'verifySchool'])->name('verify.school');
        Route::get('institute_login/create', CollegeForm::class)->name('institute_login.create');
        Route::get('institute_login/{user}/edit', CollegeForm::class)->name('institute_login.edit');
        Route::get('tests', TestList::class)->name('tests');
        Route::get('/phase-submission-3', PhaseSubmission::class)->name('submissions3');
        Route::get('/phase-submission-3/create', PhaseSubmissionForm::class)->name('submissions3.create');
        Route::get('/export-students', [StudentListAdmin::class, 'export'])->name('admin.export.students');
        Route::get('/export-school', [CollegeList::class, 'export'])->name('admin.export.school');
        Route::get('/export-quizattempt', [TestList::class, 'export'])->name('admin.export.quizattempt');
        Route::get('school/edit_school_profile/{id}', SchoolEditForm::class)->name('editschoolprofile');
        Route::get('student/edit_student_profile/{id}', StudentEditForm::class)->name('editstudentprofile');
        Route::get('testimonialslist', TestimonialAdmin::class)->name('testimonial.list');
    });
    Route::get('student-list', ClassList::class)->name('class.list');
});


require __DIR__ . '/auth.php';
