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

Route::post('/register-seller', \RLI\Booking\Actions\RegisterSellerAction::class)
    ->name('register-seller');

Route::get('/products/{sku}', function (string $sku) {
    $product = \RLI\Booking\Models\Product::where('sku', $sku)->firstOrFail();

    return $product ? $product->toData(): false;
})->name('products-show');

Route::post('/official-sale/{code}', \RLI\Booking\Actions\OfficialSaleAction::class)
    ->name('official-sale');

Route::post('/accredit-seller/{email}/{accredit?}', \RLI\Booking\Actions\AccreditSellerAction::class)
    ->name('accredit-seller');

Route::post('/update-seller-mfiles_id/{email}/{mfiles_id}', \RLI\Booking\Actions\UpdateSellerMFilesIdAction::class)
    ->name('update-seller-mfiles_id');
