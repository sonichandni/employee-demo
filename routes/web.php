<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{UserController, EmployeeController};
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
    return view('welcome');
});

Route::get('/login', function () {
    return view('welcome');
});

Route::post('login', [UserController::class, 'login'])->name('login');
Route::get('dashboard', [EmployeeController::class, 'dashboard'])->name('dashboard')->middleware('auth');
Route::post('delete', [EmployeeController::class, 'delete'])->name('delete');
Route::get('create', [EmployeeController::class, 'create'])->name('create');
Route::get('edit/{id}', [EmployeeController::class, 'edit'])->name('edit');
Route::post('store', [EmployeeController::class, 'store'])->name('store');
Route::get('bulk-upload', [EmployeeController::class, 'bulk_upload'])->name('bulk-upload');
Route::post('bulk-upload-store', [EmployeeController::class, 'bulk_upload_store'])->name('bulk-upload-store');
