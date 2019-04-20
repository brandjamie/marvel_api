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

Route::get('/', function () {
    return view('welcome');
});


//Route::get('/characters','CharactersController@index');


Route::post('/characters','CharactersController@get_character_by_name');
Route::get('/events','EventsController@get_event');

Route::get('/comics','ComicsController@get_comic');
Route::get('/character','CharactersController@get_character');
Route::get('/marvel', function () {
    return view('marvel');
});
