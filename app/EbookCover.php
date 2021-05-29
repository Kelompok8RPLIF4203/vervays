<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EbookCover
{
    public static function getEbookCoverByBookId($bookId)
    {
        $ebookCoverId = Book::getEbookCoverId($bookId);
        return DB::table('ebook_covers')
                    ->select('id', 'name')
                    ->where('id', $ebookCoverId)
                    ->get()[0];
    }

    public static function getEbookCoverURL($ebookCoverId)
    {
        $fileName = DB::table('ebook_covers')
                        ->where('id', $ebookCoverId)
                        ->first()
                        ->name;
        return url("ebook/ebook_cover/".$ebookCoverId."/".$fileName);
    }

    public static function getNewEbookCoverId()
    {
        return DB::table('ebook_covers')->get()->count() + 1;
    }

    public static function uploadCoverPhoto($file, $bookId)
    {
        $photoId = EbookCover::getNewEbookCoverId();
        $photo = $file;
        $nama_file = $photo->getClientOriginalName();
        $tujuan_upload = 'ebook/ebook_cover/'.$photoId;
        $photo->move($tujuan_upload,$nama_file);
        DB::table('ebook_covers')->insert([
            "id" => $photoId,
            "name" => $photo->getClientOriginalName(),
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        return $photoId;
    }
}
