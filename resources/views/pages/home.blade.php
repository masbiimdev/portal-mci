@extends('layouts.home')
@section('title')
    Home Page | Portal MCI
@endsection
@section('content')
    <!-- Header Mini -->
    <section class="py-6 bg-gradient-to-r from-blue-600 via-indigo-600 to-blue-700 text-white animate-gradient">
        <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-wide">Selamat Datang di Portal MCI 👋</h1>
                <p id="tanggal" class="text-xs text-blue-100 mt-1"></p>
            </div>
            <div class="text-right mt-4 md:mt-0">
                <p class="text-3xl font-semibold" id="suhu"></p>
                <p id="cuaca" class="text-[10px] text-blue-100 inline-flex items-center gap-1"></p>
            </div>
        </div>
    </section>

    <!-- Pengumuman Terbaru -->
    <!-- Pengumuman Terbaru -->
    <section class="py-12 bg-gray-50 border-b animate-fadein">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-xl font-bold mb-6 text-gray-800">📢 Pengumuman Terbaru</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

                @php
                    $borderColors = [
                        'high' => 'border-red-500',
                        'medium' => 'border-yellow-500',
                        'low' => 'border-blue-500',
                    ];

                    $bgColors = [
                        'high' => 'bg-red-600 hover:bg-red-700',
                        'medium' => 'bg-yellow-500 hover:bg-yellow-600',
                        'low' => 'bg-blue-600 hover:bg-blue-700',
                    ];
                @endphp

                @forelse ($announcements as $item)
                    <div
                        class="bg-white p-6 rounded-xl shadow {{ $borderColors[$item->priority] ?? 'border-blue-500' }} border-l-4 hover:shadow-lg transition transform hover:-translate-y-1">
                        <h3 class="font-semibold text-lg mb-2 text-gray-800">{{ $item->title }}</h3>
                        <p class="text-sm text-gray-600 mb-3">
                            {{ Str::limit($item->content, 100, '...') }}
                        </p>
                        <p class="text-xs text-gray-400 mb-1">Dibuat oleh: {{ $item->author->name ?? 'Admin' }}</p>
                        @if ($item->expiry_date)
                            <p class="text-xs text-gray-400 mb-4">
                                Berlaku sampai: {{ \Carbon\Carbon::parse($item->expiry_date)->translatedFormat('d M Y') }}
                            </p>
                        @endif
                        <a href="{{ route('announcements.show', $item->id) }}"
                            class="inline-block px-4 py-2 text-sm font-medium text-white rounded-lg transition {{ $bgColors[$item->priority] ?? 'bg-blue-600 hover:bg-blue-700' }}">
                            Lihat Detail
                        </a>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-10 text-gray-500">
                        Belum ada pengumuman terbaru.
                    </div>
                @endforelse

            </div>
        </div>
    </section>
    <section class="py-12 bg-white animate-fadein">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-xl font-bold text-gray-800 mb-6">⚡ Akses Cepat</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <a href="/schedule"
                    class="group bg-blue-50 hover:bg-blue-100 p-6 rounded-xl text-center border transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
                    <i class="fas fa-cogs text-blue-600 text-2xl mb-2 group-hover:scale-110 transition"></i>
                    <p class="font-semibold text-gray-800">Jadwal</p>
                </a>
                <a href="/tracking"
                    class="group bg-green-50 hover:bg-green-100 p-6 rounded-xl text-center border transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
                    <i class="fas fa-search text-green-600 text-2xl mb-2 group-hover:scale-110 transition"></i>
                    <p class="font-semibold text-gray-800">Tracking</p>
                </a>
                <a href="/report"
                    class="group bg-yellow-50 hover:bg-yellow-100 p-6 rounded-xl text-center border transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
                    <i class="fas fa-chart-line text-yellow-600 text-2xl mb-2 group-hover:scale-110 transition"></i>
                    <p class="font-semibold text-gray-800">Report</p>
                </a>
                <a href="/announcement"
                    class="group bg-indigo-50 hover:bg-indigo-100 p-6 rounded-xl text-center border transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
                    <i class="fas fa-bullhorn text-indigo-600 text-2xl mb-2 group-hover:scale-110 transition"></i>
                    <p class="font-semibold text-gray-800">Pengumuman</p>
                </a>
            </div>
        </div>
    </section>

    <!-- Animasi -->
    <style>
        @keyframes gradientMove {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        .animate-gradient {
            background-size: 200% 200%;
            animation: gradientMove 10s ease infinite;
        }

        @keyframes fadein {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadein {
            animation: fadein 0.8s ease both;
        }
    </style>
@endsection
