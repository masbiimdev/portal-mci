<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\TelegramService;

class TestTelegramBot extends Command
{
    protected $signature = 'telegram:test';
    protected $description = 'Tes pengiriman pesan Telegram bot';

    protected $telegram;

    public function __construct(TelegramService $telegram)
    {
        parent::__construct();
        $this->telegram = $telegram;
    }

    public function handle()
    {
        $message = "🔥 Test pesan dari bot Telegram. Jika kamu melihat ini, bot berhasil terkoneksi!";

        // Kirim pesan dan tangkap response
        $response = $this->telegram->sendMessage($message, 'Markdown');

        // Tampilkan response Telegram
        $this->info("Response Telegram:");
        $this->line(json_encode($response, JSON_PRETTY_PRINT));
    }
}
