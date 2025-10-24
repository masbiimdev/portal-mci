<?php

namespace App\Http\Controllers;

use App\Activity;
use App\ActivityItemResult;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::all();
        return view('pages.admin.jadwal.witness.index', compact('activities'));
    }

    public function create()
    {
        return view('pages.admin.jadwal.witness.add');
    }

    public function store(Request $request)
    {
        $rules = [
            'type' => 'required|in:meeting,production,other',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'kegiatan' => 'required|string',
            'customer' => 'required|string',
            'status' => 'required|in:Pending,On Going,Reschedule,Done',
        ];

        if ($request->type === 'production') {
            $rules['po'] = 'required|string';
            $rules['part_name.*'] = 'required|string';
            $rules['material.*'] = 'required|string';
            $rules['qty.*'] = 'required|integer';
            $rules['heat_no.*'] = 'nullable|string';
            $rules['remarks.*'] = 'nullable|string';
        }

        $request->validate($rules);

        $data = $request->only(['type', 'start_date', 'end_date', 'kegiatan', 'customer', 'po', 'status']);

        // Jika type production, masukkan detail parts ke JSON
        if ($request->type === 'production') {
            $items = [];
            foreach ($request->part_name as $i => $part) {
                // abaikan baris kosong
                if ($part || $request->material[$i] || $request->qty[$i] || $request->remarks[$i] || $request->heat_no[$i]) {
                    $items[] = [
                        'part_name' => $part,
                        'material' => $request->material[$i] ?? null,
                        'qty' => $request->qty[$i] ?? null,
                        'heat_no' => $request->heat_no[$i] ?? null,
                        'remarks' => $request->remarks[$i] ?? null,
                    ];
                }
            }
            $data['items'] = json_encode($items);
        }

        Activity::create($data);

        return redirect()->route('activities.index')
            ->with('success', 'Data berhasil ditambahkan');
    }



    public function edit(Activity $activity)
    {
        return view('pages.admin.jadwal.witness.update', compact('activity'));
    }

    public function update(Request $request, Activity $activity)
    {
        $data = $request->all();

        // Gabungkan items
        $items = [];
        if ($request->part_name) {
            foreach ($request->part_name as $index => $part_name) {
                $items[] = [
                    'part_name' => $part_name,
                    'material'  => $request->material[$index] ?? null,
                    'qty'       => $request->qty[$index] ?? null,
                    'heat_no'   => $request->heat_no[$index] ?? null,
                    'remarks'   => $request->remarks[$index] ?? null,
                ];
            }
        }
        $data['items'] = json_encode($items);

        $activity->update($data);

        return redirect()->route('activities.index')->with('success', 'Activity berhasil diperbarui!');
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();
        return redirect()->route('activities.index')->with('success', 'Data berhasil dihapus');
    }

    public function notifications()
    {
        // Ambil 3 jadwal terbaru
        $notifications = Activity::orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('includes.navbar', compact('notifications'));
    }

    public function show($id)
    {
        $activity = Activity::findOrFail($id);
        $items = json_decode($activity->items, true) ?? [];

        // Ambil hasil checklist dari tabel result
        $results = ActivityItemResult::where('activity_id', $id)->get();

        return view('pages.admin.activity.detail', compact('activity', 'items', 'results'));
    }

    // public function storeResult(Request $request)
    // {
    //     $validated = $request->validate([
    //         'activity_id' => 'required|exists:activities,id',
    //         'part_name' => 'required|string',
    //         'material' => 'nullable|string',
    //         'qty' => 'nullable|integer',
    //         'inspector_name' => 'required|string',
    //         'inspection_time' => 'nullable',
    //         'result' => 'required|string',
    //         'remarks' => 'nullable|string',
    //     ]);

    //     $validated['status'] = 'Checked';
    //     $validated['inspection_time'] = $validated['inspection_time'] ?? now();

    //     ActivityItemResult::create($validated);

    //     return back()->with('success', 'Hasil pemeriksaan berhasil disimpan!');
    // }
}
