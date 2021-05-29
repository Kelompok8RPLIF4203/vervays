<?php

namespace App\Http\Controllers\buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Book;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->keyword) {
            return redirect()->route('dashboard');
        }
        else {
            $data = [
                "keyword" => $request->keyword,
                "firstName" => User::getFirstName(session('id'))
            ];
            return view('pages.buyer.search', $data);
        }
    }
}
