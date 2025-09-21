<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actions\ProcessAttendanceAction;

class AttendanceController extends Controller
{
    /**
     * Menerima dan memproses data absensi dari perangkat.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Actions\ProcessAttendanceAction $processAttendance
     * @return \Illuminate\Http\JsonResponse
     */
    public function receive(Request $request, ProcessAttendanceAction $processAttendance)
    {
        // Validasi input, menggunakan 'identifier' yang lebih generik
        // untuk menerima UID kartu atau ID sidik jari.
        $validated = $request->validate([
            'identifier' => 'required|string',
            'device_id' => 'required|string',
            'method' => 'required|string|in:rfid,fingerprint', // Hanya menerima rfid atau fingerprint
        ]);

        // Memanggil kelas Aksi (Action) untuk memproses logika inti absensi.
        // Ini membuat controller tetap bersih dan logikanya terpusat.
        $result = $processAttendance->execute(
            $validated['identifier'],
            $validated['method'],
            $validated['device_id']
        );

        // Jika Aksi berhasil, kembalikan response JSON sukses.
        if ($result['success']) {
            return response()->json(['message' => $result['message']], 200);
        }

        // Jika Aksi gagal (misalnya siswa tidak ditemukan),
        // kembalikan response JSON error.
        return response()->json(['message' => $result['message']], 404);
    }
}

