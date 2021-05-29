<?php

namespace App;

use Illuminate\Support\Facades\DB;
use App\Book;

class EbookFile
{
    public static function getEbookFile($ebookFileId)
    {
        return DB::table('ebook_files')
                    ->select('id', 'name')
                    ->where('id' , $ebookFileId)
                    ->first();
    }

    public static function getBookFileURL($bookId)
    {
        $ebookFileId = Book::getEbookFileId($bookId);
        $ebookFile = EbookFile::getEbookFile($ebookFileId);
        return "/ebook/ebook_files/".$ebookFile->id."/".$ebookFile->name;
    }

    public static function getNewEbookFilesId()
    {
        return DB::table('ebook_files')->get()->count() + 1;
    }
}
