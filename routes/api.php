<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\TransferControllerAPI;


Route::post('/register',[AuthenticationController::class,'register']);
Route::post('/login',[AuthenticationController::class,'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/transfer',[TransferControllerAPI::class,'transfer']);
    Route::get('/history',[TransferControllerAPI::class,'history']);
});
