<?php
// app/Http/Middleware/CheckOPD.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckOPD
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        // Periksa apakah pengguna adalah Super Admin atau memiliki akses ke OPD terkait
        if ($user->hasRole('Super Admin') || $user->opd_id == $request->route('opd_id')) {
            return $next($request);
        }

        return response()->json(['error' => 'Tidak diizinkan'], 403);
    }
}
