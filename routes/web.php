<?php

use App\Http\Controllers\DiagnosaController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\JenisTindakanController;
use App\Http\Controllers\RekapFeeRSIAController;
use App\Http\Controllers\RekapPendapatanController;
use App\Http\Controllers\TindakanPasienController;
use Illuminate\Support\Facades\Auth;
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
    if (!Auth::check()) {
        return redirect('/login');
    } else {
        if (Auth::user()->role === 'admin') {
            return redirect('/admin');
        } else if (Auth::user()->role === 'superAdmin') {
            return redirect('/super');
        } else if (Auth::user()->role === 'dokter') {
            return redirect('/dokter');
        }
    }
});

Route::get('/forgot', function () {
    return view('forgot');
});

Route::middleware(['auth', 'dokter'])->group(function () {
});

Route::resource('dokter', DokterController::class);

Route::post('dokter/aktifkan', [DokterController::class, 'aktifkan'])->name('dokter.aktifkan');
Route::post('dokter/nonaktifkan', [DokterController::class, 'nonaktifkan'])->name('dokter.nonaktifkan');

Route::resource('jenistindakan', JenisTindakanController::class);
Route::resource('diagnosa', DiagnosaController::class);
Route::resource('tindakanPasien', TindakanPasienController::class);
Route::resource('rekapfeersia', RekapFeeRSIAController::class);
Route::resource('rekapPendapatan', RekapPendapatanController::class);



Route::post('diagnosa/aktifkan', [DiagnosaController::class, 'aktifkan'])->name('diagnosa.aktifkan');
Route::post('diagnosa/nonaktifkan', [DiagnosaController::class, 'nonaktifkan'])->name('diagnosa.nonaktifkan');

Route::post('jenistindakan/aktifkan', [JenisTindakanController::class, 'aktifkan'])->name('jenistindakan.aktifkan');
Route::post('jenistindakan/nonaktifkan', [JenisTindakanController::class, 'nonaktifkan'])->name('jenistindakan.nonaktifkan');
Route::post('jenistindakan/ubahpersentase', [JenisTindakanController::class, 'ubahpersentase'])->name('jenistindakan.ubahpersentase');

Route::post('rekappendapatan/getRekap', [RekapPendapatanController::class, 'getRekapPendapatan'])->name('rekappendapatan.getRekap');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
