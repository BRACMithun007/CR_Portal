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

Route::get('/', function () {
    if(Auth::check()){
        $ongoingCR = changeRequestMaster::where('cr_status', 'Ongoing')->count();
        return view('/dashboard',compact('ongoingCR'));
    }else{
        return view('/welcome');
    }
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/admin/load-cr-status-chart', 'HomeController@crStatusChart');
Route::post('/admin/load-cr-area-chart', 'HomeController@crAreaChart');


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
    Route::get('/admin/mf-calculators', 'calculatorController@index');
    Route::get('/loan/repayment-schedule-monthly', 'LoanRepayScheduleController@index');
    Route::post('/loan/get-repayment-schedule', 'LoanRepayScheduleController@getRepaySchedule');
});

Route::group(array('middleware' => ['auth','adminPermission']), function() {
    Route::get('/admin/mf-cr-list', 'crMfController@index');
    Route::post('/admin/get-mf-cr-list', 'crMfController@getUserList');
    Route::post('/admin/add-new-cr', 'crMfController@store');
    Route::post('/admin/get-mf-cr-info', 'crMfController@getCRInfo');
    Route::post('/admin/update-mf-cr-info', 'crMfController@updateCRInfo');
    Route::post('/admin/delete-mf-cr', 'crMfController@destroy');
    Route::post('/admin/get-mf-cr-note-info', 'crMfController@getCRNoteInfo');
    Route::post('/admin/get-add-note-template', 'crMfController@addNoteTemplate');
    Route::post('/admin/add-new-cr-store', 'crMfController@addNewCRNotes');
    Route::post('/admin/get-note-details', 'crMfController@getNoteDetails');
    Route::post('/admin/update-cr-note', 'crMfController@updateCrNote');
    Route::get('/admin/export-as-excel', 'crMfController@excelExport');
});

