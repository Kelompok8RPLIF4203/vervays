<?php

namespace App\Http\Controllers\buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\EbookFile;
use App\SampleEbookFile;
use App\Book;

class ReadController extends Controller
{
    public function readSample(Request $request)
    {
        $data = [
            "bookId" => $request->bookId,
            "title" => Book::getTitle($request->bookId),
            "ebookURL" => SampleEbookFile::getSampleBookFileURL($request->bookId),
        ];
        return view('pages.buyer.read_sample', $data);
    }

    public function readBook(Request $request)
    {
        $data = [
            "bookId" => $request->bookId,
            "title" => Book::getTitle($request->bookId),
            "ebookURL" => EbookFile::getBookFileURL($request->bookId),
        ];
        return view('pages.buyer.read_book', $data);
    }
}
