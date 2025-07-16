<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckWarungSelected
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            return $next($request);
        }

        // Abaikan route khusus
        if (
            $request->routeIs('warung.select') ||
            $request->routeIs('auth.pilih-warung.post')
        ) {
            return $next($request);
        }

        // ADMIN → boleh lanjut walau tidak punya warung
        if ($user->hasRole('Admin')) {
            $adminWarungs = $user->warungs;

            // Punya 1 warung → set otomatis
            if ($adminWarungs->count() === 1 && !session('warung_id')) {
                $warung = $adminWarungs->first();
                session([
                    'warung_id' => $warung->id,
                    'nama_warung' => $warung->nama_warung,
                ]);
            }

            // Punya >1 warung → wajib pilih
            if ($adminWarungs->count() > 1 && !session('warung_id')) {
                return redirect()->route('warung.select');
            }

            // Tidak punya warung → tetap lanjut (tanpa session warung)
            return $next($request);
        }

        // USER biasa
        $warungs = $user->warungs;

        // Punya 1 warung → set otomatis
        if ($warungs->count() === 1 && !session('warung_id')) {
            $warung = $warungs->first();
            session([
                'warung_id' => $warung->id,
                'nama_warung' => $warung->nama_warung,
            ]);
        }

        // Tidak punya warung atau belum pilih → redirect
        if (!session('warung_id')) {
            return redirect()->route('warung.select');
        }

        return $next($request);
    }
}
