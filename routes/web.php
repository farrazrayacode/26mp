<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GateInController;
use App\Http\Controllers\Admin\WorkOrderController;
use App\Http\Controllers\Admin\EstimasiController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\GateOutController;
use App\Http\Controllers\Admin\RiwayatController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //Gate in
    Route::get('/gate-in', [GateInController::class, 'index'])->name('gate-in.index');
    Route::post('/gate-in', [GateInController::class, 'store'])->name('gate-in.store');
    Route::patch('/gate-in/{id}/reject', [GateInController::class, 'reject'])->name('gate-in.reject');
    Route::patch('/gate-in/{id}/approve', [GateInController::class, 'approve'])->name('gate-in.approve');

    //Work order
    Route::get('/work-order', [WorkOrderController::class, 'index'])->name('work-order.index');
    Route::post('/work-order/{id}', [WorkOrderController::class, 'update'])->name('work-order.update');
        Route::get('/work-order/{id}/print', [WorkOrderController::class, 'print'])->name('work-order.print');

    //Estimasi

    Route::get('/estimasi', [EstimasiController::class, 'index'])->name('estimasi.index');
    Route::get('/estimasi/{id}', [EstimasiController::class, 'show'])->name('estimasi.show');
    Route::post('/estimasi/{id}', [EstimasiController::class, 'store'])->name('estimasi.store');

    //invoice 
    Route::get('/invoice', [InvoiceController::class, 'index'])->name('invoice.index');
    Route::get('/invoice/{id}', [InvoiceController::class, 'show'])->name('invoice.show');
    Route::post('/invoice/{id}/payment', [InvoiceController::class, 'payment'])->name('invoice.payment');

    //gate out
    Route::get('/gate-out', [GateOutController::class, 'index'])->name('gate-out.index');
    Route::patch('/gate-out/{id}', [GateOutController::class, 'process'])->name('gate-out.process');

    //riwayat
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
});


require __DIR__.'/auth.php';
