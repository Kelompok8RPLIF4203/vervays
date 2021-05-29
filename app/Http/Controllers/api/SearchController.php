<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Book;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        return Book::getBookForSearch($request->get('keyword'));
    }
}
