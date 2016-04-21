<?php

namespace GAPlatform\Http\Middleware;

use Closure;
use Session;
use Illuminate\Support\Facades\Auth;

class IntranetAuth
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
        if (!Session::get('intranet.admin')) {
            return redirect(env('app.url-gai').'/intranet/login/');
        }

        return $next($request);
    }
}
