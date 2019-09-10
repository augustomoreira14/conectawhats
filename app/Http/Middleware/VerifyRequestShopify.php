<?php

namespace App\Http\Middleware;

use Closure;
use Oseintow\Shopify\Facades\Shopify;

class VerifyRequestShopify
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
        $queryString = $request->getQueryString();
        if (!Shopify::verifyRequest($queryString)) {
            abort(403);
        }
        return $next($request);
    }
}
