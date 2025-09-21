<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ambil API key dari header request
        $apiKey = $request->header('X-API-KEY');

        // Ambil API key yang valid dari file .env
        $validApiKey = env('DEVICE_API_KEY');

        // Validasi: jika key kosong atau tidak cocok, kembalikan error
        if (!$apiKey || $apiKey !== $validApiKey) {
            return response()->json(['message' => 'Unauthorized. Invalid API Key.'], 401);
        }

        // Jika valid, lanjutkan request ke controller
        return $next($request);
    }
}
