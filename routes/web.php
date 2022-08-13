<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
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
//Auth::routes();
Auth::routes(['register' => false]);

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function() {
    
    Route::get('/cadry', [App\Http\Controllers\CadryController::class, 'index'])->name('cadry');
    Route::get('/regions', [App\Http\Controllers\CadryController::class, 'regions'])->name('regions');
    Route::post('/add-city', [App\Http\Controllers\CadryController::class, 'add_city'])->name('add_city');   
    Route::get('/cadry/staff', [App\Http\Controllers\CadryController::class, 'staff'])->name('staff');
    Route::post('/cadry/addstaf', [App\Http\Controllers\CadryController::class, 'add_staff'])->name('add_staff');
    Route::get('/cadry/departments', [App\Http\Controllers\CadryController::class, 'departments'])->name('departments');
    Route::post('/cadry/edit-department/{id}', [App\Http\Controllers\CadryController::class, 'edit_department'])->name('edit_department');
    Route::post('/cadry/delete-department/{id}', [App\Http\Controllers\CadryController::class, 'delete_department'])->name('delete_department');
    Route::post('/cadry/adddepartments', [App\Http\Controllers\CadryController::class, 'add_department'])->name('add_department');
    Route::post('/edit-cadry-us/{cadry}', [App\Http\Controllers\CadryController::class, 'edit_cadry_us'])->name('edit_cadry_us');

    //education info add,edit,delete
    Route::post('/add-ins-cadry/{id}', [App\Http\Controllers\CadryController::class, 'add_ins_cadry'])->name('add_ins_cadry');
    Route::post('/edit-info-cadry/{id}', [App\Http\Controllers\CadryController::class, 'cadry_info_edit'])->name('cadry_info_edit');
    Route::post('/delete-info-cadry/{id}', [App\Http\Controllers\CadryController::class, 'cadry_info_delete'])->name('cadry_info_delete');

    //career add,edit,delete
    Route::post('/add-career-cadry/{id}', [App\Http\Controllers\CadryController::class, 'add_career_cadry'])->name('add_career_cadry');
    Route::post('/edit-career-cadry/{id}', [App\Http\Controllers\CadryController::class, 'cadry_career_edit'])->name('cadry_career_edit');
    Route::post('/delete-career-cadry/{id}', [App\Http\Controllers\CadryController::class, 'cadry_career_delete'])->name('cadry_career_delete');
    
    //relative add,edit,delete
    Route::post('/add-relative-cadry/{id}', [App\Http\Controllers\CadryController::class, 'add_relative_cadry'])->name('add_relative_cadry');
    Route::post('/edit-relative-cadry/{id}', [App\Http\Controllers\CadryController::class, 'edit_relative_cadry'])->name('edit_relative_cadry');
    Route::post('/delete-relative-cadry/{id}', [App\Http\Controllers\CadryController::class, 'delete_relative_cadry'])->name('delete_relative_cadry');
    
    Route::get('/addworker', [App\Http\Controllers\CadryController::class, 'addworker'])->name('addworker');
    Route::post('/addworkersuccess', [App\Http\Controllers\CadryController::class, 'addworkersuccess'])->name('addworkersuccess');
    Route::post('/delete-cadry/{id}', [App\Http\Controllers\CadryController::class, 'delete_cadry'])->name('delete_cadry');
    
    Route::get('/back-page-cadry', [App\Http\Controllers\CadryController::class, 'back_page_cadry'])->name('back_page_cadry');
    Route::post('/edit-staff/{id}', [App\Http\Controllers\CadryController::class, 'edit_staf'])->name('edit_staf');
    Route::post('/del-staff/{id}', [App\Http\Controllers\CadryController::class, 'del_staf'])->name('del_staf');

    //Kadr malumotlarini taxrirlash
    Route::get('/organizations/cadry-edit/{id}', [App\Http\Controllers\CadryController::class, 'cadry_edit'])->name('cadry_edit');
    Route::get('/organizations/cadry-information/{id}', [App\Http\Controllers\CadryController::class, 'cadry_information'])->name('cadry_information');
    Route::get('/organizations/cadry-career/{id}', [App\Http\Controllers\CadryController::class, 'cadry_career'])->name('cadry_career');
    Route::get('/organizations/cadry-realy/{id}', [App\Http\Controllers\CadryController::class, 'cadry_realy'])->name('cadry_realy');
    Route::get('/organizations/cadry-other/{id}', [App\Http\Controllers\CadryController::class, 'cadry_other'])->name('cadry_other');

    Route::post('/cadry/adddiscip/{id}', [App\Http\Controllers\CadryController::class, 'add_discip_cadry'])->name('add_discip_cadry');
    Route::post('/cadry/editdiscip/{id}', [App\Http\Controllers\CadryController::class, 'edit_discip_cadry'])->name('edit_discip_cadry');
    Route::post('/cadry/deletediscip/{id}', [App\Http\Controllers\CadryController::class, 'delete_discip_cadry'])->name('delete_discip_cadry');
    
    Route::post('/cary/cadry-information/{id}', [App\Http\Controllers\CadryController::class, 'add_abroad_cadry'])->name('add_abroad_cadry');
    Route::post('/cary/editAbroad/{id}', [App\Http\Controllers\CadryController::class, 'edit_abroad_cadry'])->name('edit_abroad_cadry');
    Route::post('/cary/delete_abroad_cadry/{id}', [App\Http\Controllers\CadryController::class, 'delete_abroad_cadry'])->name('delete_abroad_cadry');

    Route::post('/cary/cadryAcademic/{id}', [App\Http\Controllers\CadryController::class, 'add_academic_cadry'])->name('add_academic_cadry');
    Route::post('/cary/editAcademic/{id}', [App\Http\Controllers\CadryController::class, 'edit_academic_cadry'])->name('edit_academic_cadry');
    Route::post('/cary/deleteAcademic/{id}', [App\Http\Controllers\CadryController::class, 'delete_academic_cadry'])->name('delete_academic_cadry');

    Route::post('/cadry/addmed/{id}', [App\Http\Controllers\CadryController::class, 'add_med_cadry'])->name('add_med_cadry');
    Route::post('/cadry/editmed/{id}', [App\Http\Controllers\CadryController::class, 'edit_med_cadry'])->name('edit_med_cadry');
    Route::post('/cadry/deletemed/{id}', [App\Http\Controllers\CadryController::class, 'delete_med_cadry'])->name('delete_med_cadry');

    Route::post('/cadry/addincentive/{id}', [App\Http\Controllers\CadryController::class, 'add_incentive_cadry'])->name('add_incentive_cadry');
    Route::post('/cadry/editincentive/{id}', [App\Http\Controllers\CadryController::class, 'edit_incentive_cadry'])->name('edit_incentive_cadry');
    Route::post('/cadry/deleteincentive/{id}', [App\Http\Controllers\CadryController::class, 'delete_incentive_cadry'])->name('delete_incentive_cadry');
    Route::get('/cadry/cadry-department/{id}', [App\Http\Controllers\CadryController::class, 'cadry_department'])->name('cadry_department');
    Route::get('/cadry/cadry-staff-view/{id}', [App\Http\Controllers\CadryController::class, 'cadry_staff_view'])->name('cadry_staff_view');

    Route::post('/career/sortable', [App\Http\Controllers\CadryController::class, 'sortable_carer']);
    Route::post('/relatives/sortable', [App\Http\Controllers\CadryController::class, 'sortable_relatives']);

    Route::get('/cadry/archive', [App\Http\Controllers\CadryController::class, 'archive_cadry'])->name('archive_cadry');
    Route::get('/cadry/archive/view/{id}', [App\Http\Controllers\CadryController::class, 'cadry_archive_load'])->name('cadry_archive_load');
    Route::post('/cadry/archiveSave/{id}', [App\Http\Controllers\CadryController::class, 'save_archive_cadry'])->name('save_archive_cadry');

    Route::get('/cadry/decret/{id}', [App\Http\Controllers\CadryController::class, 'decret_cadry'])->name('decret_cadry');

    Route::post('/cadry/add_filestaff_cadry/{id}', [App\Http\Controllers\CadryController::class, 'add_filestaff_cadry'])->name('add_filestaff_cadry');
    Route::post('/cadry/edit_filestaff_cadry/{id}', [App\Http\Controllers\CadryController::class, 'edit_stafffile_cadry'])->name('edit_stafffile_cadry');
    Route::post('/cadry/delete_filestaff_cadry/{id}', [App\Http\Controllers\CadryController::class, 'delete_stafffile_cadry'])->name('delete_stafffile_cadry');
    //word export

    Route::get('/word-export/{id}', [App\Http\Controllers\OrganizationController::class, 'word_export'])->name('word_export');

    Route::get('/word-export-demo/{id}', [App\Http\Controllers\OrganizationController::class, 'word_export_demo'])->name('word_export_demo');

   // Route::get('/send-archive-cadry', [App\Http\Controllers\OrganizationController::class, 'send_archive_cadry'])->name('send_archive_cadry');
    Route::get('/cadry/cadry-export-all', [App\Http\Controllers\OrganizationController::class, 'export_excel'])->name('export_excel');
    //Route::get('/cadry/cadry-export-archive-all', [App\Http\Controllers\OrganizationController::class, 'export_excel_arhive'])->name('export_excel_arhive');
    //democadry
    Route::get('/cadry/demo-to-cadry/{id}', [App\Http\Controllers\OrganizationController::class, 'demo_to_cadry'])->name('demo_to_cadry');
    Route::get('/cadry/delete-to-cadry/{id}', [App\Http\Controllers\OrganizationController::class, 'demo_to_delete'])->name('demo_to_delete');
    
    
    //boshqalar
    Route::get('/cadry/incentives', [App\Http\Controllers\OrganizationController::class, 'incentives'])->name('incentives');
    Route::get('/cadry/cadry-staff-organ/{id}', [App\Http\Controllers\OrganizationController::class, 'cadry_staff_organ'])->name('cadry_staff_organ');
    Route::get('/organizations/user-edit', [App\Http\Controllers\OrganizationController::class, 'user_edit'])->name('user_edit');
    Route::post('/organizations/user-edit-success/{id}', [App\Http\Controllers\OrganizationController::class, 'user_edit_success'])->name('user_edit_success');

    
    Route::get('/addstaffToDepartment/{id}', [App\Http\Controllers\ChatController::class, 'addstaffToDepartment'])->name('addstaffToDepartment');

    Route::group(['middleware' => ['can:product-list']], function () {
        Route::get('/cadry/administration/turnicet', [App\Http\Controllers\OrganizationController::class, 'turnicet'])->name('turnicet');
        Route::get('/organizations/cadry-search', [App\Http\Controllers\CadryController::class, 'cadry_search'])->name('cadry_search');
        Route::get('/statistics', [App\Http\Controllers\CadryController::class, 'statistics'])->name('statistics');
        Route::get('/cadry/statistics/photoView', [App\Http\Controllers\OrganizationController::class, 'photoView'])->name('photoView');
        Route::get('/cadry/NewCadries', [App\Http\Controllers\OrganizationController::class, 'newcadries'])->name('newcadries');
        Route::get('/cadry/DelCadries', [App\Http\Controllers\OrganizationController::class, 'delcadries'])->name('delcadries');
        Route::get('/cadry/BirthCadries', [App\Http\Controllers\OrganizationController::class, 'birthcadries'])->name('birthcadries');
        Route::get('/uty/DelCadriesBlack', [App\Http\Controllers\OrganizationController::class, 'black_del'])->name('black_del');
        Route::post('/organizations/success-message', [App\Http\Controllers\OrganizationController::class, 'success_message'])->name('success_message');
        Route::get('/organizations', [App\Http\Controllers\OrganizationController::class, 'index'])->name('uty_organ');
        Route::get('/organizations/shtat', [App\Http\Controllers\OrganizationController::class, 'shtat'])->name('shtat');
        Route::get('/organizations/cadry-view/{id}', [App\Http\Controllers\OrganizationController::class, 'cadry_view'])->name('cadry_view');
        Route::get('/organizations/cadry-downlaod/{id}', [App\Http\Controllers\OrganizationController::class, 'cadry_downlaod'])->name('cadry_downlaod');
        Route::get('/organizations/users', [App\Http\Controllers\UserController::class, 'users'])->name('users');
        Route::get('/organizations/userDevices', [App\Http\Controllers\OrganizationController::class, 'userDevices'])->name('userDevices');
        Route::get('/organizations/sessions', [App\Http\Controllers\OrganizationController::class, 'sessions'])->name('sessions');
    });
    Route::group(['middleware' => ['can:role-edit']], function () {
        Route::get('/railway/organizations', [App\Http\Controllers\OrganizationController::class, 'cadry_leader'])->name('cadry_leader');  
        Route::get('/organizations/cadry-leader-view/{id}', [App\Http\Controllers\CadryController::class, 'cadry_leader_view'])->name('cadry_leader_view');
    });

    Route::group(['middleware' => ['can:role-delete']], function () {
        Route::resource('roles', RoleController::class);
        Route::resource('users', UserController::class);
        Route::resource('products', ProductController::class);
        Route::get('/excelimport', [App\Http\Controllers\CadryController::class, 'excelimport'])->name('excelimport');
        Route::get('/taxrir', [App\Http\Controllers\CadryController::class, 'ssss'])->name('ssss');
        Route::get('/taxrir2', [App\Http\Controllers\CadryController::class, 'userPhone'])->name('userPhone');
        Route::get('/relations/organizations', [App\Http\Controllers\CadryController::class, 'organization_index'])->name('organization_table');
        Route::get('/relations/enterprices', [App\Http\Controllers\CadryController::class, 'enterprice_index'])->name('enterprice_table');
        Route::post('file-import', [App\Http\Controllers\CadryController::class, 'fileImport'])->name('file-import');
        Route::get('/add-cadry', [App\Http\Controllers\CadryController::class, 'base64'])->name('addcadry');

        Route::get('/message/sendtasks', [App\Http\Controllers\HomeController::class, 'sendtask'])->name('sendtask');
        Route::get('/select_users', [App\Http\Controllers\HomeController::class, 'select_users'])->name('select_users');
        Route::post('/selelected',  [App\Http\Controllers\HomeController::class, 'sel_users'])->name('sel_user');
        Route::post('/submitted-task',[App\Http\Controllers\HomeController::class, 'send_task'])->name('send_task');
        Route::get('/message/submitted-files',[App\Http\Controllers\HomeController::class, 'send_files'])->name('send_files');
        Route::post('/message-send-files',[App\Http\Controllers\HomeController::class, 'submit_file'])->name('submit_file');
        Route::post('/edit_task', [App\Http\Controllers\HomeController::class, 'edit_task'])->name('edit_task');
        Route::post('/share-task',[App\Http\Controllers\HomeController::class, 'share_task'])->name('share_task');
        Route::post('/success-task',[App\Http\Controllers\HomeController::class, 'success_task'])->name('success_task');
        Route::get('/delete-task',[App\Http\Controllers\HomeController::class, 'delete_task'])->name('delete_task');
        Route::get('/edit-simp-task',[App\Http\Controllers\HomeController::class, 'edit_simp_task'])->name('edit_simp_task');
        Route::get('/share-simp-task',[App\Http\Controllers\HomeController::class, 'share_simp_task'])->name('share_simp_task');
        Route::get('/success-simp-task',[App\Http\Controllers\HomeController::class, 'success_simp_task'])->name('success_simp_task');
        Route::get('/delete-simp-task',[App\Http\Controllers\HomeController::class, 'delete_simp_task'])->name('delete_simp_task');
        Route::get('/message/received', [App\Http\Controllers\HomeController::class, 'received'])->name('received');
        Route::get('/share-rec-task', [App\Http\Controllers\HomeController::class, 'share_rec_task'])->name('share_rec_task');
        Route::get('/share-simp-rec-task',[App\Http\Controllers\HomeController::class, 'share_simp_rec_task'])->name('share_simp_rec_task');
        Route::get('/success-rec-task',[App\Http\Controllers\HomeController::class, 'success_rec_task'])->name('success_rec_task');
        Route::get('/success-rec-task-simple',[App\Http\Controllers\HomeController::class, 'success_rec_simp_task'])->name('success_rec_simp_task');
        Route::post('/edit-file-task',[App\Http\Controllers\HomeController::class, 'edit_file_task'])->name('edit_file_task');
        Route::get('/share-file-task',[App\Http\Controllers\HomeController::class, 'share_file_task'])->name('share_file_task');
        Route::get('/success-file-task',[App\Http\Controllers\HomeController::class, 'succ_file'])->name('succ_file');
        Route::get('/delete-file',[App\Http\Controllers\HomeController::class, 'del_file'])->name('del_file');
        Route::get('/message/received-files',[App\Http\Controllers\HomeController::class, 'received_files'])->name('received_files');
        Route::get('/share-received-files',[App\Http\Controllers\HomeController::class, 'share_rec_file'])->name('share_rec_file');
        Route::get('/success-received-files',[App\Http\Controllers\HomeController::class, 'rec_suc_file'])->name('rec_suc_file');
        Route::get('/archive-tasks-files',[App\Http\Controllers\HomeController::class, 'archive_task'])->name('archive_task');
        Route::get('/message/chat', [App\Http\Controllers\ChatController::class, 'index'])->name('chat');
    });


    Route::post('/cadry/vacation/{id}', [App\Http\Controllers\OrganizationController::class, 'vacation'])->name('vacation');

    Route::post('/cadry/krilltolatin', [App\Http\Controllers\OrganizationController::class, 'krilltolatin'])->name('krilltolatin');
    Route::get('/cadry/suggestions', [App\Http\Controllers\OrganizationController::class, 'suggestions'])->name('suggestions');

    
    
    Route::get('/uty/receptions', [App\Http\Controllers\OrganizationController::class, 'receptions'])->name('receptions');
    Route::post('/uty/SendReceptions', [App\Http\Controllers\OrganizationController::class, 'send_receptions'])->name('send_receptions');


    Route::get('/staffAjax', [App\Http\Controllers\OrganizationController::class, 'staff_ajax'])->name('staff_ajax');
    Route::get('/cadry/Statistics', [App\Http\Controllers\CadryController::class, 'cadry_statistics'])->name('cadry_statistics');


    Route::get('change/locale/{lang}', function($lang){
        Session::put('locale', $lang);
        return redirect()->back();
    });
});