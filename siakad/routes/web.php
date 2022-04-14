<?php

use App\Http\Controllers\MahasiswaController;
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

Route::resource('mahasiswa', MahasiswaController::class);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/mahasiswa/search/aa/', [ MahasiswaController::class, 'search' ])->name('search');
Route::get('/nilai/{id}', [MahasiswaController::class, 'nilai'])->name('mahasiswa.nilai');
