<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlockIpAddressMiddleware
{
    /**
     * @var string[]
     */
    public $whitelistIps = [
        '127.0.1.1',
        '172.19.0.1'
    ];
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!in_array($request->getClientIp(), $this->whitelistIps)) {
            abort(403, "You are restricted to access the site.");
        }

        return $next($request);
    }
}
