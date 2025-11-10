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

        // Pastikan ada message
        if (!isset($data['message']['text'])) {
            return response()->json(['ok' => true]);
        }

        $chatId = $data['message']['chat']['id'];
        $text = $data['message']['text'];

        // Command /jadwal
        if (strtolower($text) == '/jadwal') {
            $this->sendTodaysActivity($chatId);
        }

        return response()->json(['ok' => true]);
    }

    protected function sendTodaysActivity($chatId)
    {
        $today = now()->toDateString();
        $activities = Activity::where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->get();

        if ($activities->isEmpty()) {
            $this->telegram->sendMessage($chatId, "Tidak ada jadwal hari ini.");
        } else {
            foreach ($activities as $act) {
                // Format tanggal ke gaya Indonesia
                $start = Carbon::parse($act->start_date)->locale('id')->translatedFormat('d F Y');
                $end   = Carbon::parse($act->end_date)->locale('id')->translatedFormat('d F Y');

                // Jika tanggalnya sama, tampilkan hanya 1
                $dateRange = $start === $end ? $start : "{$start} – {$end}";

                $message = "📋 *Jadwal Hari Ini*\n";
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
}
