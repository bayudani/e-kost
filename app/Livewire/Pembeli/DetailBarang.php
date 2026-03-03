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
        // Logika buat buka room chat baru atau redirect ke chat
        return redirect()->route('pembeli.chat', ['barang_id' => $this->barang->id]);
    }

    public function render()
    {
        return view('livewire.pembeli.detail-barang');
    }
}