<?php

use App\Http\Controllers\DiagnosaController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\JenisTindakanController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\RekapDataRSIAController;
use App\Http\Controllers\RekapFeeaRSIAController;
use App\Http\Controllers\RekapFeeRSIAController;
use App\Http\Controllers\RekapPendapatanController;
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

Route::get('/forgot', function () {
    return view('forgot');
});

Route::resource('dokter', DokterController::class);
Route::resource('jenistindakan', JenisTindakanController::class);
Route::resource('diagnosa', DiagnosaController::class);
Route::resource('tindakanPasien', TindakanPasienController::class);
Route::resource('rekapfeersia', RekapFeeRSIAController::class);
Route::resource('rekapPendapatan', RekapPendapatanController::class);

Route::post('dokter/aktifkan', [DokterController::class, 'aktifkan'])->name('dokter.aktifkan');
Route::post('dokter/nonaktifkan', [DokterController::class, 'nonaktifkan'])->name('dokter.nonaktifkan');

Route::post('diagnosa/aktifkan', [DiagnosaController::class, 'aktifkan'])->name('diagnosa.aktifkan');
Route::post('diagnosa/nonaktifkan', [DiagnosaController::class, 'nonaktifkan'])->name('diagnosa.nonaktifkan');

Route::post('jenistindakan/aktifkan', [JenisTindakanController::class, 'aktifkan'])->name('jenistindakan.aktifkan');
Route::post('jenistindakan/nonaktifkan', [JenisTindakanController::class, 'nonaktifkan'])->name('jenistindakan.nonaktifkan');
Route::post('jenistindakan/ubahpersentase', [JenisTindakanController::class, 'ubahpersentase'])->name('jenistindakan.ubahpersentase');

Route::post('rekappendapatan/getRekap', [RekapPendapatanController::class, 'getRekapPendapatan'])->name('rekappendapatan.getRekap');
