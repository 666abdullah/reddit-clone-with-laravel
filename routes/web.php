<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\ProductController;
use  App\Models\Product;

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
Route::get('product',[ProductController::class , 'index']);
Route::post('store',[ProductController::class, 'store'])->name('store');
Route::get('fetchall' ,[ProductController::class , 'fetchall'])->name('fetchall');
Route::get('edit' ,[ProductController::class , 'edit'])->name('edit');
Route::post('update',[ProductController::class, 'update'])->name('update');
Route::delete('delete',[ProductController::class, 'delete'])->name('delete');

