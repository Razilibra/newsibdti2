<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Pegawai;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\User;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = session('role');
        $title = "pengembalian";
        return view('admin.a_pengembalian.index', compact('role', 'title') + [
            'pengembalian' => Pengembalian::with('users', 'peminjaman', 'pegawais')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role = session('role');
        $title = "pengembalian";
        return view('admin.a_pengembalian.create', compact('role', 'title') + [
            'user' => User::get(),
            'pegawai' => Pegawai::get(),
            'peminjaman' => Peminjaman::get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $role = session('role');
        $title = "pengembalian";
        $data = $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'pegawais_id' => 'required|exists:pegawai,id',
            'tanggal_kembali' => 'required|date',
        ]);

        $data['users_id'] = $data['peminjaman_id'];
        unset($data['peminjaman_id']); // Change peminjaman_id to users_id

        $pengembalian = Pengembalian::create($data);
        if ($pengembalian) {
            $peminjaman = Peminjaman::find($request->peminjaman_id);
            if ($peminjaman) {
                $barang = Barang::find($peminjaman->id_barang);
                if ($barang) {
                    $barang->stok += $peminjaman->jumlah; // Increase stock according to borrowed quantity
                    $barang->save();
                }
            }
            return redirect()->route('pengembalian.index')->with('success', 'Successfully Added Data')->with(compact('role', 'title'));
        } else {
            return redirect()->route('pengembalian.index')->with('failed', 'Failed to Add Data')->with(compact('role', 'title'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = session('role');
        $title = "pengembalian";
        $pengembalian = Pengembalian::with('users', 'peminjaman', 'pegawais')->find($id);
        return view('admin.a_pengembalian.show', compact('pengembalian', 'role', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = session('role');
        $title = "pengembalian";
        $pengembalian = Pengembalian::find($id);
        return view('admin.a_pengembalian.edit', compact('role', 'title') + [
            'pengembalian' => $pengembalian,
            'user' => User::get(),
            'pegawai' => Pegawai::get(),
            'peminjaman' => Peminjaman::get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = session('role');
        $title = "pengembalian";
        $data = $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'pegawais_id' => 'required|exists:pegawai,id',
            'tanggal_kembali' => 'required|date',
        ]);

        $pengembalian = Pengembalian::findOrFail($id);
        $data['users_id'] = $data['peminjaman_id'];
        unset($data['peminjaman_id']); // Change peminjaman_id to users_id

        if ($pengembalian->update($data)) {
            $peminjaman = Peminjaman::find($request->peminjaman_id);
            if ($peminjaman) {
                $barang = Barang::find($peminjaman->id_barang);
                if ($barang) {
                    $barang->stok += $peminjaman->jumlah; // Increase stock according to borrowed quantity
                    $barang->save();
                }
            }
            return redirect()->route('pengembalian.index')->with('success', 'Successfully Updated Data')->with(compact('role', 'title'));
        } else {
            return redirect()->route('pengembalian.index')->with('failed', 'Failed to Update Data')->with(compact('role', 'title'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = session('role');
        $title = "pengembalian";
        $pengembalian = Pengembalian::find($id);
        if ($pengembalian && $pengembalian->delete()) {
            return redirect()->route('pengembalian.index')->with('success', 'Successfully Deleted Data')->with(compact('role', 'title'));
        } else {
            return redirect()->route('pengembalian.index')->with('failed', 'Failed to Delete Data')->with(compact('role', 'title'));
        }
    }
}
