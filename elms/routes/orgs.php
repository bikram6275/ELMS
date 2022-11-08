<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Organization\HomeController;
use App\Http\Controllers\Organization\Org\SurveyController;
use App\Http\Controllers\Employee\EmployeeAwardController;
use App\Http\Controllers\Employee\EmployeeLeaveController;
use App\Http\Controllers\Employee\EmployeeRecordController;
use App\Http\Controllers\Organization\OrganizationController;
use App\Http\Controllers\Employee\EmployeePunishmentController;
use App\Http\Controllers\Employee\EmployeeExperienceController;
use App\Http\Controllers\Employee\EmployeeTrainingController;
use App\Http\Controllers\Employee\EmployeeResponsibilityController;
use App\Http\Controllers\Organization\Auth\ForgotPasswordController;

Route::get('/login', [App\Http\Controllers\Organization\Auth\LoginController::class, 'showLoginForm'])->name('orgs.login');
Route::post('/login', [App\Http\Controllers\Organization\Auth\LoginController::class, 'login'])->name('orgs.signin');
Route::post('logout',[App\Http\Controllers\Organization\Auth\LoginController::class, 'logout'])->name('orgs.logout');



Route::group(['middleware' => ['auth:orgs']], function () {

    Route::get('/dashboard', [App\Http\Controllers\Organization\HomeController::class, 'index'])->name('orgs.home');

    Route::get('/answer/show/{id}', [SurveyController::class, 'answer'])->name('orgs.answere.show');



    //Employee Record
    Route::resource('/employeeRecord', EmployeeRecordController::class);
    Route::post('/employeeRecord/search', [EmployeeRecordController::class,'search'])->name('employeeRecord.search');

    //Employee Education

    Route::get('/get/educationLevel/{education_type_id}', [EmployeeRecordController::class, 'getEduLevel']);

    //Employee Award
    Route::get('/employee/award/view/{id}', [EmployeeAwardController::class, 'view'])->name('view');
    Route::resource('/employee/award', EmployeeAwardController::class);
    Route::get('/employee/update', [EmployeeAwardController::class, 'update'])->name('update');
    Route::get('/employee/delete', [EmployeeAwardController::class, 'destroy'])->name('delete');

    //Employee Leave
    Route::resource('/employee/leave', EmployeeLeaveController::class);

    //Employee Punishment
    Route::resource('/employee/punishment', EmployeePunishmentController::class);
    Route::get('/employee/punishment/view/{id}', [EmployeePunishmentController::class, 'view']);
    Route::post('/employee/punishmentupdate', [EmployeePunishmentController::class, 'update']);
    Route::post('/employee/punishmentdelete', [EmployeePunishmentController::class, 'destroy']);

    //Employee Experience
    Route::resource('/employee/experience', EmployeeExperienceController::class);

    //Employee Training
    Route::resource('/employee/training', EmployeeTrainingController::class);
    Route::get('/employee/training/view/{id}', [EmployeeTrainingController::class, 'view']);
    // Route::get('/employee/training/{training}', [EmployeeTrainingController::class, 'destroy']);

    //Employee Responsibility
    Route::resource('/employee/responsibility', EmployeeResponsibilityController::class);

    Route::get('/get/district/{permanent_pradesh_id}', [OrganizationController::class, 'getDistrict']);
    Route::get('/get/municipality/{permanent_district_id}', [OrganizationController::class, 'getMunicipality']);
    Route::delete('/delete/selected/{id}', [OrganizationController::class, 'remove']);


    Route::get('/get/district/{pradesh_id}', [OrganizationController::class, 'getDistrict']);
    Route::get('/get/municipality/{district_id}', [OrganizationController::class, 'getMunicipality']);



});

Route::get('/profile', [App\Http\Controllers\Organization\UserController::class,'profile'])->name('orgs.profile');
Route::post('/profile/password', [App\Http\Controllers\Organization\UserController::class,'password']);
Route::post('/profile/profilePic', [App\Http\Controllers\Organization\UserController::class,'profilePic']);

Route::get('/password_reset',[ForgotPasswordController::class,'showForgetPasswordForm'])->name('orgs.forget.password.get');
Route::post('/password_reset',[ForgotPasswordController::class,'submitForgetPasswordForm'])->name('orgs.forget.password.post');

Route::get('reset-password/{token}/{email}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('orgs.reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('orgs.reset.password.post');

