<?php

use App\Http\Controllers\DiagnosaController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\JenisTindakanController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\TindakanPasienController;
use Illuminate\Support\Facades\Route;

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
    return view('home');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/logout', function () {
    return view('login');
});

Route::resource('employee', EmployeesController::class);
Route::resource('jenisTindakan', JenisTindakanController::class);
Route::resource('diagnosa', DiagnosaController::class);
Route::resource('tindakanPasien', TindakanPasienController::class);
