<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOnly
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = session('auth_user');

        if (!$user || ($user['role'] ?? null) !== 'admin') {
            return redirect()->route('login')->with('error', 'Harus login sebagai admin.');
        }

        return $next($request);
    }
}
