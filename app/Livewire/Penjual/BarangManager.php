<?php

namespace App\Livewire\Penjual;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BarangManager extends Component
{
    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'tailwind';

    public $isModalOpen = false;
    public $isEditMode = false;
    public $barang_id, $nama_barang, $deskripsi, $kondisi_barang, $harga, $kategori_id, $foto, $old_foto, $status;
    
    public $search = '';

    protected function rules()
    {
        return [
            'nama_barang' => 'required|min:3|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'required|min:10',
            'kondisi_barang' => 'required',
            'foto' => $this->isEditMode ? 'nullable|image|max:2048' : 'required|image|max:2048',
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openModal()
    {
        $this->resetForm();
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset(['nama_barang', 'deskripsi', 'kondisi_barang', 'harga', 'kategori_id', 'foto', 'barang_id', 'old_foto', 'status']);
        $this->isEditMode = false;
        $this->resetValidation();
    }

    public function editBarang($id)
    {
        $barang = Barang::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        $this->barang_id = $id;
        $this->nama_barang = $barang->nama_barang;
        $this->deskripsi = $barang->deskripsi;
        $this->kondisi_barang = $barang->kondisi_barang;
        $this->harga = $barang->harga;
        $this->kategori_id = $barang->kategori_id;
        $this->status = $barang->status;
        $this->old_foto = $barang->foto;
        
        $this->isEditMode = true;
        $this->isModalOpen = true;
    }

    public function saveBarang()
    {
        $this->validate();

        $data = [
            'nama_barang'    => $this->nama_barang,
            'deskripsi'      => $this->deskripsi,
            'kondisi_barang' => $this->kondisi_barang,
            'harga'          => $this->harga,
            'kategori_id'    => $this->kategori_id,
            'user_id'        => Auth::id(),
            // Kalau barang baru, statusnya 'tersedia'. Kalau edit, biarin pake status lamanya.
            'status'         => $this->isEditMode ? $this->status : 'tersedia',
        ];

        if ($this->foto) {
            if ($this->isEditMode && $this->old_foto) {
                Storage::disk('public')->delete($this->old_foto);
            }
            $data['foto'] = $this->foto->store('barangs', 'public');
        }

        Barang::updateOrCreate(['id' => $this->barang_id], $data);

        session()->flash('message', $this->isEditMode ? 'Data barang berhasil diperbarui! 🚀' : 'Barang baru berhasil diposting! 🔥');
        $this->closeModal();
    }

    public function deleteBarang($id)
    {
        $barang = Barang::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        if ($barang->foto) { Storage::disk('public')->delete($barang->foto); }
        $barang->delete();
        session()->flash('message', 'Barang ini udah dihapus');
    }

    public function render()
    {
        return view('livewire.penjual.barang-manager', [
            'kategoris' => Kategori::all(),
            'barangs' => Barang::where('user_id', Auth::id())
                ->where('nama_barang', 'like', '%' . $this->search . '%')
                ->latest()
                ->paginate(5)
        ]);
    }
}