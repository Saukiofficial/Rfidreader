<?php

namespace App\Actions;

use App\Models\User;
use App\Models\Attendance;
use App\Jobs\SendWhatsappNotification;
use App\Events\NewAttendance;
use Carbon\Carbon;

class ProcessAttendanceAction
{
    /**
     * Process an attendance record.
     *
     * @param string $identifier Can be card_uid or fingerprint_id
     * @param string $method 'rfid' or 'fingerprint'
     * @param string $deviceId
     * @return array
     */
    public function execute(string $identifier, string $method, string $deviceId): array
    {
        try {
            $query = User::student();
            if ($method === 'fingerprint') {
                $query->where('fingerprint_id', $identifier);
            } else {
                $query->where('card_uid', $identifier);
            }

            $student = $query->with('guardian')->first();

            if (!$student) {
                return ['success' => false, 'message' => 'Siswa dengan ID tersebut tidak ditemukan.'];
            }

            $today = Carbon::today();
            $lastAttendance = Attendance::where('user_id', $student->id)
                ->whereDate('recorded_at', $today)
                ->latest('recorded_at')
                ->first();

            $status = 'in';
            if ($lastAttendance && $lastAttendance->status === 'in') {
                $status = 'out';
            }

            // PERBAIKAN: Memastikan semua kolom yang dibutuhkan diisi
            $attendance = Attendance::create([
                'user_id' => $student->id,
                'card_uid' => $identifier, // Menyimpan identifier yang digunakan
                'device_id' => $deviceId,
                'method' => $method,
                'status' => $status,
                'recorded_at' => now(),
            ]);

            NewAttendance::dispatch($student, $attendance);

            if ($student->guardian && $student->guardian->guardian_phone) {
                $action = ($status === 'in') ? 'masuk' : 'pulang';
                $message = "Halo {$student->guardian->name}, putra/putri Anda {$student->name} sudah {$action} sekolah pada jam " . $attendance->recorded_at->format('H:i');
                SendWhatsappNotification::dispatch($student, $student->guardian, $message);
            }

            $actionText = ($status === 'in') ? 'masuk' : 'pulang';
            $finalMessage = "Absensi {$actionText} untuk {$student->name} berhasil dicatat pada jam " . $attendance->recorded_at->format('H:i:s');

            return ['success' => true, 'message' => $finalMessage];
        } catch (\Exception $e) {
            \Log::error('ProcessAttendanceAction Error: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Terjadi kesalahan sistem!'];
        }
    }
}

