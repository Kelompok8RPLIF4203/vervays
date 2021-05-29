<?php

namespace App\Http\Middleware;

use App\Reviews;
use Closure;

class HaveUserNotReviewedTheBook
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
        if (!Reviews::didTheUserGiveAReview($request->bookId)) {
            return $next($request);
        }
        return redirect()->back();
    }
}
