<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warung;
use Illuminate\Support\Facades\Auth;

class SelectWarungController extends Controller
{
    /**
     * Tampilkan halaman pemilihan warung
     */
    public function index()
{
    $warungs = auth()->user()->warungs;

    // Jika hanya punya 1, redirect langsung
    if ($warungs->count() === 1) {
        session([
            'warung_id' => $warungs->first()->id,
            'nama_warung' => $warungs->first()->nama_warung,
        ]);
        return redirect()->route('admin.dashboard');
    }

    return view('auth.select-warung', compact('warungs'));
}



    /**
     * Proses pemilihan warung dan simpan ke session
     */
    public function pilih(Request $request)
    {
        $request->validate([
            'warung_id' => 'required|exists:warung,id',
        ]);

        $warung = Warung::where('id', $request->warung_id)
            ->where('user_id', Auth::id()) // ✅ Pastikan warung milik user ini
            ->first();

        if (!$warung) {
            return redirect()->back()->with('error', 'Warung tidak ditemukan atau bukan milik Anda.');
        }

        session([
            'warung_id' => $warung->id,
            'nama_warung' => $warung->nama_warung,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Berhasil memilih warung.');
    }
}
