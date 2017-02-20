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


//This pulls back the reports, now need this per area

Route::get('/getLookups/{area}', [
    'as' => 'lookups.list', 'uses' => 'LookupController@getLookups'
]);




Route::get('/', 'LookupController@index');



Route::get('lookups/{area}', 'LookupController@index');
Route::get('lookups', 'LookupController@index');


Route::get('mobile', 'LookupController@mobile');


Route::post('/mobile', [
    'as' => 'mobile', 'uses' => 'LookupController@mobile'
]);


Route::post('/lookups', [
    'as' => 'lookups', 'uses' => 'LookupController@index'
]);


Route::get('/showLookup', [
    'as' => 'showLookup', 'uses' => 'LookupController@show'
]);


/*Route::get('/lookup', function () {
    return view('lookup');
});*/
