<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuaranteeController;
use App\Http\Controllers\BulkUploadController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated routes
Route::middleware(['auth'])->group(function () {

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Bulk Upload routes
    Route::get('/bulk-upload', [BulkUploadController::class, 'showForm'])->name('bulk-upload');
    Route::post('/bulk-upload', [BulkUploadController::class, 'uploadFile'])->name('bulk-upload.store');
    Route::delete('/bulk-upload/{filename}', [BulkUploadController::class, 'deleteFile'])->name('bulk-upload.delete');

    // Guarantee routes
    Route::resource('guarantees', GuaranteeController::class);
    Route::post('guarantees/{id}/review', [GuaranteeController::class, 'review'])->name('guarantees.review');
    Route::post('guarantees/{id}/apply', [GuaranteeController::class, 'apply'])->name('guarantees.apply');
    Route::post('guarantees/{id}/issue', [GuaranteeController::class, 'issue'])->name('guarantees.issue');
});

require __DIR__.'/auth.php';
