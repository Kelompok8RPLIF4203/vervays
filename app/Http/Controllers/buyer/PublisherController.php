<?php

namespace App\Http\Controllers\buyer;

use App\Book;
use App\Http\Controllers\Controller;
use App\Publisher;
use Illuminate\Http\Request;
use App\User;

class PublisherController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            "firstName" => User::getFirstName(session('id')),
            "publisher" => Publisher::getPublisherDataForPublisherInfoPage($request->publisherId),
            "books" => Book::getBookDataForPublisherInfoPage($request->publisherId),
        ];
        // dd($data["books"]);
        return view('pages.buyer.info_publisher', $data);
    }
}
