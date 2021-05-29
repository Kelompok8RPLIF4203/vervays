<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Book;
use App\Order;

class BookController extends Controller
{
    public function getUserBooks()
    {
        return Book::getBookDataForBookCollectionPage();
    }

    public function getPeopleGaveStarsCountAllRating(Request $request) // untuk semua rating (dari 1.0 sampai 5.0)
    {
        return Book::getPeopleGaveStarsCountAllRating($request->id);
    }

    public function getPeopleGaveStarsCountByRating(Request $request)
    {
        return Book::getPeopleGaveStarsCountByRating($request->id, $request->rating);
    }

    public function getReviewsByBookId(Request $request)
    {
        return Book::getReviewsByBookId($request->bookId);
    }

    public function getUserRoleForEbookInfoPage(Request $request)
    {
        return Order::getUserRoleForEbookInfoPage($request->bookId);
    }

    public function getPublisherName(Request $request)
    {
        return Book::getPublisherName($request->bookId);
    }

    public function isBookNotDeleted(Request $request)
    {
        return response()->json(Book::isBookNotDeleted($request->get('id')));
    }

    public function getPublisherBook(Request $request)
    {
        return Book::getBookDataForDashboardPublisher();
    }
}
