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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/admin', 'HomeController@index')->name('admin');

Route::post('/new/test/user', "StudentController@StudentAdd");
Route::post('/new/test/add', "TestController@TestAdd");

Route::get('/new/question/add/{id}', "QuestionController@index");
Route::post('/new/question/add/{id}/store', "QuestionController@store");
Route::post("/start", "StudentController@index");

Route::get("/start/{id}/{lang}", "TestController@start");

Route::get("/get/question/{id}", "TestController@showQuestion");

Route::post("/test/finish/store", "TestController@finishTestStore");
Route::get("/test/finish", "TestController@finishTest");