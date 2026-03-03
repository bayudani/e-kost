<div class="flex-1 p-6 h-[calc(100vh-120px)] bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden"
    x-data="{
        scrollToBottom() {
            setTimeout(() => {
                // Ambil elemen berdasarkan ID langsung, lebih aman dari $refs saat DOM berubah-ubah
                const el = document.getElementById('chat-container');
                if (el) {
                    el.scrollTop = el.scrollHeight;
                }
            }, 100);
        }
    }" 
    x-init="scrollToBottom()" 
    @scroll-to-bottom.window="scrollToBottom()">

    <div class="flex h-full">
        <!-- 📱 SIDEBAR CHAT (LIST) -->
        <div class="w-1/3 border-r border-slate-100 flex flex-col bg-slate-50/50 h-full">
            <div class="p-6 border-b border-slate-100 bg-white">
                <h2 class="text-xl font-black text-slate-800 uppercase italic tracking-tighter">Pesan Saya</h2>
            </div>

            <div class="flex-1 overflow-y-auto">
                @forelse($conversations as $key => $group)
                    @php
                        $lastChat = $group->first();
                        $myId = auth()->id();
                        $partner = $lastChat->id_pengirim == $myId ? $lastChat->penerima : $lastChat->pengirim;
                        $isActive = $selectedBarangId == $lastChat->id_barang && $receiverId == $partner?->id;
                    @endphp

                    @if($partner)
                        <div wire:key="chat-list-{{ $lastChat->id_barang }}-{{ $partner->id }}"
                            wire:click="selectChat({{ $lastChat->id_barang }}, {{ $partner->id }})"
                            class="p-4 flex items-center gap-3 cursor-pointer transition-all border-b border-slate-50
                            {{ $isActive ? 'bg-blue-600 text-white' : 'bg-white hover:bg-slate-100' }}">

                            <div class="h-12 w-12 rounded-full bg-slate-200 flex-shrink-0 flex items-center justify-center font-bold text-slate-500 overflow-hidden border-2 {{ $isActive ? 'border-white/50' : 'border-slate-100' }}">
                                {{ strtoupper(substr($partner->name, 0, 1)) }}
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-baseline">
                                    <h4 class="font-bold text-sm truncate {{ $isActive ? 'text-white' : 'text-slate-800' }}">
                                        {{ $partner->name }}</h4>
                                    <span class="text-[10px] {{ $isActive ? 'text-blue-100' : 'text-slate-400' }}">
                                        {{ $lastChat->created_at->format('H:i') }}
                                    </span>
                                </div>
                                <p class="text-[11px] font-bold opacity-80 uppercase tracking-tighter truncate">
                                    {{ $lastChat->barang?->nama_barang ?? 'Barang Dihapus' }}</p>
                                <p class="text-xs truncate {{ $isActive ? 'text-blue-50' : 'text-slate-500' }}">
                                    {{ $lastChat->pesan }}</p>
                            </div>
                        </div>
                    @endif
                @empty
                    <div class="p-10 text-center text-slate-400">
                        <p class="text-sm font-bold uppercase italic">Belum ada chat bro!</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- 💬 AREA CHAT (MESSAGES) -->
        <div class="flex-1 flex flex-col bg-white h-full relative">
            @if ($selectedBarangId && $receiverId)
                <!-- Header Chat -->
                <div class="p-4 border-b border-slate-100 flex justify-between items-center shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-black">
                            {{ $activePartner ? strtoupper(substr($activePartner->name, 0, 1)) : '?' }}
                        </div>
                        <div>
                            <h3 class="font-black text-slate-800 uppercase tracking-tight">
                                {{ $activePartner?->name ?? 'User Tidak Diketahui' }}
                            </h3>
                            <p class="text-[10px] font-bold text-blue-500 uppercase">Membahas:
                                {{ $activeBarang?->nama_barang ?? 'Barang' }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-black text-slate-800 italic">
                            Rp {{ $activeBarang ? number_format($activeBarang->harga, 0, ',', '.') : '0' }}
                        </p>
                    </div>
                </div>

                <!-- Pesan (Polling seperti project lama) -->
                <div wire:poll.3s
                    id="chat-container"
                    class="flex-1 overflow-y-auto p-6 space-y-4 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] bg-slate-50/30">
                    
                    @foreach ($messages as $msg)
                        <div class="flex {{ $msg->id_pengirim == auth()->id() ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-[70%] px-4 py-2.5 rounded-2xl shadow-sm text-sm font-medium
                                {{ $msg->id_pengirim == auth()->id()
                                    ? 'bg-blue-600 text-white rounded-tr-none'
                                    : 'bg-white text-slate-700 border border-slate-200 rounded-tl-none' }}">
                                {{ $msg->pesan }}
                                <div class="text-[9px] mt-1 text-right opacity-60 font-bold">
                                    {{ $msg->created_at->format('H:i') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Input Box -->
                <div class="p-4 border-t border-slate-100 bg-white">
                    <form wire:submit.prevent="sendMessage" class="flex gap-2">
                        <input type="text" wire:model="pesan"
                            class="flex-1 bg-slate-100 border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 transition-all font-medium"
                            placeholder="Tulis pesan kamu di sini, bro..." required>
                        <button type="submit"
                            class="bg-blue-600 text-white px-6 py-3 rounded-xl font-black uppercase tracking-widest hover:bg-blue-700 transition-all shadow-lg shadow-blue-100">
                            Kirim
                        </button>
                    </form>
                </div>
            @else
                <!-- Placeholder Kalau Belum Pilih Chat -->
                <div class="flex-1 flex flex-col items-center justify-center text-slate-300 h-full">
                    <svg class="w-20 h-20 mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                        </path>
                    </svg>
                    <p class="font-black uppercase italic tracking-widest">Pilih obrolan buat mulai chat bro!</p>
                </div>
            @endif
        </div>
    </div>
</div>