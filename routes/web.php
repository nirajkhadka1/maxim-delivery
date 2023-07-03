<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\v1\SchoolClient\SchoolClient;
use App\Http\Controllers\v1\web\AdminController;
use App\Models\Admin;
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

Route::get('/', function () {
    return view('admin.edit-date');
});
Route::prefix('v1')->namespace('v1/web')->group(function(){
    Route::get('/client-form',[ClientController::class,'showForm']);
    Route::prefix('/admin')->group(function(){
        Route::get('/available-dates',[AdminController::class,'viewAvailableDates']);
        Route::get('/add-available-date',[AdminController::class,'addAvailableDates']);
        Route::get('/edit-available-date',[AdminController::class,'editAvailableDates']);
        Route::get('/edit-date/{id}',[AdminController::class,'editSingleDateForm']);
    });
});
Route::get('/delivery-form',[SchoolClient::class,'showForm']);
