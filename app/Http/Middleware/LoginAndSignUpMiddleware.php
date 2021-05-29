<?php

namespace App\Http\Middleware;

use Closure;

class LoginAndSignUpMiddleware
{
    /**
     * Handle an incoming request.
     * Fungsi ini digunakan untuk mengecek apakah user sudah login atau belum,
     * jika sudah login maka akan diarahkan ke dashboard,
     * jika belum login maka akan melanjutkan request
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $value = session('id', 0);
        if ($value == 0) {
            return $next($request);
        }
        return redirect()->route('dashboard');
    }
}
