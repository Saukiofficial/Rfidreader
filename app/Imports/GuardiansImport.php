<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class GuardiansImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * Method ini akan dipanggil untuk setiap baris di dalam file Excel.
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Membuat email dummy secara otomatis dari nomor WA untuk memenuhi constraint database.
        $dummyEmail = $row['nomor_wa_wali'] . '@school.app';

        // Membuat data User baru dengan role 'wali'.
        return new User([
            'name'           => $row['nama_wali'],
            'email'          => $dummyEmail,
            'guardian_phone' => $row['nomor_wa_wali'],
            'password'       => Hash::make($row['password_wali']),
            'role'           => 'wali',
        ]);
    }

    /**
     * Aturan validasi untuk setiap baris di file Excel.
     * Ini akan memastikan data yang diimpor bersih dan sesuai format.
     */
    public function rules(): array
    {
        return [
            'nama_wali' => 'required|string',
            // Validasi email dihapus dari sini karena dibuat otomatis.
            'nomor_wa_wali' => 'required|numeric|unique:users,guardian_phone',
            'password_wali' => 'required|min:8',
        ];
    }
}

