<?php

namespace App\Http\Controllers\publisher;

use App\Bank;
use App\Http\Controllers\Controller;
use App\Publisher;
use Illuminate\Http\Request;
use App\User;

class BalanceController extends Controller
{
    public function cashout()
    {
        $publisherId = Publisher::getPublisherIdWithUserId(session('id'));
        $balance = Publisher::getBalance($publisherId);
        $data = [
            "firstName" => User::getFirstName(session('id')),
            "balance" => $balance,
            "banks" => Bank::getAllBank(),
        ];
        // dd($data["banks"]);
        return view('pages.publisher.cashout', $data);
    }
}
