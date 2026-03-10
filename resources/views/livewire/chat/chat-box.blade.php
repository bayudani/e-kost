<!-- PERBAIKAN: Layout dipecah jadi 2 Card terpisah (Desktop) -->
<div class="flex-1 p-0 md:p-6 h-[100dvh] md:h-[calc(100vh-80px)] max-w-7xl mx-auto w-full"
    x-data="chatApp"
    x-init="initChat('{{ $selectedBarangId }}', '{{ $receiverId }}')">

    <!-- Kontainer Grid dengan Gap -->
    <div class="flex flex-col md:flex-row h-full md:gap-6 relative">
        
        <!-- 📱 CARD 1: SIDEBAR CHAT (LIST) -->
        <div class="w-full md:w-[35%] lg:w-1/3 bg-white md:rounded-2xl md:shadow-sm md:border border-slate-200 flex-col h-full overflow-hidden {{ ($selectedBarangId && $receiverId) ? 'hidden md:flex' : 'flex' }}">
            
            <!-- Header List Chat -->
            <div class="px-5 py-5 border-b border-slate-100 bg-slate-50/80 sticky top-0 z-10 flex-shrink-0">
                <h2 class="text-lg font-bold text-slate-800 tracking-tight">
                    {{ auth()->user()->role === 'penjual' ? 'Pesan Pelanggan' : 'Chat Penjual' }}
                </h2>
                <p class="text-[11px] font-medium text-slate-500 mt-0.5">
                    {{ auth()->user()->role === 'penjual' ? 'Komunikasi dengan pembeli' : 'Komunikasi dengan penjual' }}
                </p>
            </div>

            <!-- List Obrolan -->
            <div class="flex-1 overflow-y-auto custom-scrollbar bg-white">
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
                            {{ $isActive ? 'bg-blue-50/80 border-l-4 border-blue-600' : 'bg-white border-l-4 border-transparent hover:bg-slate-50' }}">

                            <!-- Avatar Profile -->
                            <div class="relative h-12 w-12 rounded-full bg-gradient-to-br from-slate-100 to-slate-200 flex-shrink-0 flex items-center justify-center font-bold text-slate-600 shadow-inner border border-slate-200">
                                {{ strtoupper(substr($partner->name, 0, 1)) }}
                                
                                @if($hasUnread && !$isActive)
                                    <span class="absolute -top-0.5 -right-0.5 w-3.5 h-3.5 bg-red-500 border-2 border-white rounded-full animate-pulse shadow-sm"></span>
                                @endif
                            </div>

                            <!-- Info Chat Pendek -->
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-baseline mb-0.5">
                                    <h4 class="font-bold text-sm truncate {{ $isActive ? 'text-blue-800' : 'text-slate-800' }} {{ $hasUnread && !$isActive ? 'text-blue-600' : '' }}">
                                        {{ $partner->name }}
                                    </h4>
                                    <span class="text-[10px] {{ $isActive ? 'text-blue-600 font-semibold' : 'text-slate-400' }} {{ $hasUnread && !$isActive ? 'font-bold text-red-500' : '' }}">
                                        {{ $lastChat->created_at->format('H:i') }}
                                    </span>
                                </div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest truncate mb-1">
                                    {{ $lastChat->barang?->nama_barang ?? 'Barang Dihapus' }}
                                </p>
                                <div class="flex justify-between items-center">
                                    <p class="text-xs truncate {{ $isActive ? 'text-blue-700' : 'text-slate-500' }} {{ $hasUnread && !$isActive ? 'font-bold text-slate-800' : '' }}">
                                        {{ $lastChat->pesan }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    @endif
                @empty
                    <div class="p-10 flex flex-col items-center justify-center text-center h-full text-slate-400 opacity-80">
                        <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        <p class="text-sm font-semibold">Belum ada obrolan.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- 💬 CARD 2: AREA CHAT (MESSAGES) -->
        <div class="flex-1 w-full md:w-[65%] lg:w-2/3 bg-white md:rounded-2xl md:shadow-sm md:border border-slate-200 flex-col h-full overflow-hidden relative {{ ($selectedBarangId && $receiverId) ? 'flex' : 'hidden md:flex' }}" wire:ignore.self>
            
            <!-- ANIMASI LOADING (Overlay Mulus) -->
            <div wire:loading class="absolute inset-0 bg-white/60 z-50 flex flex-col items-center justify-center backdrop-blur-sm">
                <div class="w-10 h-10 border-4 border-blue-500 border-t-transparent rounded-full animate-spin mb-3 shadow-md"></div>
                <p class="font-bold text-blue-600 animate-pulse text-[11px] uppercase tracking-widest">Memuat Pesan...</p>
            </div>

            @if ($selectedBarangId && $receiverId)
                <!-- Header Ruang Obrolan -->
                <div class="px-5 py-4 border-b border-slate-100 flex justify-between items-center bg-white shadow-sm flex-shrink-0 z-10">
                    <div class="flex items-center gap-3 md:gap-4">
                        
                        <!-- Tombol Back HP (Kembali ke List URL Kosong) -->
                        <a href="{{ url()->current() }}" wire:navigate class="md:hidden p-2 -ml-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </a>

                        <div class="h-11 w-11 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-lg flex-shrink-0 border border-blue-200 shadow-inner">
                            {{ $activePartner ? strtoupper(substr($activePartner->name, 0, 1)) : '?' }}
                        </div>
                        <div class="min-w-0">
                            <h3 class="font-bold text-slate-800 tracking-tight truncate text-sm md:text-base mb-0.5">
                                {{ $activePartner?->name ?? 'User Tidak Diketahui' }}
                            </h3>
                            <p class="text-[10px] font-bold text-blue-500 uppercase tracking-wider truncate flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                                {{ $activeBarang?->nama_barang ?? 'Barang' }}
                            </p>
                        </div>
                    </div>
                    <div class="text-right flex-shrink-0 ml-3">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Harga</p>
                        <p class="text-sm md:text-base font-black text-blue-600 tracking-tight">
                            Rp {{ $activeBarang ? number_format($activeBarang->harga, 0, ',', '.') : '0' }}
                        </p>
                    </div>
                </div>

                <!-- Area Looping Pesan (Background dengan Pattern Halus) -->
                <div id="chat-container" class="flex-1 overflow-y-auto p-4 md:p-6 space-y-4 bg-slate-50/50 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] custom-scrollbar">
                    <template x-for="msg in messages" :key="msg.id">
                        <div class="flex" :class="msg.id_pengirim == myId ? 'justify-end' : 'justify-start'">
                            
                            <!-- Bubble Chat Modern -->
                            <div class="max-w-[85%] md:max-w-[70%] px-4 py-2.5 shadow-sm text-sm"
                                 :class="msg.id_pengirim == myId ? 'bg-blue-600 text-white rounded-2xl rounded-tr-sm' : 'bg-white text-slate-700 border border-slate-200 rounded-2xl rounded-tl-sm'">
                                <span x-text="msg.pesan" class="break-words leading-relaxed font-medium"></span>
                                <div class="text-[10px] mt-1 text-right font-semibold flex items-center justify-end gap-1"
                                     :class="msg.id_pengirim == myId ? 'text-blue-200' : 'text-slate-400'">
                                    <span x-text="msg.time"></span>
                                    <template x-if="msg.id_pengirim == myId">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Kotak Input Premium -->
                <div class="p-3 md:p-4 border-t border-slate-100 bg-white flex-shrink-0">
                    <div class="flex items-center gap-2 sm:gap-3 bg-slate-50 border border-slate-200 rounded-2xl p-1.5 focus-within:ring-2 focus-within:ring-blue-500/20 focus-within:border-blue-400 transition-all">
                        <input type="text" x-model="pesanText" @keydown.enter.prevent="kirimPesanJS()"
                            class="flex-1 bg-transparent border-none px-4 py-2.5 text-sm focus:ring-0 text-slate-800 font-medium placeholder-slate-400"
                            placeholder="Ketik pesan Anda di sini...">
                        <button type="button" @click.prevent="kirimPesanJS()"
                            class="bg-blue-600 hover:bg-blue-700 text-white p-3 sm:px-6 rounded-xl font-bold uppercase tracking-wider transition-all shadow-sm flex items-center justify-center flex-shrink-0 disabled:opacity-50"
                            :disabled="pesanText.trim() === ''">
                            <span class="hidden sm:block text-xs">Kirim</span>
                            <svg class="w-5 h-5 sm:hidden -ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        </button>
                    </div>
                </div>
            @else
                <!-- Tampilan Empty State Kalau Belum Pilih Chat -->
                <div class="flex-1 flex flex-col items-center justify-center text-slate-400 h-full bg-slate-50/30">
                    <div class="w-24 h-24 bg-white rounded-full shadow-sm flex items-center justify-center mb-5 border border-slate-100">
                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-700 mb-1">Mulai Obrolan</h3>
                    <p class="font-medium text-sm text-slate-500">Pilih salah satu chat di samping untuk mulai membalas.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Logika JS Alpine -->
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