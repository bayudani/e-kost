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

    public function konfirmasiPenyerahan($id)
    {
        $trx = Transaksi::where('id', $id)->where('id_penjual', Auth::id())->firstOrFail();

        // Update status jadi 'Diproses' (Artinya: Sedang dalam proses serah terima)
        $trx->update([
            'status_transaksi' => 'Diproses'
        ]);

        session()->flash('message', 'Mantap! Status berhasil diupdate. Tunggu pembeli konfirmasi penerimaan ya bro! 🚀');
    }
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