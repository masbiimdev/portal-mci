<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TelegramService
{
    protected $botToken;
    protected $apiUrl;

    public function __construct()
    {
        $this->botToken = '8493801001:AAGqyjRQtkoZCjOuj6drQsbVVCIsXXioZd8';
        $this->apiUrl = "https://api.telegram.org/bot{$this->botToken}";
        $this->chatId = -5021332628; // langsung set chat ID di sini
    }


    /**
     * Kirim pesan ke chat Telegram
     */
    public function sendMessage($chatId, $message, $parseMode = 'Markdown')
    {
        $response = Http::post("{$this->apiUrl}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => $parseMode,
        ]);

        return $response->json();
    }

    /**
     * Set webhook ke URL kamu
     */
    public function setWebhook($url)
    {
        $response = Http::get("{$this->apiUrl}/setWebhook", [
            'url' => $url,
        ]);

        return $response->json();
    }

    /**
     * Cek status webhook
     */
    public function getWebhookInfo()
    {
        $response = Http::get("{$this->apiUrl}/getWebhookInfo");
        return $response->json();
    }
}
