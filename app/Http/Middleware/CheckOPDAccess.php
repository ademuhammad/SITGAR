<?php
// app/Http/Middleware/CheckOPD.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckOPDAccess
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        // Check if the user is Super Admin
        if ($user->hasRole('Super Admin')) {
            return $next($request);
        }

        // If not Super Admin, restrict access based on OPD
        $opdId = $user->opd_id;

        if ($opdId) {
            // Attach opd_id to the request for further use in the controller
            $request->merge(['opd_id' => $opdId]);
            return $next($request);
        }

        return response()->json(['error' => 'Tidak diizinkan'], 403);
    }
}
