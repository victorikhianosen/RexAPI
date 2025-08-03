<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Business\AuthController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:business');

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('verify-email', [AuthController::class, 'verifyEmail'])->name('verifyemail');
Route::post('resendotp', [AuthController::class, 'resendOtp'])->name('resendotp');

Route::prefix('register')->name('register.')->group(function () {
    Route::post('stepthree', [AuthController::class, 'stepThree'])->name('stepthree');
    Route::post('stepfour', [AuthController::class, 'stepFour'])->name('stepfour');
});

Route::middleware('auth:business')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});
