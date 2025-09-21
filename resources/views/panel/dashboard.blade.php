@extends('layouts.app')

@section('header')
    Dashboard
@endsection

@section('content')

{{-- Tampilan untuk Siswa --}}
@if(Auth::user()->role === 'siswa')
    <div class="space-y-6">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">Selamat Datang, {{ $user->name }}!</h2>
            <p class="text-gray-600">Berikut adalah ringkasan absensi Anda.</p>
        </div>

        <!-- Status Absensi Hari Ini -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold border-b pb-2 mb-4">Absensi Hari Ini ({{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }})</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-green-100 text-green-800 p-4 rounded-lg">
                    <p class="font-bold">Jam Masuk</p>
                    <p class="text-2xl">{{ $checkIn ? \Carbon\Carbon::parse($checkIn->recorded_at)->format('H:i:s') : 'Belum Absen' }}</p>
                </div>
                <div class="bg-red-100 text-red-800 p-4 rounded-lg">
                    <p class="font-bold">Jam Pulang</p>
                    <p class="text-2xl">{{ $checkOut ? \Carbon\Carbon::parse($checkOut->recorded_at)->format('H:i:s') : 'Belum Absen' }}</p>
                </div>
            </div>
        </div>

        <!-- Riwayat Absensi Bulan Ini -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold border-b pb-2 mb-4">Riwayat Absensi Bulan Ini</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Masuk</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Pulang</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($monthlyAttendances as $date => $attendances)
                            @php
                                $in = $attendances->firstWhere('status', 'in');
                                $out = $attendances->last(function($item) { return $item->status == 'out'; });
                            @endphp
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $in ? \Carbon\Carbon::parse($in->recorded_at)->format('H:i:s') : '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $out ? \Carbon\Carbon::parse($out->recorded_at)->format('H:i:s') : '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($in)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Hadir
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Tidak Hadir
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada data absensi bulan ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif

{{-- Tampilan untuk Wali Murid --}}
@if(Auth::user()->role === 'wali')
    <div class="space-y-6">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">Selamat Datang, {{ $user->name }}!</h2>
            <p class="text-gray-600">Berikut adalah ringkasan absensi putra/putri Anda.</p>
        </div>

        @forelse($students as $student)
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold border-b pb-2 mb-4">Riwayat Absensi: {{ $student->name }} ({{ $student->class }})</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Masuk</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Pulang</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                $studentAttendances = $monthlyAttendances->get($student->id) ? $monthlyAttendances->get($student->id)->groupBy(function($date) {
                                    return \Carbon\Carbon::parse($date->recorded_at)->format('Y-m-d');
                                }) : collect();
                            @endphp

                            @forelse($studentAttendances as $date => $attendances)
                                @php
                                    $in = $attendances->firstWhere('status', 'in');
                                    $out = $attendances->last(function($item) { return $item->status == 'out'; });
                                @endphp
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $in ? \Carbon\Carbon::parse($in->recorded_at)->format('H:i:s') : '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $out ? \Carbon\Carbon::parse($out->recorded_at)->format('H:i:s') : '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($in)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Hadir
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Tidak Hadir
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada data absensi bulan ini untuk {{ $student->name }}.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @empty
            <div class="bg-white p-6 rounded-lg shadow-md text-center text-gray-500">
                Data siswa tidak ditemukan.
            </div>
        @endforelse
    </div>
@endif

@endsection

