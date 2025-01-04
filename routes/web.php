<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VideoCallController;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/contacts', function () {
    $users = User::where('id', '!=', Auth::user()->id)->get();
    return Inertia::render('Contacts', ['users' => $users]);
})->middleware(['auth', 'verified'])->name('contacts');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/video-call/request/{user}', [VideoCallController::class, 'requestVideoCall'])->name('video-call.request');
    Route::post('/video-call/request/status/{user}', [VideoCallController::class, 'requestVideoCallStatus'])->name('video-call.request-status');
});

require __DIR__.'/auth.php';
