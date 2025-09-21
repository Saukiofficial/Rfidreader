<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Helper untuk menyediakan data kelas dan jurusan.
     */
    private function getClassData(): array
    {
        return [
            'grades' => ['X', 'XI', 'XII'],
            'majors' => [
                'AKUNTANSI',
                'ANIMASI',
                'DESAIN KOMUNIKASI VISUAL',
                'MANAJEMEN PERKANTORAN',
                'PRODUKSI SIARAN PROGRAM TELEVISI',
            ]
        ];
    }

    /**
     * Menampilkan daftar semua siswa.
     */
    public function index()
    {
        $students = User::student()->latest()->paginate(10);
        return view('admin.students.index', compact('students'));
    }

    /**
     * Menampilkan form untuk membuat siswa baru.
     */
    public function create()
    {
        $pageTitle = 'Tambah Siswa';
        $guardians = User::query()->guardian()->orderBy('name')->get();
        // Mengirim data kelas dan jurusan ke view
        return view('admin.students.form', array_merge(
            compact('pageTitle', 'guardians'),
            $this->getClassData()
        ));
    }

    /**
     * Menyimpan siswa baru ke database.
     */
    public function store(Request $request)
    {
        $classData = $this->getClassData();
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nis' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'grade' => ['required', Rule::in($classData['grades'])],
            'major' => ['required', Rule::in($classData['majors'])],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'card_uid' => ['nullable', 'string', 'max:255', 'unique:'.User::class],
            'fingerprint_id' => ['nullable', 'string', 'max:255', 'unique:'.User::class],
            'guardian_id' => ['required', 'exists:users,id'],
        ]);

        $data = $request->except('password', 'photo', 'grade', 'major');
        $data['password'] = Hash::make($request->password);
        $data['role'] = 'siswa';
        // Menggabungkan grade dan major menjadi satu string untuk disimpan
        $data['class'] = $request->grade . ' ' . $request->major;

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        User::create($data);

        return redirect()->route('admin.students.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit data siswa.
     */
    public function edit(User $student)
    {
        $pageTitle = 'Edit Siswa: ' . $student->name;
        $guardians = User::query()->guardian()->orderBy('name')->get();
        return view('admin.students.form', array_merge(
            compact('pageTitle', 'student', 'guardians'),
            $this->getClassData()
        ));
    }

    /**
     * Memperbarui data siswa di database.
     */
    public function update(Request $request, User $student)
    {
        $classData = $this->getClassData();
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class.',email,'.$student->id],
            'nis' => ['required', 'string', 'max:255', 'unique:'.User::class.',nis,'.$student->id],
            'grade' => ['required', Rule::in($classData['grades'])],
            'major' => ['required', Rule::in($classData['majors'])],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'card_uid' => ['nullable', 'string', 'max:255', 'unique:'.User::class.',card_uid,'.$student->id],
            'fingerprint_id' => ['nullable', 'string', 'max:255', 'unique:'.User::class.',fingerprint_id,'.$student->id],
            'guardian_id' => ['required', 'exists:users,id'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $data = $request->except('password', 'photo', 'grade', 'major');
        $data['class'] = $request->grade . ' ' . $request->major;

        if ($request->hasFile('photo')) {
            if ($student->photo) {
                Storage::disk('public')->delete($student->photo);
            }
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $student->update($data);

        return redirect()->route('admin.students.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Menghapus data siswa dari database.
     */
    public function destroy(User $student)
    {
        if ($student->photo) {
            Storage::disk('public')->delete($student->photo);
        }
        $student->delete();
        return redirect()->route('admin.students.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}

