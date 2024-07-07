<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;

class BarangKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Barang Keluar";
        $role = session('role');
        return view('admin.a_barang_keluar.index', compact('role', 'title') + [
            'barangkeluar' => BarangKeluar::with('users', 'peminjaman')->latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Barang Keluar";
        $role = session('role');
        return view('admin.a_barang_keluar.create', compact('role', 'title') + [
            'user' => User::get(),
            'peminjaman' => Peminjaman::get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $title = "Barang Keluar";
        $role = session('role');
        $data = $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'tanggal_keluar' => 'required|date',
        ]);

        // Cari entri peminjaman terkait
        $peminjaman = Peminjaman::find($request->peminjaman_id);
        if ($peminjaman) {
            // Kurangi stok barang
            $barang = Barang::find($peminjaman->id_barang);
            if ($barang) {
                // Pastikan stok cukup
                if ($barang->stok >= $peminjaman->jumlah) {
                    $barang->stok -= $peminjaman->jumlah; // Mengurangi stok barang sesuai jumlah peminjaman
                    $barang->save();

                    // Map 'peminjamen_id' to 'users_id' for the 'BarangKeluar' model
                    $data['users_id'] = $data['peminjaman_id'];
                    unset($data['peminjaman_id']);

                    $barangkeluar = BarangKeluar::create($data);
                    return to_route('barangkeluar.index')->with(compact('role', 'title'))->with('success', 'Berhasil Menambah Data');
                } else {
                    return to_route('barangkeluar.create')->with(compact('role', 'title'))->with('failed', 'Stok barang tidak mencukupi');
                }
            }
        }

        return to_route('barangkeluar.index')->with(compact('role', 'title'))->with('failed', 'Gagal Menambah Data');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $title = "Barang Keluar";
        $role = session('role');
        // Add any other necessary logic here
        return view('admin.a_barang_keluar.show', compact('role', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = "Barang Keluar";
        $role = session('role');
        return view('admin.a_barang_keluar.edit', compact('role', 'title') + [
            'barangkeluar' => BarangKeluar::find($id),
            'user' => User::get(),
            'peminjaman' => Peminjaman::get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $title = "Barang Keluar";
        $role = session('role');
        $data = $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'tanggal_keluar' => 'required|date',
        ]);

        $barangkeluar = BarangKeluar::findOrFail($id);
        $data['users_id'] = $data['peminjaman_id'];
        unset($data['peminjaman_id']);

        $barangkeluar->update($data);
        if ($barangkeluar) {
            return to_route('barangkeluar.index')->with(compact('role', 'title'))->with('success', 'Berhasil Menyimpan Data');
        } else {
            return to_route('barangkeluar.index')->with(compact('role', 'title'))->with('failed', 'Gagal Menyimpan Data');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $title = "Barang Keluar";
        $role = session('role');
        $barangkeluar = BarangKeluar::find($id);
        if ($barangkeluar) {
            $peminjaman = Peminjaman::find($barangkeluar->peminjaman_id);
            if ($peminjaman) {
                // Tambahkan kembali stok barang
                $barang = Barang::find($peminjaman->id_barang);
                if ($barang) {
                    $barang->stok += $peminjaman->jumlah; // Menambahkan stok barang sesuai jumlah peminjaman
                    $barang->save();
                }
            }

            $barangkeluar->delete();
            return to_route('barangkeluar.index')->with(compact('role', 'title'))->with('success', 'Berhasil Menghapus Data');
        } else {
            return to_route('barangkeluar.index')->with(compact('role', 'title'))->with('failed', 'Gagal Menghapus Data');
        }
    }
}
