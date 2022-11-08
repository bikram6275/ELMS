<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->truncate();
        $rows = [
            [
                'parent_id' => '0',
                'menu_name' => 'Users',
                'menu_link' => '/user',
                'menu_controller' => 'UserController',
                'menu_css' => '',
                'menu_icon' => '<i class="fa fa-user-circle" aria-hidden="true"></i>',
                'menu_status' => '1',
                'menu_order' => '2'
            ],
            [
                'parent_id' => '0',
                'menu_name' => 'Roles',
                'menu_link' => '',
                'menu_controller' => '',
                'menu_css' => '',
                'menu_icon' => '<i class="fa fa-wrench" aria-hidden="true"></i>',
                'menu_status' => '1',
                'menu_order' => '3'
            ],
            [
                'parent_id' => '0',
                'menu_name' => 'Configuration',
                'menu_link' => '',
                'menu_controller' => '',
                'menu_css' => '',
                'menu_icon' => '<i class="fa fa-gears" aria-hidden="true"></i>',
                'menu_status' => '1',
                'menu_order' => '4'
            ],


            [
                'parent_id' => '0',
                'menu_name' => 'Logs',
                'menu_link' => '',
                'menu_controller' => '',
                'menu_css' => '',
                'menu_icon' => '<i class="fa fa-child" aria-hidden="true"></i>',
                'menu_status' => '1',
                'menu_order' => '5'
            ],

            [
                'parent_id' => '2',
                'menu_name' => 'Menus',
                'menu_link' => '/roles/menu',
                'menu_controller' => 'MenuController',
                'menu_css' => '',
                'menu_icon' => '<i class="fa fa-list" aria-hidden="true"></i>',
                'menu_status' => '1',
                'menu_order' => '1'
            ],

            [
                'parent_id' => '2',
                'menu_name' => 'User Groups',
                'menu_link' => '/roles/group',
                'menu_controller' => 'UserGroupController',
                'menu_css' => '',
                'menu_icon' => '<i class="fa fa-group" aria-hidden="true"></i>',
                'menu_status' => '1',
                'menu_order' => '2'
            ],
            [
                'parent_id' => '2',
                'menu_name' => 'Role Access',
                'menu_link' => '/roles/roleAccessIndex',
                'menu_controller' => 'RoleAccessController',
                'menu_css' => '',
                'menu_icon' => '<i class="fa fa-unlock" aria-hidden="true"></i>',
                'menu_status' => '1',
                'menu_order' => '3'
            ],
            [
                'parent_id' => '3',
                'menu_name' => 'Designation',
                'menu_link' => '/configurations/designation',
                'menu_controller' => 'DesignationController',
                'menu_css' => '',
                'menu_icon' => '<i class="fa fa-gears" aria-hidden="true"></i>',
                'menu_status' => '1',
                'menu_order' => '1'
            ],

            [
                'parent_id' => '3',
                'menu_name' => 'Fiscal Year',
                'menu_link' => '/configurations/fiscalYear',
                'menu_controller' => 'FiscalYearController',
                'menu_css' => '',
                'menu_icon' => '<i class="fa fa-gears" aria-hidden="true"></i>',
                'menu_status' => '1',
                'menu_order' => '2'
            ],


            [
                'parent_id' => '3',
                'menu_name' => 'Pradesh',
                'menu_link' => '/configurations/pradesh',
                'menu_controller' => 'PradeshController',
                'menu_css' => '',
                'menu_icon' => '<i class="fa fa-gears" aria-hidden="true"></i>',
                'menu_status' => '1',
                'menu_order' => '3'
            ],
            [
                'parent_id' => '3',
                'menu_name' => 'Municipality Type',
                'menu_link' => '/configurations/muniType',
                'menu_controller' => 'MuniTypeController',
                'menu_css' => '',
                'menu_icon' => '<i class="fa fa-gears" aria-hidden="true"></i>',
                'menu_status' => '1',
                'menu_order' => '4'
            ],

            [
                'parent_id' => '3',
                'menu_name' => 'District',
                'menu_link' => '/configurations/district',
                'menu_controller' => 'DistrictController',
                'menu_css' => '',
                'menu_icon' => '<i class="fa fa-gears" aria-hidden="true"></i>',
                'menu_status' => '1',
                'menu_order' => '5'
            ],
            [
                'parent_id' => '3',
                'menu_name' => 'Municipality',
                'menu_link' => '/configurations/municipality',
                'menu_controller' => 'MunicipalityController',
                'menu_css' => '',
                'menu_icon' => '<i class="fa fa-gears" aria-hidden="true"></i>',
                'menu_status' => '1',
                'menu_order' => '6'

            ],
            [
                'parent_id' => '3',
                'menu_name' => 'Leave',
                'menu_link' => '/configurations/leavetype',
                'menu_controller' => 'LeaveTypeController',
                'menu_css' => '',
                'menu_icon' => '<i class="fa fa-gears	" aria-hidden="true"></i>',
                'menu_status' => '1',
                'menu_order' => '7'
            ],

            [
                'parent_id' => '3',
                'menu_name' => 'Economic Sector',
                'menu_link' => '/economic_sector',
                'menu_controller' => 'EconomicSectorController',
                'menu_css' => '',
                'menu_icon' => '<i class="fa fa-industry" aria-hidden="true"></i>',
                'menu_status' => '1',
                'menu_order' => '8'
            ],
            [
                'parent_id' => '3',
                'menu_name' => 'Product And Services',
                'menu_link' => '/product_and_service',
                'menu_controller' => 'ProductAndServiceController',
                'menu_css' => '',
                'menu_icon' => '<i class="fa fa-industry" aria-hidden="true"></i>',
                'menu_status' => '1',
                'menu_order' => '9'
            ],
            [
                'parent_id' => '3',
                'menu_name' => 'Occupation',
                'menu_link' => '/occupation',
                'menu_controller' => 'OccupationController',
                'menu_css' => '',
                'menu_icon' => '<i class="fa fa-tasks" aria-hidden="true"></i>',
                'menu_status' => '1',
                'menu_order' => '10'
            ],
            [
                'parent_id' => '3',
                'menu_name' => 'Education Qualification',
                'menu_link' => '/education_qualification',
                'menu_controller' => 'EduQualificationController',
                'menu_css' => '',
                'menu_icon' => '<i class="fas fa-graduation-cap	" aria-hidden="true"></i>',
                'menu_status' => '1',
                'menu_order' => '11'
            ],

            [
                'parent_id' => '4',
                'menu_name' => 'Login Logs',
                'menu_link' => '/logs/loginLogs',
                'menu_controller' => 'LogController',
                'menu_css' => '',
                'menu_icon' => '<i class="fa fa-user-plus" aria-hidden="true"></i>',
                'menu_status' => '1',
                'menu_order' => '1'
            ],

            [
                'parent_id' => '4',
                'menu_name' => 'Failed Login Logs',
                'menu_link' => '/logs/failLoginLogs',
                'menu_controller' => 'LogController',
                'menu_css' => '',
                'menu_icon' => '<i class="fa fa-user-times" aria-hidden="true"></i>',
                'menu_status' => '1',
                'menu_order' => '2'
            ],
            [
                'parent_id' => '0',
                'menu_name' => 'Questions',
                'menu_link' => '/question',
                'menu_controller' => 'QuestionController',
                'menu_css' => '',
                'menu_icon' => '<i class="fa fa-list" aria-hidden="true"></i>',
                'menu_status' => '1',
                'menu_order' => '6'
            ],

            [
                'parent_id' => '0',
                'menu_name' => 'Organization',
                'menu_link' => '/organization',
                'menu_controller' => 'OrganizationController',
                'menu_css' => '',
                'menu_icon' => '<i class="fa fa-building" aria-hidden="true"></i>',
                'menu_status' => '1',
                'menu_order' => '7'
            ],
            [
                'parent_id' => '0',
                'menu_name' => 'Enumerator',
                'menu_link' => '/emitter',
                'menu_controller' => 'EmitterController',
                'menu_css' => '',
                'menu_icon' => '<i class="fa fa-user-circle" aria-hidden="true"></i>',
                'menu_status' => '1',
                'menu_order' => '8'
            ],

            [
                'parent_id' => '0',
                'menu_name' => 'Enumerator Assign',
                'menu_link' => '/enumeratorassign',
                'menu_controller' => 'EnumeratorAssignController',
                'menu_css' => '',
                'menu_icon' => '<i class="fas fa-user-check"></i>',
                'menu_status' => '1',
                'menu_order' => '9'
            ],
            [
                'parent_id' => '0',
                'menu_name' => 'Survey',
                'menu_link' => '/survey',
                'menu_controller' => 'SurveyController',
                'menu_css' => '',
                'menu_icon' => '<i class="fas fa-poll"></i>',
                'menu_status' => '1',
                'menu_order' => '10'
            ],



            [
                'parent_id' => '0',
                'menu_name' => 'Survey List',
                'menu_link' => '/survey_list',
                'menu_controller' => 'SurveyListController',
                'menu_css' => '',
                'menu_icon' => '<i class="fa fa-list" aria-hidden="true"></i>',
                'menu_status' => '1',
                'menu_order' => '11'
            ],
            [
                'parent_id' => '0',
                'menu_name' => 'Survey Occupation',
                'menu_link' => '/survey_occupation',
                'menu_controller' => 'SurveyOccupationController',
                'menu_css' => '',
                'menu_icon' => '<i class="fa fa-list" aria-hidden="true"></i>',
                'menu_status' => '1',
                'menu_order' => '12'
            ],
            [
                'parent_id' => '0',
                'menu_name' => 'Survey Report',
                'menu_link' => '',
                'menu_controller' => '',
                'menu_css' => '',
                'menu_icon' => '<i class="fa fa-child" aria-hidden="true"></i>',
                'menu_status' => '1',
                'menu_order' => '13'
            ],

            [
                'parent_id' => '28',
                'menu_name' => 'Enumerator Report',
                'menu_link' => '/report/enumeratorreport',
                'menu_controller' => 'EnumeratorReportController',
                'menu_css' => '',
                'menu_icon' => '<i class="fa fa-bar-chart" aria-hidden="true"></i>',
                'menu_status' => '1',
                'menu_order' => '1'
            ],
            [
                'parent_id' => '28',
                'menu_name' => ' Report By Question',
                'menu_link' => '/report/reportbyquestions',
                'menu_controller' => 'ReportByQuesController',
                'menu_css' => '',
                'menu_icon' => '<i class="fa fa-line-chart" aria-hidden="true"></i>',
                'menu_status' => '1',
                'menu_order' => '2'
            ],
            [
                'parent_id' => '28',
                'menu_name' => 'Enumerator Organization',
                'menu_link' => '/enumerator/organization',
                'menu_controller' => 'EnumeratorOrgReportController',
                'menu_css' => '',
                'menu_icon' => '<i class="fa fa-user-plus" aria-hidden="true"></i>',
                'menu_status' => '1',
                'menu_order' => '2'
            ],
            [
                'parent_id' => '28',
                'menu_name' => 'Organization Report',
                'menu_link' => '/report_organization',
                'menu_controller' => 'OrganizationReportController',
                'menu_css' => '',
                'menu_icon' => '<i class="fa fa-user-plus" aria-hidden="true"></i>',
                'menu_status' => '1',
                'menu_order' => '3'
            ],
            [
                'parent_id' => '3',
                'menu_name' => 'Questionnaire',
                'menu_link' => '/configurations/questionnaire',
                'menu_controller' => 'QuestionnaireController',
                'menu_css' => '',
                'menu_icon' => '<i class="fa fa-gears	" aria-hidden="true"></i>',
                'menu_status' => '1',
                'menu_order' => '8'
            ],
            [
                'parent_id' => '0',
                'menu_name' => 'Survey Result',
                'menu_link' => '/field_response',
                'menu_controller' => 'CoordinatorSurveyController',
                'menu_css' => '',
                'menu_icon' => '<i class="fa fa-users" aria-hidden="true"></i>',
                'menu_status' => '1',
                'menu_order' => '6'
            ],

            [
                'parent_id' => '0',
                'menu_name' => 'Survey Response',
                'menu_link' => '/survey_response',
                'menu_controller' => 'SurveyResponseController',
                'menu_css' => '',
                'menu_icon' => '<i class="fa fa-users" aria-hidden="true"></i>',
                'menu_status' => '1',
                'menu_order' => '7'
            ],
            [
                'parent_id' => '0',
                'menu_name' => 'Coordinator Supervisor',
                'menu_link' => '/coordinator_supervisor',
                'menu_controller' => 'CoordinatorSupervisorController',
                'menu_css' => '',
                'menu_icon' => '<i class="fa fa-user-circle" aria-hidden="true"></i>',
                'menu_status' => '1',
                'menu_order' => '8'
            ],
            [
                'parent_id' => '0',
                'menu_name' => 'Data Monitoring',
                'menu_link' => '/monitor',
                'menu_controller' => 'DataMonitoringController',
                'menu_css' => '',
                'menu_icon' => '<i class="fa fa-user-circle" aria-hidden="true"></i>',
                'menu_status' => '1',
                'menu_order' => '9'
            ],


        ];
        DB::table('menus')->insert($rows);
    }
}
