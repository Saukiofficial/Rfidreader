<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use App\Exports\AttendancesExport;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceController extends Controller
{
    /**
     * Menampilkan daftar rekapitulasi absensi.
     */
    public function index(Request $request)
    {
        // Memanggil helper untuk mendapatkan data yang sudah difilter
        $processedAttendances = $this->getFilteredAttendances($request);

        // Ambil daftar kelas unik untuk dropdown filter
        $classes = User::student()->select('class')->whereNotNull('class')->distinct()->orderBy('class')->pluck('class');

        return view('admin.attendances.index', [
            'attendances' => $processedAttendances,
            'classes' => $classes,
            'filters' => $request->only(['start_date', 'end_date', 'class']),
        ]);
    }

    /**
     * Menangani permintaan ekspor data ke Excel.
     */
    public function export(Request $request)
    {
        // Menggunakan kembali logika filter untuk mendapatkan data yang akan diekspor
        $processedAttendances = $this->getFilteredAttendances($request);

        // Membuat nama file yang dinamis berdasarkan tanggal
        $fileName = 'rekap_absensi_' . Carbon::now()->format('d-m-Y') . '.xlsx';

        // Memicu unduhan file Excel
        return Excel::download(new AttendancesExport($processedAttendances), $fileName);
    }

    /**
     * Helper private untuk memfilter dan memproses data absensi.
     * Logika ini digunakan bersama oleh method index() dan export().
     */
    private function getFilteredAttendances(Request $request): array
    {
        $query = Attendance::with('user')->whereHas('user', function ($q) {
            $q->where('role', 'siswa');
        });

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $endDate = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('recorded_at', [$startDate, $endDate]);
        }

        if ($request->filled('class')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('class', $request->class);
            });
        }

        $attendances = $query->orderBy('recorded_at', 'desc')->get();

        $groupedAttendances = $attendances->groupBy(function ($item) {
            return $item->recorded_at->format('Y-m-d') . '_' . $item->user_id;
        });

        $processedAttendances = [];
        foreach ($groupedAttendances as $key => $group) {
            $checkIn = $group->where('status', 'in')->first();
            $checkOut = $group->where('status', 'out')->last();
            $user = $group->first()->user;

            if ($user) {
                 $processedAttendances[] = [
                    'date' => $group->first()->recorded_at->translatedFormat('d F Y'),
                    'user_name' => $user->name,
                    'class' => $user->class,
                    'check_in' => $checkIn ? $checkIn->recorded_at->format('H:i:s') : null,
                    'check_out' => $checkOut ? $checkOut->recorded_at->format('H:i:s') : null,
                ];
            }
        }
        return $processedAttendances;
    }
}

