<?php

use App\Http\Controllers\LogController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\KategoriBerita;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\admin\ProdiController;
use App\Http\Controllers\admin\BarangController;
use App\Http\Controllers\admin\BeritaController;
use App\Http\Controllers\admin\PegawaiController;
use App\Http\Controllers\admin\RuanganController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\admin\SupplierController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\MahasiswaController;
use App\Http\Controllers\admin\PeminjamanController;
use App\Http\Controllers\admin\BarangMasukController;
use App\Http\Controllers\admin\BarangKeluarController;
use App\Http\Controllers\admin\PengembalianController;
use App\Http\Controllers\auth\ForgotPasswordController;
use App\Http\Controllers\admin\KategoriBeritaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



//Login


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', 'App\Http\Controllers\Auth\LoginController@login')->name('login.store');
Route::get('/logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');

// Rute untuk menyimpan data registrasi
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

//forget password
Route::get('/auth-forgot-password.html', function () {
    return view('auth.forgot-password');
})->name('forgot-password');
// Rute untuk menampilkan form pengaturan ulang kata sandi
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

// Rute untuk mengirim email pengaturan ulang kata sandi
Route::post('/forgot-password', [
    'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail',
    'as' => 'password.email'
]);

// Rute untuk menampilkan form reset kata sandi
Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->name('password.reset');

// Rute untuk menyimpan kata sandi yang direset
Route::post('/reset-password', [
    'uses' => 'Auth\ResetPasswordController@reset',
    'as' => 'password.update'
]);

Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');




Route::get('/', function () {
    return view('frontend.index');
});
// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

//Ruangan
Route::get('/ruangan',[RuanganController::class, 'index'])->name('ruangan.index');
Route::get('/create-ruangan',[RuanganController::class, 'create'])->name('ruangan.create');
Route::post('/ruangan', [RuanganController::class, 'store'])->name('ruangan.store');
Route::get('/ruangan/{id}/edit', [RuanganController::class, 'edit'])->name('ruangan.edit');
Route::patch('/ruangan/{id}/update', [RuanganController::class, 'update'])->name('ruangan.update');
Route::delete('ruangan/{id}destroy',[RuanganController::class, 'destroy'])->name('ruangan.destroy');

// Barang
Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
Route::get('/create-barang', [BarangController::class, 'create'])->name('barang.create');
Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');
Route::get('/barang/{id}', [BarangController::class, 'show'])->name('barang.show');
Route::get('/barang/{id}/edit', [BarangController::class, 'edit'])->name('barang.edit');
Route::put('/barang/{id}/update', [BarangController::class, 'update'])->name('barang.update');
Route::delete('/barang/{id}/destroy',[BarangController::class, 'destroy'])->name('barang.destroy');

// Barang Masuk
Route::get('/barang-masuk',[BarangMasukController::class, 'index'])->name('barangmasuk.index');
Route::get('/create-barang-masuk',[BarangMasukController::class, 'create'])->name('barangmasuk.create');
Route::post('/barang-masuk', [BarangMasukController::class, 'store'])->name('barangmasuk.store');
Route::get('/barang-masuk/{id}/edit', [BarangMasukController::class, 'edit'])->name('barangmasuk.edit');
Route::put('/barang-masuk/{id}/update', [BarangMasukController::class, 'update'])->name('barangmasuk.update');
Route::delete('/barang-masuk/{id}destroy',[BarangMasukController::class, 'destroy'])->name('barangmasuk.destroy');

// Barang Keluar
Route::get('/barang-keluar',[BarangKeluarController::class, 'index'])->name('barangkeluar.index');
Route::get('/create-barang-keluar',[BarangKeluarController::class, 'create'])->name('barangkeluar.create');
Route::post('/barang-keluar', [BarangKeluarController::class, 'store'])->name('barangkeluar.store');
Route::delete('/barang-keluar/{id}/destroy',[BarangKeluarController::class, 'destroy'])->name('barangkeluar.destroy');

// Supplier
Route::get('/supplier',[SupplierController::class, 'index'])->name('supplier.index');
Route::get('/create-supplier',[SupplierController::class, 'create'])->name('supplier.create');
Route::post('/supplier', [SupplierController::class, 'store'])->name('supplier.store');
Route::get('/supplier/{id}/edit', [SupplierController::class, 'edit'])->name('supplier.edit');
Route::patch('/supplier/{id}/update', [SupplierController::class, 'update'])->name('supplier.update');
Route::delete('/supplier/{id}/destroy',[SupplierController::class, 'destroy'])->name('supplier.destroy');

// Peminjaman
Route::get('/peminjaman',[PeminjamanController::class, 'index'])->name('peminjaman.index');
Route::get('/create-peminjaman',[PeminjamanController::class, 'create'])->name('peminjaman.create');
Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
Route::get('/peminjaman/{id}/edit', [PeminjamanController::class, 'edit'])->name('peminjaman.edit');
Route::put('/peminjaman/{id}/update', [PeminjamanController::class, 'update'])->name('peminjaman.update');
Route::delete('/peminjaman/{id}/destroy',[PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');

// Pengembalian
Route::get('/pengembalian',[PengembalianController::class, 'index'])->name('pengembalian.index');
Route::get('/create-pengembalian',[PengembalianController::class, 'create'])->name('pengembalian.create');
Route::post('/pengembalian', [PengembalianController::class, 'store'])->name('pengembalian.store');
Route::get('/pengembalian/{id}/edit', [PengembalianController::class, 'edit'])->name('pengembalian.edit');
Route::put('/pengembalian/{id}/update', [PengembalianController::class, 'update'])->name('pengembalian.update');
Route::delete('/pengembalian/{id}/destroy',[PengembalianController::class, 'destroy'])->name('pengembalian.destroy');

// Kategori Berita
Route::get('/kategori-berita',[KategoriBeritaController::class, 'index'])->name('kategoriberita.index');
Route::get('/create-kategori-berita',[KategoriBeritaController::class, 'create'])->name('kategoriberita.create');
Route::post('/kategori-berita', [KategoriBeritaController::class, 'store'])->name('kategoriberita.store');
Route::get('/kategori-berita/{id}/edit', [KategoriBeritaController::class, 'edit'])->name('kategoriberita.edit');
Route::patch('/kategori-berita/{id}/update', [KategoriBeritaController::class, 'update'])->name('kategoriberita.update');
Route::delete('/kategori-berita/{id}/destroy',[KategoriBeritaController::class, 'destroy'])->name('kategoriberita.destroy');

// Berita
Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/create-berita', [BeritaController::class, 'create'])->name('berita.create');
Route::post('/berita', [BeritaController::class, 'store'])->name('berita.store');
Route::get('/berita/{id}', [BeritaController::class, 'show'])->name('berita.show');
Route::get('/berita/{id}/edit', [BeritaController::class, 'edit'])->name('berita.edit');
Route::put('/berita/{id}/update', [BeritaController::class, 'update'])->name('berita.update');
Route::delete('/berita/{id}/destroy',[BeritaController::class, 'destroy'])->name('berita.destroy');

// User
Route::get('/user', [UserController::class, 'index'])->name('user.index');
Route::get('/create-user', [UserController::class, 'create'])->name('user.create');
Route::post('/user', [UserController::class, 'store'])->name('user.store');
Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
Route::put('/user/{id}/update', [UserController::class, 'update'])->name('user.update');
Route::delete('/user/{id}/destroy',[UserController::class, 'destroy'])->name('user.destroy');

// Pegawai/Dosen/Staff
Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
Route::get('/create-pegawai', [PegawaiController::class, 'create'])->name('pegawai.create');
Route::post('/pegawai', [PegawaiController::class, 'store'])->name('pegawai.store');
Route::get('/pegawai/{id}', [PegawaiController::class, 'show'])->name('pegawai.show');
Route::get('/pegawai/{id}/edit', [PegawaiController::class, 'edit'])->name('pegawai.edit');
Route::put('/pegawai/{id}/update', [PegawaiController::class, 'update'])->name('pegawai.update');
Route::delete('/pegawai/{id}/destroy',[PegawaiController::class, 'destroy'])->name('pegawai.destroy');

// Prodi
Route::get('/prodi',[ProdiController::class, 'index'])->name('prodi.index');
Route::get('/create-prodi',[ProdiController::class, 'create'])->name('prodi.create');
Route::post('/prodi', [ProdiController::class, 'store'])->name('prodi.store');
Route::get('/prodi/{id}/edit', [ProdiController::class, 'edit'])->name('prodi.edit');
Route::patch('/prodi/{id}/update', [ProdiController::class, 'update'])->name('prodi.update');
Route::delete('/prodi/{id}/destroy',[ProdiController::class, 'destroy'])->name('prodi.destroy');

// Mahasiswa
Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
Route::get('/create-mahasiswa', [MahasiswaController::class, 'create'])->name('mahasiswa.create');
Route::post('/mahasiswa', [MahasiswaController::class, 'store'])->name('mahasiswa.store');
Route::get('/mahasiswa/{id}', [MahasiswaController::class, 'show'])->name('mahasiswa.show');
Route::get('/mahasiswa/{id}/edit', [MahasiswaController::class, 'edit'])->name('mahasiswa.edit');
Route::put('/mahasiswa/{id}/update', [MahasiswaController::class, 'update'])->name('mahasiswa.update');
Route::delete('/mahasiswa/{id}/destroy',[MahasiswaController::class, 'destroy'])->name('mahasiswa.destroy');

// Log Aktivitas

Route::resource('/logs', LogController::class);
