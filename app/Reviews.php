<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Reviews
{
    public static function didTheUserGiveAReview($bookId)
    {
        $count = DB::table('reviews')
                        ->join('have', 'reviews.haveId', '=', 'have.id')
                        ->where('have.userId', session('id'))
                        ->where('have.bookId', $bookId)
                        ->get()
                        ->count();
        return $count == 1;
    }

    public static function store($rating, $review, $isAnonymous, $haveId)
    {
        $now = Carbon::now();
        DB::table('reviews')->insert([
            "id" => Reviews::getNewId(),
            "rating" => $rating,
            "review" => $review,
            "isAnonymous" => $isAnonymous,
            "haveId" => $haveId,
            "created_at" => $now,
            "updated_at" => $now,
        ]);
    }

    private static function getNewId()
    {
        return DB::table('reviews')->get()->count() + 1;
    }

    public static function getBookRating($id)
    {
        $rating = DB::table('reviews')
            ->join('have', 'reviews.haveId', '=', 'have.id')
            ->where('bookId', $id)
            ->avg('rating');
        return $rating ?? 0;
    }

    public static function getBookRatingCount($id)
    {
        $ratingCount = DB::table('reviews')
            ->join('have', 'reviews.haveId', '=', 'have.id')
            ->where('bookId', $id)
            ->count();
        return $ratingCount ?? 0;
    }
}
