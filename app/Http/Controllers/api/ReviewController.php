<?php

namespace App\Http\Controllers\api;

use App\Have;
use App\Http\Controllers\Controller;
use App\Reviews;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function haveUserGivenBookRating(Request $request)
    {
        return response()->json(Reviews::didTheUserGiveAReview($request->bookId));
    }

    public function store(Request $request)
    {
        $haveId = Have::getIdByUserIdAndBookId(session(('id')), $request->bookId);
        Reviews::store($request->rating, $request->review, $request->isAnonymous, $haveId);
    }
}
