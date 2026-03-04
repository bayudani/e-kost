<?php

namespace App\Livewire\Pembeli;

use Livewire\Component;
use App\Models\Barang;

class DetailBarang extends Component
{
    public $barang;

    public function mount($id)
    {
        // Ambil data barang lengkap dengan kategori dan penjual (user)
        $this->barang = Barang::with(['kategori', 'user'])->findOrFail($id);
    }

    /**
     * Fungsi buat nge-gas ke halaman checkout
     */
    public function beliSekarang()
    {
        return redirect()->route('pembeli.checkout', $this->barang->id);
    }

    /**
     * Fungsi buat mulai chat (Nanti kita hubungkan ke modul Chat)
     */
    public function hubungiPenjual()
    {
        // Kirim pesan otomatis pertama, atau langsung redirect ke chat
        $barang = $this->barang; // pastikan property barang ada

        // Redirect ke halaman chat dengan query params
        return redirect()->to(
            route('pembeli.chat') . '?' . http_build_query([
                'selectedBarangId' => $barang->id,
                'receiverId' => $barang->user_id, // atau $barang->user_id, sesuaikan nama kolom
            ])
        );
    }

    public function render()
    {
        return view('livewire.pembeli.detail-barang');
    }
}
