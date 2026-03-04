<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use App\Models\Chat;
use App\Models\Barang;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;

class ChatBox extends Component
{
    #[Url(history: true)]
    public $selectedBarangId = null;

    #[Url(history: true)]
    public $receiverId = null;

    // FUNGSI SEND MESSAGE & LOAD MESSAGE DIHAPUS (Sudah pindah ke JS)

    public function selectChat($barangId, $partnerId)
    {
        $this->selectedBarangId = $barangId;
        $this->receiverId = $partnerId;
        
        // Panggil AlpineJS untuk mulai Load & Polling data
        $this->dispatch('chat-selected', barangId: $barangId, partnerId: $partnerId);
    }

    public function render()
    {
        $myId = Auth::id();

        // Load list sidebar tetap via Livewire
        $conversations = Chat::with(['barang', 'pengirim', 'penerima'])
            ->where(function($query) use ($myId) {
                $query->where('id_pengirim', $myId)
                      ->orWhere('id_penerima', $myId);
            })
            ->latest()
            ->get()
            ->groupBy(function($item) use ($myId) {
                $partnerId = ($item->id_pengirim == $myId) ? $item->id_penerima : $item->id_pengirim;
                return $item->id_barang . '-' . $partnerId;
            });

        $activeBarang = null;
        $activePartner = null;

        if ($this->selectedBarangId && $this->receiverId) {
            $activeBarang = Barang::find($this->selectedBarangId);
            $activePartner = User::find($this->receiverId);
        }

        return view('livewire.chat.chat-box', [
            'conversations' => $conversations,
            'activeBarang'  => $activeBarang,
            'activePartner' => $activePartner
        ]);
    }
}