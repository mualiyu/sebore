<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AgentAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (session()->has('Agent')) {
            return $next($request);
        }
        return redirect()->route('login');
    }
}
