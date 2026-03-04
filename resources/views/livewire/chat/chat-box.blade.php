<!-- PERBAIKAN: Margin & Padding HP disesuaikan agar full screen -->
<div class="flex-1 p-0 md:p-6 h-[calc(100vh-100px)] md:h-[calc(100vh-120px)] bg-white md:rounded-3xl shadow-sm border-t md:border border-slate-200 overflow-hidden"
    x-data="chatApp"
    x-init="initChat('{{ $selectedBarangId }}', '{{ $receiverId }}')">

    <div class="flex h-full">
        <!-- 📱 SIDEBAR CHAT (LIST) -->
        <!-- PERBAIKAN: Sembunyikan List di HP jika ada chat yang sedang aktif -->
        <div class="w-full md:w-1/3 border-r border-slate-100 flex-col bg-slate-50/50 h-full relative {{ ($selectedBarangId && $receiverId) ? 'hidden md:flex' : 'flex' }}">
            <div class="p-6 border-b border-slate-100 bg-white sticky top-0 z-10">
                <h2 class="text-xl font-black text-slate-800 uppercase italic tracking-tighter">Pesan Saya</h2>
            </div>

            <div class="flex-1 overflow-y-auto">
                @forelse($conversations as $key => $group)
                    @php
                        $lastChat = $group->first();
                        $myId = auth()->id();
                        $partner = $lastChat->id_pengirim == $myId ? $lastChat->penerima : $lastChat->pengirim;
                        $isActive = ($selectedBarangId == $lastChat->id_barang && $receiverId == optional($partner)->id);
                        
                        // Logika Unread (titik merah)
                        $hasUnread = $lastChat->id_pengirim != $myId && !$lastChat->is_read;
                    @endphp

                    @if($partner)
                        <a wire:key="chat-list-{{ $lastChat->id_barang }}-{{ $partner->id }}"
                            href="?selectedBarangId={{ $lastChat->id_barang }}&receiverId={{ $partner->id }}"
                            wire:navigate
                            class="block p-4 flex items-center gap-3 cursor-pointer transition-all border-b border-slate-50 relative
                            {{ $isActive ? 'bg-blue-600 text-white' : 'bg-white hover:bg-slate-100' }}">

                            <div class="relative h-12 w-12 rounded-full bg-slate-200 flex-shrink-0 flex items-center justify-center font-bold text-slate-500 overflow-hidden border-2 {{ $isActive ? 'border-white/50' : 'border-slate-100' }}">
                                {{ strtoupper(substr($partner->name, 0, 1)) }}
                                
                                @if($hasUnread && !$isActive)
                                    <span class="absolute top-0 right-0 w-3 h-3 bg-red-500 border-2 border-white rounded-full animate-pulse"></span>
                                @endif
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-baseline">
                                    <h4 class="font-bold text-sm truncate {{ $isActive ? 'text-white' : 'text-slate-800' }} {{ $hasUnread && !$isActive ? 'text-blue-600' : '' }}">
                                        {{ $partner->name }}</h4>
                                    <span class="text-[10px] {{ $isActive ? 'text-blue-100' : 'text-slate-400' }} {{ $hasUnread && !$isActive ? 'font-bold text-red-500' : '' }}">
                                        {{ $lastChat->created_at->format('H:i') }}
                                    </span>
                                </div>
                                <p class="text-[11px] font-bold opacity-80 uppercase tracking-tighter truncate">
                                    {{ $lastChat->barang?->nama_barang ?? 'Barang Dihapus' }}</p>
                                <div class="flex justify-between items-center">
                                    <p class="text-xs truncate {{ $isActive ? 'text-blue-50' : 'text-slate-500' }} {{ $hasUnread && !$isActive ? 'font-semibold text-slate-800' : '' }}">
                                        {{ $lastChat->pesan }}</p>
                                    
                                    @if($hasUnread && !$isActive)
                                        <div class="w-2 h-2 bg-red-500 rounded-full flex-shrink-0 ml-2"></div>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endif
                @empty
                    <div class="p-10 text-center text-slate-400">
                        <p class="text-sm font-bold uppercase italic">Belum ada chat!</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- 💬 AREA CHAT (MESSAGES) -->
        <!-- PERBAIKAN: Sembunyikan Pesan di HP jika belum memilih chat -->
        <div class="flex-1 w-full md:w-2/3 flex-col bg-white h-full relative {{ ($selectedBarangId && $receiverId) ? 'flex' : 'hidden md:flex' }}" wire:ignore.self>
            
            <!-- ANIMASI LOADING -->
            <div wire:loading class="absolute inset-0 bg-white/70 z-50 flex flex-col items-center justify-center backdrop-blur-sm">
                <div class="w-12 h-12 border-4 border-blue-500 border-t-transparent rounded-full animate-spin mb-3"></div>
                <p class="font-bold text-blue-600 animate-pulse text-sm uppercase tracking-widest">Membuka Obrolan...</p>
            </div>

            @if ($selectedBarangId && $receiverId)
                <!-- Header Chat -->
                <div class="p-4 border-b border-slate-100 flex justify-between items-center shadow-sm">
                    <div class="flex items-center gap-2 md:gap-3">
                        
                        <!-- PERBAIKAN: TOMBOL BACK KHUSUS MOBILE UNTUK KEMBALI KE LIST CHAT -->
                        <a href="{{ url()->current() }}" wire:navigate class="md:hidden p-2 -ml-2 text-slate-500 hover:text-slate-800 bg-slate-50 hover:bg-slate-100 rounded-full transition-colors mr-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </a>

                        <div class="h-10 w-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-black flex-shrink-0">
                            {{ $activePartner ? strtoupper(substr($activePartner->name, 0, 1)) : '?' }}
                        </div>
                        <div class="min-w-0">
                            <h3 class="font-black text-slate-800 uppercase tracking-tight truncate text-sm md:text-base">
                                {{ $activePartner?->name ?? 'User Tidak Diketahui' }}
                            </h3>
                            <p class="text-[10px] font-bold text-blue-500 uppercase truncate">Membahas:
                                {{ $activeBarang?->nama_barang ?? 'Barang' }}</p>
                        </div>
                    </div>
                    <div class="text-right flex-shrink-0 ml-2">
                        <p class="text-xs md:text-sm font-black text-slate-800 italic">
                            Rp {{ $activeBarang ? number_format($activeBarang->harga, 0, ',', '.') : '0' }}
                        </p>
                    </div>
                </div>

                <!-- Area Looping Pesan pakai AlpineJS -->
                <div id="chat-container" class="flex-1 overflow-y-auto p-4 md:p-6 space-y-4 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] bg-slate-50/30">
                    <template x-for="msg in messages" :key="msg.id">
                        <div class="flex" :class="msg.id_pengirim == myId ? 'justify-end' : 'justify-start'">
                            <div class="max-w-[85%] md:max-w-[70%] px-4 py-2.5 rounded-2xl shadow-sm text-sm font-medium"
                                 :class="msg.id_pengirim == myId ? 'bg-blue-600 text-white rounded-tr-none' : 'bg-white text-slate-700 border border-slate-200 rounded-tl-none'">
                                <span x-text="msg.pesan" class="break-words"></span>
                                <div class="text-[9px] mt-1 text-right opacity-60 font-bold" x-text="msg.time"></div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Kotak Input AlpineJS murni -->
                <div class="p-3 md:p-4 border-t border-slate-100 bg-white">
                    <div class="flex gap-2">
                        <input type="text" x-model="pesanText" @keydown.enter.prevent="kirimPesanJS()"
                            class="flex-1 bg-slate-100 border-none rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 transition-all font-medium"
                            placeholder="Ketik pesan...">
                        <button type="button" @click.prevent="kirimPesanJS()"
                            class="bg-blue-600 text-white px-5 md:px-6 py-3 rounded-xl font-black uppercase tracking-widest hover:bg-blue-700 transition-all shadow-lg shadow-blue-100 flex-shrink-0">
                            <!-- Sembunyikan tulisan 'Kirim' di HP terkecil jika perlu, gunakan ikon pesawat kertas -->
                            <span class="hidden sm:inline">Kirim</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:hidden" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                            </svg>
                        </button>
                    </div>
                </div>
            @else
                <!-- Tampilan Kalau Belum Pilih Chat (Hanya tampil di Desktop/Tablet) -->
                <div class="flex-1 flex flex-col items-center justify-center text-slate-300 h-full">
                    <svg class="w-20 h-20 mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <p class="font-black uppercase italic tracking-widest text-center px-6">Pilih obrolan buat mulai chat!</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Logika JS Alpine (Sama seperti sebelumnya) -->
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('chatApp', () => ({
            pesanText: '',
            messages: [],
            barangId: null,
            partnerId: null,
            myId: {{ auth()->id() }},
            polling: null,

            initChat(bId, pId) {
                if(bId && pId) {
                    this.changeChat(bId, pId);
                }
            },

            changeChat(bId, pId) {
                if (this.barangId == bId && this.partnerId == pId && this.messages.length > 0) {
                    return; 
                }

                this.barangId = bId;
                this.partnerId = pId;
                this.messages = [];
                this.loadMessages();

                if(this.polling) clearInterval(this.polling);
                this.polling = setInterval(() => {
                    this.loadMessages();
                }, 3000); 
            },

            loadMessages() {
                if(!this.barangId || !this.partnerId) return;

                fetch(`/api/chat/fetch?barang_id=${this.barangId}&receiver_id=${this.partnerId}`)
                    .then(res => res.json())
                    .then(data => {
                        let oldLen = this.messages.length;
                        this.messages = data;
                        
                        if(data.length > oldLen) {
                            this.scrollToBottom();
                        }
                    })
                    .catch(err => console.error("Gagal ambil pesan:", err));
            },

            kirimPesanJS() {
                if(this.pesanText.trim() === '') return;
                
                let text = this.pesanText;
                this.pesanText = ''; 

                this.messages.push({
                    id: 'temp-' + Date.now(),
                    id_pengirim: this.myId,
                    pesan: text,
                    time: new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })
                });
                this.scrollToBottom();

                let token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                fetch('/api/chat/send', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({
                        pesan: text,
                        barang_id: this.barangId,
                        receiver_id: this.partnerId
                    })
                })
                .then(res => res.json())
                .then(data => {
                    this.loadMessages();
                })
                .catch(err => console.error("Gagal kirim pesan:", err));
            },

            scrollToBottom() {
                setTimeout(() => {
                    const el = document.getElementById('chat-container');
                    if (el) {
                        el.scrollTop = el.scrollHeight;
                    }
                }, 100);
            }
        }));
    });
</script>