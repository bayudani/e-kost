<?php

namespace App\Livewire\Sidebar;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Chat;

class Sidebar extends Component
{
    // Hitung jumlah chat masuk yang belum dibaca
    public function getUnreadChatsCountProperty()
    {
        if (!Auth::check()) return 0;

        // Hitung pesan dimana kita adalah penerima dan status is_read masih false
        return Chat::where('id_penerima', Auth::id())
            ->where('is_read', false)
            ->count();
    }

    // Kita define menu dinamis berdasarkan role user
    public function getMenusProperty()
    {
        $role = Auth::user()->role ?? 'pembeli'; // Default fallback

        $menus = [];

        // 🛒 Menu khusus Pembeli
        if ($role === 'pembeli') {
            $menus = [
                ['title' => 'Katalog Barang', 'route' => 'pembeli.katalog'],
                ['title' => 'Chat', 'route' => 'pembeli.chat', 'show_badge' => true],
                ['title' => 'Status Transaksi', 'route' => 'pembeli.status'],
                ['title' => 'Riwayat', 'route' => 'pembeli.riwayat'],
            ];
        }
        // 🏪 Menu khusus Penjual
        elseif ($role === 'penjual') {
            $menus = [
                ['title' => 'Kelola Barang', 'route' => 'penjual.barang'],
                ['title' => 'Transaksi', 'route' => 'penjual.transaksi'],
                ['title' => 'Chat', 'route' => 'penjual.chat', 'show_badge' => true],
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
            'menus' => $this->menus,
            'unreadCount' => $this->unreadChatsCount
        ]);
    }
}