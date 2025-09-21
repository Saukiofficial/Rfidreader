<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentsImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * Method ini akan dipanggil untuk setiap baris di dalam file Excel.
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Langkah 1: Cari atau buat data wali murid.
        // Menggunakan firstOrCreate untuk mencari wali berdasarkan nomor WA.
        // Jika tidak ditemukan, data wali baru akan dibuat secara otomatis.
        $guardian = User::firstOrCreate(
            ['guardian_phone' => $row['nomor_wa_wali']],
            [
                'name' => $row['nama_wali'],
                'email' => $row['nomor_wa_wali'] . '@school.app', // Email dummy untuk wali agar unik
                'password' => Hash::make('password123'), // Password default untuk wali
                'role' => 'wali',
            ]
        );

        // Langkah 2: Gabungkan tingkat kelas dan jurusan dari template menjadi satu string.
        $class = $row['tingkat_kelas'] . ' ' . $row['jurusan'];

        // Langkah 3: Buat data siswa baru dan hubungkan dengan ID wali murid.
        return new User([
            'name'     => $row['nama_siswa'],
            'email'    => $row['email_siswa'],
            'password' => Hash::make($row['password_siswa']),
            'role' => 'siswa',
            'nis' => $row['nis'],
            'class' => $class, // Simpan kelas yang sudah digabung
            'guardian_id' => $guardian->id,
        ]);
    }

    /**
     * Aturan validasi untuk setiap baris di file Excel.
     * Ini akan memastikan data yang diimpor bersih dan sesuai format.
     * @return array
     */
    public function rules(): array
    {
        return [
            'nama_siswa' => 'required|string',
            'email_siswa' => 'required|email|unique:users,email',
            'nis' => 'required|unique:users,nis',
            'tingkat_kelas' => 'required|in:X,XI,XII',
            'jurusan' => 'required|in:AKUNTANSI,ANIMASI,DESAIN KOMUNIKASI VISUAL,MANAJEMEN PERKANTORAN,PRODUKSI SIARAN PROGRAM TELEVISI',
            'password_siswa' => 'required|min:8',
            'nama_wali' => 'required|string',
            'nomor_wa_wali' => 'required|numeric',
        ];
    }
}

