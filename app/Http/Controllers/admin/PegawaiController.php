<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\PegawaiRequest;
use App\Http\Requests\UpdatePegawaiRequest;
use Illuminate\Support\Facades\Storage;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = session('role');
        $title = "data pegawai"; // Setting the title variable

        return view('admin.a_pegawai.index', compact('role', 'title') + [
            'pegawai' => Pegawai::with('users')->latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role = session('role');
        return view('admin.a_pegawai.create', compact('role') + [
            'users' => User::get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PegawaiRequest $request)
    {
        $data = $request->validated();
        $role = session('role');
        $file = $request->file('foto');
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/image', $fileName);

        $data['foto'] = $fileName;

        $pegawai = Pegawai::create($data);
        if ($pegawai) {
            return redirect()->route('pegawai.index')->with('success', 'Berhasil Menambah Data');
        } else {
            return redirect()->route('pegawai.index')->with('failed', 'Gagal Menambah Data');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = session('role');
        $pegawai = Pegawai::findOrFail($id);
        return view('admin.a_pegawai.detail', compact('pegawai', 'role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = session('role');
        return view('admin.a_pegawai.edit', compact('role') + [
            'pegawai' => Pegawai::find($id),
            'users' => User::get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePegawaiRequest $request, string $id)
    {
        $data = $request->validated();

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/image', $fileName);

            if ($request->oldImg) {
                Storage::delete('public/image/' . $request->oldImg);
            }
            $data['foto'] = $fileName;
        } else {
            $data['foto'] = $request->oldImg;
        }

        $pegawai = Pegawai::find($id)->update($data);
        if ($pegawai) {
            return redirect()->route('pegawai.index')->with('success', 'Berhasil Mengubah Data');
        } else {
            return redirect()->route('pegawai.index')->with('failed', 'Gagal Mengubah Data');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pegawai = Pegawai::find($id);
        Storage::delete('public/image/' . $pegawai->foto);
        $pegawai->delete();

        if ($pegawai) {
            return redirect()->route('pegawai.index')->with('success', 'Berhasil Menghapus Data');
        } else {
            return redirect()->route('pegawai.index')->with('failed', 'Gagal Menghapus Data');
        }
    }
}
