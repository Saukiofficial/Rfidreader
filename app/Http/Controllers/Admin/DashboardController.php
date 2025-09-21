<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // Total siswa
        $totalStudents = User::where('role', 'siswa')->count();

        // Siswa yang sudah absen masuk hari ini
        $presentStudentIds = Attendance::whereDate('recorded_at', $today)
            ->where('status', 'in')
            ->distinct('user_id')
            ->pluck('user_id');

        $presentCount = $presentStudentIds->count();
        $absentCount = $totalStudents - $presentCount;

        // TODO: Logika untuk siswa terlambat bisa ditambahkan di sini
        // Misalnya, jika jam masuk > 07:15
        $lateCount = Attendance::whereDate('recorded_at', $today)
            ->where('status', 'in')
            ->whereTime('recorded_at', '>', '07:15:00')
            ->distinct('user_id')
            ->count();

        // Data absensi terakhir
        $latestAttendances = Attendance::with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalStudents',
            'presentCount',
            'absentCount',
            'lateCount',
            'latestAttendances'
        ));
    }
}
