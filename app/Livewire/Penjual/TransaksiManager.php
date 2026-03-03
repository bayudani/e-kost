<?php

namespace App\Livewire\Penjual;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

class TransaksiManager extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public function render()
    {
        // Ambil semua transaksi yang masuk ke toko si penjual
        $transaksis = Transaksi::with(['barang', 'pembeli'])
            ->where('id_penjual', Auth::id())
            ->latest()
            ->paginate(10);

        return view('livewire.penjual.transaksi-manager', [
            'transaksis' => $transaksis
        ]);
    }
}