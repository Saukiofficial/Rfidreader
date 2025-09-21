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

    <form action="{{ isset($student) ? route('admin.students.update', $student->id) : route('admin.students.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($student))
            @method('PUT')
        @endif

        <div class="space-y-4">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name', $student->name ?? '') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $student->email ?? '') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <div>
                <label for="nis" class="block text-sm font-medium text-gray-700">NIS (Nomor Induk Siswa)</label>
                <input type="text" id="nis" name="nis" value="{{ old('nis', $student->nis ?? '') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            {{-- Input Kelas dan Jurusan baru dengan Dropdown --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="grade" class="block text-sm font-medium text-gray-700">Kelas</label>
                    <select id="grade" name="grade" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Pilih Tingkat</option>
                        @foreach ($grades as $grade)
                            <option value="{{ $grade }}" {{ old('grade', $student->grade ?? '') == $grade ? 'selected' : '' }}>
                                {{ $grade }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="major" class="block text-sm font-medium text-gray-700">Jurusan</label>
                    <select id="major" name="major" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">Pilih Jurusan</option>
                        @foreach ($majors as $major)
                             <option value="{{ $major }}" {{ old('major', $student->major ?? '') == $major ? 'selected' : '' }}>
                                {{ $major }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                 <label for="photo" class="block text-sm font-medium text-gray-700">Foto Siswa</label>
                 @if(isset($student) && $student->photo)
                    <div class="mt-2 mb-2">
                        <img src="{{ Storage::url($student->photo) }}" alt="Foto {{ $student->name }}" class="h-24 w-24 rounded-full object-cover">
                        <p class="mt-1 text-xs text-gray-500">Foto saat ini.</p>
                    </div>
                 @endif
                <input type="file" id="photo" name="photo" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG. Maks 2MB. Kosongkan jika tidak ingin mengubah foto.</p>
            </div>

             <div>
                <label for="card_uid" class="block text-sm font-medium text-gray-700">UID Kartu RFID (Opsional)</label>
                <input type="text" id="card_uid" name="card_uid" value="{{ old('card_uid', $student->card_uid ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                 <p class="mt-1 text-xs text-gray-500">UID dari kartu RFID siswa. Bisa diisi nanti.</p>
            </div>

            <div>
                <label for="fingerprint_id" class="block text-sm font-medium text-gray-700">ID Sidik Jari (Opsional)</label>
                <input type="text" id="fingerprint_id" name="fingerprint_id" value="{{ old('fingerprint_id', $student->fingerprint_id ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                 <p class="mt-1 text-xs text-gray-500">ID unik dari mesin sidik jari. Bisa diisi nanti.</p>
            </div>

            <div>
                <label for="guardian_id" class="block text-sm font-medium text-gray-700">Wali Murid</label>
                <select id="guardian_id" name="guardian_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">Pilih Wali Murid</option>
                    @forelse ($guardians as $guardian)
                        <option value="{{ $guardian->id }}" {{ old('guardian_id', $student->guardian_id ?? '') == $guardian->id ? 'selected' : '' }}>
                            {{ $guardian->name }} ({{ $guardian->guardian_phone }})
                        </option>
                    @empty
                        <option value="" disabled>Belum ada data wali murid. Silakan tambah data wali terlebih dahulu.</option>
                    @endforelse
                </select>
                <p class="mt-1 text-xs text-gray-500">Pastikan data wali murid sudah ditambahkan terlebih dahulu.</p>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" {{ isset($student) ? '' : 'required' }} class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                 @if(isset($student))
                    <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengubah password.</p>
                @endif
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" {{ isset($student) ? '' : 'required' }} class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>
        </div>

        <div class="mt-6">
            <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ isset($student) ? 'Perbarui Siswa' : 'Simpan Siswa' }}
            </button>
        </div>
    </form>
</div>
@endsection

