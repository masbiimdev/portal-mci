<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TelegramService;
use App\Activity;
use Carbon\Carbon;

class TelegramController extends Controller
{
    protected $telegram;

    public function __construct(TelegramService $telegram)
    {
        $this->telegram = $telegram;
    }

    public function handle(Request $request)
    {
        $data = $request->all();

        // Pastikan ada pesan masuk
        if (!isset($data['message']['text'])) {
            return response()->json(['ok' => true]);
        }

        $chatId = $data['message']['chat']['id'];
        $text = strtolower(trim($data['message']['text']));

        // Command /jadwal → hari ini
        if ($text === '/jadwal') {
            $this->sendTodaysActivity($chatId);
        }

        // Command /besok → jadwal besok
        if ($text === '/besok') {
            $this->sendTomorrowsActivity($chatId);
        }

        return response()->json(['ok' => true]);
    }

    protected function sendTomorrowsActivity($chatId)
    {
        $tomorrow = now()->addDay()->toDateString();
        $activities = Activity::where('start_date', '<=', $tomorrow)
            ->where('end_date', '>=', $tomorrow)
            ->get();

        if ($activities->isEmpty()) {
            $this->telegram->sendMessage($chatId, "Tidak ada jadwal untuk besok.");
        } else {
            foreach ($activities as $act) {
                $start = Carbon::parse($act->start_date)->locale('id')->translatedFormat('d F Y');
                $end   = Carbon::parse($act->end_date)->locale('id')->translatedFormat('d F Y');

                $dateRange = $start === $end ? $start : "{$start} – {$end}";

                $message = "📅 *Jadwal Besok*\n";
                $message .= "───────────────────────\n";
                $message .= "🗂️ *Kegiatan:* {$act->kegiatan}\n";
                $message .= "📅 *Waktu:* {$dateRange}\n";
                $message .= "🏢 *Customer:* {$act->customer}\n";
                $message .= "🧾 *PO:* " . ($act->po ?? '-') . "\n";
                $message .= "⚙️ *Status:* {$act->status}\n\n";

                $items = json_decode($act->items, true);

                if ($items && count($items) > 0) {
                    $message .= "🧩 *Detail Items:*\n";
                    foreach ($items as $index => $item) {
                        $message .= "━━━━━━━━━━━━━━━\n";
                        $message .= "🔹 *Item #" . ($index + 1) . "*\n";
                        $message .= "• *Part Name:* {$item['part_name']}\n";
                        $message .= "• *Material:* {$item['material']}\n";
                        $message .= "• *Heat No:* {$item['heat_no']}\n";
                        $message .= "• *Qty:* {$item['qty']}\n";
                        $message .= "• *Remarks:* " . ($item['remarks'] ?? '-') . "\n\n";
                    }
                } else {
                    $message .= "📦 Tidak ada detail items.\n";
                }

                $this->telegram->sendMessage($chatId, $message);
            }
        }
    }
    protected function sendTodaysActivity($chatId)
    {
        $today = now()->toDateString();

        $activities = Activity::where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->get();

        if ($activities->isEmpty()) {
            $this->telegram->sendMessage($chatId, "Tidak ada jadwal untuk hari ini.");
            return;
        }

        foreach ($activities as $act) {
            $start = Carbon::parse($act->start_date)->locale('id')->translatedFormat('d F Y');
            $end   = Carbon::parse($act->end_date)->locale('id')->translatedFormat('d F Y');
            $dateRange = $start === $end ? $start : "{$start} – {$end}";

            $message = "*Jadwal Kegiatan Hari Ini*\n";
            $message .= "-----------------------------\n";
            $message .= "*Nama Kegiatan:* {$act->kegiatan}\n";
            $message .= "*Waktu:* {$dateRange}\n";
            $message .= "*Customer:* {$act->customer}\n";
            $message .= "*Nomoe PO:* " . ($act->po ?? '-') . "\n";

            $items = json_decode($act->items, true);

            if ($items && count($items) > 0) {
                $message .= "\n*Detail Barang:*\n";
                foreach ($items as $index => $item) {
                    $message .= "-----------------------------\n";
                    $message .= "*Item #" . ($index + 1) . "*\n";
                    $message .= "- Nama Part: {$item['part_name']}\n";
                    $message .= "- Material: {$item['material']}\n";
                    $message .= "- Heat No: {$item['heat_no']}\n";
                    $message .= "- Kuantiti: {$item['qty']}\n";
                    $message .= "- Catatan: " . ($item['remarks'] ?? '-') . "\n";
                }
            } else {
                $message .= "\nTidak ada detail items.\n";
            }

            $this->telegram->sendMessage($chatId, $message);
        }
    }
}
