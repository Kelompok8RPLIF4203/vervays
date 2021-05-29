<?php

namespace App\Http\Controllers\api;

use App\EbookCover;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EbookCoverController extends Controller
{
    public function getEbookCoverByBookId(Request $request)
    {
        return response()->json(EbookCover::getEbookCoverByBookId($request->bookId));
    }
}
