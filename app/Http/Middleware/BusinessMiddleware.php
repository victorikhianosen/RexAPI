<?php

namespace App\Http\Middleware;

use App\Traits\HttpResponses;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class BusinessMiddleware
{

    use HttpResponses;
    public function handle(Request $request, Closure $next): Response
    {
         if (!Auth::guard('business')->check()) {
            return $this->error('Invalid URL', 404);
        }
        return $next($request);
    }
}
