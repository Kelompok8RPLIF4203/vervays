<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Cart;
use App\Book;

class CartController extends Controller
{
    public function whetherTheUserHasAddedBookToCart(Request $request)
    {
        return Cart::whetherTheUserHasAddedBookToCart($request->bookId);
    }

    public function addBookToCart(Request $request)
    {
        Cart::addBookToCart($request->bookId);
    }

    public function removeBookFromCart(Request $request)
    {
        Cart::removeBookFromCart($request->bookId);
    }

    public function getUserCart(Request $request)
    {
        return Cart::getUserCart($request->userId);
    }
}
