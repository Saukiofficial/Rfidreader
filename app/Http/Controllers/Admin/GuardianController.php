<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class GuardianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // PERBAIKAN: Memulai query dengan User::query() untuk menghindari ambiguitas
        $guardians = User::query()->guardian()->withCount('students')->latest()->paginate(10);
        return view('admin.guardians.index', compact('guardians'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // PERBAIKAN: Mengirimkan variabel pageTitle ke view
        $pageTitle = 'Tambah Wali Murid';
        return view('admin.guardians.form', compact('pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'guardian_phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'guardian_phone' => $request->guardian_phone,
            'password' => Hash::make($request->password),
            'role' => 'wali',
        ]);

        return redirect()->route('admin.guardians.index')->with('success', 'Data wali murid berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $guardian)
    {
        // PERBAIKAN: Mengirimkan variabel pageTitle ke view
        $pageTitle = 'Edit Wali Murid';
        return view('admin.guardians.form', compact('guardian', 'pageTitle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $guardian)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($guardian->id)],
            'guardian_phone' => ['required', 'string', 'max:20'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $data = $request->only('name', 'email', 'guardian_phone');
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $guardian->update($data);

        return redirect()->route('admin.guardians.index')->with('success', 'Data wali murid berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $guardian)
    {
        // Logika untuk memastikan tidak ada siswa yang terkait sebelum menghapus
        if ($guardian->students()->count() > 0) {
            return back()->with('error', 'Tidak bisa menghapus wali murid yang masih memiliki siswa terkait.');
        }

        $guardian->delete();
        return redirect()->route('admin.guardians.index')->with('success', 'Data wali murid berhasil dihapus.');
    }
}

