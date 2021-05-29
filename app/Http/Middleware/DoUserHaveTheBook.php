<?php

namespace App\Http\Middleware;

use App\Have;
use Closure;

class DoUserHaveTheBook
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
        if (Have::doUserHaveTheBook(session('id'), $request->bookId)) {
            return $next($request);
        }
        return redirect()->back();
    }
}
