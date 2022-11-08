<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Roles\MenuController;
use App\Http\Controllers\ReportByQuesController;
use App\Http\Controllers\SurveyStatusController;
use App\Http\Controllers\Survey\SurveyController;
use App\Http\Controllers\DataMonitoringController;
use App\Http\Controllers\SurveyResponseController;
use App\Http\Controllers\Emitter\EmitterController;
use App\Http\Controllers\Leave\LeaveTypeController;
use App\Http\Controllers\Roles\UserGroupController;
use App\Http\Controllers\Roles\RoleAccessController;
use App\Http\Controllers\CoordinatorSurveyController;
use App\Http\Controllers\OrganizationReportController;
use App\Http\Controllers\CoordintorSupevisorController;
use App\Http\Controllers\Occupation\OccupationController;
use App\Http\Controllers\Configurations\PradeshController;
use App\Http\Controllers\Configurations\DistrictController;

//use App\Http\Controllers\Organization\HomeController;


use App\Http\Controllers\Configurations\MuniTypeController;
use App\Http\Controllers\Report\EnumeratorReportController;
use App\Http\Controllers\Configurations\FiscalYearController;
use App\Http\Controllers\Organization\OrganizationController;
use App\Http\Controllers\Configurations\DesignationController;
use App\Http\Controllers\Education\EduQualificationController;
use App\Http\Controllers\Report\EnumeratorOrgReportController;
use App\Http\Controllers\Configurations\MunicipalityController;
use App\Http\Controllers\Configurations\QuestionnaireController;
use App\Http\Controllers\EconomicSector\EconomicSectorController;
use App\Http\Controllers\Configurations\ProductAndServiceController;
use App\Http\Controllers\EnumeratorAssign\EnumeratorAssignController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\SurveyListController;

Route::get('privacy-policies', [HomeController::class, 'privacyPolicy'])->name('privacy.policy');

Auth::routes();
Route::get('/', function () {
    return Redirect::to('/login');
});
//Route::get('/', 'HomeController@index');

Route::get('duplicate',[HomeController::class,'duplicateAnswer']);
Route::group(['middleware' => ['auth', 'roles']], function () {

    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    Route::prefix('roles')->group(function () {
        Route::resource('/menu', MenuController::class);
        Route::get('/menu/menuControllerChangeStatus/{id}', [MenuController::class, 'changeStatus']);
        Route::resource('/group', UserGroupController::class);
        Route::get('/roleAccessIndex', [RoleAccessController::class, 'index']);
        Route::get('roleChangeAccess/{allowId}/{id}', [RoleAccessController::class, 'changeAccess']);
    });

    Route::resource('/user', UserController::class);
    Route::get('/user/status/{id}', [UserController::class, 'status']);
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('profile/profilePic', [UserController::class, 'profilePic']);
    Route::post('/profile/password', [UserController::class, 'password']);

    Route::prefix('configurations')->group(function () {
        Route::resource('/designation', DesignationController::class);
        Route::resource('/fiscalYear', FiscalYearController::class);
        Route::get('/fiscalYear/status/{id}', [FiscalYearController::class, 'status']);
        Route::resource('/pradesh', PradeshController::class);
        Route::resource('/muniType', MuniTypeController::class);
        Route::resource('/district', DistrictController::class);
        Route::resource('/municipality', MunicipalityController::class);
        Route::resource('/questionnaire', QuestionnaireController::class);
    });

    Route::prefix('logs')->group(function () {
        Route::get('/loginLogs', [LogController::class, 'loginLogs']);
        Route::get('/failLoginLogs', [LogController::class, 'failLogin']);
    });

    //Economic Sector
    Route::resource('/economic_sector', EconomicSectorController::class);

    //Product and Service
    Route::resource('/product_and_service', ProductAndServiceController::class);

    //Occupation
    Route::resource('/occupation', OccupationController::class);

    //Education Qualification
    Route::resource('/education_qualification', EduQualificationController::class);

    //Organization
    Route::get('/get/district/{pradesh_id}', [OrganizationController::class, 'getDistrict']);
    Route::get('/get/municipality/{district_id}', [OrganizationController::class, 'getMunicipality']);
    Route::resource('/organization', OrganizationController::class);

    //Survey
    Route::resource('/survey', SurveyController::class);

    Route::get('/orgs/status/{id}', [OrganizationController::class, 'status'])->name('orgs.status');
    Route::get('/survey/status/{id}', [SurveyController::class, 'status'])->name('survey.status');

    Route::resource('/emitter', EmitterController::class);
    Route::post('/emitter/{id}/password',[EmitterController::class,'changePassword'])->name('emitter.changePassword');

    //    Route::post('/enumeratorassign/add/', [EnumeratorAssignController::class,'add'])->name('enumeratorassign.add');
    Route::resource('/enumeratorassign', EnumeratorAssignController::class);
    Route::get('/enumeratorassign/delete/{id}', [EnumeratorAssignController::class, 'remove']);

    Route::resource('/report/enumeratorreport', EnumeratorReportController::class);
    //Leave
    Route::resource('/configurations/leavetype', LeaveTypeController::class);






    /* Report */
    Route::resource('/report/reportbyquestions', ReportByQuesController::class);
    Route::get('/enumerator/organization', [EnumeratorOrgReportController::class, 'index'])->name('enumerator.org');



    Route::get('/import/org', [OrganizationController::class, 'getImport'])->name('org.import');
    Route::post('/import/org', [OrganizationController::class, 'storeImport'])->name('org.import.store');

    /* Export */
    Route::get('/export/enumerator', [EnumeratorOrgReportController::class, 'export'])->name('enumeratororg.export');

    /* Questionnaire*/

    /* Survey Responses */
    Route::get('survey_response', [SurveyResponseController::class, 'index']);
    Route::get('survey_response/{id}', [SurveyResponseController::class, 'show'])->name('survey.response.show');
    Route::get('view_response/{id}', [SurveyResponseController::class, 'viewResponse'])->name('survey.view');
    Route::get('approve_response/{id}', [SurveyResponseController::class, 'approveResponse'])->name('survey.approve');

    /* Coordinator Survey */

    Route::get('field_response', [CoordinatorSurveyController::class, 'index']);
    Route::get('field_response/{id}', [CoordinatorSurveyController::class, 'show'])->name('field.response.show');
    Route::post('field_response/{id}/feedback', [CoordinatorSurveyController::class, 'feedback'])->name('field.response.feedback');
    Route::get('view_field_response/{id}', [CoordinatorSurveyController::class, 'viewResponse'])->name('field.view');
    Route::get('approve_field_response/{id}', [CoordinatorSurveyController::class, 'approveResponse'])->name('field.approve');

    /* Coordinator Supervisor */

    Route::resource('/coordinator_supervisor', CoordintorSupevisorController::class);
    Route::get('/return_to_coordiantor/{id}',[SurveyListController::class,'returnToCoordinator'])->name('return.coordinator');
    /* Surey Status Controller */

    Route::get('survey_status/view', [EnumeratorReportController::class, 'view'])->name('survey_status.view');

    Route::get('monitor', [DataMonitoringController::class, 'index'])->name('monitor.index');
    Route::get('report_organization', [OrganizationReportController::class, 'index'])->name('orgReport.index');


    /* Export */
    Route::get('/enumerator-pdf/{id}', [DataMonitoringController::class, 'export'])->name('enumerator-export');
});
Route::get('/occupation_filter/{id}', [OccupationController::class, 'filterOccupation']);

Route::get('/questionnaire/download/{id}', [QuestionnaireController::class, 'download'])->name('questionnaire.download');
Route::get('/map',[MapController::class,'index'])->name('map.index');

