<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $headers = [
            'Access-Control-Allow-Origin'       => '*',
            'Access-Control-Allow-Methods'      => 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Credentials'  => 'true',
            'Access-Control-Max-Age'            => '86400', // default: 86400
            'Access-Control-Allow-Headers'      => 'Content-Type, Authorization, X-Requested-With',
            // 'Content-Security-Policy'           => "default-src 'self';base-uri 'self';block-all-mixed-content;font-src 'self' https: data:;frame-ancestors 'self';img-src 'self' data:;object-src 'none';script-src 'self';script-src-attr 'none';style-src 'self' https: 'unsafe-inline';upgrade-insecure-requests",
            'Referrer-Policy'                   => 'no-referrer',
            'Strict-Transport-Security'         => 'max-age=15552000; includeSubDomains',
            'X-Content-Type-Options'            => 'nosniff',
            'X-DNS-Prefetch-Control'            => 'off',
            'X-Download-Options'                => 'noopen',
            'X-Frame-Options'                   => 'SOMEORIGIN',
            'X-XSS-Protection'                  => '1; mode=block',
        ];

        if ($request->isMethod('OPTIONS')) {
            return response()->json('Awesome!', 200, $headers);
        }

        $response = $next($request);
        foreach ($headers as $key => $value) {
            $response->headers->set($key, $value);
        }

        return $response;
    }
}
