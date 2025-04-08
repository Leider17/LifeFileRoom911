<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AccessAttemptController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::post('/employees/attempt',[AccessAttemptController::class,'attempt'])->name('accessAttempt.attempt');
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/employees/index', [EmployeeController::class, 'index'])->name('employee.index');
    Route::get('/employees/create',[EmployeeController::class, 'create'])->name('employee.create');
    Route::post('/employees/store',[EmployeeController::class, 'store'])->name('employee.store');
    Route::get('/employees/edit/{employee}', [EmployeeController::class,'edit'])->name('employee.edit');
    Route::put('/employees/update/{employee}', [EmployeeController::class,'update'])->name('employee.update');
    Route::delete('/employees/destroy/{employee}', [EmployeeController::class,'destroy'])->name('employee.destroy');
    Route::post('/employees/importCSV', [EmployeeController::class,'importCSV'])->name('employee.importCSV');
    Route::get('/employees/history/{employee}',[AccessAttemptController::class, 'showHistory'])->name('accessAttempt.history');
    Route::get('/employees/history/downloadPdf/{employee}',[AccessAttemptController::class, 'downloadPdf'])->name('accessAttempt.downloadPdf');
});
require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
