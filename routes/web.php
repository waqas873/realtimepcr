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
Route::get('/', function () {
    return redirect('/reception');
});

Route::get('/redirected', 'RedirectionController@index');

Route::get('/track/covid/{id?}', 'PrintsController@covid_passenger');
Route::get('/track/{id?}', 'PrintsController@covid_passenger');

Route::get('/send_api_requests', 'ApiController@send_api_requests');

Route::get('/resend_api_requests', 'ApiController@resend_api_requests');

Auth::routes();
Route::get('/user-update', 'UserController@update');
Route::post('/user-update', 'UserController@process_update');

Route::group(['middleware' => ['web','admin']], function()
{
	//Route::auth();
	Route::group(['prefix'=>'admin'], function(){
        Route::get('/home', 'Admin\HomeController@index')->name('home');
        Route::get('/cpanel/{profile_id?}', 'Admin\CpanelController@index');
        Route::post('/change-permission', 'Admin\CpanelController@changePermission');
        Route::post('/add-account-category', 'Admin\CpanelController@processAccountCategory');
        Route::post('/add-test-category', 'Admin\CpanelController@processTestCategory');
        Route::get('/doctors', 'Admin\DoctorsController@index');
        Route::post('/add-category', 'Admin\CategoryController@process_add');
        Route::post('/add-sample', 'Admin\SampleController@process_add');
        Route::post('/add-reporting-unit', 'Admin\ReportingUnitController@process_add');

        Route::get('/patients', 'Admin\PatientController@index');
        Route::get('/patient-detail/{patient_id?}', 'Admin\PatientController@detail');
        Route::get('/patient-update/{id?}', 'Admin\PatientController@update');
        Route::get('/patient-delete/{id?}', 'Admin\PatientController@delete');
        Route::post('/process-patient-update', 'Admin\PatientController@process_update');
        Route::post('/process-patient-reason', 'Admin\PatientController@process_reason');
        Route::get('/delete-reason', 'Admin\PatientController@delete_reason');

        Route::get('/products', 'Admin\ProductController@index');
        Route::post('/add-product', 'Admin\ProductController@process_add');
        Route::post('/get-products', 'Admin\ProductController@get_products');
        Route::get('/update-product/{id?}', 'Admin\ProductController@update');
        Route::get('/product-delete/{id?}', 'Admin\ProductController@delete');

        Route::get('/suppliers', 'Admin\SupplierController@index');
        Route::post('/add-supplier', 'Admin\SupplierController@process_add');
        Route::get('/update-supplier/{id?}', 'Admin\SupplierController@update');

        Route::get('/patient-delete-permanently/{id?}', 'Admin\PatientController@delete_permanently');
        Route::get('/delete-admin/{id?}', 'Admin\AdminController@delete_admin');

        Route::get('/deleted-patients', 'Admin\PatientController@patientsDeleted');

        Route::get('/update-doctor/{update_id?}', 'Admin\DoctorsController@update');

        Route::get('/update-test-profile/{id?}', 'Admin\TestController@update_test_profile');
        Route::get('/delete-test/{test_id?}', 'Admin\TestController@delete');
        Route::get('/delete-test-profile/{id?}', 'Admin\TestController@delete_test_profile');
        Route::get('/update-test/{test_id?}', 'Admin\TestController@update');
        Route::post('/add-test', 'Admin\TestController@process_add');
        Route::post('/add-profile-test', 'Admin\TestController@process_add_profile');
        Route::post('/doctor-add', 'Admin\DoctorsController@process_add');

        Route::get('/labs', 'Admin\LabsController@index');
        Route::post('/add-lab', 'Admin\LabsController@process_add');

        Route::get('/collection-points', 'Admin\Collection_pointController@index');
        Route::post('/add-collection-point', 'Admin\Collection_pointController@process_add');
        Route::get('/delete-cp/{id?}', 'Admin\Collection_pointController@delete');

        Route::get('/staff', 'Admin\StaffController@index');
        Route::post('/add-lab-user', 'Admin\StaffController@process_lab_user');
        Route::post('/add-cp-user', 'Admin\StaffController@process_cp_user');
        Route::get('/staff-patients/{source?}/{id?}', 'Admin\StaffController@staff_patients');
        Route::post('/staff-patients', 'Admin\StaffController@get_patients');
        Route::get('/delete-user/{id?}', 'Admin\StaffController@delete');

        Route::get('/reports/{date?}', 'Admin\ReportsController@index');

        Route::get('/invoice-detail/{id?}', 'Admin\InvoiceController@invoice_detail');
        
        Route::get('/accounts/transfers', 'Admin\AccountsController@transfers');
        Route::get('/accounts/cashbook', 'Admin\AccountsController@cashbook');
        Route::get('/accounts/vouchers', 'Admin\AccountsController@vouchers');
        Route::get('/accounts/ledgers', 'Admin\AccountsController@ledgers');
        Route::get('/accounts/trial-balance', 'Admin\AccountsController@trial_balance');
        Route::get('/accounts/balance-sheet', 'Admin\AccountsController@balance_sheet');
        Route::get('/accounts/income-statment', 'Admin\AccountsController@income_statment');

        Route::get('/logs', 'Admin\LogsController@index');
        Route::post('/get-logs', 'Admin\LogsController@get_logs');

        Route::get('/api', 'Admin\ApiController@index');
        Route::get('/cancel-api-request/{id?}', 'Admin\ApiController@cancel_request');

        Route::post('/get-patients', 'Admin\PatientController@get_patients');
        Route::post('/get-deleted-patients', 'Admin\PatientController@get_deleted_patients');
        Route::get('/reporting_time/{id?}', 'Admin\PatientController@reporting_time');

        Route::post('/export-patients', 'Admin\PatientController@export_patients');
        
        Route::get('/sub-admins', 'Admin\AdminController@index');
        Route::get('/add-admin', 'Admin\AdminController@add');
        Route::post('/add-admin', 'Admin\AdminController@processAdd');
        Route::get('/update-admin/{id?}', 'Admin\AdminController@update');
        Route::post('/update-admin', 'Admin\AdminController@processUpdate');
    });

});

Route::group(['middleware' => ['web','staff']], function()
{
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/reports', 'ReportsController@index');
    Route::post('/get-reports', 'ReportsController@get_reports');
    Route::post('/pay-now', 'InvoiceController@pay_invoice');
    Route::post('/get-invoices', 'InvoiceController@get_invoices');
    Route::get('/invoices', 'InvoiceController@index');
    Route::get('/invoice_detail/{id?}', 'InvoiceController@detail');
    Route::get('/invoice-detail/{id?}/{code?}', 'InvoiceController@invoice_detail');
    Route::get('/reception', 'ReceptionController@index')->name('reception');
    Route::get('/patient-add', 'PatientController@add');
    Route::get('/patient-update/{id?}', 'PatientController@update');
    Route::get('/patients/{from_date?}/{to_date?}', 'PatientController@index');
    //Route::get('/staff-doctors', 'DoctorsController@index');
    Route::get('/patient-detail/{patient_id?}/{search?}', 'PatientController@detail');
    Route::get('/pay_now/{invoice_id?}', 'PatientController@pay_now');
    Route::get('/contact_no_exist/{num?}', 'PatientController@contact_no_exist');
    Route::post('/patient-add', 'PatientController@process_add');
    Route::post('/add-patient-tests', 'PatientController@process_add_tests');
    Route::post('/get-invoice', 'PatientController@invoice');
    Route::post('/check-passenger', 'PatientController@check_passenger');
    Route::post('/process_pay_now', 'PatientController@process_pay_invoice');
    Route::get('/patient-delete/{id?}', 'PatientController@delete');
    Route::post('/process-patient-reason', 'PatientController@process_reason');
    Route::get('/delete-reason', 'PatientController@delete_reason');


    Route::get('/amounts', 'AmountsController@index');
    Route::post('/add-expense', 'AmountsController@process_expense');
    Route::post('/transfer-amount', 'AmountsController@amount_transfer');
    Route::get('/cancel-transfer/{id?}', 'AmountsController@cancel_transfer');
    Route::get('/accept-transfer/{id?}', 'AmountsController@accept_transfer');
    Route::get('/reject-transfer/{id?}', 'AmountsController@reject_transfer');
});

Route::group(['middleware' => ['web','covid_staff']], function()
{
    Route::group(['prefix'=>'embassy'], function(){
        Route::get('/reports', 'EmbassyController@reports');
        Route::get('/all-reports/{date?}', 'EmbassyController@all_reports');
        Route::post('/get_patients', 'EmbassyController@get_patients');
    });

    Route::group(['prefix'=>'airlines'], function(){
        Route::get('/reports', 'AirlineController@reports');
        Route::post('/get_patients', 'AirlineController@get_patients');
    });

});

Route::group(['middleware' => ['web','lab_user']], function()
{
    Route::group(['prefix'=>'lab'], function(){
        Route::get('/dashboard', 'LabUserController@index');
        Route::get('/open-cases', 'LabUserController@open_cases');
        Route::get('/reports', 'LabUserController@reports');
        Route::get('/detected/{id?}', 'LabUserController@detected');
        Route::get('/not_detected/{id?}', 'LabUserController@not_detected');
        Route::get('/revoke/{id?}', 'LabUserController@revoke');
        Route::post('/get_reports', 'LabUserController@get_reports');
        Route::post('/add-patient-test-result', 'LabUserController@addTestResult');
    });
});

Route::group(['middleware' => ['web','doctor']], function()
{
    Route::group(['prefix'=>'doctor'], function(){
        Route::get('/home', 'DoctorsController@index');
        Route::post('/request-withdraw', 'DoctorsController@withdrawRequest');
        Route::get('/cancel-withdraw/{id?}', 'DoctorsController@withdrawCancel');
    });
});