<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductTypeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->routeIs('cart.addSong')) {
            $request->attributes->add(['product_type' => 'song']);
        } elseif ($request->routeIs('cart.addAlbum')) {
            $request->attributes->add(['product_type' => 'album']);
        }

        return $next($request);
    }
}
