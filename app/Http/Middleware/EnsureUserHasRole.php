<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Redirect jika user tidak login atau role-nya tidak sesuai
        if (! $request->user() || $request->user()->role !== $role) {
            // Anda bisa arahkan ke halaman 'unauthorized' atau redirect ke home
            return redirect('/');
        }

        return $next($request);
    }
}
