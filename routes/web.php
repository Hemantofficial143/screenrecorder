<?php

use App\Http\Controllers\ProfileController;

use App\Http\Controllers\RecordingController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticatorDeviceController;
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



Route::get('/view-recording/{recording_id}', [RecordingController::class, 'view'])->name('view-recording');

Route::middleware(['auth'])->group(function () {
    Route::get('/2fa-verify', [AuthenticatorDeviceController::class, 'Verify2FACode'])->name('2fa-verify');
    Route::post('/2fa-verify-submit', [AuthenticatorDeviceController::class, 'Verify2FACodeSubmit'])->name('2fa-verify-submit');
});

Route::middleware(['auth','2fa'])->group(function () {
    Route::get('/dashboard', function () { return Inertia::render('Dashboard'); })->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::post('/get2fa', [AuthenticatorDeviceController::class, 'get2FACode'])->name('profile.get2fa');
    Route::post('/set2fa', [AuthenticatorDeviceController::class, 'set2FA'])->name('profile.set2fa');



    Route::get('/recordings', [RecordingController::class, 'index'])->name('recordings');
    Route::post('/recordings/upload', [RecordingController::class, 'upload'])->name('recordings.upload');



});

require __DIR__.'/auth.php';
