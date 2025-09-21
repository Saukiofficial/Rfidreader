<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Actions\ProcessAttendanceAction;

class SimulationController extends Controller
{
    /**
     * Show the simulation form.
     */
    public function index()
    {
        $students = User::student()->get();

        // PERBAIKAN: Mengembalikan variabel pageTitle yang dibutuhkan oleh view
        $pageTitle = 'Simulasi Absensi';

        return view('admin.simulation.index', compact('students', 'pageTitle'));
    }

    /**
     * Store a new attendance record from the simulation.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Actions\ProcessAttendanceAction $processAttendance
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, ProcessAttendanceAction $processAttendance)
    {
        $request->validate([
            'card_uid' => 'required|string|exists:users,card_uid',
        ]);

        // Panggil Aksi secara langsung, tanpa HTTP request
        $result = $processAttendance->execute(
            $request->card_uid,
            'web_simulator',
            'rfid_simulation'
        );

        if ($result['success']) {
            return back()->with('success', $result['message']);
        }

        return back()->with('error', $result['message']);
    }
}
