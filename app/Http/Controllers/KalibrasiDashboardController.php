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
        $in15Days = $now->copy()->addDays(15);

        /* ============================================================
           AUTO UPDATE STATUS (TIDAK MENYENTUH KETERANGAN)
        ============================================================ */

        $histories = CalibrationHistory::with('tool')->latest('id')->get();

        foreach ($histories as $h) {

            if (!$h->tgl_kalibrasi_ulang) {
                continue;
            }

            $diff = $now->diffInDays($h->tgl_kalibrasi_ulang, false);

            // < 15 hari → Due Soon
            if ($diff < 15 && $diff > 0 && $h->status_kalibrasi !== "Due Soon") {
                $h->status_kalibrasi = "Due Soon";
                $h->save();
                continue;
            }

            // = hari ini → Proses
            if ($diff === 0 && $h->status_kalibrasi !== "Proses") {
                $h->status_kalibrasi = "Proses";
                $h->save();
                continue;
            }

            // Lewat 15+ hari → OK
            if ($diff < -15 && $h->status_kalibrasi !== "OK") {
                $h->status_kalibrasi = "OK";
                $h->save();
                continue;
            }
        }

        /* ============================================================
           SUMMARY BOX
        ============================================================ */

        $totalTools = Tool::count();

        $statusOk = Tool::whereHas('latestHistory', function ($q) {
            $q->where('status_kalibrasi', 'OK');
        })->count();

        $statusProses = Tool::whereHas('latestHistory', function ($q) {
            $q->where('status_kalibrasi', 'Proses');
        })->count();

        $dueSoon = Tool::whereHas('latestHistory', function ($q) use ($now, $in15Days) {
            $q->whereBetween('tgl_kalibrasi_ulang', [$now, $in15Days]);
        })->count();


        /* ============================================================
           PIE CHART DATA
        ============================================================ */

        $pieData = [
            'ok' => $statusOk,
            'proses' => $statusProses,
            'due' => $dueSoon,
        ];


        /* ============================================================
           BAR CHART DATA
        ============================================================ */

        $barLabels = [];
        $barValues = [];

        for ($i = 1; $i <= 12; $i++) {
            $barLabels[] = Carbon::create()->month($i)->format('F');

            $count = Tool::whereHas('latestHistory', function ($q) use ($i) {
                $q->whereMonth('tgl_kalibrasi_ulang', $i);
            })->count();

            $barValues[] = $count;
        }


        /* ============================================================
           SUBQUERY: HISTORY TERBARU PER TOOL
        ============================================================ */

        $latestSub = CalibrationHistory::select(
            'id',
            'tool_id',
            'tgl_kalibrasi',
            'tgl_kalibrasi_ulang',
            'status_kalibrasi'
        )
            ->orderBy('tgl_kalibrasi', 'desc');


        /* ============================================================
           SECTION: Akan Jatuh Tempo (≤ 15 hari)
        ============================================================ */

        $dueSoonList = Tool::joinSub($latestSub, 'latest_history', function ($join) {
            $join->on('tools.id', '=', 'latest_history.tool_id');
        })
            ->whereBetween('latest_history.tgl_kalibrasi_ulang', [$now, $in15Days])
            ->orderBy('latest_history.tgl_kalibrasi_ulang', 'asc')
            ->select('tools.*', 'latest_history.tgl_kalibrasi_ulang')
            ->get();


        /* ============================================================
           SECTION: Dalam Proses Kalibrasi
        ============================================================ */

        $inProgress = Tool::joinSub($latestSub, 'latest_history', function ($join) {
            $join->on('tools.id', '=', 'latest_history.tool_id');
        })
            ->where('latest_history.status_kalibrasi', 'Proses')
            ->orderBy('latest_history.tgl_kalibrasi', 'desc')
            ->select('tools.*')
            ->get();


        /* ============================================================
           TABEL UTAMA SEMUA ALAT
        ============================================================ */

        $tools = Tool::with('latestHistory')->orderBy('nama_alat')->paginate(15);


        /* ============================================================
           RETURN TO VIEW
        ============================================================ */

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
