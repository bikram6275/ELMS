<?php

use App\Http\Controllers\Api\ApiResetPasswordController;
use App\Http\Controllers\Emitter\AnswerController;
use App\Http\Controllers\Emitter\Auth\ForgotPasswordController;
use App\Http\Controllers\Emitter\ReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Emitter\Emitter\SurveyController;

Route::get('/login', [\App\Http\Controllers\Emitter\Auth\LoginController::class, 'showLoginForm'])->name('emitter.login');
Route::post('/login', [App\Http\Controllers\Emitter\Auth\LoginController::class, 'login'])->name('emitter.signin');
Route::post('logout',[App\Http\Controllers\Emitter\Auth\LoginController::class, 'logout'])->name('emitter.logout');
Route::get('/emitter/reset-password',[ApiResetPasswordController::class,'resetForm']);
Route::post('/reset/password',[ApiResetPasswordController::class,'reset'])->name('emitter.reset');

Route::group(['middleware' => ['auth:emitter']], function () {

    Route::get('/dashboard', [App\Http\Controllers\Emitter\HomeController::class, 'index'])->name('emitter.home');
    Route::get('survey/{id}', [App\Http\Controllers\Emitter\HomeController::class, 'show'])->name('enumerator.survey.orgs.show');
    Route::get('survey/orgs/{pivot_id}', [AnswerController::class,'index'])->name('enumerator.answer.index');
    Route::get('survey/orgs/question/{pivot_id}/{qsn_id}',[AnswerController::class,'listQuestion']);
    Route::post('answer', [AnswerController::class,'store'])->name('emitter.answer.store');
    Route::get('answer', [AnswerController::class,'index'])->name('emitter.answer.index');
    Route::get('survey/view/{pivot_id}',[AnswerController::class,'viewAnswer']);


    Route::get('other_occupation/deleteOption/{id}',[AnswerController::class,'otherOccupationDelete']);
    Route::get('human_resource/deleteOption/{id}',[AnswerController::class,'technicalHumanDelete']);
    Route::get('skilled/deleteOption/{id}',[AnswerController::class,'businessPlanDelete']);
    Route::post('repondent_information',[AnswerController::class,'respondentInfo']);

    Route::resource('/survey', SurveyController::class,[
        'names' => [
            'index' => 'emitter.survey.index',
            'edit' => 'emitter.survey.edit',
            'create' => 'emitter.survey.create',
            'show' => 'emitter.survey.show',
            'store' => 'emitter.survey.store',
            'update' => 'emitter.survey.update',
            'destroy' => 'emitter.survey.destroy',

        ],

    ]);

    Route::get('report/organizationReport/{survey_id}',[ReportController::class,'organizationReport']);

});
Route::get('/profile', [App\Http\Controllers\Emitter\UserController::class,'profile'])->name('emitter.profile');
Route::post('/profile/password', [App\Http\Controllers\Emitter\UserController::class,'password']);

Route::get('/password_reset',[ForgotPasswordController::class,'showForgetPasswordForm'])->name('forget.password.get');
Route::post('/password_reset',[ForgotPasswordController::class,'submitForgetPasswordForm'])->name('forget.password.post');

Route::get('reset-password/{token}/{email}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');








