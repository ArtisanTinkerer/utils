<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


//The reporting routes

Route::get('/compile', 'ReportController@compile');

Route::get('/process', 'ReportController@process');
Route::get('/display', 'ReportController@display');




//The calendar routes


Route::get('/calendar', 'CalendarController@index');

Route::get('/fetchEvents', 'CalendarController@fetchEvents');
Route::get('/eventDetails', 'CalendarController@eventDetails');


Route::resource('calendar', 'CalendarController');




//The lookup routes

Route::get('lookups/back', 'LookupController@back');

//This is so we can enter this application,
//with all reports displayed or  filtered by area
Route::get('lookups/{area}', 'LookupController@index');
Route::get('lookups', 'LookupController@index');
Route::get('/', 'LookupController@index');




//This pulls back the reports, now need this per area.
//This is because there is multiple entry points, to this application.
//Each entry point is an area, which will have its own reports.

Route::get('/getLookups/{area}', [
    'as' => 'lookups.list', 'uses' => 'LookupController@getLookups'
]);


//If the URL does not have an area on it, just get all

Route::get('/getLookups', [
    'as' => 'lookups.list', 'uses' => 'LookupController@getLookups'
]);



//These are for the mobile hand scanners
Route::get('mobile', 'LookupController@mobile');

Route::post('/mobile', [
    'as' => 'mobile', 'uses' => 'LookupController@mobile'
]);


Route::get('/showLookup', [
    'as' => 'showLookup', 'uses' => 'LookupController@show'
]);



//Catch all
Route::any('{query}',
    function () {
        return redirect('/');
    })
    ->where('query', '.*');
