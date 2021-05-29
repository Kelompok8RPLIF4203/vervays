<?php

namespace App\Http\Middleware;

use Closure;
use App\Book;

class IsBookNotDeleted
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
        if (Book::isBookNotDeleted($request->bookId)) {
            return $next($request);
        }
        return redirect()->back();
    }
}
