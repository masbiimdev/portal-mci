<?php

namespace App\Http\Controllers;

use App\Tool;
use App\CalibrationHistory;
use Carbon\Carbon;

class KalibrasiDashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $in30Days = $now->copy()->addDays(30);

        // Summary
        $totalTools = Tool::count();

        $statusOk = Tool::whereHas('latestHistory', function($q){
            $q->where('status_kalibrasi', 'OK');
        })->count();

        $statusProses = Tool::whereHas('latestHistory', function($q){
            $q->where('status_kalibrasi', 'Proses');
        })->count();

        $dueSoon = Tool::whereHas('latestHistory', function($q) use ($now, $in30Days){
            $q->whereBetween('tgl_kalibrasi_ulang', [$now, $in30Days]);
        })->count();

        $pieData = [
            'ok' => $statusOk,
            'proses' => $statusProses,
            'due' => $dueSoon,
        ];

        $barLabels = [];
        $barValues = [];
        for ($i = 1; $i <= 12; $i++) {
            $barLabels[] = Carbon::create()->month($i)->format('F');

            $count = Tool::whereHas('latestHistory', function($q) use ($i){
                $q->whereMonth('tgl_kalibrasi_ulang', $i);
            })->count();

            $barValues[] = $count;
        }

        // --- Subquery terbaru: include status_kalibrasi ---
        $latestSub = CalibrationHistory::select(
                'id', 'tool_id', 'tgl_kalibrasi', 'tgl_kalibrasi_ulang', 'status_kalibrasi'
            )
            ->orderBy('tgl_kalibrasi', 'desc');

        // Due soon
        $dueSoonList = Tool::joinSub($latestSub, 'latest_history', function($join){
                $join->on('tools.id', '=', 'latest_history.tool_id');
            })
            ->whereBetween('latest_history.tgl_kalibrasi_ulang', [$now, $in30Days])
            ->orderBy('latest_history.tgl_kalibrasi_ulang', 'asc')
            ->select('tools.*')
            ->get();

        // In progress
        $inProgress = Tool::joinSub($latestSub, 'latest_history', function($join){
                $join->on('tools.id', '=', 'latest_history.tool_id');
            })
            ->where('latest_history.status_kalibrasi', 'Proses')
            ->orderBy('latest_history.tgl_kalibrasi', 'desc')
            ->select('tools.*')
            ->get();

        // Table utama
        $tools = Tool::with('latestHistory')->orderBy('nama_alat')->paginate(15);

        return view('pages.admin.kalibrasi.dashboard', compact(
            'totalTools',
            'statusOk',
            'statusProses',
            'dueSoon',
            'pieData',
            'barLabels',
            'barValues',
            'dueSoonList',
            'inProgress',
            'tools'
        ));
    }
}
