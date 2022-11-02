<?php

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

use App\changeRequestMaster;
use Illuminate\Support\Facades\Auth;
//use Maatwebsite\Excel\Facades\Excel;

Route::get('/', function () {
    if(Auth::check()){
        $ongoingCR = changeRequestMaster::where('cr_status', 'Ongoing')->count();
        return view('dashboard',compact('ongoingCR'));
    }else{
        return view('loginTemplate');
    }
});

//Route::get('/excel-read', function () {
//    Excel::assertImported('public/circular_doc/test.xlsx');
//});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/admin/load-cr-status-chart', 'HomeController@crStatusChart');
Route::post('/admin/load-cr-area-chart', 'HomeController@crAreaChart');

Route::group(array('middleware' => ['auth']), function() {
    Route::post('/admin/graph-list-item-content', 'DashboardController@getGraphDataTblComment');
    Route::post('/admin/chart-list-item-content', 'DashboardController@getChartDataTblComment');
});

Route::get('auth/social', 'Auth\LoginController@show')->name('social.login');
Route::get('oauth/{driver}', 'Auth\LoginController@redirectToProvider')->name('social.oauth');
Route::get('oauth/{driver}/callback', 'Auth\LoginController@handleProviderCallback')->name('social.callback');

Route::group(array('middleware' => ['adminPermission']), function() {
    Route::get('/admin/user-list', 'cmsUserController@index');
    Route::post('/admin/get-user-list', 'cmsUserController@getUserList');
    Route::post('/admin/add-new-user', 'cmsUserController@store');
    Route::post('/admin/get-user-info', 'cmsUserController@getUserInfo');
    Route::post('/admin/update-user-info', 'cmsUserController@updateUserInfo');
    Route::post('/admin/delete-user', 'cmsUserController@destroy');
});

Route::group(array('middleware' => ['auth']), function() {
    Route::get('/calculators/mf-calculators', 'calculatorController@index');
    Route::get('/calculators/loan-repayment-schedule', 'LoanRepayScheduleController@index');
    Route::post('/calculators/get-loan-repayment-schedule', 'LoanRepayScheduleController@getRepaySchedule');
    Route::get('/calculators/export-loan-repayment-schedule-as-excel', 'LoanRepayScheduleController@excelExport');

    Route::get('/calculators/loan-premium', 'premiumCalculatorController@index');
    Route::post('/calculators/get-loan-premium-result', 'premiumCalculatorController@loanPremiumResult');
});

Route::group(array('middleware' => ['auth','adminPermission']), function() {
    Route::get('/item/mf-item-list', 'crMfController@index');
    Route::post('/item/get-mf-item-list', 'crMfController@getMfCrList');
    Route::post('/item/add-new-item', 'crMfController@store');
    Route::post('/item/get-mf-item-info', 'crMfController@getCRInfo');
    Route::post('/item/update-mf-item-info', 'crMfController@updateCRInfo');
    Route::post('/item/delete-mf-item', 'crMfController@destroy');
    Route::post('/item/get-mf-item-note-info', 'crMfController@getCRNoteInfo');
    Route::post('/item/get-add-note-template', 'crMfController@addNoteTemplate');
    Route::post('/item/add-item-note', 'crMfController@addNewCRNotes');
    Route::post('/item/get-item-note-details', 'crMfController@getNoteDetails');
    Route::post('/item/update-item-note', 'crMfController@updateCrNote');
    Route::get('/item/export-item-report-in-excel', 'crMfController@excelExport');

    Route::post('/item/get-item-comment-template', 'crMfController@addCommentTemplate');
    Route::post('/item/item-new-comment-store', 'crMfController@addNewCRComment');
    Route::post('/item/get-item-detail-comment', 'crMfController@getCommentDetails');
    Route::post('/item/update-item-comment', 'crMfController@updateCrComment');
});

Route::group(array('middleware' => ['auth']), function() {
    Route::get('/circular/mf-circular-list', 'MfCircularController@index');
    Route::post('/circular/get-mf-circular-list', 'MfCircularController@getMfCircularList');
    Route::post('/circular/add-circular-template', 'MfCircularController@addCircularTemplate');
    Route::post('/circular/add-new-circular', 'MfCircularController@addNewCircular');
    Route::post('/circular/get-mf-circular-info', 'MfCircularController@getCircularInfo');
    Route::post('/circular/get-importable-circular-info', 'MfCircularController@getCircularImportableInfo');
    Route::post('/circular/update-mf-circular-info', 'MfCircularController@updateCircularInfo');
    Route::post('/circular/delete-mf-circular', 'MfCircularController@destroy');
    Route::post('/circular/import-new-circular', 'MfCircularController@importCircular');
});

Route::group(array('middleware' => ['auth','adminPermission']), function() {
    Route::get('/admin/mf-approval-list', 'ApprovalController@index');
    Route::post('/admin/get-mf-approval-list', 'ApprovalController@getApprovalList');

});

Route::group(array('middleware' => ['auth']), function() {
    Route::get('/request/mf-request-cr', 'reqMfCrController@index');
    Route::post('/request/get-mf-request-cr-list', 'reqMfCrController@getMfRequestCrList');
    Route::post('/request/add-new-cr-request', 'reqMfCrController@requestStore');
    Route::post('/request/get-mf-req-cr-info', 'reqMfCrController@getReqCRInfo');
    Route::post('/request/update-req-mf-cr-info', 'reqMfCrController@updateReqCRInfo');
    Route::post('/request/get-mf-req-cr-importable-info', 'reqMfCrController@getReqCRImportInfo');
    Route::post('/request/import-request-cr', 'reqMfCrController@importReqStore');

});

