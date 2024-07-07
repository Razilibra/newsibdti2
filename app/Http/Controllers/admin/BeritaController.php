namespace App\Http\Controllers\admin;
<?php
use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use App\Models\KategoriBerita;
use App\Http\Requests\BeritaRequest;
use App\Http\Requests\UpdateBeritaRequest;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Barang Masuk";
        $role = session('role');
        return view('admin.a_berita.index', compact('role', 'title') + [
            'berita' => Berita::with('kategori_beritas')->latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Barang Masuk";
        $role = session('role');
        return view('admin.a_berita.create', compact('role', 'title') + [
            'kategori_berita' => KategoriBerita::get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BeritaRequest $request)
    {
        $title = "Barang Masuk";
        $data = $request->validated();
        $role = session('role');
        $file = $request->file('gambar');
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/image', $fileName);

        $data['gambar'] = $fileName;

        $beritas = Berita::create($data);
        if ($beritas) {
            return redirect()->route('berita.index')->with('success', 'Berhasil Menambah Data')->with(compact('title'));
        } else {
            return redirect()->route('berita.index')->with('failed', 'Gagal Menambah Data')->with(compact('title'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $title = "Barang Masuk";
        $role = session('role');
        $berita = Berita::findOrFail($id);
        return view('admin.a_berita.detail', compact('berita', 'role', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = "Barang Masuk";
        $role = session('role');
        return view('admin.a_berita.edit', compact('role', 'title') + [
            'berita' => Berita::find($id),
            'kategori_berita' => KategoriBerita::get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBeritaRequest $request, string $id)
    {
        $title = "Barang Masuk";
        $data = $request->validated();

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/image', $fileName);

            if ($request->oldImg) {
                Storage::delete('public/image/' . $request->oldImg);
            }
            $data['gambar'] = $fileName;
        } else {
            $data['gambar'] = $request->oldImg;
        }

        $berita = Berita::find($id)->update($data);
        if ($berita) {
            return redirect()->route('berita.index')->with('success', 'Berhasil Mengubah Data')->with(compact('title'));
        } else {
            return redirect()->route('berita.index')->with('failed', 'Gagal Mengubah Data')->with(compact('title'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $title = "Barang Masuk";
        $data = Berita::find($id);
        Storage::delete('public/image/' . $data->gambar);
        $data->delete();

        if ($id) {
            return redirect()->route('berita.index')->with('success', 'Berhasil Menghapus Data')->with(compact('title'));
        } else {
            return redirect()->route('berita.index')->with('failed', 'Gagal Menghapus Data')->with(compact('title'));
        }
    }
}
