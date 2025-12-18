<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PanenController;
use App\Http\Controllers\RencanaPanenController;

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

Route::middleware(['auth'])->group(function () {

    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::put('/profile', 'ProfileController@update')->name('profile.update');

    Route::get('/jenis-jeruk', 'JenisJerukController@index')->name('jenis-jeruk.index');
    Route::post('/jenis-jeruk', 'JenisJerukController@store')->name('jenis-jeruk.store');
    Route::post('/jenis-jeruk/update', 'JenisJerukController@update')->name('jenis-jeruk.update');
    Route::get('/jenis-jeruk/delete/{id}', 'JenisJerukController@destroy')->name('jenis-jeruk.destroy');

    Route::get('/riwayat-panen', 'PanenController@index')->name('riwayat-panen.index');
    Route::post('/riwayat-panen', 'PanenController@store')->name('riwayat-panen.store');
    Route::post('/riwayat-panen/update', 'PanenController@update')->name('riwayat-panen.update');
    Route::get('/riwayat-panen/delete/{id}', 'PanenController@destroy')->name('riwayat-panen.destroy');

    Route::get('/riwayat-penjualan', 'PenjualanController@index')->name('riwayat-penjualan.index');
    Route::post('/riwayat-penjualan', 'PenjualanController@store')->name('riwayat-penjualan.store');
    Route::post('/riwayat-penjualan/update', 'PenjualanController@update')->name('riwayat-penjualan.update');
    Route::get('/riwayat-penjualan/delete/{id}', 'PenjualanController@destroy')->name('riwayat-penjualan.destroy');

    Route::get('/panen/report', 'PanenController@report')->name('panen.report');
    Route::get('/laporan/panen/data', [PanenController::class, 'data'])
        ->name('laporan.panen.data');
    Route::get('/panen/print', 'PanenController@print')
        ->name('laporan.panen.print');

    Route::get('/perencanan-panen', 'RencanaPanenController@index')->name('perencanaan-panen.index');


    Route::get('/penjualan/report', 'PenjualanController@report')->name('penjualan.report');
    Route::get('/penjualan/data', 'PenjualanController@data')
        ->name('laporan.penjualan.data');
    Route::get('/penjualan/print', 'PenjualanController@print')
        ->name('laporan.penjualan.print');
});

Route::get('/perencanaan-panen/events', [RencanaPanenController::class, 'events'])
    ->name('perencanaan-panen.events')
    ->middleware('auth');

// routes/web.php
Route::post('/perencanaan-panen/store', [RencanaPanenController::class, 'store'])
    ->name('perencanaan-panen.store')
    ->middleware('auth');

Route::post('/perencanaan-panen/update', [RencanaPanenController::class, 'update'])
    ->name('perencanaan-panen.update')
    ->middleware('auth');
Route::delete('/rencana-panen/{id}', [RencanaPanenController::class, 'destroy'])
    ->name('rencana-panen.destroy');
Route::get('/rencana-panen/{id}', [RencanaPanenController::class, 'show'])->name('perencanaan-panen.show')->middleware('auth');




Auth::routes();
