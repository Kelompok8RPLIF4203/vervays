<?php

namespace App\Http\Controllers\buyer;

use App\Http\Controllers\Controller;
use App\User;
use App\Book;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            "firstName" => User::getFirstName(session('id')),
            "newestBook" => Book::getSixNewestBookForBuyerDashboard(), //Berupa array asosiatif
            "editorChoicesBook" => Book::getSixEditorChoiceBookForBuyerDashboard(), //Berupa array asosiatif
            "bestsellerBook" => Book::getSixBestsellerBookForBuyerDashboard(),
        ];
        // dd($data["bestsellerBook"]);
        return view('pages.buyer.dashboard', $data);
    }
}
