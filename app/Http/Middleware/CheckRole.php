<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            abort(403, 'Akses tidak sah. Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        $userId = $user->id;
        $userRole = null;

        if (DB::table('mahasiswa')->where('user_id', $userId)->exists()) {
            $userRole = 'mahasiswa';
        } elseif (DB::table('admin')->where('user_id', $userId)->exists()) {
            $userRole = 'admin';
        } elseif (DB::table('dosen')->where('user_id', $userId)->exists()) {
            $userRole = 'dosen';
        }

        if (!$userRole || !in_array($userRole, $roles)) {
            abort(403, 'Akses tidak sah. Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
