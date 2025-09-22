@extends('layouts.admin')

@section('header', $pageTitle)

@section('content')
<!-- Header Section with Gradient Background -->
<div class="relative overflow-hidden bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 rounded-2xl p-8 mb-8 shadow-sm border border-white/20">
    <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-bl from-blue-100/30 to-transparent rounded-full -translate-y-32 translate-x-32"></div>
    <div class="absolute bottom-0 left-0 w-48 h-48 bg-gradient-to-tr from-indigo-100/40 to-transparent rounded-full translate-y-24 -translate-x-24"></div>

    <div class="relative z-10 max-w-4xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div class="space-y-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold bg-gradient-to-r from-slate-800 to-slate-600 bg-clip-text text-transparent">
                            {{ $pageTitle }}
                        </h1>
                        <p class="text-slate-600 text-base font-medium mt-1">
                            Import data wali murid secara massal dengan file Excel
                        </p>
                    </div>
                </div>
            </div>

            <a href="{{ route('admin.guardians.index') }}"
               class="group flex items-center gap-2 bg-white/80 hover:bg-white text-slate-700 hover:text-slate-900 px-5 py-3 rounded-xl font-medium transition-all duration-200 shadow-sm hover:shadow-md border border-white/50 backdrop-blur-sm">
                <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Kembali ke Daftar</span>
            </a>
        </div>
    </div>
</div>

<div class="max-w-4xl mx-auto">
    <!-- Alert Messages -->
    @if (session('success'))
        <div class="relative bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-200 rounded-xl p-6 mb-8 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0 w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-emerald-800 mb-1">Berhasil!</h3>
                    <p class="text-emerald-700">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="relative bg-gradient-to-r from-red-50 to-rose-50 border border-red-200 rounded-xl p-6 mb-8 shadow-sm">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-red-800 mb-2">Terjadi Kesalahan!</h3>
                    <div class="text-red-700">{!! session('error') !!}</div>
                </div>
            </div>
        </div>
    @endif

    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Instructions Card -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 via-blue-700 to-cyan-600 px-8 py-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-white">Panduan Import Data</h2>
                    </div>
                </div>

                <div class="p-8">
                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center font-bold text-sm">1</div>
                            <div>
                                <h3 class="font-bold text-gray-800 mb-2">Download Template Excel</h3>
                                <p class="text-gray-600 text-sm mb-3">Unduh template yang sudah disediakan untuk memastikan format data sesuai dengan sistem.</p>
                                <a href="{{ route('admin.guardians.import.template') }}"
                                   class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-500 to-cyan-600 hover:from-blue-600 hover:to-cyan-700 text-white px-4 py-2 rounded-lg font-medium transition-all duration-200 shadow-sm hover:shadow-md text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Unduh Template
                                </a>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-8 h-8 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center font-bold text-sm">2</div>
                            <div>
                                <h3 class="font-bold text-gray-800 mb-2">Isi Data Sesuai Format</h3>
                                <p class="text-gray-600 text-sm">Lengkapi template dengan data wali murid. Pastikan tidak mengubah nama kolom header yang sudah ada.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-8 h-8 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center font-bold text-sm">3</div>
                            <div>
                                <h3 class="font-bold text-gray-800 mb-2">Pastikan Data Unik</h3>
                                <p class="text-gray-600 text-sm">Email dan nomor WhatsApp harus unik untuk setiap wali murid. Tidak boleh ada duplikasi data.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-8 h-8 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center font-bold text-sm">4</div>
                            <div>
                                <h3 class="font-bold text-gray-800 mb-2">Upload & Proses</h3>
                                <p class="text-gray-600 text-sm">Upload file Excel yang sudah diisi melalui form di samping, lalu klik tombol untuk memulai proses import.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Format Requirements -->
                    <div class="mt-8 p-6 bg-gradient-to-r from-gray-50 to-blue-50 rounded-xl border border-gray-200">
                        <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Format File yang Didukung
                        </h3>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="text-center p-3 bg-white rounded-lg border border-gray-100">
                                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-700">.xlsx</span>
                            </div>
                            <div class="text-center p-3 bg-white rounded-lg border border-gray-100">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-700">.xls</span>
                            </div>
                            <div class="text-center p-3 bg-white rounded-lg border border-gray-100">
                                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                                    <svg class="w-4 h-4 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-gray-700">.csv</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upload Form Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden sticky top-8">
                <div class="bg-gradient-to-r from-emerald-600 via-emerald-700 to-teal-600 px-6 py-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                        </div>
                        <h2 class="text-lg font-bold text-white">Upload File</h2>
                    </div>
                </div>

                <div class="p-6">
                    <form action="{{ route('admin.guardians.import.store') }}" method="POST" enctype="multipart/form-data" id="importForm">
                        @csrf

                        <!-- File Upload Area -->
                        <div class="mb-6">
                            <label for="file" class="block text-sm font-bold text-gray-700 mb-3">
                                Pilih File Excel
                                <span class="text-red-500 ml-1">*</span>
                            </label>

                            <div class="relative">
                                <div id="drop-zone" class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-emerald-500 hover:bg-emerald-50/50 transition-all duration-200 cursor-pointer group">
                                    <div id="upload-content">
                                        <svg class="w-12 h-12 text-gray-400 group-hover:text-emerald-500 mx-auto mb-4 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                        </svg>
                                        <p class="text-gray-600 group-hover:text-emerald-600 font-medium mb-2 transition-colors">
                                            Klik untuk memilih file
                                        </p>
                                        <p class="text-gray-500 text-sm">atau drag & drop file di sini</p>
                                    </div>

                                    <div id="file-info" class="hidden">
                                        <svg class="w-12 h-12 text-emerald-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <p id="file-name" class="text-gray-800 font-medium mb-1"></p>
                                        <p id="file-size" class="text-gray-500 text-sm"></p>
                                        <button type="button" onclick="clearFile()" class="mt-3 text-red-600 hover:text-red-800 text-sm font-medium">
                                            Hapus File
                                        </button>
                                    </div>
                                </div>

                                <input
                                    type="file"
                                    id="file"
                                    name="file"
                                    required
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                    accept=".xlsx, .xls, .csv"
                                >
                            </div>

                            <p class="mt-2 text-xs text-gray-500 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Maksimal ukuran file 2MB. Format: .xlsx, .xls, .csv
                            </p>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" id="submitBtn" disabled
                                class="w-full bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 disabled:from-gray-300 disabled:to-gray-400 text-white px-6 py-4 rounded-xl font-bold transition-all duration-200 shadow-lg hover:shadow-emerald-500/25 disabled:shadow-none disabled:cursor-not-allowed flex items-center justify-center gap-3">
                            <svg id="submit-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                            </svg>
                            <span id="submit-text">Pilih File Terlebih Dahulu</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for File Upload Handling -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('file');
    const dropZone = document.getElementById('drop-zone');
    const uploadContent = document.getElementById('upload-content');
    const fileInfo = document.getElementById('file-info');
    const fileName = document.getElementById('file-name');
    const fileSize = document.getElementById('file-size');
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submit-text');
    const submitIcon = document.getElementById('submit-icon');
    const importForm = document.getElementById('importForm');

    // Handle file selection
    fileInput.addEventListener('change', function(e) {
        handleFile(e.target.files[0]);
    });

    // Handle drag and drop
    dropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        dropZone.classList.add('border-emerald-500', 'bg-emerald-50');
    });

    dropZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        dropZone.classList.remove('border-emerald-500', 'bg-emerald-50');
    });

    dropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        dropZone.classList.remove('border-emerald-500', 'bg-emerald-50');

        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            handleFile(files[0]);
        }
    });

    function handleFile(file) {
        if (file) {
            // Validate file type
            const allowedTypes = ['.xlsx', '.xls', '.csv'];
            const fileExtension = '.' + file.name.split('.').pop().toLowerCase();

            if (!allowedTypes.includes(fileExtension)) {
                alert('Format file tidak didukung. Gunakan format .xlsx, .xls, atau .csv');
                clearFile();
                return;
            }

            // Validate file size (2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file terlalu besar. Maksimal 2MB');
                clearFile();
                return;
            }

            // Show file info
            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);
            uploadContent.classList.add('hidden');
            fileInfo.classList.remove('hidden');

            // Enable submit button
            submitBtn.disabled = false;
            submitBtn.classList.remove('from-gray-300', 'to-gray-400');
            submitBtn.classList.add('from-emerald-500', 'to-teal-600', 'hover:from-emerald-600', 'hover:to-teal-700');
            submitText.textContent = 'Mulai Proses Import';

            // Update border
            dropZone.classList.add('border-emerald-500', 'bg-emerald-50/30');
        }
    }

    // Handle form submission
    importForm.addEventListener('submit', function() {
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span>Memproses...</span>
        `;
    });

    window.clearFile = function() {
        fileInput.value = '';
        uploadContent.classList.remove('hidden');
        fileInfo.classList.add('hidden');
        dropZone.classList.remove('border-emerald-500', 'bg-emerald-50/30');

        // Disable submit button
        submitBtn.disabled = true;
        submitBtn.classList.add('from-gray-300', 'to-gray-400');
        submitBtn.classList.remove('from-emerald-500', 'to-teal-600', 'hover:from-emerald-600', 'hover:to-teal-700');
        submitText.textContent = 'Pilih File Terlebih Dahulu';
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
});
</script>
@endsection
