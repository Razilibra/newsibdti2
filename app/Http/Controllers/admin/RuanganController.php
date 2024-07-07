<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = session('role');
        $title = "data ruangan";
        return view('admin.a_ruangan.index', compact('role','title') + [
            'ruangan' => Ruangan::orderBy('id','asc')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "data ruangan";
        $role = session('role');
        return view('admin.a_ruangan.create', compact('role','title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $role = session('role');
        $data = $request->validate([
            'nama_ruangan' => 'required|min:3',
            'gedung' => 'required|min:1'
        ]);
    
        $ruangan = Ruangan::create($data);
        if ($ruangan) {
            return redirect()->route('ruangan.index')->with('success', 'Berhasil Menambah Data')->with(compact('role'));
        } else {
            return redirect()->route('ruangan.index')->with('failed', 'Gagal Menambah Data')->with(compact('role'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = session('role');
        $ruangan = Ruangan::findOrFail($id);
        $title = "data ruangan";
        return view('admin.a_ruangan.edit', compact('ruangan', 'role','ruangan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = session('role');
        $ruangan = Ruangan::findOrFail($id);

        $data = $request->validate([
            'nama_ruangan' => 'required|min:3',
            'gedung' => 'required|min:1'
        ]);

        $ruangan->update($data);
        if ($ruangan) {
            return redirect()->route('ruangan.index')->with('success', 'Berhasil Menyimpan Data')->with(compact('role'));
        } else {
            return redirect()->route('ruangan.index')->with('failed', 'Gagal Menyimpan Data')->with(compact('role'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ruangan = Ruangan::find($id)->delete();
        if ($ruangan) {
            return redirect()->route('ruangan.index')->with('success', 'Berhasil Menghapus Data');
        } else {
            return redirect()->route('ruangan.index')->with('failed', 'Gagal Menghapus Data');
        }
    }
}
