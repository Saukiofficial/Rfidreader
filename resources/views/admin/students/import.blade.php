@extends('layouts.admin')

@section('header', $pageTitle)

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-6 pb-2 border-b">
        <h2 class="text-xl font-semibold">{{ $pageTitle }}</h2>
        <a href="{{ route('admin.students.index') }}" class="text-sm text-gray-600 hover:text-indigo-600">
            &larr; Kembali ke Daftar Siswa
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{!! session('error') !!}</span>
        </div>
    @endif

    <div class="bg-gray-50 p-4 rounded-md border">
        <h3 class="font-semibold text-gray-800">Petunjuk Penggunaan:</h3>
        <ol class="list-decimal list-inside mt-2 text-sm text-gray-600 space-y-1">
            <li>Unduh template file Excel yang sudah disediakan.</li>
            <li>Isi data siswa dan wali murid sesuai dengan kolom pada template. Jangan mengubah nama kolom.</li>
            <li>Pastikan email dan NIS untuk setiap siswa bersifat unik.</li>
            <li>Nomor WA wali murid harus dalam format angka (contoh: 6281234567890).</li>
            <li>Setelah selesai, unggah file tersebut menggunakan formulir di bawah ini.</li>
        </ol>
        <div class="mt-4">
            <a href="{{ route('admin.students.import.template') }}" class="inline-flex items-center bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 text-sm font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
                Unduh Template Excel
            </a>
        </div>
    </div>

    <form action="{{ route('admin.students.import.store') }}" method="POST" enctype="multipart/form-data" class="mt-6">
        @csrf
        <div>
            <label for="file" class="block text-sm font-medium text-gray-700">Pilih File Excel</label>
            <input
                type="file"
                id="file"
                name="file"
                required
                class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                accept=".xlsx, .xls, .csv"
            >
            <p class="mt-1 text-xs text-gray-500">Hanya file dengan format .xlsx, .xls, atau .csv yang diperbolehkan.</p>
        </div>

        <div class="mt-6">
            <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Impor Data
            </button>
        </div>
    </form>
</div>
@endsection

