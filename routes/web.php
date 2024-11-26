<?php

use Illuminate\Support\Facades\Route;
use App\http\Controllers\BookController;
use App\http\Controllers\AuthorController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::view('awad','test');
// Route::prefix('Books')->group(function () {
    
//    
// });

Route::post('/store',[BookController::class,'store']);
Route::get('/index',[BookController::class,'index']);
Route::get('/awad/{id}',[BookController::class,'show']);
Route::get('/author',[AuthorController::class,'index']);
