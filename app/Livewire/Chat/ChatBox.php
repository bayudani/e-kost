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
    public $selectedBarangId;

    #[Url(history: true)]
    public $receiverId;

    public $pesan;

    public function sendMessage()
    {
        $this->validate([
            'pesan' => 'required|string|max:1000',
        ]);

        if (!$this->receiverId || !$this->selectedBarangId) {
            return;
        }

        Chat::create([
            'id_pengirim' => Auth::id(),
            'id_penerima' => $this->receiverId,
            'id_barang'   => $this->selectedBarangId,
            'pesan'       => $this->pesan,
        ]);

        $this->reset('pesan');
        
        // Scroll ke bawah (pake event window buat ditangkap Alpine)
        $this->dispatch('scroll-to-bottom');
    }

    public function selectChat($barangId, $partnerId)
    {
        $this->selectedBarangId = $barangId;
        $this->receiverId = $partnerId;
        $this->dispatch('scroll-to-bottom');
    }

    // Dummy method agar wire:poll punya target yang ringan tanpa nge-reload hal ga perlu
    public function loadMessages()
    {
        // Fitur re-render native dari livewire otomatis berjalan.
    }

    public function render()
    {
        $myId = Auth::id();

        // Diperbaiki logic 'where' nya pakai closure (grouping sql) agar aman.
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

        $messages = [];
        $activeBarang = null;
        $activePartner = null;

        if ($this->selectedBarangId && $this->receiverId) {
            $messages = Chat::where('id_barang', $this->selectedBarangId)
                ->where(function($q) use ($myId) {
                    $q->where(function($q2) {
                        $q2->where('id_pengirim', Auth::id())
                           ->where('id_penerima', $this->receiverId);
                    })->orWhere(function($q2) {
                        $q2->where('id_pengirim', $this->receiverId)
                           ->where('id_penerima', Auth::id());
                    });
                })
                ->oldest()
                ->get();

            $activeBarang = Barang::find($this->selectedBarangId);
            $activePartner = User::find($this->receiverId);
        }

        return view('livewire.chat.chat-box', [
            'conversations' => $conversations,
            'messages'      => $messages,
            'activeBarang'  => $activeBarang,
            'activePartner' => $activePartner
        ]);
    }
}