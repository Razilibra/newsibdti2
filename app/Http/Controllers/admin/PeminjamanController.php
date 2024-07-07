<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Pegawai;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = session('role');
        $userId = auth()->id(); // Assuming you want to get the authenticated user's ID

        // Initialize query with eager loading
        $query = Peminjaman::with('users', 'barangs', 'pegawais')->latest();

        // Apply additional conditions based on role
        if ($role !== 'admin') {
            $query->where('users_id', $userId); // Adjusted column name assuming it's 'users_id'
        }

        // Fetch peminjaman records
        $peminjaman = $query->get();

        // Set the title
        $title = "data peminjaman";

        return view('admin.a_peminjaman.index', compact('peminjaman', 'role', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role = session('role');
        $users = User::all();
        $barangs = Barang::all();
        $pegawais = Pegawai::all();

        // Set the title
        $title = "data peminjaman";

        return view('admin.a_peminjaman.create', compact('users', 'barangs', 'pegawais', 'role', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'users_id' => 'required',
            'barangs_id' => 'required',
            'pegawais_id' => 'required',
            'jumlah' => 'required|min:0',
            'tanggal_pinjam' => 'required',
            'lama_pinjam' => 'required'
        ]);

        Peminjaman::create($data);

        return redirect()->route('peminjaman.index')->with('success', 'Berhasil Menambah Data');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $role = session('role');
        $peminjaman = Peminjaman::findOrFail($id);

        // Set the title
        $title = "data peminjaman";

        return view('admin.a_peminjaman.show', compact('peminjaman', 'role', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $role = session('role');
        $peminjaman = Peminjaman::findOrFail($id);
        $users = User::all();
        $barangs = Barang::all();
        $pegawais = Pegawai::all();

        // Set the title
        $title = "data peminjaman";

        return view('admin.a_peminjaman.edit', compact('peminjaman', 'users', 'barangs', 'pegawais', 'role', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $data = $request->validate([
            'users_id' => 'required',
            'barangs_id' => 'required',
            'pegawais_id' => 'required',
            'jumlah' => 'required|min:0',
            'tanggal_pinjam' => 'required',
            'lama_pinjam' => 'required'
        ]);

        $peminjaman->update($data);

        return redirect()->route('peminjaman.index')->with('success', 'Berhasil Menyimpan Data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Peminjaman::findOrFail($id)->delete();

        return redirect()->route('peminjaman.index')->with('success', 'Berhasil Menghapus Data');
    }
}
