<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Collection;

class AttendancesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $attendances;

    /**
     * Menerima data absensi yang sudah diproses dari controller.
     *
     * @param array $attendances
     */
    public function __construct(array $attendances)
    {
        // Mengubah array biasa menjadi Laravel Collection untuk kemudahan manipulasi
        $this->attendances = collect($attendances);
    }

    /**
    * Mengembalikan collection data yang akan diekspor.
    *
    * @return \Illuminate\Support\Collection
    */
    public function collection(): Collection
    {
        return $this->attendances;
    }

    /**
     * Mendefinisikan header untuk setiap kolom di dalam file Excel.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Tanggal',
            'Nama Siswa',
            'Kelas',
            'Jam Masuk',
            'Jam Pulang',
            'Status',
        ];
    }

    /**
     * Memetakan data dari setiap item di collection ke format baris Excel.
     *
     * @param mixed $attendance
     * @return array
     */
    public function map($attendance): array
    {
        // Pastikan $attendance adalah array
        if (!is_array($attendance)) {
            return [];
        }

        return [
            $attendance['date'],
            $attendance['user_name'],
            $attendance['class'],
            $attendance['check_in'] ?? '-',
            $attendance['check_out'] ?? '-',
            $attendance['check_in'] ? 'Hadir' : 'Tidak Hadir',
        ];
    }
}

