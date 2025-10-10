<?php

namespace App\Http\Controllers;

use App\Jobcard;
use App\JobcardHistory;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index()
    {
        return view('pages.tracking');
    }

    // AJAX search jobcard
    public function ajaxSearch(Request $request)
    {
        $keyword = $request->get('q');

        $jobcards = Jobcard::where('jobcard_id', 'LIKE', "%$keyword%")
            ->orWhere('id', $keyword)
            ->get();

        return response()->json($jobcards);
    }

    // AJAX get history
    public function ajaxHistory(Jobcard $jobcard)
    {
        $histories = JobcardHistory::with('user')
            ->where('jobcard_id', $jobcard->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($histories);
    }
}
