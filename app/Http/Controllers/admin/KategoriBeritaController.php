<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriBerita;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriBeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = session('role');
        $title = "Daftar kategori berita";
        return view('admin.a_kategori_berita.index', compact('role', 'title') + [
            'kategori' => KategoriBerita::orderBy('id', 'asc')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role = session('role');
        $title = "Daftar kategori berita";
        return view('admin.a_kategori_berita.create', compact('role', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|min:5'
        ]);

        $data['slug'] = Str::slug($data['nama']);
        $title = "Daftar kategori berita";

        $kategori = KategoriBerita::create($data);
        if ($kategori) {
            return redirect()->route('kategoriberita.index')->with('success', 'Berhasil Menambah Data');
        } else {
            return redirect()->route('kategoriberita.index')->with('failed', 'Gagal Menambah Data');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Implementasi belum ditambahkan
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = session('role');
        $title = "Daftar kategori berita";
        $kategori = KategoriBerita::findOrFail($id);
        return view('admin.a_kategori_berita.update', compact('kategori', 'role', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kategori = KategoriBerita::findOrFail($id);
        $role = session('role');
        $title = "Daftar kategori berita";
        $data = $request->validate([
            'nama' => 'required|min:5'
        ]);

        $data['slug'] = Str::slug($data['nama']);

        $kategori->update($data);
        if ($kategori) {
            return redirect()->route('kategoriberita.index')->with('success', 'Berhasil Menyimpan Data');
        } else {
            return redirect()->route('kategoriberita.index')->with('failed', 'Gagal Menyimpan Data');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kategori = KategoriBerita::find($id)->delete();
        if ($kategori) {
            return redirect()->route('kategoriberita.index')->with('success', 'Berhasil Menghapus Data');
        } else {
            return redirect()->route('kategoriberita.index')->with('failed', 'Gagal Menghapus Data');
        }
    }
}
