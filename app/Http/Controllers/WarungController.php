<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warung;

class WarungController extends Controller
{
    // Menampilkan semua warung milik user atau semua jika admin
    public function index()
    {
        if (auth()->user()->hasRole('Admin')) {
            $warung = Warung::paginate(10); 
        } else {
            $warung = Warung::where('user_id', auth()->id())->paginate(10);
        }

        return view('admin.warung.warung', compact('warung'));
    }

    // Tampilkan form tambah warung
    public function tambah()
    {
        return view('admin.warung.tambah');
    }

    // Ambil data warung via AJAX
    public function ajax($id)
    {
        $data = Warung::findOrFail($id);
        return response()->json($data);
    }

    // Simpan warung baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_warung' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
        ]);

        $warung = Warung::create([
            'user_id' => auth()->id(),
            'nama_warung' => $request->nama_warung,
            'alamat' => $request->alamat,
        ]);

        activity()
            ->causedBy(auth()->user())
            ->withProperties(['warung_id' => $warung->id])
            ->log('Menambahkan warung baru');

        return redirect()->route("admin.warung")->with('success', 'Warung berhasil dibuat');
    }

    // Tampilkan form edit
    public function edit($id)
    {
        $warung = Warung::findOrFail($id);

        if (!auth()->user()->hasRole('Admin') && $warung->user_id !== auth()->id()) {
            abort(403, 'Anda tidak berhak mengakses warung ini.');
        }

        return view('admin.warung.edit', compact('warung'));
    }

    // Update warung
    public function update($id, Request $request)
    {
        $request->validate([
            'nama_warung' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
        ]);

        $warung = Warung::findOrFail($id);

        if (!auth()->user()->hasRole('Admin') && $warung->user_id !== auth()->id()) {
            abort(403, 'Anda tidak berhak mengedit warung ini.');
        }

        $warung->update([
            'nama_warung' => $request->nama_warung,
            'alamat' => $request->alamat,
        ]);

        activity()
            ->causedBy(auth()->user())
            ->withProperties(['warung_id' => $warung->id])
            ->log('Mengubah data warung');

        return redirect()->route('admin.warung')->with('success', 'Warung berhasil diperbarui');
    }

    // Hapus warung
    public function delete($id)
    {
        $warung = Warung::findOrFail($id);

        if (!auth()->user()->hasRole('Admin') && $warung->user_id !== auth()->id()) {
            abort(403, 'Anda tidak berhak menghapus warung ini.');
        }

        $warung->delete();

        activity()
            ->causedBy(auth()->user())
            ->withProperties(['warung_id' => $warung->id])
            ->log('Menghapus warung');

        return redirect()->route('admin.warung')->with('success', 'Warung berhasil dihapus');
    }

    // Pilihan warung setelah login (jika user punya lebih dari satu)
    public function select()
    {
        $warungs = auth()->user()->warungs;

        if ($warungs->count() === 1) {
            session(['warung_id' => $warungs->first()->id]);
            return redirect()->route('admin.dashboard');
        }

        return view('auth.select-warung', compact('warungs'));
    }

    // Simpan pilihan warung ke session
    public function set(Request $request)
    {
        $request->validate([
            'id_warung' => 'required|exists:warung,id'
        ]);

        $warung = auth()->user()->warungs->where('id', $request->id_warung)->first();

        if (!$warung) {
            abort(403, 'Anda tidak memiliki akses ke warung ini.');
        }

        session(['warung_id' => $warung->id]);
        return redirect()->route('admin.dashboard');
    }
}
