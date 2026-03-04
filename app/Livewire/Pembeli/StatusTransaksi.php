<?php

namespace App\Livewire\Pembeli;

use App\Models\Transaksi;
use Livewire\Component;

class StatusTransaksi extends Component
{


    public function konfirmasiTerima($id)
    {
        $trx = Transaksi::findOrFail($id);
        $trx->update(['status_transaksi' => 'Selesai']);

        // Update status barang juga jadi 'terjual' biar ga nongol di katalog
        $trx->barang->update(['status' => 'terjual']);

        session()->flash('message', 'Mantap! Transaksi selesai, semoga barangnya awet!');
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
