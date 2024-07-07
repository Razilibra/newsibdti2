<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use App\Http\Requests\BarangRequest;
use App\Http\Requests\UpdateBarangRequest;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Barang ";
        $role = session('role');
        return view('admin.a_barang.index', [
            'barang' => Barang::with('ruangans')->latest()->get(),
            'role' => $role,
            'title' => $title
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Barang ";
        $role = session('role');
        return view('admin.a_barang.create', [
            'ruangan' => Ruangan::get(),
            'role' => $role,
            'title' => $title
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BarangRequest $request)
    {
        $title = "Barang ";
        $role = session('role');
        $data = $request->validated();

        $file = $request->file('foto');
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/image', $fileName);

        $data['foto'] = $fileName;

        $barangs = Barang::create($data);
        if ($barangs) {
            return to_route('barang.index')->with('success', 'Berhasil Menambah Data')->with(compact('role', 'title'));
        } else {
            return to_route('barang.index')->with('failed', 'Gagal Menambah Data')->with(compact('role', 'title'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $title = "Barang ";
        $role = session('role');
        $barang = Barang::findOrFail($id);
        return view('admin.a_barang.detail', compact('barang', 'role', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = "Barang ";
        $role = session('role');
        return view('admin.a_barang.edit', [
            'barang' => Barang::find($id),
            'ruangan' => Ruangan::get(),
            'role' => $role,
            'title' => $title
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBarangRequest $request, string $id)
    {
        $title = "Barang ";
        $role = session('role');
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

        $barang = Barang::find($id)->update($data);
        if ($barang) {
            return to_route('barang.index')->with('success', 'Berhasil Mengubah Data')->with(compact('role', 'title'));
        } else {
            return to_route('barang.index')->with('failed', 'Gagal Mengubah Data')->with(compact('role', 'title'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $title = "Barang ";
        $role = session('role');
        $data = Barang::find($id);
        Storage::delete('public/image/' . $data->foto);
        $data->delete();

        if ($data) {
            return to_route('barang.index')->with('success', 'Berhasil Menghapus Data')->with(compact('role', 'title'));
        } else {
            return to_route('barang.index')->with('failed', 'Gagal Menghapus Data')->with(compact('role', 'title'));
        }
    }
}
