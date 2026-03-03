<?php

namespace App\Livewire\Pembeli;

use Livewire\Component;
use App\Models\Barang;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Checkout extends Component
{
    public $barang;
    public $metode_pembayaran = 'Transfer';

    public function mount($id)
    {
        $this->barang = Barang::findOrFail($id);
    }

    public function buatPesanan()
    {
        // Pake Database Transaction biar kalau satu gagal, semua batal (aman!)
        DB::transaction(function () {
            // 1. Bikin data transaksi
            $transaksi = Transaksi::create([
                'id_barang' => $this->barang->id,
                'id_pembeli' => Auth::id(),
                'id_penjual' => $this->barang->user_id,
                'metode_pembayaran' => $this->metode_pembayaran,
                'tanggal_transaksi' => now(),
                'status_transaksi' => 'Menunggu Pembayaran',
            ]);

            // 2. 💡 UPDATE STATUS BARANG JADI TERJUAL
            // Biar langsung ilang dari katalog dan nggak bisa dibeli orang lain
            $this->barang->update(['status' => 'terjual']);

            // Redirect ke halaman pembayaran
            return redirect()->route('pembeli.pembayaran', $transaksi->id);
        });
    }

    public function render()
    {
        return view('livewire.pembeli.checkout');
    }
}