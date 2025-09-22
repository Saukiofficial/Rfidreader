<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class GuardiansExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * Mengambil data dari database.
    */
    public function collection()
    {
        // Mengambil semua user dengan role 'wali' beserta jumlah anak yang terhubung
        return User::guardian()->withCount('students')->get();
    }

    /**
     * Mendefinisikan header untuk kolom di file Excel.
     */
    public function headings(): array
    {
        return [
            'Nama Wali',
            'Email',
            'Nomor WhatsApp',
            'Jumlah Anak',
        ];
    }

    /**
     * Memetakan data dari collection ke format yang diinginkan per baris.
     */
    public function map($guardian): array
    {
        return [
            $guardian->name,
            $guardian->email,
            $guardian->guardian_phone,
            $guardian->students_count,
        ];
    }
}
