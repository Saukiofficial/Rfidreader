@extends('layouts.admin')

@section('header', $pageTitle)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-8 px-4">
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-indigo-600 to-blue-600 rounded-2xl mb-4 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Simulasi Absensi</h1>
            <p class="text-gray-600 max-w-2xl mx-auto leading-relaxed">
                Platform simulasi untuk menguji sistem absensi dengan teknologi RFID.
                Simulasikan proses tap kartu dan pantau respons sistem secara real-time.
            </p>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-indigo-600 to-blue-600 px-8 py-6">
                <h2 class="text-2xl font-semibold text-white flex items-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-2 5.5V15"/>
                    </svg>
                    Formulir Simulasi
                </h2>
                <p class="text-indigo-100 mt-2 text-sm">
                    Eksekusi simulasi absensi dengan notifikasi WhatsApp otomatis
                </p>
            </div>

            <!-- Alert Messages -->
            @if (session('success'))
                <div class="mx-8 mt-6">
                    <div class="bg-emerald-50 border-l-4 border-emerald-400 rounded-r-lg p-4 shadow-sm">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-emerald-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-emerald-800 font-medium">{{ session('success') }}</span>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mx-8 mt-6">
                    <div class="bg-red-50 border-l-4 border-red-400 rounded-r-lg p-4 shadow-sm">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-red-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-red-800 font-medium">{{ session('error') }}</span>
                        </div>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="mx-8 mt-6">
                    <div class="bg-red-50 border-l-4 border-red-400 rounded-r-lg p-4 shadow-sm">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-red-400 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <h4 class="text-red-800 font-medium mb-2">Terdapat kesalahan:</h4>
                                <ul class="text-red-700 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li class="flex items-start">
                                            <span class="w-1.5 h-1.5 bg-red-400 rounded-full mt-2 mr-2 flex-shrink-0"></span>
                                            {{ $error }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Form Content -->
            <div class="p-8">
                <!-- Info Card -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6 mb-8 border border-blue-100">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Cara Kerja Simulasi</h3>
                            <p class="text-gray-600 leading-relaxed">
                                Pilih siswa berdasarkan UID kartu RFID untuk memulai simulasi. Sistem akan memproses data absensi
                                dan mengirim notifikasi WhatsApp kepada orang tua/wali siswa secara otomatis.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <form action="{{ route('admin.simulation.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Student Selection -->
                    <div class="space-y-3">
                        <label for="card_uid" class="block text-sm font-semibold text-gray-900 mb-2">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Pilih Siswa
                            </span>
                        </label>
                        <div class="relative">
                            <input
                                list="student-uids"
                                id="card_uid"
                                name="card_uid"
                                class="w-full pl-12 pr-4 py-4 text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 hover:border-gray-300 text-lg"
                                placeholder="Ketik nama siswa atau UID kartu..."
                                required
                                autocomplete="off"
                            >
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <datalist id="student-uids">
                                @foreach($students as $student)
                                    <option value="{{ $student->card_uid }}">{{ $student->name }} - {{ $student->class }}</option>
                                @endforeach
                            </datalist>
                        </div>
                        <p class="text-sm text-gray-500 flex items-center">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Gunakan UID kartu atau nama siswa untuk pencarian cepat
                        </p>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-6">
                        <button
                            type="submit"
                            class="group w-full bg-gradient-to-r from-indigo-600 to-blue-600 text-white font-semibold py-4 px-8 rounded-xl hover:from-indigo-700 hover:to-blue-700 focus:outline-none focus:ring-4 focus:ring-indigo-200 transform transition-all duration-200 hover:scale-[1.02] active:scale-[0.98] shadow-lg hover:shadow-xl"
                        >
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-3 group-hover:rotate-12 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                                Kirim Simulasi Absensi
                            </span>
                        </button>
                    </div>
                </form>

                <!-- Features Info -->
                <div class="mt-10 pt-8 border-t border-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <h4 class="font-semibold text-gray-900 mb-1">Real-time Processing</h4>
                            <p class="text-sm text-gray-600">Data absensi diproses secara langsung</p>
                        </div>
                        <div class="text-center">
                            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                            </div>
                            <h4 class="font-semibold text-gray-900 mb-1">WhatsApp Notification</h4>
                            <p class="text-sm text-gray-600">Notifikasi otomatis ke orang tua</p>
                        </div>
                        <div class="text-center">
                            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <h4 class="font-semibold text-gray-900 mb-1">Secure & Reliable</h4>
                            <p class="text-sm text-gray-600">Sistem aman dan terpercaya</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Info -->
        <div class="text-center mt-8">
            <p class="text-sm text-gray-500">
                Sistem Manajemen Absensi â€¢ Simulasi RFID Technology
            </p>
        </div>
    </div>
</div>

<style>
    /* Custom styles for enhanced UX */
    #card_uid {
        background-image: url("data:image/svg+xml,%3csvg width='100' height='100' xmlns='http://www.w3.org/2000/svg'%3e%3cdefs%3e%3cpattern id='a' patternUnits='userSpaceOnUse' width='20' height='20' patternTransform='scale(0.5) rotate(0)'%3e%3crect x='0' y='0' width='100%25' height='100%25' fill='hsla(0, 0%25, 100%25, 0)'/%3e%3cpath d='m0 20 20-10L0 0' stroke='hsla(210, 100%25, 98%25, 0.1)' stroke-width='1' fill='none'/%3e%3c/pattern%3e%3c/defs%3e%3crect width='100%25' height='100%25' fill='url(%23a)'/%3e%3c/svg%3e");
    }

    #card_uid:focus {
        background-image: none;
    }

    /* Smooth transitions for all interactive elements */
    * {
        transition: all 0.2s ease-in-out;
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 6px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }

    ::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
</style>

<script>
    // Enhanced form interaction
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('card_uid');
        const form = input.closest('form');

        // Add loading state on form submission
        form.addEventListener('submit', function() {
            const button = form.querySelector('button[type="submit"]');
            button.innerHTML = `
                <span class="flex items-center justify-center">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Memproses Simulasi...
                </span>
            `;
            button.disabled = true;
        });

        // Enhanced input interaction
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'translateY(-2px)';
        });

        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'translateY(0)';
        });
    });
</script>
@endsection
