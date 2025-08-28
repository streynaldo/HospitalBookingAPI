<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KlinikController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\JanjiTemuController;
use App\Http\Controllers\ProfesionalController;
use App\Http\Controllers\SlotController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return ['message' => 'Welcome To CiHos API'];
});

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login',    [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
});

Route::prefix('pasien')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        // Route::get('/', [PasienController::class, 'index']);
        Route::post('/', [PasienController::class, 'createPasien']);
        Route::get('/user', [PasienController::class, 'getPasienByUserId']);
        Route::get('/user/{pasienId}', [PasienController::class, 'getPasienById']);
        Route::put('/user/{pasienId}', [PasienController::class, 'updatePasienById']);
        Route::delete('/user/{pasienId}', [PasienController::class, 'deletePasienById']);
    });
});

Route::prefix('klinik')->group(function () {
    Route::get('/', [KlinikController::class, 'getAllKlinik']);
    Route::get('/{klinikId}', [KlinikController::class, 'getKlinikById']);
});


Route::prefix('dokter')->group(function () {
    Route::get('/', [DokterController::class, 'getAllDokter']);
    Route::get('/klinik/{klinikId}', [DokterController::class, 'getAllDokterByKlinikId']);
    Route::get('/{dokterId}/jadwal', [JadwalController::class, 'getJadwalByDokterId']);
    Route::get('/{dokterId}/jadwal/{jadwalId}/slot', [SlotController::class, 'getSlotsByJadwalId']);
    Route::get('/{dokterId}/jadwal-cuti', [CutiController::class, 'getCutiByDokterId']);
    Route::get('/{dokterId}/riwayat-pendidikan', [ProfesionalController::class, 'getRiwayatPendidikanByDokterId']);
    Route::get('/{dokterId}/pengalaman-praktik', [ProfesionalController::class, 'getPengalamanByDokterId']);
    Route::get('/{dokterId}/prestasi', [ProfesionalController::class, 'getPrestasiByDokterId']);
});

Route::prefix('janjitemu')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/', [JanjiTemuController::class, 'getAllJanjiTemuByUserId']);
        Route::post('/', [JanjiTemuController::class, 'createJanjiTemu']);
        Route::put('/{janjiTemuId}', [JanjiTemuController::class, 'updateJanjiTemuById']);
        Route::get('/check-slot/{slotId}/{tanggal}', [JanjiTemuController::class, 'checkTotalPasien']);
        Route::delete('/{janjiTemuId}', [JanjiTemuController::class, 'deleteJanjiTemuById']);
    });
});

Route::prefix('profile')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/', [UserController::class, 'getLoggedInUser']);
        Route::put('/', [UserController::class, 'updateProfile']);
        Route::delete('/', [UserController::class, 'deleteAccount']);
    });
});


// Pake Token Coba
// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/doctors', [DokterController::class, 'index']);
//     // Route::get('/doctors/{doctor}', [DokterController::class, 'show']);
// });

Route::get('/ping', function () {
    return ['message' => 'pong from API'];
});
