<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\Supplier;
use Illuminate\Http\Request;

class BarangMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Barang Masuk";
        $role = session('role');
        $barangmasuk = BarangMasuk::with('barangs', 'suppliers')->latest()->get();
        return view('admin.a_barang_masuk.index', compact('barangmasuk', 'role', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Barang Masuk";
        $role = session('role');
        $barang = Barang::all();
        $supplier = Supplier::all();
        return view('admin.a_barang_masuk.create', compact('barang', 'supplier', 'role', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $title = "Barang Masuk";
        $data = $request->validate([
            'barangs_id' => 'required',
            'suppliers_id' => 'required',
            'jumlah_barang' => 'required|integer|min:0',
            'tanggal_masuk' => 'required'
        ]);

        // Find the barang by id
        $barang = Barang::find($request->barangs_id);
        if ($barang) {
            $barang->stok += $request->jumlah_barang; // Increase stock of barang
            $barang->save();
        }

        $barangmasuk = BarangMasuk::create($data);
        if ($barangmasuk) {
            return redirect()->route('barangmasuk.index')->with('success', 'Berhasil Menambah Data');
        } else {
            return redirect()->route('barangmasuk.index')->with('failed', 'Gagal Menambah Data');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $title = "Barang Masuk";
        $role = session('role');
        // Logic to show specific barang masuk detail
        return view('admin.a_barang_masuk.show', compact('role', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = "Barang Masuk";
        $role = session('role');
        $barangmasuk = BarangMasuk::findOrFail($id);
        $barang = Barang::all();
        $supplier = Supplier::all();
        return view('admin.a_barang_masuk.edit', compact('barangmasuk', 'barang', 'supplier', 'role', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $title = "Barang Masuk";
        $data = $request->validate([
            'barangs_id' => 'required',
            'suppliers_id' => 'required',
            'jumlah_barang' => 'required|integer|min:0',
            'tanggal_masuk' => 'required'
        ]);

        $barangmasuk = BarangMasuk::findOrFail($id);

        // Find the barang by id and adjust stock
        $barang = Barang::find($request->barangs_id);
        if ($barang) {
            // Adjust stock based on the difference
            $difference = $data['jumlah_barang'] - $barangmasuk->jumlah_barang;
            $barang->stok += $difference;
            $barang->save();
        }

        $barangmasuk->update($data);
        if ($barangmasuk) {
            return redirect()->route('barangmasuk.index')->with('success', 'Berhasil Menyimpan Data');
        } else {
            return redirect()->route('barangmasuk.index')->with('failed', 'Gagal Menyimpan Data');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $title = "Barang Masuk";
        $barangmasuk = BarangMasuk::findOrFail($id);

        // Find the barang by id and adjust stock
        $barang = Barang::find($barangmasuk->barangs_id);
        if ($barang) {
            $barang->stok -= $barangmasuk->jumlah_barang; // Decrease stock of barang
            $barang->save();
        }

        $barangmasuk->delete();

        if ($barangmasuk) {
            return redirect()->route('barangmasuk.index')->with('success', 'Berhasil Menghapus Data');
        } else {
            return redirect()->route('barangmasuk.index')->with('failed', 'Gagal Menghapus Data');
        }
    }
}
