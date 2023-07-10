<?php

use App\Http\Controllers\v1\web\ClientController;
use App\Http\Controllers\v1\web\AdminController;
use App\Http\Controllers\v1\web\AuthController;
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
Route::prefix('v1')->namespace('v1/web')->group(function(){

    Route::prefix('client')->group(function(){
        Route::get('/form',[ClientController::class,'showForm']);
    });

    Route::prefix('/admin')->middleware(['auth'])->group(function(){
        Route::get('/view-orders',[AdminController::class,'orderView']);
        Route::get('/order/{id}',[AdminController::class,'viewOrderDetails']);
        Route::get('/dates',[AdminController::class,'dateLists'])->name('date-view');
        Route::get('/modify-dates',[AdminController::class,'modifyDates']);
    });

    Route::get('/login',[AuthController::class,'login'])->name('web.login');
    Route::get('/logout',[AuthController::class,'logout']);
    Route::post('/authenticate',[AuthController::class,'authenticate']);

});
