<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User as UserModel; 

class User extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    // Properti buat ngatur state Modal dan Form
    public $isEditModalOpen = false;
    public $user_id;
    public $name;
    public $email;
    public $role;

    /**
     * Buka modal dan isi form dengan data user yang mau diedit
     */
    public function editUser($id)
    {
        $user = UserModel::findOrFail($id);
        
        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;

        $this->isEditModalOpen = true; // Buka modalnya bro!
    }

    /**
     * Proses update data ke database
     */
    public function updateUser()
    {
        // Validasi inputan dulu biar aman dari error
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->user_id,
            'role' => 'required|in:admin,penjual,pembeli',
        ]);

        // Cari user-nya, terus update datanya
        $user = UserModel::findOrFail($this->user_id);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ]);

        // Tutup modal & kasih notif sukses
        $this->closeModal();
        session()->flash('message', 'Mantap! Data user berhasil di-update bro! 🚀');
    }

    /**
     * Tutup modal dan bersihin sisa inputan
     */
    public function closeModal()
    {
        $this->isEditModalOpen = false;
        $this->reset(['user_id', 'name', 'email', 'role']);
        $this->resetValidation(); // Ilangin pesan error validasi (kalau ada)
    }

    /**
     * Fungsi hapus user (Yang kemaren udah kita buat)
     */
    public function deleteUser($id)
    {
        $user = UserModel::find($id);
        
        if ($user) {
            $user->delete();
            session()->flash('message', 'Data user berhasil dihapus, bro!');
        }
    }

    public function render()
    {
        $users = UserModel::latest()->paginate(10);

        return view('livewire.admin.user', [
            'users' => $users
        ]);
    }
}