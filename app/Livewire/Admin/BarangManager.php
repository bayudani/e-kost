<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Barang;

class BarangManager extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    // Bikin properti buat fitur pencarian biar makin mantep
    public $search = '';

    // Reset halaman ke 1 kalau lagi ngetik di search bar
    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Fungsi hapus barang dari database
     */
    public function deleteBarang($id)
    {
        $barang = Barang::find($id);
        
        if ($barang) {
            // Hapus gambar dari storage kalau ada (Opsional, tapi best practice)
            // if ($barang->foto && file_exists(storage_path('app/public/' . $barang->foto))) {
            //     unlink(storage_path('app/public/' . $barang->foto));
            // }

            $barang->delete();
            session()->flash('message', 'Sip! Data barang berhasil dihapus dari sistem, bro!');
        }
    }

    public function render()
    {
        // Ambil data barang sekalian sama relasinya (Eager Loading) biar nggak lemot (N+1 Query)
        // Terus filter kalau ada inputan pencarian
        $barangs = Barang::with(['kategori', 'user'])
            ->when($this->search, function($query) {
                $query->where('nama_barang', 'like', '%' . $this->search . '%')
                      ->orWhereHas('user', function($q) {
                          $q->where('name', 'like', '%' . $this->search . '%');
                      });
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.barang-manager', [
            'barangs' => $barangs
        ]);
    }
}