<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Publisher;

class BalanceController extends Controller
{
    public function withdrawBalance(Request $request)
    {
        $publisherId = Publisher::getPublisherIdWithUserId(session('id'));
        Publisher::withdrawBalance($publisherId, $request->amount, $request->bankId, $request->accountOwner);
    }
}
