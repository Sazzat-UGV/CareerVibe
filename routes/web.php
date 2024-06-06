<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/jobs', [JobController::class, 'index'])->name('jobs');

Route::prefix('account')->group(function () {

    // Guest Route
    Route::middleware('guest')->group(function () {
        Route::get('/register', [AccountController::class, 'registration'])->name('account.registration');
        Route::post('/process-register', [AccountController::class, 'processRegistration'])->name('account.processRegistration');
        Route::get('/login', [AccountController::class, 'login'])->name('account.login');
        Route::post('/authenticate', [AccountController::class, 'authenticate'])->name('account.authenticate');
    });

    // Authenticated Route
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [AccountController::class, 'profile'])->name('account.profile');
        Route::put('/update/profile', [AccountController::class, 'updateProfile'])->name('account.updateProfile');
        Route::get('/logout', [AccountController::class, 'logout'])->name('account.logout');
        Route::post('/update-profile-pic', [AccountController::class, 'updateProfilePic'])->name('account.updateProfilePic');

        // job route
        Route::get('/create-job', [JobController::class, 'createJob'])->name('account.createJob');
        Route::post('/save-job', [JobController::class, 'saveJob'])->name('account.saveJob');
        Route::get('/my-jobs', [JobController::class, 'myJobs'])->name('account.myJobs');
        Route::get('/my-jobs/edit/{id}', [JobController::class, 'editJob'])->name('account.editJob');
        Route::put('/update-job/{jobId}', [JobController::class, 'updateJob'])->name('account.updateJob');
        Route::post('/delete-job', [JobController::class, 'deleteJob'])->name('account.deleteJob');
    });
});
