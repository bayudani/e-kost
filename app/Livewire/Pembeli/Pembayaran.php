<?php

namespace App\Livewire\Pembeli;

use Livewire\Component;
use App\Models\Transaksi;
use Livewire\WithFileUploads;

class Pembayaran extends Component
{
    use WithFileUploads;

    public $transaksi;
    public $bukti_transfer;

    public function mount($id) {
    $this->transaksi = Transaksi::with('barang')->findOrFail($id);

    // Cek Expiry khusus untuk metode TRANSFER
    if ($this->transaksi->metode_pembayaran === 'Transfer' && 
        $this->transaksi->status_transaksi === 'Menunggu Pembayaran') {
        
        // Jika sudah lebih dari 24 jam dari waktu transaksi dibuat
        if (now()->diffInHours($this->transaksi->created_at) >= 24) {
            $this->transaksi->update(['status_transaksi' => 'Dibatalkan']);
        }
    }
}
    public function uploadBukti()
    {
        $this->validate([
            'bukti_transfer' => 'required|image|max:2048',
        ]);

        $path = $this->bukti_transfer->store('bukti_pembayaran', 'public');

        $this->transaksi->update([
            'bukti_transfer' => $path,
            'status_transaksi' => 'Menunggu pembayaran' // Map ke 'waiting confirmation'
        ]);

        session()->flash('message', 'Bukti berhasil diupload! Tunggu admin verifikasi ya bro. 🔥');
        return redirect()->route('pembeli.status');
    }

    public function render()
    {
        return view('livewire.pembeli.pembayaran');
    }
}