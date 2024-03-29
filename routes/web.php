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

// Route::get('/', function () {
//     return view('welcome');
// });
// Frontend routes
Route::get('/', [App\Http\Controllers\FrontEndController::class, 'index'])->name('home');
Route::get('plans', [App\Http\Controllers\FrontEndController::class, 'plans'])->name('plans');
Route::get('help', [App\Http\Controllers\FrontEndController::class, 'help'])->name('help');
Route::get('contact', [App\Http\Controllers\FrontEndController::class, 'contact'])->name('contact');
Route::post('contact', [App\Http\Controllers\ContactFormController::class, 'postContactForm'])->name('post-contact');

Route::post('/', [App\Http\Controllers\NewsletterController::class, 'newsletterPost'])->name('newsletter');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'dashboard'])->name('dashboard')->middleware('trial');
    
// Admin Routes

Route::get('admin/dashboard', [App\Http\Controllers\Admin\AdminController::class, 'getDashboard'])->name('admin.dashboard');//->middleware('admin');
Route::get('admin/dashboard/{id}/upgrade-plan', [App\Http\Controllers\Admin\AdminController::class, 'upgradeUserPlan'])->name('upgrade.user_status');

//User Routes

// quizzes
Route::get('quizzes', [App\Http\Controllers\QuizController::class, 'displayQuizzes'])->name('quizzes'); //->middleware('verify.payment'); //verify payment
Route::get('/quiz/{quiz:slug}', [App\Http\Controllers\QuizController::class, 'quizGenerator'])->name('display.quiz');
Route::get('user_quiz/{quiz_id}/quiz-questions', [App\Http\Controllers\QuizController::class, 'createUserQuiz'])->name('user.quiz');
Route::get('/quizzes/user-quizzes', [App\Http\Controllers\QuizController::class, 'getAllQuizzess'])->name('all.quizzes');
Route::get('/quizzes/{quiz:slug}/print-answers', [App\Http\Controllers\QuizController::class, 'printAnswers'])->name('print.answers'); //remember to protect this route
Route::post('/quizzes/post-score', [App\Http\Controllers\QuizController::class, 'postUserScore']); 

// quiz practice mode 
Route::get('/subjects', [App\Http\Controllers\QuizPracticeModeController::class, 'getSubjects'])->name('subjects');
Route::get('/subjects/{subject_id}/quiz-questions', [App\Http\Controllers\QuizPracticeModeController::class, 'getSubjectQuestions'])->name('questions');

// library
Route::get('/user/library', [App\Http\Controllers\LibraryController::class, 'index'])->name('library');

// add questions to quiz item
Route::get('create-quiz/add-quiz-questions/{subject_id}/{quiz_id}', [App\Http\Controllers\QuizController::class, 'addQuizQuestions'])->name('add.quiz.questions');
//save user quiz
Route::post('/user_quiz/save-quiz', [App\Http\Controllers\QuizController::class, 'store'])->name('save.user.quiz');
Route::post('/create-quiz/post', [App\Http\Controllers\QuestionsController::class, 'storeQuizTitle'])->name('quiz.create');
//post quiz
Route::get('/create-quiz/subjects', [App\Http\Controllers\QuestionsController::class, 'showQuestions'])->name('show.questions');
Route::get('/create-quiz/{subject_id}', [App\Http\Controllers\QuestionsController::class, 'subjectQuestions'])->name('subject.questions');
Route::post('/questions-by-subject', [App\Http\Controllers\VerifyAnswerController::class, 'verifyAnswer'])->name('verify.answer');
Route::get('questions/{subject}/{id}', [App\Http\Controllers\QuestionsController::class, 'getQuestion'])->name('single.question');
Route::get('/questionsby-subject', [App\Http\Controllers\QuestionsController::class, 'sortQuestions'])->name('sort.questions');

// teams
Route::get('my-teams', [App\Http\Controllers\TeamController::class, 'getTeams'])->name('teams');
Route::get('my-teams/team-details/{id}', [App\Http\Controllers\TeamController::class, 'getTeamDetail'])->name('team.detail');
// Route::get('weekly-challenge', [App\Http\Controllers\WeeklyChallengesController::class, 'getChallengeQuestions'])->name('weekly.challenge');
Route::get('/weekly-challenge', [App\Http\Controllers\WeeklyChallengesController::class, 'renderChallenge'])->name('weekly.challenge');
Route::post('/weekly-challenge/post', [App\Http\Controllers\WeeklyChallengesController::class, 'postScore']);
Route::get('/weekly-challenge/leadersboard', [App\Http\Controllers\WeeklyChallengesController::class, 'leadersBoard'])->name('leaders.board');
Route::post('/weekly-challenge/leadersboard/week', [App\Http\Controllers\WeeklyChallengesController::class, 'postleadersBoard']);
Route::get('user_questions/create-user-question', [App\Http\Controllers\UserQuestionsController::class, 'createUserQuestion'])->name('create.user.question');
Route::post('/post_question', [App\Http\Controllers\UserQuestionsController::class, 'postQuestion'])->name('post.question');
Route::get('/user_questions/', [App\Http\Controllers\UserQuestionsController::class, 'index'])->name('user.questions');
Route::get('/user_questions/{id}', [App\Http\Controllers\UserQuestionsController::class, 'userQuestionShow'])->name('user_question.detail');
Route::get('/user_questions/{id}/edit', [App\Http\Controllers\UserQuestionsController::class, 'editQuestion'])->name('edit.question');
Route::put('user_questions/{id}/edit', [App\Http\Controllers\UserQuestionsController::class, 'unpdateQuestion'])->name('update.question');
Route::delete('/user_questions/{id}/delete', [App\Http\Controllers\UserQuestionsController::class, 'deleteQuestion'] )->name('delete.question');
Route::post('/users_questions/{id}/answer', [App\Http\Controllers\AnswerController::class, 'postAnswer'])->name('post.answer');
Route::get('/answers/{id}/edit', [App\Http\Controllers\AnswerController::class, 'editAnswer'])->name('edit.answer');
Route::put('/answers/{id}/edit', [App\Http\Controllers\AnswerController::class, 'updateAnswer']);
Route::delete('/answers/{id}/delete', [App\Http\Controllers\AnswerController::class, 'deleteAnswer'])->name('answer.delete');
// Payment
Route::get('price-plans', [App\Http\Controllers\PaymentController::class, 'pricePlans'])->name('price.plans');
Route::get('/payment', [App\Http\Controllers\PaymentController::class, 'getPaymentProcessor'])->name('payment');
Route::post('/payment', [App\Http\Controllers\PaymentController::class, 'postPaymentProcessor'])->name('post.payment');
// Quest
Route::get('quest', [App\Http\Controllers\QuestController::class, 'index']);
Route::get('quest/add-question', [App\Http\Controllers\QuestController::class, 'create'])->name('add.question');

// Analytics
Route::get('analytics', [App\Http\Controllers\AnalyticsController::class, 'analyseUsersContent'])->name('analytics');
Route::post('/analytics/post', [App\Http\Controllers\AnalyticsController::class, 'getStats']);

//Reviews
Route::get('reviews', [App\Http\Controllers\ReviewsController::class, 'index'])->name('reviews');

//Blog
Route::get('blog', [App\Http\Controllers\BlogController::class, 'index'])->name('blog');

//Messages
Route::get('messages/inbox', [App\Http\Controllers\MessagesController::class, 'index'])->name('messages.inbox');

//Bookmarks
Route::get('bookmarks', [App\Http\Controllers\BookmarksController::class, 'index'])->name('bookmarks');
});

// sorting quiz questions by class

Route::post('/quiz-detail/post', [App\Http\Controllers\QuizController::class, 'sortQuizQuestions']);




