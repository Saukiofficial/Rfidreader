@extends('layouts.admin')

@section('header', $pageTitle)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-8 px-4">
    <!-- Main Container -->
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-slate-800 mb-2">{{ $pageTitle }}</h1>
                    <p class="text-slate-600">Impor data siswa dalam satu langkah mudah</p>
                </div>
                <a href="{{ route('admin.students.index') }}"
                   class="group flex items-center gap-2 px-4 py-2 text-slate-600 hover:text-indigo-600 transition-all duration-200 rounded-lg hover:bg-white/50">
                    <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span class="font-medium">Kembali</span>
                </a>
            </div>
        </div>

        <!-- Alert Messages -->
        @if (session('success'))
            <div class="mb-6 p-4 bg-gradient-to-r from-green-500 to-emerald-500 text-white rounded-xl shadow-lg animate-fadeIn">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 bg-gradient-to-r from-red-500 to-rose-500 text-white rounded-xl shadow-lg animate-fadeIn">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.664-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                    <div>{!! session('error') !!}</div>
                </div>
            </div>
        @endif

        <div class="grid lg:grid-cols-2 gap-8">
            <!-- Instructions Card -->
            <div class="bg-white/70 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-6 h-fit">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800">Panduan Import</h3>
                </div>

                <div class="space-y-4">
                    <div class="flex items-start gap-4 group">
                        <div class="w-8 h-8 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-lg flex items-center justify-center text-white text-sm font-bold flex-shrink-0">1</div>
                        <div class="flex-1">
                            <p class="text-slate-700 leading-relaxed">Unduh template Excel yang telah disediakan sebagai panduan format data</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 group">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-lg flex items-center justify-center text-white text-sm font-bold flex-shrink-0">2</div>
                        <div class="flex-1">
                            <p class="text-slate-700 leading-relaxed">Isi data siswa dan wali murid sesuai kolom template tanpa mengubah header</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 group">
                        <div class="w-8 h-8 bg-gradient-to-br from-purple-400 to-pink-500 rounded-lg flex items-center justify-center text-white text-sm font-bold flex-shrink-0">3</div>
                        <div class="flex-1">
                            <p class="text-slate-700 leading-relaxed">Pastikan email dan NIS bersifat unik untuk setiap siswa</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 group">
                        <div class="w-8 h-8 bg-gradient-to-br from-orange-400 to-red-500 rounded-lg flex items-center justify-center text-white text-sm font-bold flex-shrink-0">4</div>
                        <div class="flex-1">
                            <p class="text-slate-700 leading-relaxed">Format nomor WA dalam angka (contoh: 6281234567890)</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 group">
                        <div class="w-8 h-8 bg-gradient-to-br from-teal-400 to-cyan-500 rounded-lg flex items-center justify-center text-white text-sm font-bold flex-shrink-0">5</div>
                        <div class="flex-1">
                            <p class="text-slate-700 leading-relaxed">Upload file menggunakan form yang tersedia</p>
                        </div>
                    </div>
                </div>

                <!-- Download Template Button -->
                <div class="mt-8 p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border border-green-200">
                    <a href="{{ route('admin.students.import.template') }}"
                       class="group flex items-center justify-center gap-3 w-full bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <span>Download Template Excel</span>
                    </a>
                </div>
            </div>

            <!-- Upload Form Card -->
            <div class="bg-white/70 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800">Upload File</h3>
                </div>

                <form action="{{ route('admin.students.import.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- File Upload Area -->
                    <div class="relative">
                        <label for="file" class="block text-sm font-semibold text-slate-700 mb-3">
                            Pilih File Excel
                        </label>

                        <div class="relative border-2 border-dashed border-slate-300 hover:border-indigo-400 rounded-xl p-8 text-center transition-all duration-300 group cursor-pointer bg-gradient-to-br from-slate-50 to-blue-50">
                            <input
                                type="file"
                                id="file"
                                name="file"
                                required
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                accept=".xlsx, .xls, .csv"
                                onchange="updateFileName(this)"
                            >

                            <div class="space-y-4">
                                <div class="w-16 h-16 mx-auto bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>

                                <div>
                                    <p class="text-lg font-semibold text-slate-800" id="file-text">
                                        Klik untuk memilih file
                                    </p>
                                    <p class="text-sm text-slate-500 mt-1">
                                        atau drag & drop file di sini
                                    </p>
                                </div>

                                <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/60 rounded-lg">
                                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                    </svg>
                                    <span class="text-xs font-medium text-slate-600">XLSX, XLS, CSV</span>
                                </div>
                            </div>
                        </div>

                        <p class="mt-3 text-xs text-slate-500 text-center">
                            Maksimal ukuran file 10MB • Format yang didukung: .xlsx, .xls, .csv
                        </p>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button type="submit"
                                class="group relative w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-8 py-4 rounded-xl font-semibold text-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <span class="flex items-center justify-center gap-3">
                                <svg class="w-6 h-6 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                </svg>
                                Import Data Siswa
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function updateFileName(input) {
    const fileText = document.getElementById('file-text');
    if (input.files && input.files[0]) {
        fileText.textContent = input.files[0].name;
        fileText.classList.add('text-indigo-600');
    } else {
        fileText.textContent = 'Klik untuk memilih file';
        fileText.classList.remove('text-indigo-600');
    }
}
</script>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fadeIn {
    animation: fadeIn 0.5s ease-out;
}
</style>

@endsection
