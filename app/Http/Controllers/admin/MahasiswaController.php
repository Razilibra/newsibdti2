<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\MahasiswaRequest;
use App\Http\Requests\UpdateMahasiswaRequest;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = session('role');
        $title = "Mahasiswa";
        return view('admin.a_mahasiswa.index', compact('role', 'title') + [
            'mahasiswa' => Mahasiswa::with('prodis', 'users')->latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role = session('role');
        $title = "Mahasiswa";
        return view('admin.a_mahasiswa.create', compact('role', 'title') + [
            'prodis' => Prodi::get(),
            'users' => User::get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MahasiswaRequest $request)
    {
        $data = $request->validated();
        $role = session('role');
        $mahasiswa = Mahasiswa::create($data);
        if ($mahasiswa) {
            return redirect()->route('mahasiswa.index')->with('success', 'Berhasil Menambah Data');
        } else {
            return redirect()->route('mahasiswa.index')->with('failed', 'Gagal Menambah Data');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = session('role');
        $title = "Mahasiswa";
        $mahasiswa = Mahasiswa::findOrFail($id);
        return view('admin.a_mahasiswa.detail', compact('mahasiswa', 'role', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = session('role');
        $title = "Mahasiswa";
        return view('admin.a_mahasiswa.edit', compact('role', 'title') + [
            'mahasiswa' => Mahasiswa::find($id),
            'prodis' => Prodi::get(),
            'users' => User::get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMahasiswaRequest $request, string $id)
    {
        $data = $request->validated();
        $role = session('role');
        $mahasiswa = Mahasiswa::find($id)->update($data);
        if ($mahasiswa) {
            return redirect()->route('mahasiswa.index')->with('success', 'Berhasil Mengubah Data');
        } else {
            return redirect()->route('mahasiswa.index')->with('failed', 'Gagal Mengubah Data');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mahasiswa = Mahasiswa::find($id);
        $role = session('role');
        $mahasiswa->delete();

        if ($mahasiswa) {
            return redirect()->route('mahasiswa.index')->with('success', 'Berhasil Menghapus Data');
        } else {
            return redirect()->route('mahasiswa.index')->with('failed', 'Gagal Menghapus Data');
        }
    }
}
