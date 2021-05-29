<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Wishes;
use App\Book;

class WishesController extends Controller
{
    public function getUserWishlist()
    {
        return Wishes::getUsersWishlist();
    }

    public function addBookToWishList(Request $request)
    {
        Wishes::addBookToWishList($request->bookId);
    }

    public function removeBookFromWishList(Request $request)
    {
        Wishes::removeBookFromWishList(session('id'),$request->bookId);
    }

    public function whetherTheUserHasAddedBookToWishList(Request $request)
    {
        return Wishes::whetherTheUserHasAddedBookToWishList($request->bookId);
    }
}
