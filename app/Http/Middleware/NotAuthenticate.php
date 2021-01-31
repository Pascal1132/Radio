<?php

namespace App\Http\Middleware;
use Closure;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class NotAuthenticate
{
    public function handle($request, Closure $next)
    {
        if (!$request->session()->has('user')) {
            return redirect('/cms/');
        }
        return $next($request);
    }
}
