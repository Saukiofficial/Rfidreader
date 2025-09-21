<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentsImport;
use Maatwebsite\Excel\Excel as ExcelFormat;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class StudentImportController extends Controller
{
    /**
     * Menampilkan halaman form impor.
     */
    public function show()
    {
        $pageTitle = 'Impor Data Siswa';
        return view('admin.students.import', compact('pageTitle'));
    }

    /**
     * Memproses file Excel yang diunggah.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            // Memulai proses impor menggunakan class StudentsImport
            Excel::import(new StudentsImport, $request->file('file'));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
             // Menangkap error validasi dari file Excel
             $failures = $e->failures();
             $errorMessages = [];
             foreach ($failures as $failure) {
                 // Membuat pesan error yang jelas untuk setiap baris yang gagal
                 $errorMessages[] = "Baris ke-{$failure->row()}: " . implode(', ', $failure->errors());
             }
             return back()->with('error', 'Gagal mengimpor data. Terdapat beberapa kesalahan: <br>' . implode('<br>', $errorMessages));
        } catch (\Exception $e) {
            // Menangkap error umum lainnya
            return back()->with('error', 'Terjadi kesalahan saat memproses file: ' . $e->getMessage());
        }

        return redirect()->route('admin.students.index')->with('success', 'Data siswa berhasil diimpor!');
    }

    /**
     * Mengunduh file template Excel dengan format baru.
     */
    public function downloadTemplate(): BinaryFileResponse
    {
        // Data untuk template, termasuk header baru dan satu baris contoh
        $data = [
            ['nama_siswa', 'email_siswa', 'nis', 'tingkat_kelas', 'jurusan', 'password_siswa', 'nama_wali', 'nomor_wa_wali'],
            ['Budi Doremi', 'budi@example.com', '12345', 'X', 'AKUNTANSI', 'password123', 'Ahmad Sanjaya', '6281234567890'],
        ];

        // Class anonim untuk membuat file Excel dari array secara dinamis
        $export = new class($data) implements \Maatwebsite\Excel\Concerns\FromArray {
            public function __construct(private array $data) {}
            public function array(): array { return $this->data; }
        };

        return Excel::download($export, 'template_siswa.xlsx', ExcelFormat::XLSX);
    }
}

