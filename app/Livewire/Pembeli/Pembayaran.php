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

    public function mount($id) 
    {
        $this->transaksi = Transaksi::with('barang')->findOrFail($id);

        // Cek Expiry khusus untuk metode TRANSFER
        if ($this->transaksi->metode_pembayaran === 'Transfer' && 
            $this->transaksi->status_transaksi === 'Menunggu Pembayaran') {
            
            // PERBAIKAN LOGIC: Gunakan isPast() agar presisi hitungannya sampai ke detik
            if ($this->transaksi->created_at->addHours(24)->isPast()) {
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
            // PERBAIKAN: Setelah upload, status harus ganti biar admin ngecek, bukan nunggu dibayar lagi
            'status_transaksi' => 'Menunggu Verifikasi' 
        ]);

        session()->flash('message', 'Bukti berhasil diupload! Tunggu admin verifikasi ya.');
        return redirect()->route('pembeli.status');
    }

    public function render()
    {
        return view('livewire.pembeli.pembayaran');
    }
}