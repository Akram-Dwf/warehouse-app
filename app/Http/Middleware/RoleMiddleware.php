<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Cek user punya jabatan yang sesuai
        $allowedRoles = explode('|', $role);

        // Ambil role user yang sedang login
        $userRole = $request->user()->role;

        // Cek role user ada di dalam daftar yang dibolehkan
        if (in_array($userRole, $allowedRoles)) {
            return $next($request);
        }

        abort(403, 'Akses Ditolak! Anda tidak memiliki izin untuk masuk ke sini.');
    }
}