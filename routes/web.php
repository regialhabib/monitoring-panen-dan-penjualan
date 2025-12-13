<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

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


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/profile', 'ProfileController@index')->name('profile');
Route::put('/profile', 'ProfileController@update')->name('profile.update');


