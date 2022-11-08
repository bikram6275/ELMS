<?php

use App\Http\Controllers\Api\AboutController;
use App\Http\Controllers\Api\AddressConroller;
use App\Http\Controllers\Api\AnswerController;
use App\Http\Controllers\Api\ApiForgetPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductServiceController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\SurveyController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login'])->middleware('apilogger');
Route::post('/forget-password',[ApiForgetPasswordController::class,'sendResetLinkEmail']);

Route::group(['middleware' => ['auth:api','apilogger']], function () {
    Route::get('/recent-survey', [SurveyController::class, 'recentSurvey']);
    Route::get('{id}/organizations', [SurveyController::class, 'organizations']);
    Route::post('/start-survey',[SurveyController::class,'startSurvey']);
    Route::get('/me', [AuthController::class, 'getUser']);
    Route::get('/pradesh', [AddressConroller::class, 'pradesh']);
    Route::get('/district', [AddressConroller::class, 'district']);
    Route::get('/municipality', [AddressConroller::class, 'municipality']);
    Route::post('/update/profile',[AuthController::class,'updateProfile']);
    Route::get('/{id}/questions/{pivot_id}', [QuestionController::class, 'index']);
    Route::get('/product-and-service',[ProductServiceController::class,'index']);
    Route::get('/sector',[QuestionController::class,'sector']);
    Route::get('/sub-sector',[QuestionController::class,'sectorWiseSubSector']);
    Route::get('/occupation',[QuestionController::class,'sectorWiseOccupation']);
    Route::post('/answer',[AnswerController::class,'store']);
    Route::get('/about',[AboutController::class,'index']);
    Route::post('/finish-survey',[SurveyController::class,'finishSurvey']);
    Route::get('/nepali-years',[QuestionController::class,'nepaliYears']);
    Route::get('/nepali-months',[QuestionController::class,'nepaliMonths']);
    Route::get('/survey_status',[SurveyController::class,'surveyStatus']);
    Route::get('/feedback',[SurveyController::class,'feedbackOrganization']);
    Route::get('/feedback/{id}/view',[SurveyController::class,'viewFeedback']);
});




