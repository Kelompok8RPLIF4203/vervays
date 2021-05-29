<?php

namespace App\Http\Controllers\buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function setting()
    {
        $data = [
            "firstName" => User::getFirstName(session('id')),
            "user" => User::getUserDataForAccountSettingPage(session('id')),
            "currentDate" => date("Y-m-d"),
        ];
        // dd($data["user"]);
        return view('pages.buyer.account_setting', $data);
    }
}
