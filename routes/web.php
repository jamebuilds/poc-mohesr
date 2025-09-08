<?php

use App\Http\Controllers\UploadController;
use App\Http\Controllers\VerifyController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect(route('upload.create'));
})->name('home');

Route::resource('/upload', UploadController::class)->only(['create', 'store']);

Route::resource('/verify', VerifyController::class)->only(['create']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

// todo: disable the routes?
require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
