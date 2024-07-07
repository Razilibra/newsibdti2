<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Menampilkan form login.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }
    protected $redirectTo = '/dashboard';
    /**
     * Proses login user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */


    public function login(Request $request)
{
    $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    // Temukan user berdasarkan email
    $user = User::where('email', $request->email)->first();

    // Periksa apakah user ditemukan dan password cocok
    if ($user && Hash::check($request->password, $user->password)) {
        // Login berhasil, simpan role ke dalam session
        $request->session()->put('id_users', $user->id);
        $request->session()->put('role', $user->role);

        // Regenerate session
        $request->session()->regenerate();

        return redirect()->intended('/dashboard');
    }

    // Jika email atau password tidak cocok
    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ])->withInput($request->only('email'));
}

    // app/Http/Controllers/Auth/LogoutController.php

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Hapus role dari session
        $request->session()->forget('role');

        return redirect('/');
    }
}
