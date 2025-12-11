<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware groufdetailp. Now create something great!
|
*/
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/dashboard', 'DashboardController@index')->middleware('auth:admin');
Route::get('/', 'DashboardController@index')->middleware('auth:admin');
Route::post('/get_dashboard', 'DashboardController@get_dashboard')->middleware('auth:admin');
Route::post('/data_schedule_pasien_dasboard', 'DashboardController@dasboard_schedule')->middleware('auth:admin');
Route::post('/login', 'Logincontroller@login');
//dashboard
Route::get('/dashboard', 'DashboardController@index')->middleware('auth:admin');
// administrator
Route::get('/administrator/list-admin','AdministratorController@index')->middleware('auth:admin');
Route::post('/data_admin','AdministratorController@list_item')->middleware('auth:admin');
Route::post('/postadmin', 'AdministratorController@postAdmin')->middleware('auth:admin');
Route::post('/active/administrator', 'AdministratorController@active')->middleware('auth:admin');
Route::post('/nonactive/administrator', 'AdministratorController@nonactive')->middleware('auth:admin');
Route::post('/delete/administrator', 'AdministratorController@delete')->middleware('auth:admin');
Route::get('/administrator/list-admin/{id}', 'AdministratorController@detail')->middleware('auth:admin');
Route::post('/update/administrator', 'AdministratorController@update')->middleware('auth:admin');
Route::get('/ubah-password/{id}', 'AdministratorController@ubah_password')->middleware('auth:admin');
Route::post('/update-password', 'AdministratorController@update_password')->middleware('auth:admin');
Route::get('/select_role/{id}/{jenis}', 'AdministratorController@get_role')->middleware('auth:admin');

//role
Route::get('/administrator/role-admin','RoleController@index')->middleware('auth:admin');
Route::post('/postrole', 'RoleController@postrole')->middleware('auth:admin');
Route::get('/data_role','RoleController@list_item')->middleware('auth:admin');
Route::get('/administrator/role-admin/{id}', 'RoleController@detail')->middleware('auth:admin');
Route::post('/nonactive/role','RoleController@nonactive')->middleware('auth:admin');
Route::post('/active/role','RoleController@active')->middleware('auth:admin');
Route::post('/delete/role','RoleController@delete')->middleware('auth:admin');
Route::post('/update/role', 'RoleController@update')->middleware('auth:admin');

//signout
Route::get('/logout', 'Logincontroller@logout')->middleware('auth:admin');

// .............district
Route::get('/master/district','DistrictController@index')->middleware('auth:admin');
Route::post('/data_master_district','DistrictController@list_data')->middleware('auth:admin');
Route::post('/active/District', 'DistrictController@active')->middleware('auth:admin');
Route::post('/nonactive/District', 'DistrictController@nonactive')->middleware('auth:admin');
Route::get('/master/district/{id}', 'DistrictController@detail')->middleware('auth:admin');
Route::get('/get_village/{id}', 'DistrictController@get_village')->middleware('auth:admin');
Route::post('/post_master_district','DistrictController@post')->middleware('auth:admin');
Route::post('/update/master_district','DistrictController@update')->middleware('auth:admin');
Route::post('/delete/District', 'DistrictController@delete')->middleware('auth:admin');

// .............master village
Route::get('/master/village','VillageController@index')->middleware('auth:admin');
Route::post('/data_master_village','VillageController@list_data')->middleware('auth:admin');
Route::post('/active/village', 'VillageController@active')->middleware('auth:admin');
Route::post('/nonactive/village', 'VillageController@nonactive')->middleware('auth:admin');
Route::get('/master/village/{id}', 'VillageController@detail')->middleware('auth:admin');
Route::post('/post_master_village','VillageController@post')->middleware('auth:admin');
Route::post('/update_master_village','VillageController@update')->middleware('auth:admin');
Route::post('/delete/village', 'VillageController@delete')->middleware('auth:admin');

//Logs
Route::get('/logs/logs_admin', 'LogsController@logs_admin')->middleware('auth:admin');
Route::post('/data_logs_admin', 'LogsController@data_logs_admin')->middleware('auth:admin');
Route::get('/logs/log-user', 'LogsController@logs_user')->middleware('auth:admin');
Route::post('/data_log_user', 'LogsController@data_logs_user')->middleware('auth:admin');

// crud menu
Route::get('/administrator/pengaturan-menu','CrudMenuController@index')->middleware('auth:admin');
Route::get('/list-menu','CrudMenuController@list_item')->middleware('auth:admin');
Route::post('/post-menu', 'CrudMenuController@post')->middleware('auth:admin');
Route::get('/administrator/pengaturan-menu/{id}', 'CrudMenuController@detail')->middleware('auth:admin');
Route::post('/update/menu', 'CrudMenuController@update')->middleware('auth:admin');
Route::post('/delete/menu', 'CrudMenuController@delete')->middleware('auth:admin');
Route::post('/active/menu', 'CrudMenuController@active')->middleware('auth:admin');
Route::post('/nonactive/menu', 'CrudMenuController@nonactive')->middleware('auth:admin');
Route::get('/get-max-serial/{parent_id}', 'CrudMenuController@get_max_serial')->middleware('auth:admin');

// ............role
Route::get('/administrator/role','RoleController@index')->middleware('auth:admin');
Route::get('/data_role','RoleController@list_data')->middleware('auth:admin');
Route::post('/post_role','RoleController@post')->middleware('auth:admin');
Route::post('/nonactive/role','RoleController@nonactive')->middleware('auth:admin');
Route::post('/active/role','RoleController@active')->middleware('auth:admin');
Route::post('/delete/role','RoleController@delete')->middleware('auth:admin');
Route::get('/detail/role/{id}','RoleController@detail')->middleware('auth:admin');


Route::post('/data_log_admin', 'LogAdminController@list_data')->middleware('auth:admin');
Route::get('/logs/logs_admin', 'LogAdminController@index')->middleware('auth:admin');
Route::post('/data_log_approval', 'LogAdminController@list_data_approval')->middleware('auth:admin');
Route::get('/logs/log-approval', 'LogAdminController@index_approval')->middleware('auth:admin');

Route::get('/logs/logs_user', 'LogUserController@index')->middleware('auth:admin');

Route::post('/data_log_error', 'LogErrorController@list_data')->middleware('auth:admin');
Route::get('/logs/logs_error', 'LogErrorController@index')->middleware('auth:admin');

Route::get('/download_excel/{arr}', 'LaporanController@download_peserta')->middleware('auth:admin');


//export_excel/medical_report
Route::get('/export_excel/medical_report/{filter}','MedicalRecordController@export_excel')->middleware('auth:admin');

//dpt
Route::get('/dpt/list','DptController@index')->middleware('auth:admin');
Route::post('/data_dpt','DptController@list_data')->middleware('auth:admin');
Route::post('/cek_load_dpt','DptController@cek_load_dpt')->middleware('auth:admin');
Route::post('/post_dpt','DptController@post')->middleware('auth:admin');
Route::post('/nonactive/dpt','DptController@nonactive')->middleware('auth:admin');
Route::post('/active/dpt','DptController@active')->middleware('auth:admin');
Route::post('/delete/dpt','DptController@delete')->middleware('auth:admin');
Route::get('/user/dpt/{id}','DptController@detail')->middleware('auth:admin');
Route::post('/update_dpt','DptController@update')->middleware('auth:admin');
Route::get('/user/dpt/action/add','DptController@add')->middleware('auth:admin');
Route::get('/dpt/import','DptController@import')->middleware('auth:admin');
Route::post('/post_import_dpt','DptController@post_import_dpt')->middleware('auth:admin');

//rekapitulasi/list-rekap
Route::get('/rekapitulasi/list-rekap','RecapitulationsController@index')->middleware('auth:admin');
Route::get('/rekapitulasi/kecamatan','RecapitulationsController@district')->middleware('auth:admin');
Route::get('/rekapitulasi/desa','RecapitulationsController@village')->middleware('auth:admin');
Route::post('/rekapitulasi/data','RecapitulationsController@list_data')->middleware('auth:admin');
Route::post('/rekapitulasi/data','RecapitulationsController@list_data')->middleware('auth:admin');
Route::post('/rekapitulasi/data','RecapitulationsController@list_data')->middleware('auth:admin');
Route::post('/rekapitulasi/calculate','RecapitulationsController@calculate')->middleware('auth:admin');

