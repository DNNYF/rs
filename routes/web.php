<?php

use App\Livewire\Wizard;
use Illuminate\Http\Request;
use App\Livewire\PendaftaranWizard;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VodController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\RawatJalanController;
use App\Http\Controllers\ChangePasswordController;

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



// Route::group(['middleware' => 'auth'], function () {

// 	Route::get('/', [HomeController::class, 'home']);
// 	Route::get('dashboard', function () {
// 		return view('dashboard');
// 	})->name('dashboard');

// 	Route::get('billing', function () {
// 		return view('billing');
// 	})->name('billing');

// 	Route::get('profile', function () {
// 		return view('profile');
// 	})->name('profile');

// 	Route::get('rtl', function () {
// 		return view('rtl');
// 	})->name('rtl');

// 	Route::get('user-management', function () {
// 		return view('laravel-examples/user-management');
// 	})->name('user-management');

// 	Route::get('tables', function () {
// 		return view('tables');
// 	})->name('tables');

// 	Route::get('virtual-reality', function () {
// 		return view('virtual-reality');
// 	})->name('virtual-reality');


// 	Route::get('static-sign-in', function () {
// 		return view('static-sign-in');
// 	})->name('sign-in');

// 	Route::get('static-sign-up', function () {
// 		return view('static-sign-up');
// 	})->name('sign-up');

// });
// Route::get('/logout', [SessionsController::class, 'destroy']);
// Route::get('/user-profile', [InfoUserController::class, 'create']);
// Route::post('/user-profile', [InfoUserController::class, 'store']);
// Route::get('/login', function () {
// 	return view('dashboard');
// })->name('sign-up');



Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [RegisterController::class, 'create']);
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/login', [SessionsController::class, 'create'])->name('login');
    Route::post('/session', [SessionsController::class, 'store']);
    Route::get('/login/forgot-password', [ResetController::class, 'create']);
    Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
    Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
    Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');
});

// ROLE : ADMIN

Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/', [HomeController::class, 'home']);
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('info-pasien')->group(function () {
        Route::get('/', [PasienController::class, 'index'])->name('pasiens.index');
        Route::get('create', [PasienController::class, 'create'])->name('pasiens.create');
        Route::post('store', [PasienController::class, 'store'])->name('pasiens.store');
        Route::get('{pasien}/edit', [PasienController::class, 'edit'])->name('pasiens.edit');
        Route::put('{id}', [PasienController::class, 'update'])->name('pasiens.update');
        Route::get('{id}', [PasienController::class, 'show'])->name('pasiens.show');
        Route::delete('{id}', [PasienController::class, 'destroy'])->name('pasiens.destroy');
    });


    Route::prefix('kamar')->group(function () {
        Route::get('/', [KamarController::class, 'index'])->name('kamar.index');
        Route::get('/create', [KamarController::class, 'create'])->name('kamar.create');
        Route::post('/store', [KamarController::class, 'store'])->name('kamar.store');
        Route::get('{kamar}/edit', [KamarController::class, 'edit'])->name('kamar.edit');
        Route::put('{kamar}', [KamarController::class, 'update'])->name('kamar.update');
        Route::delete('{kamar}', [KamarController::class, 'destroy'])->name('kamar.destroy');
    });

    Route::prefix('info-dokter')->group(function () {
        Route::get('/', [DokterController::class, 'index'])->name('dokters.index');
        Route::get('/create', [DokterController::class, 'create'])->name('dokters.create');
        Route::post('/store', [DokterController::class, 'store'])->name('dokters.store');
        Route::get('{dokter}/edit', [DokterController::class, 'edit'])->name('dokters.edit');
        Route::put('{id}', [DokterController::class, 'update'])->name('dokters.update');
        Route::get('{id}', [DokterController::class, 'show'])->name('dokters.show');
        Route::delete('{id}', [DokterController::class, 'destroy'])->name('dokters.destroy');
    });

    Route::prefix('vod')->group(function () {
        Route::get('/', [VodController::class, 'index'])->name('vod.index');
        Route::get('/create', [VodController::class, 'create'])->name('vod.create');
        Route::post('/store', [VodController::class, 'store'])->name('vod.store');
        Route::get('/{vod}/edit', [VodController::class, 'edit'])->name('vod.edit');
        Route::get('/vod/{vod}', [VodController::class, 'show'])->name('vod.show');
        Route::put('/{vod}', [VodController::class, 'update'])->name('vod.update');
        Route::delete('/{vod}', [VodController::class, 'destroy'])->name('vod.destroy');
    });
    
    Route::prefix('rawat-jalan')->group(function () {
        Route::get('/', [RawatJalanController::class, 'index'])->name('rawat-jalan.index');
        Route::post('/store', [RawatJalanController::class, 'store'])->name('rawat-jalan.store');
        Route::post('/step1', [RawatJalanController::class, 'step1'])->name('rawat-jalan.step1');
        Route::put('/step2', [RawatJalanController::class, 'step2'])->name('rawat-jalan.step2');
        Route::put('/step3', [RawatJalanController::class, 'step3'])->name('rawat-jalan.step3');
    });

    Route::prefix('manajemen-user')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/create', [AdminController::class, 'create'])->name('admin.create');
        Route::post('/store', [AdminController::class, 'store'])->name('admin.store');
        Route::delete('{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
        Route::get('{admin}/edit', [AdminController::class, 'edit'])->name('admin.edit');
        Route::put('{admin}', [AdminController::class, 'update'])->name('admin.update');
        Route::get('{id}', [AdminController::class, 'show'])->name('admin.show');
    });

    Route::prefix('fasilitas')->group(function(){
        Route::get('/', [FasilitasController::class, 'index'])->name('operator.fasilitas.index');
        Route::get('/create', [FasilitasController::class, 'create'])->name('operator.fasilitas.create');
        Route::post('/store', [FasilitasController::class, 'store'])->name('operator.fasilitas.store');
        Route::get('/{fasilitas}/edit', [FasilitasController::class, 'edit'])->name('operator.fasilitas.edit');
        Route::put('{fasilitas}', [FasilitasController::class, 'update'])->name('operator.fasilitas.update');
        Route::delete('{id}', [FasilitasController::class, 'destroy'])->name('operator.fasilitas.destroy');
    });

    Route::prefix('manajemen-pasien')->group(function () {
        Route::get('/', [OperatorController::class, 'index'])->name('operator.index');
        Route::get('/create', [OperatorController::class, 'create'])->name('operator.create');
        Route::post('/store', [OperatorController::class, 'store'])->name('operator.store');
        Route::delete('{id}', [OperatorController::class, 'destroy'])->name('operator.destroy');
        Route::get('{operator}/edit', [OperatorController::class, 'edit'])->name('operator.edit');
        Route::put('{operator}', [OperatorController::class, 'update'])->name('operator.update');
        Route::get('{id}', [OperatorController::class, 'show'])->name('operator.show');
    });

    Route::resource('obat', ObatController::class);
    Route::get('/obat', [ObatController::class, 'index'])->name('obat.index');
    Route::get('/obat/create', [ObatController::class, 'create'])->name('obat.create');
    Route::post('/obat', [ObatController::class, 'store'])->name('obat.store');
    Route::get('/obat/{id}/edit', [ObatController::class, 'edit'])->name('obat.edit');
    Route::put('/obat/{id}', [ObatController::class, 'update'])->name('obat.update');
    Route::delete('/obat/{id}', [ObatController::class, 'destroy'])->name('obat.destroy');

    Route::get('static-sign-in', function () {
        return view('static-sign-in');
    })->name('sign-in');

    Route::get('static-sign-up', function () {
        return view('static-sign-up');
    })->name('sign-up');
});

// ROLE :: OPERATOR
Route::group(['middleware' => ['role:operator']], function () {
    Route::get('/', [HomeController::class, 'operatorHome']);
});

Route::get('/logout', [SessionsController::class, 'destroy']);

Route::get('/user-profile', [InfoUserController::class, 'create']);
Route::post('/user-profile', [InfoUserController::class, 'store']);
