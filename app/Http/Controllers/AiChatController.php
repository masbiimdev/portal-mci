<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiChatController extends Controller
{
    public function ask(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);
        $userMessage = $request->input('message');

        // 2. Konteks Metinca AI
        $systemContext = "Kamu adalah 'Metinca AI', asisten ahli katup industri (industrial valve) dari PT Metinca Prima. Jawab pertanyaan HANYA seputar Valve, kalibrasi, API 598, ASME, dan inventory secara profesional dan ringkas. Jika ditanya di luar topik itu, tolak dengan sopan.";

        // 3. MASUKKAN API KEY BARU ANDA DI SINI
        $apiKey = 'API_KEY_BARU_ANDA';

        try {
            // 4. Panggil model Gemini-Pro (Paling stabil, pasti ada di semua akun)
            // MENGGUNAKAN GEMINI 2.5 FLASH
            $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=" . $apiKey;
            $response = Http::withoutVerifying()
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($url, [
                    'contents' => [
                        [
                            'role' => 'user',
                            'parts' => [
                                // Trik paling ampuh: Gabung instruksi dan pertanyaan jadi satu
                                ['text' => "INSTRUKSI: " . $systemContext . "\n\nPERTANYAAN USER: " . $userMessage]
                            ]
                        ]
                    ]
                ]);

            // 5. Cek Hasilnya
            if ($response->successful()) {
                $data = $response->json();
                $aiReply = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Maaf, saya tidak bisa memprosesnya.';

                return response()->json([
                    'status' => 'success',
                    'reply' => $aiReply
                ]);
            }

            // Jika gagal, catat pesan asli dari Google ke laravel.log
            Log::error('Gemini API Error Asli: ' . $response->body());
            return response()->json([
                'status' => 'error',
                'reply' => 'Maaf, server AI menolak permintaan.'
            ], 500);
        } catch (\Exception $e) {
            Log::error('Koneksi Gagal: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'reply' => 'Gagal terhubung ke jaringan Google.'
            ], 500);
        }
    }
}
