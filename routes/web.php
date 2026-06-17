<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ViolationController;
use App\Http\Controllers\StudentViolationController;

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

// Dashboard Route
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Students CRUD Routes
Route::resource('students', StudentController::class);

// Violations CRUD Routes
Route::resource('violations', ViolationController::class)->except(['show']);

// Student Violation Logs Routes
Route::get('/logs', [StudentViolationController::class, 'index'])->name('logs.index');
Route::get('/logs/create', [StudentViolationController::class, 'create'])->name('logs.create');
Route::post('/logs', [StudentViolationController::class, 'store'])->name('logs.store');
Route::delete('/logs/{log}', [StudentViolationController::class, 'destroy'])->name('logs.destroy');
