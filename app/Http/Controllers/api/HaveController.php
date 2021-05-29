<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Have;

class HaveController extends Controller
{
    public function updateLastRead(Request $request)
    {
        Have::updateLastRead($request->bookId, $request->lastRead);
    }

    public function getLastRead(Request $request)
    {
        return Have::getLastRead($request->bookId);
    }
}
