<?php

namespace App\Livewire\Sidebar;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Sidebar extends Component
{
    // Kita define menu dinamis berdasarkan role user
    public function getMenusProperty()
    {
        $role = Auth::user()->role ?? 'pembeli'; // Default fallback

        $menus = [];

        // 🛒 Menu khusus Pembeli
        if ($role === 'pembeli') {
            $menus = [
                ['title' => 'Katalog Barang', 'route' => 'pembeli.katalog'],
                ['title' => 'Chat', 'route' => 'pembeli.chat'],
                ['title' => 'Status Transaksi', 'route' => 'pembeli.status'],
                ['title' => 'Riwayat', 'route' => 'pembeli.riwayat'],
            ];
        }
        // 🏪 Menu khusus Penjual
        elseif ($role === 'penjual') {
            $menus = [
                ['title' => 'Kelola Barang', 'route' => 'penjual.barang'],
                ['title' => 'Transaksi', 'route' => 'penjual.transaksi'],
                ['title' => 'Chat', 'route' => 'penjual.chat'],
            ];
        }
        // 👑 Menu khusus Admin
        elseif ($role === 'admin') {
            $menus = [
                ['title' => 'Kelola User', 'route' => 'admin.user'],
                ['title' => 'Kelola Kategori', 'route' => 'admin.kategori'],
                ['title' => 'Kelola Barang', 'route' => 'admin.barang'],
                ['title' => 'Verifikasi Pembayaran', 'route' => 'admin.verifikasi'],
                ['title' => 'Kelola Transaksi', 'route' => 'admin.transaksi'],
            ];
        }

        return $menus;
    }

    public function render()
    {
        return view('livewire.sidebar.sidebar', [
            // Kirim data menu ke view (Blade)
            'menus' => $this->menus
        ]);
    }
}
