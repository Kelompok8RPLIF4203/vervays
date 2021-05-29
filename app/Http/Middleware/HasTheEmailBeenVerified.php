<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class HasTheEmailBeenVerified
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
        if (!User::IsTheEmailNotVerified()) {
            return $next($request);
        }
        else {
            return redirect()->route('email-verification');
        }
    }
}
