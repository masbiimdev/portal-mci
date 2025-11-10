<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TelegramService;
use App\Activity;

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
                $message = "┌─ *Tipe:* {$act->type}\n";
                $message .= "│ *Waktu:* {$act->start_date} - {$act->end_date}\n";
                $message .= "│ *Customer:* {$act->customer}\n";
                $message .= "│ *PO:* {$act->po}\n";
                $message .= "│ *Status:* {$act->status}\n";
                $message .= "│ *Detail Items:*\n";

                $items = json_decode($act->items, true);
                if ($items) {
                    foreach ($items as $item) {
                        $message .= "│   Part Name: {$item['part_name']}\n";
                        $message .= "│   Material: {$item['material']}\n";
                        $message .= "│   Heat Number: {$item['heat_number']}\n";
                        $message .= "│   Quantity: {$item['quantity']}\n";
                        $message .= "│   Remarks: {$item['remarks']}\n";
                        $message .= "│   Status: {$item['detail_status']}\n";
                    }
                } else {
                    $message .= "│   Tidak ada detail items.\n";
                }

                $message .= "└────────────────────\n\n";

                $this->telegram->sendMessage($chatId, $message);
            }
        }
    }
}
