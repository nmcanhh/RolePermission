<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    /**
    Lệnh tạo php artisan make:middleware CheckPermission
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }
}
