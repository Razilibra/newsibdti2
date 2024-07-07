<?php

// app/Http/Controllers/Auth/RegisterController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // Method untuk menampilkan form registrasi
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Method untuk menyimpan data registrasi
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:mahasiswa,dosen,staff',
        ]);

        $data = [
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ];

        // Optionally, if 'name' is required, you can add it here
        if ($request->filled('name')) {
            $data['name'] = $request->name;
        }

        // Create user without 'name' if not provided
        $user = User::create($data);

        if ($user) {
            return redirect()->route('login')->with('success', 'Registration successful! Please login.');
        } else {
            return back()->with('failed', 'Failed to register user. Please try again.');
        }
    }
}
