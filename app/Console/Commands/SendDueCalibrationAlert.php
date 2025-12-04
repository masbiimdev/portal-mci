<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Tool;
use App\Services\TelegramService;
use Carbon\Carbon;

class SendDueCalibrationAlert extends Command
{
    protected $signature = 'tools:due-alert';
    protected $description = 'Kirim notifikasi Telegram untuk alat yang akan jatuh tempo kalibrasi (<15 hari)';

    protected $telegram;

    public function __construct(TelegramService $telegram)
    {
        parent::__construct();
        $this->telegram = $telegram;
    }

    public function handle()
    {
        $today = Carbon::today();
        $limit = $today->copy()->addDays(15);

        $dueTools = Tool::whereHas('latestHistory', function ($q) use ($today, $limit) {
            $q->whereBetween('tgl_kalibrasi_ulang', [$today, $limit]);
        })->get();

        if ($dueTools->isEmpty()) {
            $this->info('Tidak ada alat yang due soon.');
            return;
        }

        $chatId = -5064084237; // Bisa diset di .env

        foreach ($dueTools as $tool) {
            $history = $tool->latestHistory;

            $message = "
⚠️ *INFO KALIBRASI ALERT* ⚠️

Halo teman-teman!  
Cuma mau ngingetin nih, salah satu alat kita udah masuk kategori *DUE SOON*.

🛠 *Nama Alat:* {$tool->nama_alat}  
🔖 *Serial:* {$tool->no_seri}  
📅 *Kalibrasi Ulang:* {$history->tgl_kalibrasi_ulang->format('d M Y')}  
⏳ *Status:* DUE SOON — kurang dari 15 hari lagi  

Yuk, segera dicek dan dijadwalkan kalibrasinya supaya alat tetap:  
✅ Akurat dan aman dipakai  
✅ Gak sampai lewat batas (*overdue*)  

Kalau udah follow up atau ada update, kabarin tim juga ya biar semuanya update.  

Thanks banget atas kerjasamanya! 🙏🔥  
Mari jaga alat tetap top performance! 💪
";

            $this->telegram->sendMessage($chatId, $message, 'Markdown');

            $this->info("Notifikasi terkirim untuk alat: {$tool->nama_alat}");
        }

        $this->info('Semua notifikasi due soon berhasil dikirim.');
    }
}
