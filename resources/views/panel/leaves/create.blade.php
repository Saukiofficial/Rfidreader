@extends('layouts.app')

@section('header')
    Ajukan Izin Baru
@endsection

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-4 border-b pb-2">
        <h2 class="text-xl font-semibold">Formulir Pengajuan Izin</h2>
        <a href="{{ route('panel.leaves.index') }}" class="text-sm text-gray-600 hover:text-indigo-600">
            &larr; Kembali ke Riwayat
        </a>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Oops!</strong>
            <span class="block sm:inline">Ada beberapa masalah dengan input Anda.</span>
            <ul class="mt-3 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('panel.leaves.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="space-y-4">
            <div>
                <label for="reason" class="block text-sm font-medium text-gray-700">Alasan</label>
                <textarea
                    id="reason"
                    name="reason"
                    rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    required
                    placeholder="Contoh: Sakit demam dan batuk."
                >{{ old('reason') }}</textarea>
                <p class="mt-2 text-xs text-gray-500">Jelaskan alasan Anda tidak dapat masuk sekolah.</p>
            </div>

            <div>
                <label for="proof_file" class="block text-sm font-medium text-gray-700">Unggah Bukti (Opsional)</label>
                <input
                    type="file"
                    id="proof_file"
                    name="proof_file"
                    class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                    aria-describedby="proof_file_help"
                >
                <p class="mt-1 text-xs text-gray-500" id="proof_file_help">Dapat berupa surat dokter atau dokumen pendukung lainnya (JPG, PNG, PDF maks 2MB).</p>
            </div>
        </div>
        <div class="mt-6">
            <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Kirim Pengajuan
            </button>
        </div>
    </form>
</div>
@endsection

