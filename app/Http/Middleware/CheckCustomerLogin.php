<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckCustomerLogin
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('customer')->check()) {
            return redirect()->route('customer.login')
                             ->with('error', 'Silahkan Login Terlebih Dahulu');
        }

        return $next($request);
    }
}
