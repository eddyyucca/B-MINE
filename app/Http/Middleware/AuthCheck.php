<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AuthCheck
{
    public function handle($request, Closure $next)
    {
        if (!session()->has('logged_in_user')) {
            return redirect('/login')->withErrors(['access' => 'Anda harus login untuk mengakses halaman ini.']);
        }
        
        return $next($request);
    }
}
