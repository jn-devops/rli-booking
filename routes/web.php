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
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::post('generate-voucher', \RLI\Booking\Actions\GenerateVoucherAction::class)->name('generate-voucher');
    Route::get('edit-order/{voucher}/{order}', [\RLI\Booking\Http\Controllers\OrderController::class, 'edit'])->name('edit-order');
    Route::post('update-order/{voucher}', \RLI\Booking\Actions\UpdateOrderAction::class)->name('update-order');
//    Route::resource('references', \RLI\Booking\Http\Controllers\VoucherController::class)
//        ->only(['show'])->parameters(['references' => 'voucher']);
    Route::get('references/{voucher}', [\RLI\Booking\Http\Controllers\VoucherController::class, 'show'])->name('references.show');
});

Route::post('create-buyer', \RLI\Booking\Actions\CreateBuyerAction::class)->name('create-buyer');
