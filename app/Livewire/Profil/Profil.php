<?php

namespace App\Livewire\Profil;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Profil extends Component
{
    public $name;
    public $email;
    public $no_hp;
    public $nama_bank;
    public $no_rekening;
    public $atas_nama;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->no_hp = $user->no_hp;
        $this->nama_bank = $user->nama_bank;
        $this->no_rekening = $user->no_rekening;
        $this->atas_nama = $user->atas_nama;
    }

    public function simpanProfil()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'nama_bank' => 'nullable|string|max:50',
            'no_rekening' => 'nullable|string|max:50',
            'atas_nama' => 'nullable|string|max:100',
        ]);

        $user = Auth::user();
        $user->update([
            'name' => $this->name,
            'no_hp' => $this->no_hp,
            'nama_bank' => $this->nama_bank,
            'no_rekening' => $this->no_rekening,
            'atas_nama' => $this->atas_nama,
        ]);

        session()->flash('message', 'Mantap! Profil berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.profil.profil');
    }
}