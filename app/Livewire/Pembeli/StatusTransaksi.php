<?php

namespace App\Livewire\Pembeli;

use App\Models\Transaksi;
use Livewire\Component;

class StatusTransaksi extends Component
{
    public function konfirmasiTerima($id)
    {
        $trx = Transaksi::findOrFail($id);
        
        // Update status transaksi menjadi selesai
        $trx->update(['status_transaksi' => 'Selesai']);

        // Update status barang juga jadi 'terjual' biar ga nongol di katalog umum lagi
        if ($trx->barang) {
            $trx->barang->update(['status' => 'terjual']);
        }

        // Flash message menggunakan kata-kata yang lebih asik tapi tetap profesional
        session()->flash('message', 'Transaksi berhasil diselesaikan! Semoga barangnya awet dan bermanfaat ya.');
        
        return redirect()->route('pembeli.riwayat');
    }

    public function render()
    {
        return view('livewire.pembeli.status-transaksi', [
            // Ambil transaksi yg BELUM selesai & BELUM dibatalkan
            'transaksis' => Transaksi::with(['barang', 'penjual'])
                ->where('id_pembeli', auth()->id())
                ->whereNotIn('status_transaksi', ['Selesai', 'Dibatalkan'])
                ->latest()
                ->get()
        ]);
    }
}