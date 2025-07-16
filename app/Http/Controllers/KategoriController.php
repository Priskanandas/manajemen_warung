<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index()
    {
        $warungId = session('warung_id');
        $kategori = Kategori::where('id_warung', $warungId)->get();

        return view('admin.kategori.kategori', compact('kategori'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        Kategori::create([
            'id_warung' => session('warung_id'),
            'nama_kategori' => $request->nama_kategori
        ]);

        return redirect()->route('admin.kategori')->with('success', 'Data Berhasil Ditambahkan');
    }

    public function show(Request $request)
    {
        $warungId = session('warung_id');
        $cari = $request->cari;

        $kategori = Kategori::where('id', $cari)
            ->where('id_warung', $warungId)
            ->get();

        return view('admin.kategori.kategori', compact('kategori'));
    }

    public function edit($id)
    {
        $warungId = session('warung_id');
        $kategori = Kategori::where('id', $id)->where('id_warung', $warungId)->firstOrFail();

        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $warungId = session('warung_id');

        $request->validate([
            'nama_kategori' => 'required|string|max:255'
        ]);

        $kategori = Kategori::where('id', $id)->where('id_warung', $warungId)->firstOrFail();
        $kategori->update([
            'nama_kategori' => $request->nama_kategori
        ]);

        return redirect()->route('admin.kategori')->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy($id)
    {
        $warungId = session('warung_id');

        $kategori = Kategori::where('id', $id)->where('id_warung', $warungId)->firstOrFail();
        $kategori->delete();

        return redirect()->route('admin.kategori')->with('success', 'Kategori berhasil dihapus');
    }
}
