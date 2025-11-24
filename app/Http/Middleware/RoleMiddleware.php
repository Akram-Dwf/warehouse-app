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
        // 1. Cek apakah user punya jabatan yang sesuai
        // Kita pecah string role (misal: "admin|manager") menjadi array
        $allowedRoles = explode('|', $role);

        // 2. Ambil role user yang sedang login
        $userRole = $request->user()->role;

        // 3. Cek apakah role user ada di dalam daftar yang dibolehkan
        if (in_array($userRole, $allowedRoles)) {
            // Jika ada, silakan masuk (lanjut ke request berikutnya)
            return $next($request);
        }

        // 4. Jika tidak ada, tolak akses (Tampilkan Error 403)
        abort(403, 'Akses Ditolak! Anda tidak memiliki izin untuk masuk ke sini.');
    }
}