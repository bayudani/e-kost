<?php

namespace App\Livewire\Pembeli;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Barang;
use App\Models\Kategori;

class KatalogBarang extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    // State buat nangkep inputan search & filter kategori
    public $search = '';
    public $kategori_id = ''; // Kosong berarti 'Semua Kategori'

    // Reset pagination tiap kali user ngetik di search bar
    public function updatingSearch()
    {
        $this->resetPage();
    }

    // Reset pagination tiap kali user ganti filter kategori
    public function updatingKategoriId()
    {
        $this->resetPage();
    }

    // Fungsi buat ngeset filter kategori dari button di UI
    public function setKategori($id)
    {
        $this->kategori_id = $id;
        $this->resetPage();
    }

    public function render()
    {
        // Ambil data kategori buat ditampilin di tombol filter
        $kategoris = Kategori::all();

        // Query buat ngambil data barang berdasarkan search & filter
        // Cuma nampilin barang yang statusnya 'tersedia' aja dong pastinya
        $barangs = Barang::with(['kategori', 'user'])
            ->where('status', 'tersedia')
            ->when($this->search, function($query) {
                $query->where('nama_barang', 'like', '%' . $this->search . '%')
                      ->orWhere('deskripsi', 'like', '%' . $this->search . '%');
            })
            ->when($this->kategori_id, function($query) {
                $query->where('kategori_id', $this->kategori_id);
            })
            ->latest()
            ->paginate(12); // Nampilin 12 barang per halaman biar grid-nya cakep

        return view('livewire.pembeli.katalog-barang', [
            'barangs' => $barangs,
            'kategoris' => $kategoris
        ]);
    }
}