<?php

namespace App\Http\Middleware;

use Closure;
use App\Publisher;

class DoesPublisherHaveThatBook
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
        $publisherId = Publisher::getPublisherIdWithUserId($userId);
        if (Publisher::doesThePublisherHaveThatBook($publisherId,$request->get('id') ?? $request->post('id'))) {
            return $next($request);
        }
        return redirect()->route('dashboard-publisher');
    }
}
