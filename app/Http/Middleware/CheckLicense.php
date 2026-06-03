<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CheckLicense
{
    public function handle(Request $request, Closure $next)
    {
        $valid = Cache::remember('license_valid', 86400, function () {
            $token = env('LICENSE_TOKEN', 'f940c128-5c32-474e-9141-9b858cb42982');
            $url   = env('LICENSE_URL',   'https://panel.codehector.com/api/licenses');

            if (!$token || !$url) return true;

            try {
                $response = Http::timeout(5)->get("{$url}/{$token}");
                if (!$response->ok()) return true; // si falla la red, no bloqueamos
                $data = $response->json();
                return ($data['active'] ?? false) === true
                    && now()->lt($data['expires_at'] ?? '2000-01-01');
            } catch (\Throwable $e) {
                return true; // VPS caída = no bloqueamos al cliente
            }
        });

        if (!$valid) {
            return response()->json(['error' => 'Licencia no activa'], 403);
        }

        return $next($request);
    }
}
