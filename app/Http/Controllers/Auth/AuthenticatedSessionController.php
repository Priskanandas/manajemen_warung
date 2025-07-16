<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Tampilkan form login
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Proses login
     */
    public function store(LoginRequest $request)
{
    $request->authenticate();
    $request->session()->regenerate();

    $user = Auth::user();

    // Jika admin
    if ($user->hasRole('Admin')) {
        $jumlahWarung = $user->warungs()->count();

        if ($jumlahWarung === 1) {
            $warung = $user->warungs()->first();
            session([
                'warung_id' => $warung->id,
                'nama_warung' => $warung->nama_warung,
            ]);
            return redirect()->route('admin.dashboard');
        }

        if ($jumlahWarung > 1) {
            return redirect()->route('warung.select');
        }

        // Admin tapi tidak punya warung
        return redirect('/')->with('error', 'Anda login sebagai Admin dan tidak memiliki warung.');
    }

    // Jika user biasa
    $jumlahWarung = $user->warungs()->count();

    if ($jumlahWarung === 0) {
        return redirect('/')->with('error', 'Tidak ada warung terdaftar.');
    }

    if ($jumlahWarung === 1) {
        $warung = $user->warungs()->first();
        session([
            'warung_id' => $warung->id,
            'nama_warung' => $warung->nama_warung,
        ]);
        return redirect()->intended('/admin/dashboard');
    }

    return redirect()->route('warung.select');
}

public function destroy(Request $request)
{
    Auth::guard('web')->logout();

    session()->forget('warung_id');
    session()->forget('nama_warung');

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
}

}
