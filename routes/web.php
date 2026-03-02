<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GateInController;
use App\Http\Controllers\Admin\WorkOrderController;
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
});

require __DIR__.'/auth.php';
