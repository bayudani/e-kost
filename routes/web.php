<?php

use App\Http\Controllers\ApiChatController;
use App\Http\Controllers\ProfileController;
use App\Livewire\Admin\BarangManager;
use App\Livewire\Admin\KategoriManager;
use App\Livewire\Admin\TransaksiManager;
use App\Livewire\Admin\User;
use App\Livewire\Admin\VerifikasiManager;
use App\Livewire\Chat\ChatBox;
use App\Livewire\Pembeli\Checkout;
use App\Livewire\Pembeli\DetailBarang;
use App\Livewire\Pembeli\KatalogBarang;
use App\Livewire\Pembeli\Pembayaran;
use App\Livewire\Pembeli\RiwayatPembelian;
use App\Livewire\Pembeli\StatusTransaksi;
use App\Livewire\Penjual\BarangManager as PenjualBarangManager;
use App\Livewire\Penjual\TransaksiManager as PenjualTransaksiManager;
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
    $role = auth()->user()->role;

    if ($role === 'admin') {
        return redirect()->route('admin.user');
    } elseif ($role === 'penjual') {
        return redirect()->route('penjual.barang');
    } else {
        // Default (pembeli atau guest)
        return redirect()->route('pembeli.katalog');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', function () {
    $role = auth()->user()->role;

    if ($role === 'admin') {
        return redirect()->route('admin.user');
    } elseif ($role === 'penjual') {
        return redirect()->route('penjual.barang');
    } else {
        // Default (pembeli atau guest)
        return redirect()->route('pembeli.katalog');
    }
})->middleware(['auth', 'verified'])->name('dashboard');
// 🛒 ================= ROUTE PEMBELI ================= 🛒
Route::middleware(['auth', 'role:pembeli'])->prefix('pembeli')->name('pembeli.')->group(function () {
    Route::get('/katalog', KatalogBarang::class)->name('katalog');
    // detail
    Route::get('/detail/{id}', DetailBarang::class)->name('detail');
    Route::get('/checkout/{id}', Checkout::class)->name('checkout');
    Route::get('/pembayaran/{id}', Pembayaran::class)->name('pembayaran');
    Route::get('/status-transaksi', StatusTransaksi::class)->name('status');
    Route::get('/riwayat', RiwayatPembelian::class)->name('riwayat');
    // chat
    Route::get('/chat', ChatBox::class)->name('chat');
});

// 🏪 ================= ROUTE PENJUAL ================= 🏪
Route::middleware(['auth', 'role:penjual'])->prefix('penjual')->name('penjual.')->group(function () {
    Route::get('/kelola-barang', PenjualBarangManager::class)->name('barang');
    Route::get('/transaksi', PenjualTransaksiManager::class)->name('transaksi');
    Route::get('/chat', ChatBox::class)->name('chat');
});

// 👑 ================= ROUTE ADMIN ================= 👑
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/kelola-user', User::class)->name('user');
    Route::get('/kelola-kategori', KategoriManager::class)->name('kategori');
    Route::get('/kelola-barang', BarangManager::class)->name('barang');
    Route::get('/verifikasi-pembayaran', VerifikasiManager::class)->name('verifikasi');
    Route::get('/kelola-transaksi', TransaksiManager::class)->name('transaksi');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/api/chat/fetch', [ApiChatController::class, 'fetch'])->name('api.chat.fetch');
    Route::post('/api/chat/send', [ApiChatController::class, 'send'])->name('api.chat.send');
});

require __DIR__ . '/auth.php';
