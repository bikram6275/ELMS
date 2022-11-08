<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SurveyListController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController ;
use App\Http\Controllers\SurveyOccupationController;

Route::get('/clear_cache', [ConfigController::class,'clearRoute']);
Route::resource('question', QuestionController::class);
Route::get('question/status/{id}',[QuestionController::class,'status']);
Route::get('question/deleteOption/{id}',[QuestionController::class,'deleteOption']);

Route::get('survey_list',[SurveyListController::class,'index']);
Route::get('orgList/{id}',[SurveyListController::class,'getOrgList'])->name('survey.orgs.show');
Route::get('survey/orgs/{pivot_id}', [AnswerController::class,'index']);
Route::get('survey/orgs/question/{pivot_id}/{qsn_id}',[AnswerController::class,'listQuestion']);
Route::post('answer', [AnswerController::class,'store']);
Route::get('answer', [AnswerController::class,'index'])->name('answer.index');
Route::get('survey/view/{pivot_id}',[AnswerController::class,'viewAnswer']);

Route::get('other_occupation/deleteOption/{id}',[AnswerController::class,'otherOccupationDelete']);
Route::get('human_resource/deleteOption/{id}',[AnswerController::class,'technicalHumanDelete']);
Route::get('skilled/deleteOption/{id}',[AnswerController::class,'businessPlanDelete']);
Route::post('repondent_information',[AnswerController::class,'respondentInfo']);

Route::get('report/organizationReport/{survey_id}',[ReportController::class,'organizationReport']);
Route::get('complete_survey',[HomeController::class,'completeOrganization']);

Route::resource('survey_occupation', SurveyOccupationController::class);
Route::get('/export/list/{id}',[ReportController::class,'exportIndex'])->name('export.list.index');
Route::get('/organization_export/{id}',[ReportController::class,'orgExport'])->name('org.export');
Route::get('/questions_export/{id}',[ReportController::class,'questionExport'])->name('question.export');
Route::get('/answer_export/{id}',[ReportController::class,'answerExport'])->name('answer.export');
Route::get('/qsn5_export/{id}',[ReportController::class,'qsn5Export'])->name('qsn5.export');
Route::get('/qsn12_export/{id}',[ReportController::class,'qsn12Export'])->name('qsn12.export');
Route::get('/qsn20_export/{id}',[ReportController::class,'qsn20Export'])->name('qsn20.export');
Route::get('/qsn21_export/{id}',[ReportController::class,'qsn21Export'])->name('qsn21.export');
Route::get('/qsn2_export/{id}',[ReportController::class,'qsn2Export'])->name('qsn2.export');
Route::get('/qsn1.3_export/{id}',[ReportController::class,'registeredWithExport'])->name('registeredwith.export');
Route::get('/qsn4_export/{id}',[ReportController::class,'qsn4Export'])->name('qsn4.export');
Route::get('/qsn19_export/{id}',[ReportController::class,'qsn19Export'])->name('qsn19.export');


Route::get('/human_resource/{id}',[ReportController::class,'humanResourceExport'])->name('human_resource.export');
Route::get('/technical_human_resource/{id}',[ReportController::class,'techincalHumanResourceExport'])->name('technical_human_resource.export');
Route::get('/emp_status/{id}',[ReportController::class,'empStatusExport'])->name('emp_status.export');
Route::get('/worker_skills/{id}',[ReportController::class,'workerSkillExport'])->name('worker_skills.export');

Route::get('/other_occupation/{id}',[ReportController::class,'otherOccupationExport'])->name('other_occupation.export');
Route::get('/technology/{id}',[ReportController::class,'technologyExport'])->name('technology.export');
Route::get('/business_plan/{id}',[ReportController::class,'businessPlanExport'])->name('business_plan.export');
