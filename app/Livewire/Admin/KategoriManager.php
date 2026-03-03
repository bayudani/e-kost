<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Kategori;

class KategoriManager extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    // State Variables for Modal
    public $isModalOpen = false;
    public $kategori_id;
    public $nama_kategori;
    public $jenis_kategori;
    public $modalTitle = 'Tambah Kategori';

    /**
     * Buka Modal untuk Menambah Kategori Baru
     */
    public function createKategori()
    {
        $this->reset(['kategori_id', 'nama_kategori', 'jenis_kategori']);
        $this->modalTitle = 'Tambah Kategori Baru';
        $this->isModalOpen = true;
    }

    /**
     * Buka Modal untuk Mengedit Kategori
     */
    public function editKategori($id)
    {
        $kategori = Kategori::findOrFail($id);
        
        $this->kategori_id = $kategori->id;
        $this->nama_kategori = $kategori->nama_kategori;
        $this->jenis_kategori = $kategori->jenis_kategori; // kalau sesuai dgn schema 'elektronik', 'non elektronik'

        $this->modalTitle = 'Edit Kategori';
        $this->isModalOpen = true;
    }

    /**
     * Proses Simpan Kategori (Bisa Create atau Update)
     */
    public function storeKategori()
    {
        // Validasi, pastikan sesuai dengan struktur Enum jika ada
        $this->validate([
            'nama_kategori' => 'required|string|max:100',
            // kalau di database lu ada kolom jenis_kategori, uncomment dibawah
            // 'jenis_kategori' => 'required|in:elektronik,non elektronik', 
        ]);

        Kategori::updateOrCreate(
            ['id' => $this->kategori_id],
            [
                'nama_kategori' => $this->nama_kategori,
                // 'jenis_kategori' => $this->jenis_kategori, // Uncomment jika ada
            ]
        );

        $this->closeModal();
        
        $msg = $this->kategori_id ? 'Kategori berhasil diupdate bro!' : 'Kategori baru berhasil ditambahin bro!';
        session()->flash('message', $msg);
    }

    /**
     * Tutup Modal
     */
    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetValidation();
    }

    /**
     * Hapus Kategori
     */
    public function deleteKategori($id)
    {
        $kategori = Kategori::find($id);
        if ($kategori) {
            $kategori->delete();
            session()->flash('message', 'Mantap! Data kategori berhasil dihapus bro!');
        }
    }

    public function render()
    {
        $kategoris = Kategori::latest()->paginate(10);
        return view('livewire.admin.kategori-manager', [
            'kategoris' => $kategoris
        ]);
    }
}