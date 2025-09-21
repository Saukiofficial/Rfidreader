<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AttendanceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Endpoint untuk menerima data absensi dari perangkat
Route::middleware('api.key')->group(function () {
    // PERBAIKAN: Menambahkan ->name() untuk memberi nama pada rute
    Route::post('/attendance/receive', [AttendanceController::class, 'receive'])->name('api.attendance.receive');
});
