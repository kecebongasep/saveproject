<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PeminjamDashboardController;
use App\Http\Controllers\PenerbitController;
use App\Http\Controllers\PenulisController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    $user = auth()->user();

    return match ($user->peran) {
        'admin', 'petugas' => redirect('/admin'),
        'peminjam' => redirect('/peminjam'),
        default => abort(403),
    };
})->middleware('auth')->name('dashboard');

Route::middleware(['auth', 'role:admin,petugas'])
    ->get('/admin', [DashboardController::class, 'index']);

Route::middleware(['auth', 'role:peminjam'])
    ->get('/peminjam', [PeminjamDashboardController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::resource('kategori', KategoriController::class);
    Route::resource('penulis', PenulisController::class);
    Route::resource('penerbit', PenerbitController::class);
    Route::resource('buku', BukuController::class);
    Route::resource('peminjaman', PeminjamanController::class);
    Route::resource('detailpeminjaman', DetailController::class);
    Route::resource('user', UserController::class);

    Route::put(
        'detail-peminjaman/{id}/kembalikan',
        [DetailController::class, 'kembalikan']
    )->name('detail.kembalikan');

    Route::put(
        '/peminjam/detail/{id}/perpanjang',
        [DetailController::class, 'ajukanPerpanjangan']
    )->name('peminjam.perpanjang');

    Route::post(
        '/admin/perpanjang/{id}/setujui',
        [DetailController::class, 'setujuiPerpanjangan']
    )->name('admin.perpanjang.setujui');

    Route::post(
        '/admin/perpanjang/{id}/tolak',
        [DetailController::class, 'tolakPerpanjangan']
    )->name('admin.perpanjang.tolak');
});

Route::get('/dashboard/peminjam', [PeminjamDashboardController::class, 'index'])
    ->name('dashboard.peminjam')
    ->middleware('auth');

Route::get('/kategori/search', [KategoriController::class, 'search'])
    ->name('kategori.search');
