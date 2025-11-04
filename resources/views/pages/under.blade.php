@extends('layouts.home')

@section('title', 'Under Construction | Portal MCI')

@section('content')
<!-- Section Utama -->
<section class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-r from-blue-600 via-indigo-600 to-blue-700 text-white animate-gradient">
    <div class="text-center px-6 space-y-6 animate-fadein">
        <!-- Judul -->
        <h1 class="text-4xl md:text-5xl font-bold">Halaman Sedang Dalam Pengembangan</h1>

        <!-- Deskripsi -->
        <p class="text-blue-100 max-w-xl mx-auto leading-relaxed">
            Kami sedang menyiapkan tampilan terbaik untuk Portal MCI.<br>
            Mohon bersabar sebentar lagi — fitur ini segera hadir.
        </p>

        <!-- Tombol Kembali -->
        <a href="{{ url('/') }}"
            class="inline-block bg-white text-blue-700 font-semibold px-6 py-3 rounded-lg shadow-md hover:bg-blue-50 transition-all duration-300">
            Kembali ke Beranda
        </a>
    </div>
</section>

<!-- Style Animasi -->
<style>
    html, body {
        height: 100%;
        margin: 0;
    }

    @keyframes gradientMove {
        0%, 100% {
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

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(15px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fadein {
        animation: fadeIn 1s ease both;
    }
</style>
@endsection
