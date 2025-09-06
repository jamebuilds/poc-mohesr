<?php

use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect(route('upload'));
})->name('home');

Route::get('/upload', UploadController::class)->name('upload');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

// todo: disable the routes?
require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
