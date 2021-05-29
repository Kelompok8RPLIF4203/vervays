<?php

namespace App\Http\Controllers\buyer;

use App\Book;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Order;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            "firstName" => User::getFirstName(session('id')),
            "book" => Book::getBookForInfoPage($request->id),
        ];
        // dd($data["book"]);
        return view('pages.buyer.ebook_info', $data);
    }
}
