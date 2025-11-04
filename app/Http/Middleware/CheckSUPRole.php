<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSUPRole
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
        // Cek role user
        if (auth()->check() && auth()->user()->role === 'SUP') {
            return $next($request);
        }

        // Kalau bukan SUP, arahkan ke under-construction
        return redirect('/under-construction');
    }
}
