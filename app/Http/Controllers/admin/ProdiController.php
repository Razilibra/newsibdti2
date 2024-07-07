<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Prodi;
use Illuminate\Http\Request;

class ProdiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = session('role');
        $title = "data prodi";
        return view('admin.a_prodi.index', compact('role','title') + [
            'prodi' => Prodi::orderBy('id','asc')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role = session('role');
        $title = "data prodi";
        return view('admin.a_prodi.create', compact('role','title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $role = session('role');
        $data = $request->validate([
            'prodi' => 'required|min:8',
            'kaprodi' => 'required|min:8'
        ]);

        $prodi = Prodi::create($data);
        if ($prodi) {
            return redirect()->route('prodi.index')->with('success', 'Berhasil Menambah Data')->with(compact('role'));
        } else {
            return redirect()->route('prodi.index')->with('failed', 'Gagal Menambah Data')->with(compact('role'));
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
        $title = "data prodi";
        $prodi = Prodi::findOrFail($id);
        return view('admin.a_prodi.edit', compact('prodi', 'role','title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = session('role');
        $prodi = Prodi::findOrFail($id);

        $data = $request->validate([
            'prodi' => 'required|min:8',
            'kaprodi' => 'required|min:8'
        ]);

        $prodi->update($data);
        if ($prodi) {
            return redirect()->route('prodi.index')->with('success', 'Berhasil Menyimpan Data')->with(compact('role'));
        } else {
            return redirect()->route('prodi.index')->with('failed', 'Gagal Menyimpan Data')->with(compact('role'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $prodi = Prodi::find($id)->delete();
        if ($prodi) {
            return redirect()->route('prodi.index')->with('success', 'Berhasil Menghapus Data');
        } else {
            return redirect()->route('prodi.index')->with('failed', 'Gagal Menghapus Data');
        }
    }
}
