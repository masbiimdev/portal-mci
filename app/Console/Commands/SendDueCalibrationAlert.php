<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Tool;
use App\Services\TelegramService;
use Carbon\Carbon;

class SendDueCalibrationAlert extends Command
{
    protected $signature = 'tools:due-alert';
    protected $description = 'Kirim notifikasi Telegram untuk alat yang akan jatuh tempo kalibrasi (H-20)';

    protected $telegram;

    public function __construct(TelegramService $telegram)
    {
        parent::__construct();
        $this->telegram = $telegram;
    }

    public function handle()
    {
        $today = Carbon::today();

        // Ambil alat yang tepat H-20 hari sebelum tanggal kalibrasi ulang
        $dueTools = Tool::whereHas('latestHistory', function ($q) use ($today) {
            $q->whereDate('tgl_kalibrasi_ulang', $today->copy()->addDays(15));
        })->get();

        if ($dueTools->isEmpty()) {
            $this->info('Tidak ada alat yang due soon.');
            return;
        }

        $chatId = -5064084237; // Bisa dipindahkan ke .env jika mau

        // ================================
        // KUMPULKAN DAFTAR ALAT
        // ================================
        $list = "";
        foreach ($dueTools as $tool) {
            $history = $tool->latestHistory;

            // Format tanggal: Hari, 22 Januari 2026
            $formattedDate = $history->tgl_kalibrasi_ulang
                ->locale('id')
                ->translatedFormat('l, d F Y');

            $list .= "• *{$tool->nama_alat}*\n";
            $list .= "  Serial: `{$tool->no_seri}`\n";
            $list .= "  Jadwal Kalibrasi Ulang: *{$formattedDate}*\n\n";
        }

        // ================================
        // PESAN FINAL (DIKIRIM SEKALI)
        // ================================
        $message = "
Halo rekan-rekan,

Berikut daftar alat yang telah memasuki periode *Penjadwalan Kalibrasi (H-15)*:

$list
📌 *Tindak Lanjut yang Diperlukan*
Mohon untuk segera:
• Melakukan pengecekan jadwal kalibrasi
• Menghubungi vendor atau pihak terkait bila diperlukan
• Menginformasikan update kepada tim agar monitoring tetap terkoordinasi

Menjaga alat tetap terkalibrasi sangat penting untuk memastikan:
✔ Keakuratan pengukuran
✔ Keamanan penggunaan
✔ Kepatuhan terhadap standar operasional dan audit

Terima kasih atas perhatian dan kerjasamanya.
Mari bersama menjaga kualitas alat tetap maksimal. 🙏💼
";

        // Kirim SEKALI SAJA
        $this->telegram->sendMessage($chatId, $message, 'Markdown');

        $this->info('Notifikasi due soon berhasil dikirim.');
    }
}
