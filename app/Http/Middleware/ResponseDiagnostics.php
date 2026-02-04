<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ResponseDiagnostics
{
    /**
     * Add lightweight diagnostic headers to help identify whether responses
     * are served by Laravel (vs an upstream proxy/WAF).
     */
    public function handle(Request $request, Closure $next): Response
    {
        $requestId = (string) Str::uuid();
        $request->attributes->set('request_id', $requestId);

        /** @var \Symfony\Component\HttpFoundation\Response $response */
        $response = $next($request);

        $response->headers->set('X-App', 'torredebatalla');
        $response->headers->set('X-Request-Id', $requestId);

        $enableExtendedHeaders = filter_var(env('APP_DIAGNOSTICS_HEADERS', false), FILTER_VALIDATE_BOOL);

        if ($enableExtendedHeaders) {
            $route = $request->route();

            $response->headers->set('X-Client-Ip', (string) $request->ip());
            $response->headers->set('X-Forwarded-For', (string) $request->headers->get('x-forwarded-for', ''));

            if ($route) {
                $response->headers->set('X-Route-Uri', (string) $route->uri());
                $response->headers->set('X-Route-Name', (string) ($route->getName() ?? ''));
            }
        }

        return $response;
    }
}
