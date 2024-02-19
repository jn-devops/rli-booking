<?php

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

Route::post('/invoice-buyer', \RLI\Booking\Actions\AcquirePaymentDetailsAction::class)
    ->name('invoice-buyer');

Route::post('/acknowledge-payment', \RLI\Booking\Actions\AcknowledgePaymentAction::class)
    ->name('acknowledge-payment');
