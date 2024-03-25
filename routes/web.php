<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewController;
use App\Http\Controllers\articlecontroller;
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



Route::get("/about", function () {
    $test = request("test");


    return view('about');
});

Route::get('/menu',function(){


   $data =[
    
   ];

    return view('menu',$data);
});


Route::get('/career',function(){
    return view('career');
});


Route::get('/contact',function(){
    return view('contact');
});

Route::get('/post/{id}', [NewController::class, 'index']);

Route::get('/article',[articlecontroller::class ,'index']);
Route::get('/article/create',[articlecontroller::class ,'create']);
Route::post('/submitform',[articlecontroller::class ,'store']);
Route::get('/article/{article}',[articlecontroller::class ,'show']);
Route::get('/article/{article}/edit',[articlecontroller::class ,'edit']);
Route::post('/submitform/{article}/update',[articlecontroller::class ,'updatecsc']);







                      