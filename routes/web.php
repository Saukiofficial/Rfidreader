<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\GuardianController;
use App\Http\Controllers\Admin\AttendanceController as AdminAttendanceController;
use App\Http\Controllers\Admin\SimulationController;
use App\Http\Controllers\Panel\DashboardController as PanelDashboardController;
use App\Http\Controllers\Panel\LeaveController;
use App\Http\Controllers\Admin\StudentImportController;
use App\Http\Controllers\MonitorController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rute untuk Halaman Monitor Absensi (dapat diakses publik)
Route::get('/monitor', [MonitorController::class, 'index'])->name('monitor.index');

// Redirect root to login page
Route::get('/', function () {
    return redirect()->route('login');
});

// Laravel Breeze Authentication Routes are included here
require __DIR__.'/auth.php';

// Rute "Gerbang" setelah login
Route::get('/dashboard', function () {
    $user = Auth::user();
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('panel.dashboard');
})->middleware(['auth'])->name('dashboard');

// Admin Panel Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Rute untuk Fitur Impor Siswa
    Route::get('students/import', [StudentImportController::class, 'show'])->name('students.import.show');
    Route::post('students/import', [StudentImportController::class, 'store'])->name('students.import.store');
    Route::get('students/import/template', [StudentImportController::class, 'downloadTemplate'])->name('students.import.template');

    // Student Management
    Route::resource('students', StudentController::class);

    // Guardian Management
    Route::resource('guardians', GuardianController::class);

    // Attendance Management
    Route::get('attendances', [AdminAttendanceController::class, 'index'])->name('attendances.index');
    // PERBAIKAN: Menambahkan kembali rute untuk ekspor absensi
    Route::get('attendances/export', [AdminAttendanceController::class, 'export'])->name('attendances.export');

    // Simulation
    Route::get('simulation', [SimulationController::class, 'index'])->name('simulation.index');
    Route::post('simulation', [SimulationController::class, 'store'])->name('simulation.store');
});

// Student & Guardian Panel Routes
Route::middleware(['auth', 'role:siswa,wali'])->prefix('panel')->name('panel.')->group(function () {
    Route::get('/dashboard', [PanelDashboardController::class, 'index'])->name('dashboard');

    Route::middleware('role:siswa')->prefix('leaves')->name('leaves.')->group(function () {
        Route::get('/', [LeaveController::class, 'index'])->name('index');
        Route::get('/create', [LeaveController::class, 'create'])->name('create');
        Route::post('/', [LeaveController::class, 'store'])->name('store');
    });
});

