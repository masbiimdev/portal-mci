<style>
    /* Animasi Buka/Tutup Chat Window */
    .chat-window-wrapper {
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        transform-origin: bottom right;
    }

    .chat-window-hidden {
        opacity: 0;
        transform: scale(0.8) translateY(20px);
        pointer-events: none;
    }

    /* Scrollbar minimalis untuk area chat */
    .chat-scroll::-webkit-scrollbar {
        width: 5px;
    }

    .chat-scroll::-webkit-scrollbar-track {
        background: transparent;
    }

    .chat-scroll::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    /* Animasi Loading Typing */
    .typing-dot {
        animation: typing 1.4s infinite ease-in-out both;
        height: 6px;
        width: 6px;
        border-radius: 50%;
        background-color: #94a3b8;
    }

    .typing-dot:nth-child(1) {
        animation-delay: -0.32s;
    }

    .typing-dot:nth-child(2) {
        animation-delay: -0.16s;
    }

    @keyframes typing {

        0%,
        80%,
        100% {
            transform: scale(0);
        }

        40% {
            transform: scale(1);
        }
    }
</style>

<div id="metinca-ai-widget" class="fixed bottom-6 right-6 z-[9999] flex flex-col items-end"
    style="font-family: 'Inter', sans-serif;">

    <div id="ai-chat-window"
        class="chat-window-wrapper chat-window-hidden w-[340px] sm:w-[380px] bg-white rounded-2xl shadow-[0_20px_50px_-12px_rgba(0,0,0,0.25)] border border-slate-200 mb-4 flex flex-col h-[520px] max-h-[80vh] overflow-hidden relative">

        <div
            class="bg-gradient-to-r from-blue-700 to-sky-500 p-4 flex items-center justify-between shadow-md relative z-10">
            <div class="absolute inset-0 opacity-10 pointer-events-none"
                style="background-image: linear-gradient(rgba(255,255,255,0.5) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.5) 1px, transparent 1px); background-size: 10px 10px;">
            </div>

            <div class="flex items-center gap-3 relative z-10">
                <div class="relative">
                    <div class="w-10 h-10 bg-white rounded-xl shadow-inner flex items-center justify-center p-1">
                        <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span
                        class="absolute -bottom-1 -right-1 w-3.5 h-3.5 bg-green-400 border-2 border-white rounded-full"></span>
                </div>
                <div>
                    <h4 class="text-white font-extrabold text-sm tracking-wide">Metinca AI</h4>
                    <p class="text-blue-100 text-[10px] font-bold uppercase tracking-widest">Valve Expert Assistant</p>
                </div>
            </div>

            <button id="close-chat-btn"
                class="text-white/80 hover:text-white bg-white/10 hover:bg-white/20 p-1.5 rounded-lg transition-colors relative z-10">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div id="ai-chat-body" class="flex-1 p-4 overflow-y-auto chat-scroll bg-slate-50 flex flex-col gap-4">
            <div class="text-center">
                <span
                    class="text-[10px] font-bold text-slate-400 uppercase tracking-widest bg-slate-200/50 px-3 py-1 rounded-full">Hari
                    Ini</span>
            </div>

            <div class="flex items-start gap-2.5 max-w-[85%]">
                <div
                    class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center flex-shrink-0 text-blue-600 shadow-sm border border-blue-100">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div
                    class="bg-white p-3 rounded-2xl rounded-tl-none shadow-sm border border-slate-100 text-[13px] text-slate-700 leading-relaxed">
                    Halo! Saya AI Assistant khusus dari PT Metinca. Ada yang bisa saya bantu terkait spesifikasi <span
                        class="font-bold text-blue-600">Industrial Valve</span>, SOP Kalibrasi, atau standar API/ASME
                    hari ini?
                </div>
            </div>
        </div>

        <div class="p-3 bg-white border-t border-slate-100">
            <form id="ai-chat-form" class="flex items-center gap-2 relative">
                <input type="text" id="ai-chat-input" placeholder="Tanya seputar valve..."
                    class="w-full bg-slate-100 border border-transparent rounded-xl pl-4 pr-12 py-3 text-[13px] font-medium focus:ring-0 focus:border-blue-400 focus:bg-white outline-none text-slate-700 placeholder-slate-400 transition-all disabled:opacity-50"
                    autocomplete="off">
                <button type="submit" id="ai-submit-btn"
                    class="absolute right-2 w-8 h-8 bg-blue-600 hover:bg-blue-700 text-white rounded-lg flex items-center justify-center transition-colors shadow-md disabled:opacity-50 disabled:cursor-not-allowed">
                    <svg class="w-4 h-4 translate-x-px -translate-y-px" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z">
                        </path>
                    </svg>
                </button>
            </form>
            <div class="text-center mt-2">
                <span class="text-[9px] text-slate-400 font-medium">Powered by Metinca Knowledge Base</span>
            </div>
        </div>
    </div>

    <button id="open-chat-btn"
        class="w-14 h-14 bg-gradient-to-r from-blue-600 to-sky-500 rounded-full shadow-[0_10px_25px_rgba(37,99,235,0.4)] hover:shadow-[0_10px_35px_rgba(37,99,235,0.6)] hover:-translate-y-1 transition-all duration-300 flex items-center justify-center text-white relative group focus:outline-none">
        <span
            class="absolute inline-flex h-full w-full rounded-full bg-sky-400 opacity-40 group-hover:animate-ping"></span>
        <svg class="w-6 h-6 relative z-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
        </svg>
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const openBtn = document.getElementById('open-chat-btn');
        const closeBtn = document.getElementById('close-chat-btn');
        const chatWindow = document.getElementById('ai-chat-window');
        const chatForm = document.getElementById('ai-chat-form');
        const chatInput = document.getElementById('ai-chat-input');
        const chatBody = document.getElementById('ai-chat-body');
        const submitBtn = document.getElementById('ai-submit-btn');

        // Fungsi Buka / Tutup Chat Window
        const toggleChat = () => {
            chatWindow.classList.toggle('chat-window-hidden');
            if (!chatWindow.classList.contains('chat-window-hidden')) {
                setTimeout(() => chatInput.focus(), 300); // Fokus ke input setelah animasi
            }
        };

        openBtn.addEventListener('click', toggleChat);
        closeBtn.addEventListener('click', toggleChat);

        // Proses Kirim Pesan
        chatForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const message = chatInput.value.trim();
            if (!message) return;

            // Kunci input agar tidak di-spam
            chatInput.disabled = true;
            submitBtn.disabled = true;

            // 1. Munculkan Pesan User
            const userHtml = `
                <div class="flex items-end justify-end gap-2.5 w-full mt-2">
                    <div class="bg-blue-600 text-white p-3 rounded-2xl rounded-tr-none shadow-sm text-[13px] leading-relaxed max-w-[85%]">
                        ${escapeHtml(message)}
                    </div>
                </div>
            `;
            chatBody.insertAdjacentHTML('beforeend', userHtml);
            chatInput.value = '';
            scrollToBottom();

            // 2. Munculkan Animasi Titik-Titik (Mengetik)
            const typingId = 'typing-' + Date.now();
            const typingHtml = `
                <div id="${typingId}" class="flex items-start gap-2.5 max-w-[85%] mt-2">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center flex-shrink-0 text-blue-600 shadow-sm border border-blue-100">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div class="bg-white p-4 rounded-2xl rounded-tl-none shadow-sm border border-slate-100 flex items-center gap-1.5 h-10">
                        <div class="typing-dot"></div><div class="typing-dot"></div><div class="typing-dot"></div>
                    </div>
                </div>
            `;
            chatBody.insertAdjacentHTML('beforeend', typingHtml);
            scrollToBottom();

            // 3. Tembak ke Backend API Laravel
            fetch('/api/ai-chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Token CSRF Laravel
                    },
                    body: JSON.stringify({
                        message: message
                    })
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById(typingId).remove(); // Hapus animasi mengetik

                    let botMessage = "Maaf, terjadi kesalahan.";
                    if (data.status === 'success') {
                        // Konversi format Markdown ke HTML (Tebal & Baris baru)
                        botMessage = data.reply
                            .replace(/\*\*(.*?)\*\*/g, '<b>$1</b>')
                            .replace(/\n/g, '<br>');
                    } else {
                        botMessage = data.reply;
                    }

                    const botHtml = `
                    <div class="flex items-start gap-2.5 max-w-[85%] mt-2">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center flex-shrink-0 text-blue-600 shadow-sm border border-blue-100">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <div class="bg-white p-3 rounded-2xl rounded-tl-none shadow-sm border border-slate-100 text-[13px] text-slate-700 leading-relaxed">
                            ${botMessage}
                        </div>
                    </div>
                `;
                    chatBody.insertAdjacentHTML('beforeend', botHtml);

                    // Buka kunci input
                    chatInput.disabled = false;
                    submitBtn.disabled = false;
                    chatInput.focus();
                    scrollToBottom();
                })
                .catch(error => {
                    document.getElementById(typingId).remove();
                    const errorHtml = `
                    <div class="text-center mt-2">
                        <span class="text-xs text-red-500 bg-red-50 px-3 py-1 rounded-full border border-red-200">Gagal terhubung ke server AI.</span>
                    </div>`;
                    chatBody.insertAdjacentHTML('beforeend', errorHtml);

                    // Buka kunci input
                    chatInput.disabled = false;
                    submitBtn.disabled = false;
                    scrollToBottom();
                });
        });

        // Fungsi Auto-Scroll
        function scrollToBottom() {
            chatBody.scrollTo({
                top: chatBody.scrollHeight,
                behavior: 'smooth'
            });
        }

        // Anti-XSS (Cegah user memasukkan tag HTML berbahaya)
        function escapeHtml(text) {
            return text.replace(/[&<>"']/g, function(m) {
                return {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                } [m];
            });
        }
    });
</script>
