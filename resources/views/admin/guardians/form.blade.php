@extends('layouts.admin')

{{-- Variabel $pageTitle sekarang dikirim dari controller --}}
@section('header', $pageTitle)

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-1">{{ $pageTitle }}</h2>
                <p class="text-gray-600 text-sm">
                    {{ isset($guardian) ? 'Perbarui informasi wali murid yang sudah ada' : 'Tambahkan wali murid baru ke dalam sistem' }}
                </p>
            </div>
            <a href="{{ route('admin.guardians.index') }}"
               class="inline-flex items-center px-4 py-2.5 text-gray-600 hover:text-gray-900 font-medium text-sm transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar
            </a>
        </div>
    </div>

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-r-lg">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-red-800 font-medium">Terdapat kesalahan pada input</h3>
                    <div class="mt-2 text-red-700">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="text-sm">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        {{-- PERBAIKAN: Menggunakan isset($guardian) untuk menentukan rute action form --}}
        <form action="{{ isset($guardian) ? route('admin.guardians.update', $guardian) : route('admin.guardians.store') }}" method="POST">
            @csrf
            @if (isset($guardian))
                @method('PUT')
            @endif

            <div class="p-6">
                <!-- Personal Information Section -->
                <div class="mb-8">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-semibold text-gray-900">Informasi Personal</h3>
                            <p class="text-sm text-gray-600">Data dasar wali murid</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            {{-- PERBAIKAN: Menggunakan null coalescing operator (??) untuk menangani nilai default --}}
                            <input type="text"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', $guardian->name ?? '') }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-200 focus:border-gray-900 transition-colors duration-200 text-sm"
                                   placeholder="Masukkan nama lengkap wali murid">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Alamat Email <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                    </svg>
                                </div>
                                <input type="email"
                                       id="email"
                                       name="email"
                                       value="{{ old('email', $guardian->email ?? '') }}"
                                       required
                                       class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-200 focus:border-gray-900 transition-colors duration-200 text-sm"
                                       placeholder="contoh@email.com">
                            </div>
                        </div>

                        <div>
                            <label for="guardian_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Nomor WhatsApp <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                                <input type="text"
                                       id="guardian_phone"
                                       name="guardian_phone"
                                       value="{{ old('guardian_phone', $guardian->guardian_phone ?? '') }}"
                                       required
                                       class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-200 focus:border-gray-900 transition-colors duration-200 text-sm font-mono"
                                       placeholder="Contoh: 081234567890">
                            </div>
                            <p class="mt-2 text-xs text-gray-500">
                                Nomor WhatsApp untuk komunikasi dan notifikasi
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Security Information Section -->
                <div class="pt-8 border-t border-gray-200">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-semibold text-gray-900">Keamanan Akun</h3>
                            <p class="text-sm text-gray-600">
                                {{ isset($guardian) ? 'Kosongkan jika tidak ingin mengubah password' : 'Buat password untuk akses sistem' }}
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password
                                @unless(isset($guardian))
                                    <span class="text-red-500">*</span>
                                @endunless
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                                {{-- PERBAIKAN: Menghapus 'required' jika sedang dalam mode edit --}}
                                <input type="password"
                                       id="password"
                                       name="password"
                                       class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-200 focus:border-gray-900 transition-colors duration-200 text-sm"
                                       placeholder="Masukkan password"
                                       {{ isset($guardian) ? '' : 'required' }}>
                            </div>
                            @if (isset($guardian))
                                <p class="mt-2 text-xs text-gray-500">
                                    Kosongkan jika tidak ingin mengubah password
                                </p>
                            @endif
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                Konfirmasi Password
                                @unless(isset($guardian))
                                    <span class="text-red-500">*</span>
                                @endunless
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <input type="password"
                                       id="password_confirmation"
                                       name="password_confirmation"
                                       class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-200 focus:border-gray-900 transition-colors duration-200 text-sm"
                                       placeholder="Ulangi password">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
                <div class="text-sm text-gray-600">
                    <span class="text-red-500">*</span> Wajib diisi
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.guardians.index') }}"
                       class="px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors duration-200 text-sm">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-6 py-3 bg-gray-900 hover:bg-gray-800 text-white font-medium rounded-lg transition-colors duration-200 shadow-sm hover:shadow-md text-sm inline-flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @if(isset($guardian))
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            @endif
                        </svg>
                        {{ isset($guardian) ? 'Update Data' : 'Simpan Data' }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
/* Focus states */
input:focus {
    outline: none;
}

/* Custom input with icon styling */
.relative input {
    transition: all 0.2s ease;
}

.relative input:focus + .absolute svg,
.relative input:focus ~ .absolute svg {
    color: #111827;
}

/* Form validation styling */
.form-error {
    border-color: #EF4444;
}

.form-error:focus {
    border-color: #EF4444;
    ring-color: rgb(239 68 68 / 0.2);
}
</style>
@endsection
