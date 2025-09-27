<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\HomeController;

Route::post('/register',[AuthenticationController::class,'register']);
Route::post('/login',[AuthenticationController::class,'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/transfer',[TransactionController::class,'transfer']);
    Route::get('/history',[TransactionController::class,'history']);
    Route::get('/home',[HomeController::class,'home']);
});
