<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Turnicet;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CadryController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\BackApiController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\VacationIntegrationController;
use App\Http\Controllers\VacationController;
use App\Http\Controllers\MedController;
use App\Http\Controllers\IncentiveController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\EmmatController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PereviewStatisticController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\SmsController;


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

Route::group([
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::group([
    'middleware' => 'auth:api'
], function ($router) {
    
    Route::get('/1c/vacations', [VacationIntegrationController::class, 'vacations_1c_api']);
    Route::post('/1c/vacations/{vacation_id}/accept', [VacationIntegrationController::class, 'vacations_1c_api_success']);
    Route::post('/1c/vacations/{vacation_id}/refuse', [VacationIntegrationController::class, 'vacations_1c_api_refuse']);

    Route::get('/profile', [AuthController::class, 'userProfile']);
    
    Route::get('/cadry/ExportToWord/{id}', [OrganizationController::class, 'word_export_api']);
    Route::get('/cadry/ExportCadriesToWord', [OrganizationController::class, 'word_export_archive_api']);

    Route::get('/user/tasks', [PereviewStatisticController::class, 'user_tasks']);
    Route::delete('/user/task/{task_id}/delete', [PereviewStatisticController::class, 'task_delete']);

    Route::get('/filter/railways', [OrganizationController::class, 'filter_api_railways']);
    Route::get('/filter/organizations', [OrganizationController::class, 'filter_api_organizations']);
    Route::get('/filter/staffs', [OrganizationController::class, 'filter_api_staffs']);
    Route::get('/filter/departments', [OrganizationController::class, 'filter_api_departments']);
    Route::get('/filter/regions', [OrganizationController::class, 'filter_api_regions']);
    Route::get('/filter/cities', [OrganizationController::class, 'filter_api_cities']);
    Route::get('/filter/educations', [OrganizationController::class, 'filter_api_educations']);
    Route::get('/filter/vacations', [OrganizationController::class, 'filter_api_vacations']);
    Route::get('/filter/worklevels', [OrganizationController::class, 'filter_api_worklevels']);
    Route::get('/filter/academicTitlies', [OrganizationController::class, 'filter_api_academicTitlies']);
    Route::get('/filter/academicDegree', [OrganizationController::class, 'filter_api_academicDegree']);
    Route::get('/filter/nationalities', [OrganizationController::class, 'filter_api_nationalities']);
    Route::get('/filter/parties', [OrganizationController::class, 'filter_api_parties']);
    Route::get('/filter/languages', [OrganizationController::class, 'filter_api_languages']);
    Route::get('/filter/instituts', [OrganizationController::class, 'filter_api_instituts']);
    Route::get('/filter/abroads', [OrganizationController::class, 'filter_api_abroads']);
    Route::get('/filter/academics', [OrganizationController::class, 'filter_api_academics']);
    
    Route::get('/filter/cadry-informations', [OrganizationController::class, 'filter_api_cadry_informations']);

    
    Route::get('/organization/filter/departments', [OrganizationController::class, 'filter_api_org_departments']);
    Route::get('/organization/filter/staffs', [OrganizationController::class, 'filter_api_org_staffs']);
    Route::get('/organization/classifications', [DepartmentController::class, 'load_classifications']);

    Route::group([
        'middleware' => [
            'permission:management_organizations'
            ]
        ], function () {
        
        Route::get('/management/organizations', [OrganizationController::class, 'api_organizations']);

    }); 

    Route::group([
        'middleware' => [
            'permission:management_statistics'
            ]
        ], function () {
        
        Route::get('/management/statistics', [CadryController::class, 'api_statistics']);
        
    }); 

    Route::group([
        'middleware' => [
            'permission:pereview_statistics'
            ]
        ], function () {
        
        Route::get('/pereview/statistics/retireds', [PereviewStatisticController::class, 'pereview_retireds']);
        Route::get('/pereview/statistics/contractors', [PereviewStatisticController::class, 'pereview_contractors']);
        Route::get('/pereview/statistics/domestic_workers', [PereviewStatisticController::class, 'pereview_domestic_workers']);
        Route::get('/pereview/statistics/not-meds', [PereviewStatisticController::class, 'pereview_not_meds']);
        Route::get('/pereview/statistics/expired-meds', [PereviewStatisticController::class, 'pereview_expired_meds']);
        Route::get('/pereview/statistics/vacations', [PereviewStatisticController::class, 'pereview_vacations']);
        Route::get('/pereview/statistics/not-career-cadries', [PereviewStatisticController::class, 'pereview_not_careers']);
        Route::get('/pereview/statistics/not-relative-cadries', [PereviewStatisticController::class, 'pereview_not_relatives']);
        Route::get('/pereview/statistics/birthdays', [PereviewStatisticController::class, 'pereview_birthdays']);
        Route::get('/pereview/statistics/new-cadries', [PereviewStatisticController::class, 'pereview_new_cadries']);
        Route::get('/pereview/statistics/delete-cadries', [PereviewStatisticController::class, 'pereview_delete_cadries']);
        Route::get('/pereview/statistics/delete-black-cadries', [PereviewStatisticController::class, 'pereview_delete_black_cadries']);
        Route::get('/pereview/statistics/vacancies', [PereviewStatisticController::class, 'pereview_vacancies']);
        Route::get('/pereview/statistics/over', [PereviewStatisticController::class, 'pereview_over']);

        
        Route::get('/pereview/statistics/stafffiles', [PereviewStatisticController::class, 'stafffiles']);
        
    }); 

    Route::group([
        'middleware' => [
            'permission:organization_cadries'
            ]
        ], function () {

        //organization-cadries    
            Route::get('/organization/cadries', [OrganizationController::class, 'api_cadries']);
            Route::get('/organization/cadries/{id}', [BackApiController::class, 'api_cadry_edit']);
            Route::put('/organization/cadries/{cadry}', [BackApiController::class, 'api_cadry_edit_post']);
            Route::post('/organization/cadries/{cadry}/update/photo', [BackApiController::class, 'api_cadry_update_photo_post']);

            
            Route::get('/organization/cadries/information/{cadry}', [BackApiController::class, 'api_cadry_information']);
            Route::put('/organization/cadries/information/{cadry}', [BackApiController::class, 'api_cadry_information_post']);

            
            Route::get('/organization/cadry/instituts', [BackApiController::class, 'api_cadry_institut']);
            Route::post('/organization/cadry/instituts/{cadry_id}/add', [BackApiController::class, 'api_cadry_institut_add']);
            Route::put('/organization/cadry/instituts/{infoeducation_id}/update', [BackApiController::class, 'api_cadry_institut_update']);
            Route::delete('/organization/cadry/instituts/{infoeducation_id}/delete', [BackApiController::class, 'api_cadry_institut_delete']);

            Route::get('/organization/cadry/{cadry_id}/abroadStudies', [BackApiController::class, 'cadry_api_abroadStudies']);
            Route::post('/organization/cadry/abroadStudies/{cadry_id}/add', [BackApiController::class, 'cadry_api_abroadStudies_add']);
            Route::put('/organization/cadry/abroadStudies/{abroad_study_id}/update', [BackApiController::class, 'cadry_api_abroadStudies_update']);
            Route::delete('/organization/cadry/abroadStudies/{abroad_study_id}/delete', [BackApiController::class, 'cadry_api_abroadStudies_delete']);

            Route::get('/organization/cadry/{cadry_id}/academicStudies', [BackApiController::class, 'cadry_api_academicStudies']);
            Route::post('/organization/cadry/academicStudies/{cadry_id}/add', [BackApiController::class, 'cadry_api_academicStudies_add']);
            Route::put('/organization/cadry/academicStudies/{academic_study_id}/update', [BackApiController::class, 'cadry_api_academicStudies_update']);
            Route::delete('/organization/cadry/academicStudies/{academic_study_id}/delete', [BackApiController::class, 'cadry_api_academicStudies_delete']);

            
            Route::get('/organization/cadry/{id}/careers', [BackApiController::class, 'cadry_api_careers']);
            Route::post('/organization/cadry/career/{cadry_id}/add', [BackApiController::class, 'cadry_api_career_add']);
            Route::put('/organization/cadry/career/{career_id}/update', [BackApiController::class, 'cadry_api_career_update']);
            Route::delete('/organization/cadry/career/{career_id}/delete', [BackApiController::class, 'cadry_api_career_delete']);
            Route::put('/organization/cadry/career/sortable', [BackApiController::class, 'api_career_sortable']);
        
            Route::get('/organization/cadry/{cadry_id}/relatives', [BackApiController::class, 'cadry_api_relatives']);
            Route::post('/organization/cadry/relatives/{cadry_id}/add', [BackApiController::class, 'api_add_relative_cadry']);
            Route::put('/organization/cadry/relatives/{cadry_relative_id}/update', [BackApiController::class, 'api_update_relative_cadry']);
            Route::delete('/organization/cadry/relatives/{cadry_relative_id}/delete', [BackApiController::class, 'api_delete_relative_cadry']);
            Route::put('/organization/cadry/relatives/sortable', [BackApiController::class, 'api_relatives_sortable']);

            
            Route::get('/organization/cadry/{cadry_id}/punishments', [BackApiController::class, 'cadry_api_punishments']);
            Route::post('/organization/cadry/punishment/{cadry_id}/add', [BackApiController::class, 'api_add_discip_cadry']);
            Route::put('/organization/cadry/punishment/{punishment_id}/update', [BackApiController::class, 'api_update_discip_cadry']);
            Route::delete('/organization/cadry/punishment/{punishment_id}/delete', [BackApiController::class, 'api_delete_discip_cadry']);

            
            Route::get('/organization/cadry/{cadry_id}/incentives', [BackApiController::class, 'api_cadry_incentives']);
            Route::post('/organization/cadry/incentives/{cadry_id}/add', [BackApiController::class, 'api_add_incentive_cadry']);
            Route::put('/organization/cadry/incentives/{incentive_id}/update', [BackApiController::class, 'api_update_incentive_cadry']);
            Route::delete('/organization/cadry/incentives/{incentive_id}/delete', [BackApiController::class, 'api_delete_incentive_cadry']);

            Route::get('/organization/cadry/{cadry_id}/stafffiles', [BackApiController::class, 'api_cadry_stafffiles']);
            Route::post('/organization/cadry/stafffiles/{cadry_id}/add', [BackApiController::class, 'api_add_stafffiles_cadry']);
            Route::post('/organization/cadry/stafffiles/{staff_file_id}/update', [BackApiController::class, 'api_update_stafffiles_cadry']);
            Route::delete('/organization/cadry/stafffiles/{staff_file_id}/delete', [BackApiController::class, 'api_delete_stafffiles_cadry']);

            
            Route::get('/organization/cadry/{cadry_id}/meds', [BackApiController::class, 'api_cadry_meds']);
            Route::delete('/organization/cadry/meds/{med_id}/delete', [BackApiController::class, 'api_cadry_meds_delete']);
            Route::put('/organization/cadry/meds/{med_id}/update', [MedController::class, 'api_cadry_meds_update']);

            
            Route::get('/organization/cadry/{cadry_id}/vacations', [VacationController::class, 'api_cadry_vacations']);
            Route::delete('/organization/cadry/vacations/{vacation_id}/delete', [VacationController::class, 'api_cadry_vacations_delete']);

            
        Route::get('/organization/info/cadries', [OrganizationController::class, 'cadries_info']);
        Route::get('/organization/info/department/staffs', [OrganizationController::class, 'loadvacan']);
        Route::post('/organization/addworker', [BackApiController::class, 'api_add_worker']);
   
        Route::get('/organization/cadry-staff/{cadry_staff_id}', [BackApiController::class, 'apiStaffCadryEdit']);
        
        Route::get('/organization/new-cadry-staff/{cadry_id}', [BackApiController::class, 'apiNewStaffToCadry']);
        Route::post('/organization/new-cadry-staff/{cadry_id}', [BackApiController::class, 'apiNewStaffToCadryPost']);

        Route::get('/organization/careerCheck', [BackApiController::class, 'careerCheck']);
        Route::put('/organization/cadry-staff/{department_cadry_id}', [BackApiController::class, 'api_department_cadry_update']);
        Route::post('/organization/cadry-staff/{department_cadry_id}', [BackApiController::class, 'SuccessDeleteCadryStaff']);

        
        Route::post('/organization/cadry/{cadry_id}/delete', [BackApiController::class, 'full_delete_cadry']);


        
        Route::get('/organization/check-pinfl', [BackApiController::class, 'api_check_pinfl']);

        Route::get('/organization/cadry/ExportToExcel', [BackApiController::class, 'ExportToExcel']);

        
        
        Route::get('/qualification/apparats', [TrainingController::class, 'apparats']);
        Route::get('/qualification/cadry/{cadry_id}', [TrainingController::class, 'cadry_filter']);
        Route::post('/qualification/cadry/{cadry_id}/add', [TrainingController::class, 'cadry_add_qual']);
        Route::get('/qualification/statistics', [TrainingController::class, 'statistics']);
        Route::put('/qualification/{qualification_id}/update', [TrainingController::class, 'cadry_qual_update']);
        Route::delete('/qualification/{qualification_id}/delete', [TrainingController::class, 'cadry_qual_delete']);


        Route::get('/organization/cadry/{cadry_id}/passports', [BackApiController::class, 'api_cadry_passports']);
        Route::post('/organization/cadry/passport/{cadry_id}/add', [BackApiController::class, 'api_add_passports_cadry']);
        Route::post('/organization/cadry/passport/{passport_id}/update', [BackApiController::class, 'api_update_passports_cadry']);
        Route::delete('/organization/cadry/passport/{passport_id}/delete', [BackApiController::class, 'api_delete_passports_cadry']);
        //organization-Staff-positions
       // Route::get('/organization/staff/positions', [StaffController::class, 'api_staff_positions']);
    });

    Route::group([
        'middleware' => [
            'permission:organization_staffs'
            ]
        ], function () {

        //organization-Staff-positions
        Route::get('/organization/staff/positions', [StaffController::class, 'api_staff_positions']);
        Route::get('/organization/staff/categories', [StaffController::class, 'api_categories']);

        Route::post('/organization/staff/add', [StaffController::class, 'api_add_staff']);
        Route::put('/organization/staff/{staff_id}/update', [StaffController::class, 'api_update_staff']);
        Route::delete('/organization/staff/{staff_id}/delete', [StaffController::class, 'api_delete_staff']);
        
    }); 

    Route::group([
        'middleware' => [
            'permission:organization_departments'
            ]
        ], function () {

        //organization-Departments
        Route::get('/organization/departments', [DepartmentController::class, 'departments']);
        Route::get('/organization/staffs', [DepartmentController::class, 'load_staffs']);
        Route::get('/organization/department/{department_id}/cadries', [DepartmentController::class, 'departments_cadries']);
        Route::post('/organization/add/department', [DepartmentController::class, 'add_department']);
        Route::put('/organization/department/{department_id}/update', [DepartmentController::class, 'update_department']);
        Route::delete('/organization/department/{department_id}/delete', [DepartmentController::class, 'delete_department']);
        Route::get('/organization/department/{department_id}/staffs', [DepartmentController::class, 'department_staffs']);
        Route::post('/organization/departmentStaff/{department_id}/create', [DepartmentController::class, 'departmentStaffCreate']);
        Route::put('/organization/departmentStaff/{department_staff_id}/update', [DepartmentController::class, 'departmentStaffUpdate']);
        Route::delete('/organization/departmentStaff/{department_staff_id}/delete', [DepartmentController::class, 'departmentStaffDelete']);
        Route::get('/organization/departmentStaff/{department_staff_id}/addCadry', [DepartmentController::class, 'addCadryToDepartmentStaff']);
        Route::post('/organization/departmentStaff/{department_staff_id}/addCadry', [DepartmentController::class, 'ApiaddCadryToDepartmentStaff']);
        

        Route::get('/organization/departmentStaffCadries/{department_staff_id}', [DepartmentController::class, 'department_staff_caddries']);
        
    });


    
    
    Route::group([
        'middleware' => [
            'permission:organization_vacations'
            ]
        ], function () {

        //organization-vacations
        Route::get('/organization/search/cadries', [VacationController::class, 'loadCadryApi']);
        Route::get('/organization/vacations', [VacationController::class, 'api_vacations']);
        Route::get('/organization/vacations/add', [VacationController::class, 'api_vacations_add']);
        Route::post('/organization/vacations/add', [VacationController::class, 'api_vacations_add_post']);
        Route::put('/organization/vacations/{vacation_id}/update', [VacationController::class, 'api_vacations_edit']);
        Route::delete('/organization/vacations/{vacation_id}/delete', [VacationController::class, 'api_vacations_delete']);
        Route::put('/organization/vacations/{vacation_id}/decret/update', [VacationController::class, 'api_vacations_decret_success']);
        
    }); 

    Route::group([
        'middleware' => [
            'permission:organization_meds'
            ]
        ], function () {

        //organization-vacations
        Route::get('/organization/meds', [MedController::class, 'meds']);
        Route::post('/organization/med/{cadry_id}/accepted', [MedController::class, 'med_accepted']);
        Route::post('/organization/create-med', [MedController::class, 'create_med_info']);
        
    }); 

    Route::group([
        'middleware' => [
            'permission:organization_incentives'
            ]
        ], function () {

        //organization-vacations
        Route::get('/organization/incentives', [IncentiveController::class, 'incentives']);
        
    }); 

    Route::group([
        'middleware' => [
            'permission:organization_discips'
            ]
        ], function () {

        //organization-vacations
        Route::get('/organization/disciplinary-acttions', [IncentiveController::class, 'disciplinary_actions']);
        
    }); 

    Route::group([
        'middleware' => [
            'permission:organization_archive'
            ]
        ], function () {

        //organization-vacations
        Route::get('/organization/archive/pinfl', [ArchiveController::class, 'archive_cadry']);
        Route::get('/organization/archive/accepted-cadry/{archive_cadry_id}', [ArchiveController::class, 'accept_get_cadry']);
        Route::post('/organization/archive/accepted-cadry/{archive_cadry_id}', [ArchiveController::class, 'save_archive_cadry']);

        
        Route::get('/organization/archive/cadries', [ArchiveController::class, 'archive_cadries']);
        
    }); 
    //cadry statistics
    Route::group([
        'middleware' => [
            'permission:organization_statistics'
            ]
        ], function () {
        
        Route::get('/organization/statistics', [CadryController::class, 'api_cadry_statistics']);
       
    });

    Route::group([
        'middleware' => [
            'permission:cadry_leader_statistics'
            ]
        ], function () {
        
        Route::get('/organization/leader/statistics', [CadryController::class, 'api_cadry_leader_statistics']);
       
    });

    Route::group([
        'middleware' => [
            'permission:cadry_leader_cadries'
            ]
        ], function () {
        
        Route::get('/organization/leader/cadries', [OrganizationController::class, 'api_cadry_leader_cadries']);
       
    });
    
    Route::group([
        'middleware' => [
            'permission:organization_cadries'
            ]
        ], function () {
        
        Route::get('/administration/roles', [UserController::class, 'api_roles']);
        Route::get('/administration/role/{role_id}/permissions', [UserController::class, 'api_role_pers']);
        Route::put('/administration/role/{role_id}/permissions/update', [UserController::class, 'api_role_pers_update']);
        Route::delete('/administration/role/{role_id}/delete', [UserController::class, 'api_role_delete']);
       
    });

    Route::group([
        'middleware' => [
            'permission:admin'
            ]
        ], function () {
        
        Route::get('/administration/users', [UserController::class, 'api_users']);
        Route::get('/administration/user/{user_id}/update', [UserController::class, 'api_user_update_view']);
        Route::post('/administration/user/{user_id}/update', [UserController::class, 'api_user_update']);
        Route::get('/administration/user/create', [UserController::class, 'api_user_create_get']);
        Route::post('/administration/user/create', [UserController::class, 'api_user_create_post']);
       
    });

    //emmat
    Route::group([
        'middleware' => [
            'permission:admin'
            ]
        ], function () {
        
        Route::get('/emmat/cadries', [EmmatController::class, 'emmat_cadries']);
        Route::post('/emmat/cadry/addToken/{emmat_cadry_id}', [EmmatController::class, 'add_token_to_cadry']);
       
    });

    //qulaification
    Route::group([
        'middleware' => [
            'permission:management_qualifications'
            ]
        ], function () {

        
        Route::get('/qualification/management/apparats', [TrainingController::class, 'management_apparats']);
        Route::post('/qualification/management/apparat/add', [TrainingController::class, 'management_add_apparat']);
        Route::put('/qualification/management/apparat/{apparat_id}/update', [TrainingController::class, 'management_apparat_update']);
        Route::delete('/qualification/management/apparat/{apparat_id}/delete', [TrainingController::class, 'management_apparat_delete']);

        
        Route::get('/qualification/management/directions', [TrainingController::class, 'management_apparat_directions']);
        Route::post('/qualification/management/direction/add', [TrainingController::class, 'management_add_direction']);
        Route::put('/qualification/management/direction/{direction_id}/update', [TrainingController::class, 'management_update_direction']);
        Route::delete('/qualification/management/direction/{direction_id}/delete', [TrainingController::class, 'management_delete_direction']);

        
        Route::get('/qualification/management/upgrades', [TrainingController::class, 'management_upgrades']);
        Route::get('/qualification/management/organization/{railway_id}/upgrades', [TrainingController::class, 'management_upgrades_organization']);
        Route::get('/qualification/management/upgrades/export', [TrainingController::class, 'management_upgrades_export']);
       
    });

    //sms send
    Route::group([
        'middleware' => [
            'permission:admin'
            ]
        ], function () {
        
        Route::post('/admin/management/sms/{cadry_id0}/send', [SmsController::class, 'send_sms']);
       
    });


    //mobileApplication
    Route::group([
        'middleware' => [
            'permission:admin'
            ]
        ], function () {
        
        Route::post('/admin/application/cadry', [ApplicationController::class, 'find_cadry']);
       
    });

    
});


Route::post('control', function (Request $request) {

    $control = new Turnicet();
    $control->railway_id = 1;
    $control->organization_id = 1;
    $control->department_id = 1;
    $control->organization_name = $request->organization_name;
    $control->department_name = $request->action;
    $control->tabel = $request->tabel;
    $control->fullname = $request->fullname;
    $control->save();

    return response()->json(['message' => 'success'], 200);
});
