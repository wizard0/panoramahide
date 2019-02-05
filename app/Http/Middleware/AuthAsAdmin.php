<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AuthAsAdmin
{
    /**
     * Handle an incoming request. Only users with role 'admin' could pass.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check() || !$request->user()->isAdmin()) {
            return redirect()->route('admin.login');
        }
        return $next($request);
    }
}
