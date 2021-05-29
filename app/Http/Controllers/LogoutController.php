<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function index(Request $request)
    {
        session(['id' => 0]);
    }
}
