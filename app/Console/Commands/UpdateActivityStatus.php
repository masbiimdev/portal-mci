<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Activity;
use Carbon\Carbon;

class UpdateActivityStatus extends Command
{
    protected $signature = 'activity:update-status';
    protected $description = 'Update otomatis status activity berdasarkan tanggal';

    public function handle()
    {
        $today = Carbon::today();

        // 1️⃣ On Going -> Done jika end_date lewat
        Activity::where('status', 'On Going')
            ->whereDate('end_date', '<', $today)
            ->update(['status' => 'Done']);

        // 2️⃣ Pending -> On Going jika start_date masuk minggu ini
        $startOfWeek = $today->copy()->startOfWeek(); // Senin
        $endOfWeek = $today->copy()->endOfWeek();     // Minggu

        Activity::where('status', 'Pending')
            ->whereDate('start_date', '>=', $startOfWeek)
            ->whereDate('start_date', '<=', $endOfWeek)
            ->update(['status' => 'On Going']);

        $this->info('Activity status updated successfully.');
    }
}
