@extends('layouts.home')

@section('title', 'Detail Pengumuman | MCI')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="flex flex-wrap items-center text-sm text-gray-500 space-x-2">
                <li>
                    <a href="{{ route('home') }}" class="flex items-center text-blue-600 hover:underline">
                        <i class="bx bx-home-alt mr-1"></i> Home
                    </a>
                </li>
                <li>/</li>
                <li class="text-gray-400">Detail</li>
            </ol>
        </nav>


        <div class="md:flex md:space-x-6 gap-6">
            {{-- Kiri: Detail Pengumuman --}}
            <div class="md:w-1/2 bg-white shadow rounded-xl p-6 md:p-8 mb-6 md:mb-0">
                {{-- Judul --}}
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">{{ $announcement->title }}</h2>

                {{-- Info --}}
                <div class="flex flex-wrap gap-2 mb-4">
                    <!-- Jenis -->
                    <span class="flex items-center px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-800">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M4 3h12v2H4V3zM4 7h12v2H4V7zM4 11h12v2H4v-2z" />
                        </svg>
                        Jenis: {{ ucfirst($announcement->type) }}
                    </span>

                    <!-- Departemen -->
                    <span class="flex items-center px-3 py-1 text-sm rounded-full bg-gray-100 text-gray-800">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M6 2h8v2H6V2zM3 6h14v2H3V6zM6 10h8v2H6v-2z" />
                        </svg>
                        Departemen: {{ $announcement->department ?? 'Semua' }}
                    </span>

                    <!-- Prioritas -->
                    @php
                        $priorityColors = [
                            'low' => 'bg-green-200 text-green-800',
                            'medium' => 'bg-yellow-200 text-yellow-800',
                            'high' => 'bg-red-200 text-red-800',
                        ];
                    @endphp
                    <span class="flex items-center px-3 py-1 text-sm rounded-full bg-gray-100 text-gray-800">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5 9l4-4 4 4H5z" />
                        </svg>
                        Prioritas:
                        <span
                            class="ml-2 px-2 py-1 rounded-full {{ $priorityColors[$announcement->priority] ?? 'bg-gray-200 text-gray-800' }}">
                            {{ ucfirst($announcement->priority) }}
                        </span>
                    </span>

                    <!-- Status -->
                    <span
                        class="flex items-center px-3 py-1 text-sm rounded-full {{ $announcement->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-500' }}">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            @if ($announcement->is_active)
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3-9l-4 4-2-2 1.414-1.414L9 10.586l2.586-2.586L13 9z"
                                    clip-rule="evenodd" />
                            @else
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-2-9h4v2H8V9z"
                                    clip-rule="evenodd" />
                            @endif
                        </svg>
                        {{ $announcement->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>


                {{-- Info Tanggal & Author --}}
                <div class="text-gray-700 text-sm mb-6 space-y-2">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a8 8 0 100 16 8 8 0 000-16zm1 11H9v-2h2v2zm0-4H9V5h2v4z" />
                        </svg>
                        <span>Dibuat oleh: <span
                                class="font-medium text-gray-800">{{ $announcement->author->name ?? 'Admin' }}</span></span>
                    </div>

                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M6 2a1 1 0 00-1 1v1H3a1 1 0 000 2h2v1a1 1 0 102 0V6h6v1a1 1 0 102 0V6h2a1 1 0 100-2h-2V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1z" />
                        </svg>
                        <span>Tanggal dibuat: <span
                                class="font-medium text-gray-800">{{ $announcement->created_at->translatedFormat('d M Y, H:i') }}</span></span>
                    </div>

                    @if ($announcement->expiry_date)
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M6 2a1 1 0 00-1 1v1H3a1 1 0 000 2h2v1a1 1 0 102 0V6h6v1a1 1 0 102 0V6h2a1 1 0 100-2h-2V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1z" />
                            </svg>
                            <span>Berlaku hingga: <span
                                    class="font-medium text-red-600">{{ \Carbon\Carbon::parse($announcement->expiry_date)->translatedFormat('d M Y') }}</span></span>
                        </div>
                    @endif
                </div>

                {{-- Konten --}}
                <div class="text-gray-700 leading-relaxed mb-6">
                    {!! nl2br(e($announcement->content)) !!}
                </div>

                {{-- Kembali --}}
                <a href="{{ route('announcements.index') }}"
                    class="inline-block px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition mt-4">
                    ← Kembali
                </a>
            </div>

            {{-- Kanan: Preview PDF --}}
            @if ($announcement->attachment && Str::endsWith($announcement->attachment, '.pdf'))
                <div class="md:w-1/2 h-[600px] bg-white shadow rounded-xl overflow-hidden flex flex-col">
                    <!-- PDF iframe -->
                    <iframe id="pdfIframe" src="{{ asset('storage/' . $announcement->attachment) }}" class="w-full flex-1"
                        frameborder="0"></iframe>

                    <!-- Tombol Fullscreen di bawah -->
                    <div class="p-2 text-center bg-gray-100">
                        <button id="fullscreenBtn" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Fullscreen
                        </button>
                    </div>
                </div>

                <script>
                    const fullscreenBtn = document.getElementById('fullscreenBtn');
                    const pdfIframe = document.getElementById('pdfIframe');

                    fullscreenBtn.addEventListener('click', () => {
                        if (pdfIframe.requestFullscreen) {
                            pdfIframe.requestFullscreen();
                        } else if (pdfIframe.webkitRequestFullscreen) {
                            /* Safari */
                            pdfIframe.webkitRequestFullscreen();
                        } else if (pdfIframe.msRequestFullscreen) {
                            /* IE11 */
                            pdfIframe.msRequestFullscreen();
                        }
                    });
                </script>
            @endif

        </div>
    </div>
@endsection
