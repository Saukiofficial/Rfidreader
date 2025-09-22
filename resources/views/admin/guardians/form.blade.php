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
                    <div class="w-12 h-12 bg-gradient-to-br from-violet-500 to-purple-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @if(isset($guardian))
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            @endif
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold bg-gradient-to-r from-slate-800 to-slate-600 bg-clip-text text-transparent">
                            {{ $pageTitle }}
                        </h1>
                        <p class="text-slate-600 text-base font-medium mt-1">
                            {{ isset($guardian) ? 'Perbarui informasi wali murid' : 'Tambahkan wali murid baru ke sistem' }}
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
    <!-- Error Messages -->
    @if ($errors->any())
        <div class="relative bg-gradient-to-r from-red-50 to-rose-50 border border-red-200 rounded-xl p-6 mb-8 shadow-sm">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-red-800 mb-2">Terdapat Kesalahan Input</h3>
                    <p class="text-red-700 mb-3">Mohon periksa kembali data yang Anda masukkan:</p>
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="flex items-center gap-2 text-red-700">
                                <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Form Card -->
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-slate-800 via-slate-700 to-slate-800 px-8 py-6">
            <div class="flex items-center gap-3">
                <div class="w-2 h-8 bg-gradient-to-b from-blue-400 to-violet-500 rounded-full"></div>
                <h2 class="text-xl font-bold text-white">Formulir Data Wali Murid</h2>
            </div>
        </div>

        <div class="p-8">
            <form action="{{ isset($guardian) ? route('admin.guardians.update', $guardian->id) : route('admin.guardians.store') }}" method="POST" class="space-y-8">
                @csrf
                @if(isset($guardian))
                    @method('PUT')
                @endif

                <!-- Personal Information Section -->
                <div class="space-y-6">
                    <div class="border-l-4 border-blue-500 pl-4">
                        <h3 class="text-lg font-bold text-gray-800 mb-1">Informasi Personal</h3>
                        <p class="text-gray-600 text-sm">Masukkan data pribadi wali murid</p>
                    </div>

                    <!-- Name Field -->
                    <div class="group">
                        <label for="name" class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-3">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Nama Lengkap
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', $guardian->name ?? '') }}"
                                   required
                                   placeholder="Masukkan nama lengkap wali murid"
                                   class="w-full px-4 py-4 text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all duration-200 placeholder-gray-400 text-base">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                                <svg class="w-5 h-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Phone Field -->
                    <div class="group">
                        <label for="guardian_phone" class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-3">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            Nomor WhatsApp
                            <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text"
                                   id="guardian_phone"
                                   name="guardian_phone"
                                   value="{{ old('guardian_phone', $guardian->guardian_phone ?? '') }}"
                                   required
                                   placeholder="Contoh: 6281234567890"
                                   class="w-full px-4 py-4 text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-500/10 transition-all duration-200 placeholder-gray-400 text-base">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-2 flex items-center gap-2 text-sm text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Gunakan format internasional diawali dengan 62 (tanpa tanda +)
                        </div>
                    </div>
                </div>

                <!-- Security Section -->
                <div class="space-y-6">
                    <div class="border-l-4 border-purple-500 pl-4">
                        <h3 class="text-lg font-bold text-gray-800 mb-1">Keamanan Akun</h3>
                        <p class="text-gray-600 text-sm">{{ isset($guardian) ? 'Kosongkan jika tidak ingin mengubah password' : 'Buat password yang kuat untuk keamanan akun' }}</p>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <!-- Password Field -->
                        <div class="group">
                            <label for="password" class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-3">
                                <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                Password
                                @if(!isset($guardian))
                                    <span class="text-red-500">*</span>
                                @endif
                            </label>
                            <div class="relative">
                                <input type="password"
                                       id="password"
                                       name="password"
                                       {{ isset($guardian) ? '' : 'required' }}
                                       placeholder="{{ isset($guardian) ? 'Kosongkan jika tidak diubah' : 'Masukkan password baru' }}"
                                       class="w-full px-4 py-4 text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-purple-500 focus:ring-4 focus:ring-purple-500/10 transition-all duration-200 placeholder-gray-400 text-base pr-12">
                                <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-purple-500 transition-colors">
                                    <svg id="password-eye" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Password Confirmation Field -->
                        <div class="group">
                            <label for="password_confirmation" class="flex items-center gap-2 text-sm font-bold text-gray-700 mb-3">
                                <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Konfirmasi Password
                                @if(!isset($guardian))
                                    <span class="text-red-500">*</span>
                                @endif
                            </label>
                            <div class="relative">
                                <input type="password"
                                       id="password_confirmation"
                                       name="password_confirmation"
                                       {{ isset($guardian) ? '' : 'required' }}
                                       placeholder="{{ isset($guardian) ? 'Konfirmasi password baru' : 'Ulangi password yang sama' }}"
                                       class="w-full px-4 py-4 text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-purple-500 focus:ring-4 focus:ring-purple-500/10 transition-all duration-200 placeholder-gray-400 text-base pr-12">
                                <button type="button" onclick="togglePassword('password_confirmation')" class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-purple-500 transition-colors">
                                    <svg id="password_confirmation-eye" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button Section -->
                <div class="pt-6 border-t border-gray-100">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <button type="submit"
                                class="group flex-1 flex items-center justify-center gap-3 bg-gradient-to-r from-violet-500 to-purple-600 hover:from-violet-600 hover:to-purple-700 text-white px-8 py-4 rounded-xl font-bold transition-all duration-200 shadow-lg hover:shadow-violet-500/25 hover:scale-[1.02] text-base">
                            <svg class="w-6 h-6 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if(isset($guardian))
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3-3m0 0l-3 3m3-3v12"/>
                                @endif
                            </svg>
                            <span>{{ isset($guardian) ? 'Perbarui Data Wali Murid' : 'Simpan Data Wali Murid' }}</span>
                        </button>

                        <a href="{{ route('admin.guardians.index') }}"
                           class="flex items-center justify-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 hover:text-gray-900 px-8 py-4 rounded-xl font-semibold transition-all duration-200 text-base sm:flex-initial sm:w-auto">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            <span>Batal</span>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Password Toggle Script -->
<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const eye = document.getElementById(fieldId + '-eye');

    if (field.type === 'password') {
        field.type = 'text';
        eye.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L8.464 8.464M9.878 9.878a3 3 0 00-.007 4.243m4.242 4.242L16.536 16.536M14.12 14.12a3 3 0 01-.007-4.243m0 4.243l2.122 2.122M14.12 14.12L12 12"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
        `;
    } else {
        field.type = 'password';
        eye.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
        `;
    }
}

// Add real-time password matching validation
document.addEventListener('DOMContentLoaded', function() {
    const password = document.getElementById('password');
    const passwordConfirmation = document.getElementById('password_confirmation');

    function validatePasswordMatch() {
        if (password.value && passwordConfirmation.value) {
            if (password.value === passwordConfirmation.value) {
                passwordConfirmation.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500/10');
                passwordConfirmation.classList.add('border-green-500', 'focus:border-green-500', 'focus:ring-green-500/10');
            } else {
                passwordConfirmation.classList.remove('border-green-500', 'focus:border-green-500', 'focus:ring-green-500/10');
                passwordConfirmation.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500/10');
            }
        } else {
            passwordConfirmation.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500/10', 'border-green-500', 'focus:border-green-500', 'focus:ring-green-500/10');
        }
    }

    password.addEventListener('input', validatePasswordMatch);
    passwordConfirmation.addEventListener('input', validatePasswordMatch);
});
</script>
@endsection
