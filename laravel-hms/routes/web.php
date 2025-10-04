<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;

/**
 * MIGRATION EXAMPLE: CodeIgniter Routes to Laravel Routes
 * 
 * CodeIgniter (application/config/routes.php):
 * $route['default_controller'] = 'welcome/index';
 * $route['page/(:any)'] = 'welcome/page/$1';
 * $route['form/appointment'] = 'welcome/appointment';
 * $route['user/resetpassword/([a-z]+)/(:any)'] = 'site/resetpassword/$1/$2';
 * 
 * Laravel (routes/web.php):
 * - Named routes for easy reference
 * - Controller@method or [Controller::class, 'method'] syntax
 * - Route parameters with validation
 * - Middleware for authentication/authorization
 * - Route grouping for organization
 */

// Home Route
Route::get('/', [WelcomeController::class, 'index'])->name('home');

// Page Routes
Route::get('/page/{slug}', [WelcomeController::class, 'page'])->name('page.show');

// Appointment Routes
Route::get('/appointment', [WelcomeController::class, 'showAppointmentForm'])->name('appointment.form');
Route::post('/appointment', [WelcomeController::class, 'storeAppointment'])->name('appointment.store');

// Example: Password Reset Routes
// Route::get('/user/resetpassword/{type}/{token}', [SiteController::class, 'resetPassword'])
//     ->name('password.reset')
//     ->where(['type' => '[a-z]+']);

// Example: Admin Routes (with middleware)
// Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
//     Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
//     Route::resource('patients', PatientController::class);
//     Route::resource('appointments', AppointmentController::class);
// });

// Example: Patient Portal Routes
// Route::middleware(['auth', 'patient'])->prefix('patient')->name('patient.')->group(function () {
//     Route::get('/dashboard', [PatientController::class, 'dashboard'])->name('dashboard');
//     Route::get('/appointments', [PatientController::class, 'appointments'])->name('appointments');
//     Route::get('/medical-records', [PatientController::class, 'medicalRecords'])->name('medical-records');
// });
