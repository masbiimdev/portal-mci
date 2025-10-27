<?php

namespace App\Http\Controllers;

use App\Activity;
use Carbon\Carbon;
use App\Annon;
use App\ActivityItemResult;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $announcements = Annon::where('is_active', true)
            ->orderByRaw("FIELD(priority, 'high', 'medium', 'low')")
            ->orderBy('created_at', 'desc')
            ->take(3) // tampilkan 3 pengumuman terbaru
            ->get();

        return view('pages.home', compact('announcements'));
    }
    public function jadwal()
    {
        // Ambil semua activities dan juga weekly / sidebar data
        $activities = Activity::all();

        $today = Carbon::today();
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();

        $todayCount = Activity::whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->count();

        $weekCount = Activity::whereBetween('start_date', [$weekStart, $weekEnd])
            ->orWhereBetween('end_date', [$weekStart, $weekEnd])
            ->count();

        $weekActivities = Activity::whereBetween('start_date', [$weekStart, $weekEnd])
            ->orWhereBetween('end_date', [$weekStart, $weekEnd])
            ->get();

        // Semua hasil inspeksi (untuk rendering di blade)
        $activityResults = ActivityItemResult::whereIn('activity_id', $activities->pluck('id'))
            ->orderBy('created_at', 'desc')
            ->get();

        $resultsData = $activityResults->map(function ($r) {
            return [
                'id' => $r->id,
                'activity_id' => $r->activity_id,
                'part_name' => $r->part_name,
                'material' => $r->material,
                'qty' => $r->qty,
                'inspector_name' => $r->inspector_name,
                'pic' => $r->pic,
                'inspection_time' => $r->inspection_time,
                'result' => $r->result,
                'status' => $r->status,
                'remarks' => $r->remarks,
            ];
        })->toArray();


        return view('pages.jadwal', compact(
            'activities',
            'todayCount',
            'weekCount',
            'weekActivities',
            'activityResults',
            'resultsData'
        ));
    }

    public function storeOrUpdateResult(Request $request)
    {
        $validated = $request->validate([
            'result_id' => 'nullable|exists:activity_item_results,id',
            'activity_id' => 'required|exists:activities,id',
            'part_name' => 'required|string',
            'material' => 'nullable|string',
            'qty' => 'nullable|integer',
            'inspector_name' => 'required|string',
            'pic' => 'required|string',
            'inspection_time' => 'nullable|date_format:Y-m-d H:i:s',
            'result' => 'required|string',
            'remarks' => 'nullable|string',
        ]);

        if (!empty($validated['result_id'])) {
            // update
            $res = ActivityItemResult::findOrFail($validated['result_id']);
            $res->update([
                'activity_id' => $validated['activity_id'],
                'part_name' => $validated['part_name'],
                'material' => $validated['material'] ?? null,
                'qty' => $validated['qty'] ?? null,
                'inspector_name' => $validated['inspector_name'],
                'pic' => $validated['pic'],
                'result' => $validated['result'],
                'status' => 'Checked',
                'remarks' => $validated['remarks'] ?? null,
                // jangan ubah inspection_time
            ]);
            $message = 'Hasil pemeriksaan berhasil diperbarui!';
        } else {
            // create
            $inspectionTime = $validated['inspection_time'] ?? now()->toDateTimeString();
            $res = ActivityItemResult::create([
                'activity_id' => $validated['activity_id'],
                'part_name' => $validated['part_name'],
                'material' => $validated['material'] ?? null,
                'qty' => $validated['qty'] ?? null,
                'inspector_name' => $validated['inspector_name'],
                'pic' => $validated['pic'],
                'inspection_time' => $inspectionTime,
                'result' => $validated['result'],
                'status' => 'Checked',
                'remarks' => $validated['remarks'] ?? null,
            ]);
            $message = 'Hasil pemeriksaan berhasil disimpan!';
        }

        // tandai activity has_result true (sesuaikan sesuai kebutuhan)
        $activity = Activity::find($validated['activity_id']);
        if ($activity) {
            $activity->update(['has_result' => true]);
        }

        return redirect()->back()->with('success', $message);
    }


    public function getActivityResults(Request $request)
    {
        $request->validate([
            'activity_id' => 'required|exists:activities,id',
            'part_name' => 'required|string',
        ]);

        $results = ActivityItemResult::where('activity_id', $request->activity_id)
            ->where('part_name', $request->part_name)
            ->orderBy('inspection_time', 'desc')
            ->get(['part_name','inspector_name', 'inspection_time','part_name', 'result', 'status', 'remarks']);

        return response()->json($results);
    }
}
