<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MonitorController extends Controller
{
    /**
     * Menampilkan halaman monitor absensi real-time.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Controller ini hanya bertugas untuk menampilkan file view 'monitor.blade.php'.
        // Semua logika real-time akan ditangani di sisi frontend menggunakan
        // JavaScript (Vue.js) dan Laravel Echo.
        return view('monitor');
    }
}

