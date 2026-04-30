<?php

namespace App\Livewire\Admin;

use App\Models\User as UserModel;
use Livewire\Component;
use Livewire\WithPagination;

class User extends Component
{
    use WithPagination;
    
    protected $paginationTheme = 'tailwind';

    // State untuk Modal View
    public $isViewModalOpen = false;
    
    // Properties user
    public $user_id, $name, $email, $role;
    // Properties tambahan khusus penjual
    public $no_hp, $nama_bank, $no_rekening, $atas_nama;

    /**
     * Buka modal untuk melihat detail pengguna (Read-Only)
     */
    public function viewUser($id)
    {
        $user = UserModel::findOrFail($id);
        
        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        
        // Data rekening
        $this->no_hp = $user->no_hp;
        $this->nama_bank = $user->nama_bank;
        $this->no_rekening = $user->no_rekening;
        $this->atas_nama = $user->atas_nama;

        $this->isViewModalOpen = true;
    }

    public function deleteUser($id)
    {
        // Jangan biarkan admin menghapus dirinya sendiri (opsional tapi best practice)
        if (auth()->id() == $id) {
            session()->flash('message', 'Tidak dapat menghapus akun Anda sendiri.');
            return;
        }

        User::findOrFail($id)->delete();
        session()->flash('message', 'Pengguna berhasil dihapus.');
    }

    public function closeModal()
    {
        $this->isViewModalOpen = false;
        $this->reset(['user_id', 'name', 'email', 'role', 'no_hp', 'nama_bank', 'no_rekening', 'atas_nama']);
    }

    public function render()
    {
        return view('livewire.admin.user', [
            'users' => UserModel::latest()->paginate(10)
        ]);
    }
}