<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Attendance;

class DashboardController extends Controller
{
    /**
     * Display the dashboard for students and guardians.
     */
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Data for student panel
        if ($user->role === 'siswa') {
            $attendanceToday = $user->attendances()
                ->whereDate('recorded_at', $today)
                ->orderBy('recorded_at', 'asc')
                ->get();

            $checkIn = $attendanceToday->firstWhere('status', 'in');
            $checkOut = $attendanceToday->last(function ($item) {
                return $item->status == 'out';
            });

            $monthlyAttendances = $user->attendances()
                ->whereBetween('recorded_at', [$startOfMonth, $endOfMonth])
                ->orderBy('recorded_at', 'desc')
                ->get()
                ->groupBy(function($date) {
                    return Carbon::parse($date->recorded_at)->format('Y-m-d');
                });

            return view('panel.dashboard', compact('user', 'checkIn', 'checkOut', 'monthlyAttendances'));
        }

        // Data for guardian panel
        if ($user->role === 'wali') {
            $students = $user->students; // Mengambil semua anak dari wali murid
            $studentIds = $students->pluck('id');

            $monthlyAttendances = Attendance::whereIn('user_id', $studentIds)
                ->whereBetween('recorded_at', [$startOfMonth, $endOfMonth])
                ->with('user') // Eager load user data
                ->orderBy('recorded_at', 'desc')
                ->get()
                ->groupBy('user_id'); // Mengelompokkan absensi berdasarkan ID siswa

            return view('panel.dashboard', compact('user', 'students', 'monthlyAttendances'));
        }

        // Fallback in case of unexpected role
        return redirect('/login');
    }
}

