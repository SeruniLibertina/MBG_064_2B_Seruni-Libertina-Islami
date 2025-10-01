<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
{
    // Jika user tidak ada di dalam daftar role yang diizinkan
    if (!in_array($request->user()->role, $roles)) {
        // Tolak akses
        abort(403, 'AKSI TIDAK DIIZINKAN.');
    }
    return $next($request);
}
}
