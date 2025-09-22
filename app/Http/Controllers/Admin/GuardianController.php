<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class GuardianController extends Controller
{
    /**
     * Menampilkan daftar semua wali murid.
     */
    public function index()
    {
        // Menggunakan withCount('students') untuk efisiensi query database
        $guardians = User::query()->guardian()->withCount('students')->latest()->paginate(10);
        return view('admin.guardians.index', compact('guardians'));
    }

    /**
     * Menampilkan form untuk membuat wali murid baru.
     */
    public function create()
    {
        $pageTitle = 'Tambah Wali Murid';
        return view('admin.guardians.form', compact('pageTitle'));
    }

    /**
     * Menyimpan wali murid baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'guardian_phone' => ['required', 'numeric', 'unique:'.User::class],
        ]);

        // Membuat email dummy secara otomatis dan memvalidasinya
        $dummyEmail = $request->guardian_phone . '@school.app';
        $request->merge(['email' => $dummyEmail]);
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $dummyEmail,
            'password' => Hash::make($request->password),
            'role' => 'wali',
            'guardian_phone' => $request->guardian_phone,
        ]);

        return redirect()->route('admin.guardians.index')->with('success', 'Data wali murid berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit data wali murid.
     */
    public function edit(User $guardian)
    {
        $pageTitle = 'Edit Wali Murid: ' . $guardian->name;
        return view('admin.guardians.form', compact('pageTitle', 'guardian'));
    }

    /**
     * Memperbarui data wali murid di database.
     */
    public function update(Request $request, User $guardian)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'guardian_phone' => ['required', 'numeric', 'unique:'.User::class.',guardian_phone,'.$guardian->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        // Membuat email dummy baru jika nomor telepon berubah
        $dummyEmail = $request->guardian_phone . '@school.app';
        $request->merge(['email' => $dummyEmail]);
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class.',email,'.$guardian->id],
        ]);

        $guardian->update([
            'name' => $request->name,
            'email' => $dummyEmail,
            'guardian_phone' => $request->guardian_phone,
        ]);

        if ($request->filled('password')) {
            $guardian->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.guardians.index')->with('success', 'Data wali murid berhasil diperbarui.');
    }

    /**
     * Menghapus data wali murid dari database.
     */
    public function destroy(User $guardian)
    {
        if ($guardian->students()->count() > 0) {
            return redirect()->route('admin.guardians.index')->with('error', 'Tidak dapat menghapus wali murid yang masih memiliki siswa terdaftar.');
        }
        $guardian->delete();
        return redirect()->route('admin.guardians.index')->with('success', 'Data wali murid berhasil dihapus.');
    }

    /**
     * Menangani permintaan pencarian wali murid (AJAX) dari form siswa.
     */
    public function search(Request $request)
    {
        $search = $request->input('q');

        if (empty($search)) {
            return response()->json([]);
        }

        // Mencari wali murid berdasarkan nama atau nomor telepon
        $guardians = User::query()
            ->guardian()
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhere('guardian_phone', 'LIKE', "%{$search}%")
            ->limit(10)
            ->get(['id', 'name', 'guardian_phone']);

        return response()->json($guardians);
    }
}

