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

// default route
Route::get('/', 'CharactersController@get_characters');

// post request for searching for characters
Route::post('/characters','CharactersController@get_character_by_name');
// get character by url
Route::get('/characters/{character}','CharactersController@show');

Route::get('/events','EventsController@get_event');
Route::get('/series','SeriesController@get_series');
Route::get('/stories','StoriesController@get_story');
Route::get('/comics','ComicsController@get_comic');
Route::get('/character','CharactersController@get_character');
Route::get('/characters','CharactersController@get_characters');

Route::get('/marvel', function () {
    return view('marvel');
});
