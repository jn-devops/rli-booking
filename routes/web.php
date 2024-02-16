<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/reserve', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::post('generate-voucher', \RLI\Booking\Actions\GenerateVoucherAction::class)->name('generate-voucher');
});
Route::post('update-order/{voucher}', \RLI\Booking\Actions\UpdateOrderAction::class)->name('update-order');
Route::get('references/{voucher}', [\RLI\Booking\Http\Controllers\VoucherController::class, 'show'])->name('references.show');
Route::get('edit-order/{voucher}/{order}', [\RLI\Booking\Http\Controllers\OrderController::class, 'edit'])->name('edit-order');
Route::get('auto-reserve/{sku}/{transaction_id}', \RLI\Booking\Actions\AutoReserveAction::class)->name('auto-reserve');
Route::post('process-buyer', \RLI\Booking\Actions\ProcessBuyerAction::class)->name('process-buyer');
Route::get('affiliate-reserve/{email}/{sku}/{property_code?}', \RLI\Booking\Actions\AffiliateReserveAction::class)->name('affiliate-reserve');
