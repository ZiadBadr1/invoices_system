<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\Invoice\InvoiceController;
use App\Http\Controllers\Admin\InvoiceAttachment\InvoiceAttachmentController;
use App\Http\Controllers\Admin\Product\ProductController;
use App\Http\Controllers\Admin\Section\SectionController;
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

Route::group([
    'middleware' => ['web', 'auth'],
    'prefix' => 'admin',
    'as'=>'admin.',
],function (){
    Route::resource('/sections',SectionController::class);
});


Route::group([
    'middleware' => ['web', 'auth'],
    'prefix' => 'admin',
    'as'=>'admin.',
],function (){
    Route::resource('/products',ProductController::class);
});

Route::group([
    'middleware' => ['web', 'auth'],
    'prefix' => 'admin',
    'as'=>'admin.',
],function (){
    Route::resource('/invoices',InvoiceController::class);
    Route::get('/section/{id}', [InvoiceController::class, 'getProducts'])->name('section');
});

Route::group([
    'middleware' => ['web', 'auth'],
    'prefix' => 'admin',
],function (){
    Route::post('attachment/store', [InvoiceAttachmentController::class, 'store'])->name('attachment.store');
    Route::get('view-file/{attachment}', [InvoiceAttachmentController::class, 'view'])->name('attachments.view');
    Route::get('download/{attachment}', [InvoiceAttachmentController::class, 'download'])->name('attachments.download');
    Route::delete('delete-file/{attachment}', [InvoiceAttachmentController::class, 'delete'])->name('attachments.delete');
});

