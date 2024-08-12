<?php

use Illuminate\Http\Request;
use App\Livewire\PendaftaranWizard;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\ObatController;

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


Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [HomeController::class, 'home']);
	Route::get('dashboard', function () {
		return view('dashboard');
	})->name('dashboard');

	Route::get('billing', function () {
		return view('billing');
	})->name('billing');

	Route::get('profile', function () {
		return view('profile');
	})->name('profile');

	Route::get('rtl', function () {
		return view('rtl');
	})->name('rtl');

	Route::get('user-management', function () {
		return view('laravel-examples/user-management');
	})->name('user-management');

	Route::get('tables', function () {
		return view('tables');
	})->name('tables');

    Route::get('virtual-reality', function () {
		return view('virtual-reality');
	})->name('virtual-reality');


    Route::get('static-sign-in', function () {
		return view('static-sign-in');
	})->name('sign-in');

    Route::get('static-sign-up', function () {
		return view('static-sign-up');
	})->name('sign-up');

    Route::get('/logout', [SessionsController::class, 'destroy']);
	Route::get('/user-profile', [InfoUserController::class, 'create']);
	Route::post('/user-profile', [InfoUserController::class, 'store']);
    Route::get('/login', function () {
		return view('dashboard');
	})->name('sign-up');

	Route::prefix('info-pasien')->group(function () {
		Route::get('/', [PasienController::class, 'index'])->name('pasiens.index');
		Route::get('create', [PasienController::class, 'create'])->name('pasiens.create');
		Route::post('store', [PasienController::class, 'store'])->name('pasiens.store');
		Route::get('{pasien}/edit', [PasienController::class, 'edit'])->name('pasiens.edit');
		Route::put('{id}', [PasienController::class, 'update'])->name('pasiens.update');
		Route::get('{id}', [PasienController::class, 'show'])->name('pasiens.show');
		Route::delete('{id}', [PasienController::class, 'destroy'])->name('pasiens.destroy');
	});
	Route::prefix('info-dokter')->group(function(){
		Route::get('/', [DokterController::class, 'index'])->name('dokters.index');
		Route::get('/create', [DokterController::class, 'create'])->name('dokters.create');
		Route::post('/store', [DokterController::class, 'store'])->name('dokters.store'); 
		Route::get('{dokter}/edit', [DokterController::class, 'edit'])->name('dokters.edit');
		Route::put('{id}', [DokterController::class, 'update'])->name('dokters.update');
		Route::get('{id}', [DokterController::class, 'show'])->name('dokters.show');
		Route::delete('{id}', [DokterController::class, 'destroy'])->name('dokters.destroy'); 
	});
	
	// Route::get('/rawat-jalan', function () {
    //     return view('rawat-jalan.index');
    // })->name('rawat-jalan.index');

	// Route::get('/rawat-jalan', PendaftaranWizard::class)->name('rawat-jalan.index');


});



Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [RegisterController::class, 'create']);
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/login', [SessionsController::class, 'create']);
    Route::post('/session', [SessionsController::class, 'store']);
	Route::get('/login/forgot-password', [ResetController::class, 'create']);
	Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
	Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
	Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');

});

Route::get('/login', function () {
    return view('session/login-session');
})->name('login');



Route::get('/obat', [ObatController::class, 'index'])->name('obat.index');
Route::get('/obat/create', [ObatController::class, 'create'])->name('obat.create');
Route::post('/obat', [ObatController::class, 'store'])->name('obat.store');
Route::get('/obat/{id}/edit', [ObatController::class, 'edit'])->name('obat.edit');
Route::put('/obat/{id}', [ObatController::class, 'update'])->name('obat.update');
Route::delete('/obat/{id}', [ObatController::class, 'destroy'])->name('obat.destroy');
