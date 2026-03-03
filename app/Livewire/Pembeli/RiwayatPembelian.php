<?php

namespace App\Livewire\Pembeli;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Transaksi;

class RiwayatPembelian extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public function render()
    {
        // Ambil transaksi yang statusnya 'Selesai' atau 'Dibatalkan'
        // Karena ini riwayat, mending pake paginate biar ga numpuk kalau transaksinya udah banyak
        $riwayats = Transaksi::with(['barang', 'penjual'])
            ->where('id_pembeli', auth()->id())
            ->whereIn('status_transaksi', ['Selesai', 'Dibatalkan'])
            ->latest()
            ->paginate(5);

        return view('livewire.pembeli.riwayat-pembelian', [
            'riwayats' => $riwayats
        ]);
    }
}