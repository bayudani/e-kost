<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Transaksi;

class VerifikasiManager extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    // State buat ngatur Modal Verifikasi
    public $isModalOpen = false;
    public $selected_id;
    public $bukti_url;
    public $info_pembeli;
    public $info_barang;
    public $jumlah;

    /**
     * Buka modal dan siapin data buat dicek admin
     */
    public function openVerifikasi($id)
    {
        $transaksi = Transaksi::with(['pembeli', 'barang'])->findOrFail($id);
        
        $this->selected_id = $transaksi->id;
        $this->bukti_url = $transaksi->bukti_transfer;
        $this->info_pembeli = $transaksi->pembeli->name ?? 'Unknown User';
        $this->info_barang = $transaksi->barang->nama_barang ?? 'Unknown Item';
        // Ambil harga dari relasi barang (bisa juga pakai total_harga kalau ada di db)
        $this->jumlah = $transaksi->barang->harga ?? 0; 
        
        $this->isModalOpen = true;
    }

    /**
     * Kalau bukti valid, Admin klik Terima
     */
    public function terima($id = null)
    {
        // Kalau $id ada (dari Card), pake itu. Kalau gak ada, pake state dari Modal
        $targetId = $id ?? $this->selected_id;
        $transaksi = Transaksi::findOrFail($targetId);
        
        $transaksi->update(['status_transaksi' => 'Diverifikasi']);
        $this->closeModal();
        session()->flash('message', 'Sabi! Bukti pembayaran valid, status transaksi jadi Diverifikasi! 🎉');
    }

    public function tolak($id = null)
    {
        $targetId = $id ?? $this->selected_id;
        $transaksi = Transaksi::findOrFail($targetId);
        
        $transaksi->update([
            'bukti_transfer' => null,
            'status_transaksi' => 'Menunggu Pembayaran'
        ]);
        $this->closeModal();
        session()->flash('message', 'Oke, pembayaran ditolak. Kita minta user upload ulang buktinya. 👮‍♂️');
    }

    /**
     * Tutup modal & bersihin data
     */
    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->reset(['selected_id', 'bukti_url', 'info_pembeli', 'info_barang', 'jumlah']);
    }

    public function render()
    {
        // Kita cuma nampilin transaksi yang metodenya 'Transfer' aja, 
        // soalnya COD kan nggak perlu verifikasi Admin.
        $transaksis = Transaksi::with(['pembeli', 'barang'])
            ->where('metode_pembayaran', 'Transfer')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.verifikasi-manager', [
            'transaksis' => $transaksis
        ]);
    }
}