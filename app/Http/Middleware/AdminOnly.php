<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $jobcardId = $request->route('jobcard'); 

        // Jika user login dan role admin
        if (Auth::check() && Auth::user()->role === 'ADM') {
            return $next($request);
        }

        // Jika guest atau user bukan admin → redirect ke public page
        return redirect()->route('jobcards.public.show', ['id' => $jobcardId]);
    }
}
