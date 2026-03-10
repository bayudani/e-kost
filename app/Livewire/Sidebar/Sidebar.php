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

    // Kita define menu dinamis berdasarkan role user beserta ikonnya
    public function getMenusProperty()
    {
        $role = Auth::user()->role ?? 'pembeli'; // Default fallback

        $menus = [];

        // 🛒 Menu khusus Pembeli
        if ($role === 'pembeli') {
            $menus = [
                ['title' => 'Katalog Barang', 'route' => 'pembeli.katalog', 'icon' => 'katalog'],
                ['title' => 'Chat', 'route' => 'pembeli.chat', 'icon' => 'chat', 'show_badge' => true],
                ['title' => 'Status Transaksi', 'route' => 'pembeli.status', 'icon' => 'transaksi'],
                ['title' => 'Riwayat', 'route' => 'pembeli.riwayat', 'icon' => 'riwayat'],
            ];
        }
        // 🏪 Menu khusus Penjual
        elseif ($role === 'penjual') {
            $menus = [
                ['title' => 'Kelola Barang', 'route' => 'penjual.barang', 'icon' => 'barang'],
                ['title' => 'Transaksi', 'route' => 'penjual.transaksi', 'icon' => 'transaksi'],
                ['title' => 'Chat', 'route' => 'penjual.chat', 'icon' => 'chat', 'show_badge' => true],
            ];
        }
        // 👑 Menu khusus Admin
        elseif ($role === 'admin') {
            $menus = [
                ['title' => 'Kelola User', 'route' => 'admin.user', 'icon' => 'user'],
                ['title' => 'Kelola Kategori', 'route' => 'admin.kategori', 'icon' => 'kategori'],
                ['title' => 'Kelola Barang', 'route' => 'admin.barang', 'icon' => 'barang'],
                ['title' => 'Verifikasi Pembayaran', 'route' => 'admin.verifikasi', 'icon' => 'verifikasi'],
                ['title' => 'Kelola Transaksi', 'route' => 'admin.transaksi', 'icon' => 'transaksi'],
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