<?php

namespace App\Http\Middleware;

use Closure;

use App\Publisher;

class DoesPublishers
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
        $userId = session('id');
        if (Publisher::isUserAPublisher($userId)) {
            return $next($request);
        }
        Publisher::bePublisher($userId);
        return redirect()->route('dashboard-publisher');
    }
}
