<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\AuthController;
use Illuminate\Support\Facades\Route;

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


Route::group([
    'middleware' => ['web', 'guest'],
    'prefix' => 'admin',
    'as'=>'admin.',
],function (){
    Route::get('/login',[AuthController::class,'login'])->name('login');
    Route::post('/login',[AuthController::class,'postLogin'])->name('postLogin');
});


Route::group([
    'middleware' => ['web', 'auth'],
    'prefix' => 'admin',
    'as'=>'admin.',
],function (){
    Route::get('/dashboard',[AdminController::class,'index'])->name('dashboard');
    Route::post('/logout',[AuthController::class,'logout'])->name('logout');
});

