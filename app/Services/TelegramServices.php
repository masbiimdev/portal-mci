<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TelegramService
{
    protected $botToken;
    protected $apiUrl;

    public function __construct()
    {
        $this->botToken = '8493801001:AAGqyjRQtkoZCjOuj6drQsbVVCIsXXioZd8'; // simpan di .env
        $this->apiUrl = "https://api.telegram.org/bot{$this->botToken}/sendMessage";
    }

    /**
     * Kirim pesan ke chat Telegram
     */
    public function sendMessage($chatId, $message, $parseMode = 'Markdown')
    {
        $response = Http::post($this->apiUrl, [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => $parseMode
        ]);

        return $response->json();
    }
}
