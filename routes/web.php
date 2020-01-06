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

Route::get('/','userController@timu');

Route::get('/make', function () {
    return view('make');
});


Route::any('/makeWenjuan', 'userController@makeWenjuan');

Route::any('/back/doMakeWenjuan', 'userController@doMakeWenjuan');
Route::any('/back/saveAnswer', 'userController@saveAnswer');
Route::any('/back/listAnswers', 'userController@listAnswers');

