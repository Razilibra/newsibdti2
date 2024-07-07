<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = session('role');
        $title = "data user";
        return view('admin.a_user.index', compact('role','title') + [
            'user' => User::orderByRaw("FIELD(role, 'pimpinan','admin', 'staff', 'dosen', 'mahasiswa')")->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role = session('role');
        $title = "data user";
        return view('admin.a_user.create', compact('role','title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $role = session('role');
        $data = $request->validated();

        $user = User::create($data);
        if ($user) {
            return redirect()->route('user.index')->with('success', 'Berhasil Menambah Data')->with(compact('role'));
        } else {
            return redirect()->route('user.index')->with('failed', 'Gagal Menambah Data')->with(compact('role'));
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
        $user = User::findOrFail($id);
        $title = "data user";
        return view('admin.a_user.edit', compact('user', 'role','title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $role = session('role');
        $data = $request->validated();

        $user = User::find($id)->update($data);
        if ($user) {
            return redirect()->route('user.index')->with('success', 'Berhasil Mengubah Data')->with(compact('role'));
        } else {
            return redirect()->route('user.index')->with('failed', 'Gagal Mengubah Data')->with(compact('role'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = session('role');
        $user = User::find($id);
        $user->delete();

        if ($user) {
            return redirect()->route('user.index')->with('success', 'Berhasil Menghapus Data')->with(compact('role'));
        } else {
            return redirect()->route('user.index')->with('failed', 'Gagal Menghapus Data')->with(compact('role'));
        }
    }
}
