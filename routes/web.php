<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\JobApplicationController;
use App\Http\Controllers\admin\JobController as AdminJobController;
use App\Http\Controllers\admin\UserController;
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
Route::get('/jobs/detail/{id}', [JobController::class, 'detail'])->name('job.detail');
Route::post('/apply-job', [JobController::class, 'applyJob'])->name('job.applyJob');
Route::post('/saved-job', [JobController::class, 'savedJob'])->name('job.savedJob');

// forgot password
Route::get('/forgot-password', [AccountController::class, 'forgotPassword'])->name('account.forgotPassword');
Route::post('/process-forgot-password', [AccountController::class, 'processForgotPassword'])->name('account.processForgotPassword');
Route::get('/reset-password/{token}', [AccountController::class, 'resetPassword'])->name('account.resetPassword');
Route::post('/process-reset-password', [AccountController::class, 'processResetPassword'])->name('account.processResetPassword');


// admin route
Route::prefix('admin')->middleware(['checkRole'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
// users
    Route::get('/users', [UserController::class, 'index'])->name('admin.users');
    Route::get('/users/{id}', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/update/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/delete', [UserController::class, 'destroy'])->name('admin.users.destroy');
    // jobs
    Route::get('/jobs', [AdminJobController::class, 'index'])->name('admin.jobs');
    Route::get('/jobs/{id}', [AdminJobController::class, 'edit'])->name('admin.jobs.edit');
    Route::put('/jobs/update/{id}', [AdminJobController::class, 'update'])->name('admin.jobs.update');
    Route::delete('/jobs/delete', [AdminJobController::class, 'destroy'])->name('admin.jobs.destroy');
    // job applications
    Route::get('/job-application', [JobApplicationController::class, 'index'])->name('admin.jobapplications');
    Route::delete('/job-application/delete', [JobApplicationController::class, 'destroy'])->name('admin.jobapplications.destroy');
});

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
        Route::post('/update/password', [AccountController::class, 'updatePassword'])->name('account.updatePassword');

        // job route
        Route::get('/create-job', [JobController::class, 'createJob'])->name('account.createJob');
        Route::post('/save-job', [JobController::class, 'saveJob'])->name('account.saveJob');
        Route::get('/my-jobs', [JobController::class, 'myJobs'])->name('account.myJobs');
        Route::get('/my-jobs/edit/{id}', [JobController::class, 'editJob'])->name('account.editJob');
        Route::put('/update-job/{jobId}', [JobController::class, 'updateJob'])->name('account.updateJob');
        Route::post('/delete-job', [JobController::class, 'deleteJob'])->name('account.deleteJob');
        Route::post('/remove-job-application', [JobController::class, 'removeJobs'])->name('account.removeJobs');
        Route::get('/my-job-applications', [JobController::class, 'myJobApplications'])->name('account.myJobApplications');
        Route::get('/my-saved-jobs', [JobController::class, 'mySavedJobs'])->name('account.mySavedJobs');
        Route::post('/remove-saved-job', [JobController::class, 'removeSavedJobs'])->name('account.removeSavedJobs');
    });
});
