<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Dipanggil SETELAH login sukses
     */
    protected function authenticated(Request $request, $user)
    {
        $currentSessionId = session()->getId();

        $sessionLifetime = config('session.lifetime') * 60; // detik
        $now = time();

        // Cari session LAIN yang MASIH AKTIF
        $activeOtherSession = DB::table('sessions')
            ->where('user_id', $user->id)
            ->where('id', '!=', $currentSessionId)
            ->where('last_activity', '>=', $now - $sessionLifetime)
            ->exists();

        if ($activeOtherSession) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors([
                'login' => 'Akun ini sedang digunakan di perangkat lain.'
            ]);
        }

        // Optional: bersihkan session lama yang sudah expired
        DB::table('sessions')
            ->where('user_id', $user->id)
            ->where('last_activity', '<', $now - $sessionLifetime)
            ->delete();
    }
}
