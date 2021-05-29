<?php

namespace App;

use Illuminate\Support\Facades\DB;
use App\Book;
use Illuminate\Database\Eloquent\Model;

class SampleEbookFile extends Model
{
    protected $table = 'sample_ebook_files';

    protected $primaryKey = 'id';

    public static function getNewSampleEbookFilesId()
    {
        return SampleEbookFile::get()->count() + 1;
    }
    
    public static function getSampleEbookFile($sampleEbookFileId)
    {
        return DB::table('sample_ebook_files')
                    ->select('id', 'name')
                    ->where('id' , $sampleEbookFileId)
                    ->first();
    }

    public static function getSampleBookFileURL($bookId)
    {
        $sampleEbookFileId = Book::getSampleEbookFileId($bookId);
        $sampleEbookFile = SampleEbookFile::getSampleEbookFile($sampleEbookFileId);
        return "/ebook/sample_ebook_files/".$sampleEbookFile->id."/".$sampleEbookFile->name;
    }
}
