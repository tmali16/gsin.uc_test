<?php

use App\Setting;
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
    $settings = Setting::where("key", "gsin_name")->get();
    return view('welcome')->with("settings", $settings);
});

Auth::routes();

Route::post("/start", "StudentController@index");
Route::get("/start/{id}/{lang}", "TestController@start");
Route::get("/get/question/{id}", "TestController@showQuestion");
Route::post("/test/finish/store", "TestController@finishTestStore");
Route::get("/test/finish", "TestController@finishTest");
Route::get("/test/finish/download", "TestController@toPDF");
Route::get("/lang/{lang}", "TestController@ChangeLang");
Route::get("/print", "TestController@Print");



Route::middleware(['auth'])->group(function () {
    Route::get('/admin', 'HomeController@index')->name('admin');
    Route::get('/permissions/get', 'SettingController@GetPermissionForUser');

    Route::get('/get/dashboard', 'HomeController@Dashboard');


    Route::get('/new/pass', 'HomeController@ChangePass');
    Route::post('/newpassword', 'HomeController@NewPassword')->name('password');
    // student
    Route::get('/candidate/get/', "StudentController@CandidateGet");
    Route::post('/candidate/add/new', "StudentController@CandidateAdd");
    Route::post('/update/candidate', "StudentController@CandiUpdate");
    Route::get('/delete/candidate/{id}', "StudentController@CandidateTrash");

    // ------------------------- Test -------------------------------//
    Route::post('/store/test/add', "TestController@TestAdd");
    Route::get('/change/test/get/', "TestController@TestGet");
    Route::post("/update/test", "TestController@TestUpdate");
    Route::get('/delete/test/{id}', "TestController@TestDelete");

    Route::get('/new/question/add/{id}', "QuestionController@index");
    Route::get('/delete/question/{id}', "QuestionController@destroy");
    Route::post('/question/store/{id}', "QuestionController@store");
    Route::post('/question/update', "QuestionController@update");

// Settings 
    Route::get('/Settings/get', "SettingController@GetSettings");
    Route::post('/settings/edit', "SettingController@EditSettings");

});

Route::group(['middleware' => ['can:users.*']], function () {    
    Route::get("/get/user", "HomeController@UserGet");
    Route::get("/check/username/{name}", "HomeController@CheckUsername");
    Route::post("/create/user", "HomeController@UserCreate");
    Route::post("/update/user", "HomeController@UserUpdate");

    Route::get("/role/get", "SettingController@getRole");
    Route::post("/role/assign/permission", "SettingController@RoleGivPermiss");
    Route::post("/role/store", "SettingController@CreateRole");

    Route::get("/permission/get", "SettingController@getPermission");
    Route::post("/permission/store", "SettingController@storePermission");

});

