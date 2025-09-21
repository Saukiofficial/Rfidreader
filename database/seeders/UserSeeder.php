<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data lama agar tidak duplikat jika seeder dijalankan ulang
        DB::table('users')->delete();

        DB::table('users')->insert([
            // 1. Akun Admin
            [
                'name' => 'Admin Sekolah',
                'email' => 'admin@sekolah.id',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'nis' => null,
                'class' => null,
                'card_uid' => null,
                'guardian_name' => null,
                'guardian_phone' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 2. Akun Siswa 1
            [
                'name' => 'Budi Sanjaya',
                'email' => 'siswa1@sekolah.id',
                'password' => Hash::make('password'),
                'role' => 'siswa',
                'nis' => '1001',
                'class' => 'X RPL 1',
                'card_uid' => 'A1B2C3D4',
                'guardian_name' => null,
                'guardian_phone' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 3. Akun Siswa 2
            [
                'name' => 'Citra Lestari',
                'email' => 'siswa2@sekolah.id',
                'password' => Hash::make('password'),
                'role' => 'siswa',
                'nis' => '1002',
                'class' => 'XI TKJ 2',
                'card_uid' => 'E5F6G7H8',
                'guardian_name' => null,
                'guardian_phone' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // 4. Akun Wali Murid 1
            [
                'name' => 'Ahmad Sanjaya',
                'email' => 'wali1@sekolah.id',
                'password' => Hash::make('password'),
                'role' => 'wali_murid',
                'nis' => null,
                'class' => null,
                'card_uid' => null,
                'guardian_name' => 'Ahmad Sanjaya',
                'guardian_phone' => '081234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

