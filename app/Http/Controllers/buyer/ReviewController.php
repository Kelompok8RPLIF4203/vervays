<?php

namespace App\Http\Controllers\buyer;

use App\Book;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class ReviewController extends Controller
{
    public function giveRating(Request $request)
    {
        $data = [
            "firstName" => User::getFirstName(session('id')),
            "book" => Book::getBookDataForReviewPage($request->bookId),
            "userFullNameWithoutSpace" => User::getFirstName(session('id')).User::getLastName(session('id')),
        ];
        // dd($data["userFullName"]);
        return view('pages.buyer.give_review', $data);
    }
}
