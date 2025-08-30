<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KlinikController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\JanjiTemuController;
use App\Http\Controllers\ProfesionalController;

Route::get('/', function () {
    return Auth::check() 
        ? redirect()->route('admin.dashboard') 
        : redirect()->route('login');
})->name('root');

Route::prefix('admin')->group(function () {
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('admin.dashboard');
    
        Route::get('/klinik', [KlinikController::class, 'index'])->name('admin.klinik.index');
        Route::get('/klinik/create', [KlinikController::class, 'create'])->name('admin.klinik.create');
        Route::post('/klinik', [KlinikController::class, 'store'])->name('admin.klinik.store');
        Route::get('/klinik/{klinikId}', [KlinikController::class, 'show'])->name('admin.klinik.show');
        Route::get('/klinik/{klinikId}/edit', [KlinikController::class, 'edit'])->name('admin.klinik.edit');
        Route::put('/klinik/{klinikId}/update', [KlinikController::class, 'update'])->name('admin.klinik.update');
        Route::delete('/klinik/{klinikId}/delete', [KlinikController::class, 'destroy'])->name('admin.klinik.delete');

        Route::get('/dokter', [DokterController::class, 'index'])->name('admin.dokter.index');
        Route::get('/dokter/create', [DokterController::class, 'create'])->name('admin.dokter.create');
        Route::post('/dokter', [DokterController::class, 'store'])->name('admin.dokter.store');
        Route::get('/dokter/{dokterId}', [DokterController::class, 'show'])->name('admin.dokter.show');
        Route::get('/dokter/{dokterId}/edit', [DokterController::class, 'edit'])->name('admin.dokter.edit');
        Route::put('/dokter/{dokterId}/update', [DokterController::class, 'update'])->name('admin.dokter.update');
        Route::delete('/dokter/{dokterId}/delete', [DokterController::class, 'destroy'])->name('admin.dokter.delete');

        Route::get('/dokter/{dokterId}/jadwal/create', [JadwalController::class, 'create'])->name('admin.dokter.jadwal.create');
        Route::post('/dokter/{dokterId}/jadwal', [JadwalController::class, 'store'])->name('admin.dokter.jadwal.store');
        Route::get('/dokter/{dokterId}/jadwal/{jadwalId}/edit', [JadwalController::class, 'edit'])->name('admin.dokter.jadwal.edit');
        Route::put('/dokter/{dokterId}/jadwal/{jadwalId}/update', [JadwalController::class, 'update'])->name('admin.dokter.jadwal.update');
        Route::delete('/dokter/{dokterId}/jadwal/{jadwalId}/delete', [JadwalController::class, 'destroy'])->name('admin.dokter.jadwal.delete');

        Route::get('/profesional/create/{dokterId}', [ProfesionalController::class, 'create'])->name('admin.dokter.profesional.create');
        Route::post('/profesional/{dokterId}', [ProfesionalController::class, 'store'])->name('admin.dokter.profesional.store');
        Route::get('/profesional/{profesionalId}/edit', [ProfesionalController::class, 'edit'])->name('admin.dokter.profesional.edit');
        Route::put('/profesional/{profesionalId}/update', [ProfesionalController::class, 'update'])->name('admin.dokter.profesional.update');
        Route::delete('/profesional/{profesionalId}/delete', [ProfesionalController::class, 'destroy'])->name('admin.dokter.profesional.delete');

        Route::get('/cuti/create/{dokterId}', [CutiController::class, 'create'])->name('admin.dokter.cuti.create');
        Route::post('/cuti/{dokterId}', [CutiController::class, 'store'])->name('admin.dokter.cuti.store');
        Route::get('/cuti/{cutiId}/edit', [CutiController::class, 'edit'])->name('admin.dokter.cuti.edit');
        Route::put('/cuti/{cutiId}/update', [CutiController::class, 'update'])->name('admin.dokter.cuti.update');
        Route::delete('/cuti/{cutiId}/delete', [CutiController::class, 'destroy'])->name('admin.dokter.cuti.delete');

        Route::get('/user', [UserController::class, 'indexUser'])->name('admin.user.index');
        Route::get('/user/create', [UserController::class, 'create'])->name('admin.user.create');
        Route::post('/user', [UserController::class, 'store'])->name('admin.user.store');
        Route::get('/user/{userId}/edit', [UserController::class, 'edit'])->name('admin.user.edit');
        Route::put('/user/{userId}/update', [UserController::class, 'update'])->name('admin.user.update');
        Route::delete('/user/{userId}/delete', [UserController::class, 'destroy'])->name('admin.user.delete');

        Route::get('/admin', [UserController::class, 'indexAdmin'])->name('admin.admin.index');
        Route::get('/admin/create', [UserController::class, 'createAdmin'])->name('admin.admin.create');
        Route::post('/admin', [UserController::class, 'storeAdmin'])->name('admin.admin.store');
        Route::get('/admin/{userId}/edit', [UserController::class, 'editAdmin'])->name('admin.admin.edit');
        Route::put('/admin/{userId}/update', [UserController::class, 'updateAdmin'])->name('admin.admin.update');
        Route::delete('/admin/{userId}/delete', [UserController::class, 'destroyAdmin'])->name('admin.admin.delete');

        Route::get('/pasien', [PasienController::class, 'index'])->name('admin.pasien.index');
        Route::get('/pasien/{pasienId}', [PasienController::class, 'show'])->name('admin.pasien.show');
        Route::delete('/pasien/{pasienId}/delete', [PasienController::class, 'destroy'])->name('admin.pasien.delete');
        Route::get('/pasien/{pasienId}/edit', [PasienController::class, 'edit'])->name('admin.pasien.edit');
        Route::put('/pasien/{pasienId}/update', [PasienController::class, 'update'])->name('admin.pasien.update');

        Route::get('/janjitemu', [JanjiTemuController::class, 'index'])->name('admin.janjitemu.index');
        // Route::get('/janjitemu/{janjitemuId}/edit', [JanjiTemuController::class, 'edit'])->name('admin.janjitemu.edit');
        // Route::put('/janjitemu/{janjitemuId}/update', [JanjiTemuController::class, 'update'])->name('admin.janjitemu.update');
        Route::delete('/janjitemu/{janjitemuId}/delete', [JanjiTemuController::class, 'destroy'])->name('admin.janjitemu.delete');

        
        Route::get('/banner', [BannerController::class, 'index'])->name('admin.banner.index');
        Route::get('/banner/create', [BannerController::class, 'create'])->name('admin.banner.create');
        Route::post('/banner', [BannerController::class, 'store'])->name('admin.banner.store');
        // Route::get('/banner/{bannerId}/edit', [BannerController::class, 'edit'])->name('admin.banner.edit');
        // Route::put('/banner/{bannerId}/update', [BannerController::class, 'update'])->name('admin.banner.update');
        Route::delete('/banner/{bannerId}/delete', [BannerController::class, 'destroy'])->name('admin.banner.delete');

        // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});


require __DIR__.'/auth.php';
