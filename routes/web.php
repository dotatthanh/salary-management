<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SalaryController;

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
    return redirect('login');
});

Route::middleware(['auth'])->group(function () {
	Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

	Route::resource('users', UserController::class);
	Route::get('/users/view-change-password/{user}', [UserController::class, 'viewChangePassword'])->name('users.view-change-password');
	Route::post('/users/change-password/{user}', [UserController::class, 'changePassword'])->name('users.change-password');

	Route::resource('salaries', SalaryController::class);
	Route::post('/import-excel-salary', [SalaryController::class, 'importExcel'])->name('salaries.import-excel');
	Route::get('/export-excel-salary', [SalaryController::class, 'exportExcel'])->name('salaries.export-excel');
});

require __DIR__.'/auth.php';
