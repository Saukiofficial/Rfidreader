<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Leave;
use Illuminate\Support\Facades\Storage;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $leaves = $user->leaves()->orderBy('created_at', 'desc')->paginate(10);
        return view('panel.leaves.index', compact('leaves'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('panel.leaves.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
            'proof_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $user = Auth::user();

        $path = null;
        if ($request->hasFile('proof_file')) {
            $path = $request->file('proof_file')->store('leave_proofs', 'public');
        }

        Leave::create([
            'user_id' => $user->id,
            'reason' => $request->reason,
            'proof_file' => $path,
            'status' => 'pending',
        ]);

        return redirect()->route('panel.leaves.index')->with('success', 'Pengajuan izin berhasil dikirim.');
    }
}

