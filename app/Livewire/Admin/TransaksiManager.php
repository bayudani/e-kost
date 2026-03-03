<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Transaksi;

class TransaksiManager extends Component
{
    use WithPagination;

    // Pake style Tailwind buat pagination-nya biar nyambung sama UI kita
    protected $paginationTheme = 'tailwind';

    // Properti buat fitur pencarian (Search bar)
    public $search = '';

    // Biar tiap ngetik di search, halamannya kereset ke page 1
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Ambil semua data transaksi, sekalian panggil relasinya (Eager Loading)
        // Biar query database-nya nggak lemot (N+1 problem)
        $transaksis = Transaksi::with(['barang', 'pembeli', 'penjual'])
            ->when($this->search, function($query) {
                // Bisa nyari berdasarkan ID transaksi atau Nama Barang
                $query->where('id', 'like', '%' . $this->search . '%')
                      ->orWhereHas('barang', function($q) {
                          $q->where('nama_barang', 'like', '%' . $this->search . '%');
                      });
            })
            ->latest() // Urutin dari yang paling baru
            ->paginate(10);

        return view('livewire.admin.transaksi-manager', [
            'transaksis' => $transaksis
        ]);
    }
}