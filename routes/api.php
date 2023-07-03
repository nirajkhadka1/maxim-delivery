<?php

use App\Http\Controllers\v1\api\AdminController;
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
    Route::prefix('/date')->group(function(){
        Route::post('/',[AdminController::class,'addDate']);
        Route::delete('/{id}',[AdminController::class,'deleteDate']);
        Route::put('/{id}',[AdminController::class,'updateDate']);
    });
});
