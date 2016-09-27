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



Route::get('/', 'LookupController@index');
Route::get('lookups', 'LookupController@index');

Route::post('/lookups', [
    'as' => 'lookups', 'uses' => 'LookupController@index'
]);


Route::post('/showLookup', [
    'as' => 'showLookup', 'uses' => 'LookupController@show'
]);


/*Route::get('/lookup', function () {
    return view('lookup');
});*/
