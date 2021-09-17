<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Menu
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        view()->share('menuItems', config('tool.navigation.top'));

        return $next($request);
    }
}
