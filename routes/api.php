<?php

use App\Http\Controllers\SendSmsController;
use App\Http\Controllers\v1\api\AdminController;
use App\Http\Controllers\v1\api\ClientController;
use App\Http\Controllers\v1\api\DatatableController;
use App\Http\Controllers\v1\api\LocationController;
use App\Http\Controllers\v1\api\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('v1/api')->prefix('/admin')->group(function(){
    Route::post('/login',[AdminController::class,'login']);
    Route::prefix('/date')->group(function(){
        Route::post('/',[AdminController::class,'addDate']);
        Route::delete('/{id}',[AdminController::class,'deleteDate']);
        Route::put('/{id}',[AdminController::class,'updateDate']);
    });

    Route::prefix('/location')->group(function () {
        Route::post('/',[LocationController::class,'storeLocation']);
        Route::put('/{id}',[LocationController::class,'update'])->name('api.location-update');
        Route::get('/enabled-dates/{id}',[LocationController::class,'getEnabledDate']);
    });

    Route::prefix('/datatable')->group(function(){
        Route::get('/location/search',[DatatableController::class,'search'])->name('api.datatable.search');
        Route::get('/order/search',[DatatableController::class,'orderSearch'])->name('api.datatable.order-search');

    });
    
    Route::prefix('/orders')->group(function(){
        Route::put('/{id}',[OrderController::class,'updateOrder']);
        
    });

});
Route::post('/send-sms',[SendSmsController::class,'sendMessage']);

Route::prefix('client_form')->group(function (){
    Route::post('/submit',[ClientController::class,'submit']);
});