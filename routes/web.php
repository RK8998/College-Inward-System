<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
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

// *****************************************************login1

Route::get('/', function () {
    return view('login');
});
Route::get('login',[Controller::class,'login']);
Route::get('logout',[Controller::class,'logout']);
Route::get('home',[Controller::class,'home']);
Route::get('trash',[Controller::class,'trash']);
Route::get('restore/{id}',[Controller::class,'restore']);

Route::get('fetch_dept',[Controller::class,'fetch_dept']);
Route::get('fetch_dept_name',[Controller::class,'fetch_dept_name']);
Route::get('edit/fetch_dept_name2',[Controller::class,'fetch_dept_name2']);

Route::post('/store',[Controller::class,'store']); // insert
Route::get('/delete/{id}',[Controller::class,'delete']); // delete
Route::get('/delete_trash/{id}',[Controller::class,'delete_trash']); // delete_trash
Route::get('/view/{id}',[Controller::class,'view']); // view
Route::get('/edit/{id}',[Controller::class,'edit']); // edit
Route::get('/update',[Controller::class,'update']); // update
Route::get('/upload/{id}',[Controller::class,'upload']); // upload
Route::post('/uploadadd',[Controller::class,'uploadadd']); // upload

Route::get('/export',[Controller::class,'ExportIntoExcel']); //Export data into excel
Route::get('/filter',[Controller::class,'filter']); // Filter

// *****************************************************login2

// Route::get('home2',[Controller::class,'home2']);
Route::get('dept',[Controller::class,'department']);
Route::post('add_dept',[Controller::class,'add_dept']);
Route::get('delete_dept/{did}',[Controller::class,'delete_dept']);
Route::get('edit_dept/{did}',[Controller::class,'edit_dept']);
Route::post('update_dept',[Controller::class,'update_dept']);

Route::get('faculty',[Controller::class,'faculty']);
Route::post('add_fac',[Controller::class,'add_fac']);
Route::get('delete_fac/{fid}',[Controller::class,'delete_fac']);
Route::get('edit_fac/{fid}',[Controller::class,'edit_fac']);
Route::post('update_fac',[Controller::class,'update_fac']);