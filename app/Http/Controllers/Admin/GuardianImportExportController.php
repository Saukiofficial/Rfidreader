<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\GuardiansImport;
use App\Exports\GuardiansExport;
use Maatwebsite\Excel\Excel as ExcelFormat;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class GuardianImportExportController extends Controller
{
    /**
     * Menampilkan halaman form impor.
     */
    public function showImportForm()
    {
        $pageTitle = 'Impor Data Wali Murid';
        return view('admin.guardians.import', compact('pageTitle'));
    }

    /**
     * Memproses file Excel yang diunggah.
     */
    public function storeImport(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);

        try {
            Excel::import(new GuardiansImport, $request->file('file'));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
             $failures = $e->failures();
             $errorMessages = [];
             foreach ($failures as $failure) {
                 $errorMessages[] = "Baris ke-{$failure->row()}: " . implode(', ', $failure->errors());
             }
             return back()->with('error', 'Gagal mengimpor data: <br>' . implode('<br>', $errorMessages));
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

        return redirect()->route('admin.guardians.index')->with('success', 'Data wali murid berhasil diimpor!');
    }

    /**
     * Mengunduh file template Excel.
     */
    public function downloadTemplate(): BinaryFileResponse
    {
        // Template diperbarui untuk tidak menyertakan kolom email
        $data = [
            ['nama_wali', 'nomor_wa_wali', 'password_wali'],
            ['Ahmad Sanjaya', '6281234567890', 'password123'],
        ];

        $export = new class($data) implements \Maatwebsite\Excel\Concerns\FromArray {
            public function __construct(private array $data) {}
            public function array(): array { return $this->data; }
        };

        return Excel::download($export, 'template_wali_murid.xlsx', ExcelFormat::XLSX);
    }

    /**
     * Mengekspor data wali murid ke Excel.
     */
    public function export()
    {
        return Excel::download(new GuardiansExport, 'data_wali_murid.xlsx');
    }
}

