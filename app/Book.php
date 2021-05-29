<?php

namespace App;

use Illuminate\Support\Facades\DB;
use App\BookSnapshot;
use App\Publisher;
use App\Reviews;
use App\SampleEbookFile;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

// source code ini digunakan sebagai model dari tabel 'books' yang ada di database
// Melalui souce code ini, web vervays bisa mengambil, menghapus, menambah, dan memperbarui data pada tabel 'books'

class Book extends Model
{
    // Nama tabel yang ada pada database
    protected $table = "books";

    // Atribut yang ada dan bisa diisi nilainya pada tabel books
    protected $fillable = [
        'id', 'title', 'author', 'languageId', 'numberOfPage',
        'price', 'synopsis', 'isDeleted', 'ebookFileId',
        'sampleEbookFileId', 'ebookCoverId', 'publisherId', 'categoryId',
    ];
    
    // Method ini digunakan untuk menyimpan datum ebook ke database
    // @param $ebookData             : Data ebook
    // @param $ebookFilesData        : Data file ebook
    // @param $sampleEbookFilesData  : Data sample file ebook
    // @param $ebookCoverData        : Data cover ebook
    public static function store($ebookData, $ebookFilesData, $sampleEbookFilesData, $ebookCoverData)
    {
        DB::table('ebook_files')->insert($ebookFilesData);
        DB::table('sample_ebook_files')->insert($sampleEbookFilesData);
        DB::table('ebook_covers')->insert($ebookCoverData);
        DB::table('books')->insert($ebookData);
    }

    // Method ini digunakan untuk membuat id ebook baru
    // @return : id ebook baru
    public static function getNewBookId()
    {
        return DB::table('books')->get()->count() + 1;
    }

    // Method ini digunakan untuk mengembalikan data buku
    // Data buku tersebut akan ditampilkan pada dashboard publisher
    // @return : Data buku yang akan ditampilkan pada dashboard publisher
    public static function getBookDataForDashboardPublisher()
    {
        $userId = session('id');
        $publisherId = Publisher::getPublisherIdWithUserId($userId);
        $books = DB::table('books')
            ->where('publisherId', $publisherId)
            ->where('isDeleted', '0')
            ->get();
        $data = [];
        foreach ($books as $book) {
            array_push($data,[
                "id" => $book->id,
                "title" => $book->title,
                "rating" => Reviews::getBookRating($book->id),
                "ratingCount" => Reviews::getBookRatingCount($book->id),
                "soldCount" => BookSnapshot::getBookSoldCount($book->id),
                "price" => Book::convertPriceToCurrencyFormat($book->price),
            ]);
        }
        $titles = array_column($data, 'title');
        array_multisort($titles, SORT_ASC, $data);
        return $data;
    }

    // Method ini digunakan untuk mengonversi integer menjadi format rupiah
    // @param $price : harga buku
    // @return : String hasil konversi ke rupiah
    private static function convertPriceToCurrencyFormat($price)
    {
        return number_format($price,0,',','.');
    }

    // Method ini digunakan untuk mengembalikan data buku
    // @param $bookId : id dari buku yang akan dikembalikan datanya
    // @return : Data buku
    public static function getBook($bookId)
    {
        return DB::table('books')
            ->where('id', $bookId)
            ->first();
    }

    // Method ini digunakan untuk memperbarui data buku
    // @param $book : data buku yang akan diperbarui
    public static function updateBook($book) {
        $data = [];
        if ($book["title"] != null) {
            $data = array_merge($data, array('title' => $book["title"]));
        }
        if ($book["author"] != null) {
            $data = array_merge($data, array('author' => $book["author"]));
        }
        if ($book["languageId"] != null) {
            $data = array_merge($data, array('languageId' => $book["languageId"]));
        }
        if ($book["numberOfPage"] != null) {
            $data = array_merge($data, array('numberOfPage' => $book["numberOfPage"]));
        }
        if ($book["price"] != null) {
            $data = array_merge($data, array('price' => $book["price"]));
        }
        if ($book["synopsis"] != null) {
            $data = array_merge($data, array('synopsis' => $book["synopsis"]));
        }
        if ($book["categoryId"] != null) {
            $data = array_merge($data, array('categoryId' => $book["categoryId"]));
        }
        if ($book["release_at"] != null) {
            $data = array_merge($data, array('release_at' => $book["release_at"]));
        }
        $data = array_merge($data, array("updated_at" => Carbon::now()));
        Book::where('id', $book["id"])->update($data);
    }

    // Method ini digunakan untuk memperbarui data ebook dengan memasukkan photoId dari ebook tersebut
    // @param $photoId : id dari foto
    // @param $bookId : id dari buku
    public static function updateCoverPhoto($photoId, $bookId)
    {
        DB::table('books')
            ->join('ebook_covers', 'books.ebookCoverId', '=', 'ebook_covers.id')
            ->where('books.id',$bookId)
            ->update([
                "ebookCoverId" => $photoId,
                "books.updated_at" => Carbon::now(),
            ]);
    }

    // Method ini digunakan untuk upload sample ebook
    // @param $file   : data file sample ebook
    // @param $bookId : id dari buku
    public static function uploadSampleEbook($file, $bookId)
    {
        $sampleEbookId = SampleEbookFile::getNewSampleEbookFilesId();
        $SampleEbook = $file;
        $nama_file = $SampleEbook->getClientOriginalName();
        $tujuan_upload = 'ebook/sample_ebook_files/'.$sampleEbookId;
        $SampleEbook->move($tujuan_upload,$nama_file);
        DB::table('sample_ebook_files')->insert([
            "id" => $sampleEbookId,
            "name" => $SampleEbook->getClientOriginalName(),
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('books')
            ->join('sample_ebook_files', 'books.sampleEbookFileId', '=', 'sample_ebook_files.id')
            ->where('books.id',$bookId)
            ->update([
                "sampleEbookFileId" => $sampleEbookId,
                "books.updated_at" => Carbon::now(),
            ]);
    }

    // Method ini digunakan untuk menghapus data ebook
    // Penghapusan ebook dilakukan secara soft
    // @param $id : id dari ebook yang akan di hapus
    public static function deleteBook($id) {
        $book = Book::find($id); // mencari data ebook yang akan dihapus
        $book->isDeleted = 1; // Menandai buku bahwa buku akan dihapus
        $book->save(); // Menyimpan data ke database
        Cart::removeAllBookByBookId($id); // Hapus buku pada semua cart
        Wishes::removeAllBookByBookId($id); // Hapus buku pada semua wishlist
    }

    // Method ini digunakan untuk menghapus semua data ebook yang dimiliki oleh sebuah publisher
    // Penghapusan ebook dilakukan secara soft
    // @param $publisher : id dari publisher yang akan dihapus semua ebook-nya
    public static function deleteAllPublisherBooks($publisherId)
    {
        Cart::removeAllBookByPublisherId($publisherId);
        Wishes::removeAllBookByPublisherId($publisherId);
        DB::statement('UPDATE `books` SET `isDeleted` = 1 WHERE `publisherId` = '.$publisherId);
    }

    // Method ini digunakan untuk mengembalikan enam buku terbaru
    // @return : data enam buku terbaru
    public static function getSixNewestBookForBuyerDashboard()
    {
        $books = DB::table('books')
            ->select('id', 'title', 'author', 'price', 'ebookCoverId')
            ->where('isDeleted', '0')
            ->orderBy('release_at','desc')
            ->take(6)
            ->get();
        foreach ($books as $book) {
            $book->price = Book::convertPriceToCurrencyFormat($book->price);
        }
        $bookArray = json_decode(json_encode($books), true); //mengubah objek menjadi array
        for ($i=0; $i < count($books); $i++) { 
            $rating = Reviews::getBookRating($bookArray[$i]["id"]);
            $rating = number_format((float) $rating, 1, '.', '');
            $bookArray[$i] = array_merge($bookArray[$i], array("rating" => $rating));
            $imageURL = EbookCover::getEbookCoverURL($bookArray[$i]["ebookCoverId"]);
            $bookArray[$i] = array_merge($bookArray[$i], array("imageURL" => $imageURL));
        }
        return $bookArray;
    }

    // Method ini digunakan untuk mengembalikan enam buku yang terpilih oleh editor
    // @return : data enam buku yang terpilih oleh editor
    public static function getSixEditorChoiceBookForBuyerDashboard()
    {
        $books = DB::table('books')
            ->select('id', 'title', 'author', 'price',  'ebookCoverId')
            ->where('isDeleted', '0')
            ->where('isEditorChoice', '1')
            ->take(6)
            ->get();
        foreach ($books as $book) {
            $book->price = Book::convertPriceToCurrencyFormat($book->price);
        }
        $bookArray = json_decode(json_encode($books), true); //mengubah objek menjadi array
        for ($i=0; $i < count($books); $i++) { 
            $rating = Reviews::getBookRating($bookArray[$i]["id"]);
            $rating = number_format((float) $rating, 1, '.', '');
            $bookArray[$i] = array_merge($bookArray[$i], array("rating" => $rating));
            $imageURL = EbookCover::getEbookCoverURL($bookArray[$i]["ebookCoverId"]);
            $bookArray[$i] = array_merge($bookArray[$i], array("imageURL" => $imageURL));
        }
        return $bookArray;
    }

    // Method ini digunakan untuk mengembalikan enam buku yang paling banyak terjual
    // @return : data enam buku yang paling banyak terjual
    public static function getSixBestsellerBookForBuyerDashboard()
    {
        $booksId = DB::select("SELECT `books`.`id` FROM `books`
                                JOIN `book_snapshots` ON `books`.`id` = `book_snapshots`.`bookId`
                                JOIN `orders` ON `book_snapshots`.`orderId` = `orders`.`id`
                                WHERE `orders`.`status` = 'success'
                                AND `books`.`isDeleted` = 0
                                GROUP BY `books`.`id`
                                ORDER BY COUNT(`books`.`id`) DESC
                                LIMIT 6"); //berupa array of object (array biasa)
        if (count($booksId) == 0) { // Jika tidak ada buku yang terjual
            return null;
        }
        $arrBooksId = [];
        array_splice($arrBooksId,0,1,$booksId);
        $pureArrBooksId = [];
        for ($i=0; $i < count($arrBooksId); $i++) { 
            if ($i == 0) {
                $pureArrBooksId[0] = $arrBooksId[0]->id;
            }
            else {
                array_push($pureArrBooksId, $arrBooksId[$i]->id);
            }
        }
        $books = DB::table('books')
            ->select('id', 'title', 'author', 'price',  'ebookCoverId')
            ->where('isDeleted', '0')
            ->whereIn('id', $pureArrBooksId)
            ->take(6)
            ->get();
        foreach ($books as $book) {
            $book->price = Book::convertPriceToCurrencyFormat($book->price);
        }
        $bookArray = json_decode(json_encode($books), true); //mengubah objek menjadi array
        for ($i=0; $i < count($books); $i++) { 
            $rating = Reviews::getBookRating($bookArray[$i]["id"]);
            $rating = number_format((float) $rating, 1, '.', '');
            $bookArray[$i] = array_merge($bookArray[$i], array("rating" => $rating));
            $imageURL = EbookCover::getEbookCoverURL($bookArray[$i]["ebookCoverId"]);
            $bookArray[$i] = array_merge($bookArray[$i], array("imageURL" => $imageURL));
            $soldCount = BookSnapshot::getBookSoldCount($bookArray[$i]["id"]);
            $bookArray[$i] = array_merge($bookArray[$i], array("soldCount" => $soldCount));
        }
        \usort($bookArray, function ($book1, $book2) {
            return $book2['soldCount'] <=> $book1['soldCount'];
        });
        return $bookArray;
    }

    // Method ini digunakan untuk mengembalikan hasil pencarian ebook
    // @param $keyword : Kata kunci pencarian
    // @return : hasil pencarian
    public static function getBookForSearch($keyword)
    {
        $keywords = explode(" ",$keyword);
        $addOnQuery = " ";
        foreach ($keywords as $katakunci) {
            $addOnQuery = $addOnQuery."AND `title` LIKE '%".$katakunci."%' ";
        }
        $query = "SELECT
                    `books`.`id`, `title`, `author`, `languageId`, `price`, `release_at`, `synopsis`,
                    `ebookCoverId`, `categoryId`,
                    `languages`.`name` as 'Language' ,
                    `ebook_covers`.`name` as 'ebookCoverName',
                    `categories`.`name` as 'Category'
                    FROM `books` 
                    JOIN `ebook_covers` ON `books`.`ebookCoverId` = `ebook_covers`.`id`
                    JOIN `languages` ON `books`.`languageId` = `languages`.`id`
                    JOIN `categories` ON `books`.`categoryId` = `categories`.`id`
                    WHERE `isDeleted` = 0";
        $query = $query.$addOnQuery;
        $books = DB::select($query, [1]);
        foreach ($books as $book) {
            $book->rating = Reviews::getBookRating($book->id);
            $book->ratingCount = Reviews::getBookRatingCount($book->id);
            $book->soldCount = BookSnapshot::getBookSoldCount($book->id);
            $book->priceForHuman = Book::convertPriceToCurrencyFormat($book->price);
        }
        return response()->json($books);
    }

    // Method ini digunakan untuk mengembalikan nama bahasa
    // @param $languageId : id bahasa
    // @return : Nama bahasa
    private static function getLanguageName($languageId)
    {
        return DB::table('languages')
                    ->where('id', $languageId)
                    ->pluck('name')[0];
    }

    // Method ini digunakan untuk mengembalikan nama kategori
    // @param $languageId : id kategori
    // @return : Nama kategori
    private static function getCategoryName($categoryId) {
        return DB::table('categories')
                    ->where('id', $categoryId)
                    ->pluck('name')[0];
    }

    // Method ini digunakan untuk mengembalikan data buku untuk halaman ebook_info
    // @param $id : id buku
    // @return : data buku
    public static function getBookForInfoPage($id)
    {
        $book = DB::table('books')
                    ->where('id', $id)
                    ->first();
        $book->priceForHuman = Book::convertPriceToCurrencyFormat($book->price);
        $book->language = Book::getLanguageName($book->languageId);
        $book->category = Book::getCategoryName($book->categoryId);
        $book->publisher = Publisher::getPublisherName($book->publisherId);
        $rating = Reviews::getBookRating($book->id);
        $rating = number_format((float) $rating, 1, '.', '');
        $book->rating = $rating;
        $book->ratingCount = Reviews::getBookRatingCount($book->id);
        $book->soldCount = BookSnapshot::getBookSoldCount($book->id);
        $book->imageURL = EbookCover::getEbookCoverURL($book->ebookCoverId);
        unset($book->ebookCoverId);
        unset($book->created_at);
        unset($book->updated_at);
        unset($book->price);
        unset($book->isDeleted);
        unset($book->isEditorChoice);
        return json_decode(json_encode($book), true);
    }

    // Method ini digunakan untuk mengembalikan seberapa banyak orang yang telah merating sebuah buku
    // @param $bookId : id buku
    // @return : banyak orang yang telah merating sebuah buku
    public static function getPeopleGaveStarsCountAllRating($bookId)
    {
        return DB::table('reviews')
                    ->join('have', 'reviews.haveId', '=', 'have.id')
                    ->where('have.bookId', $bookId)
                    ->count();
    }

    // Method ini digunakan untuk mengembalikan seberapa banyak orang yang telah merating sebuah buku sesuai kategori rating
    // @param $bookId : id buku
    // @param $rating : Rating (1 atau 2 atau 3 atau 4 atau 5)
    // @return : banyak orang yang telah merating sebuah buku
    public static function getPeopleGaveStarsCountByRating($bookId, $rating)
    {
        return DB::table('reviews')
                    ->join('have', 'reviews.haveId', '=', 'have.id')
                    ->where('have.bookId', $bookId)
                    ->where('rating', $rating)
                    ->count();
    }

    // Method ini digunakan untuk mengembalikan ulasan buku
    // @param $bookId : id buku
    // @return : data ulasan buku
    public static function getReviewsByBookId($bookId)
    {
        $reviews = DB::table('reviews')
                        ->select('reviews.id', 'rating', 'review', 'isAnonymous', 'firstName', 'lastName', 'isDeleted', 'reviews.created_at')
                        ->join('have', 'reviews.haveId', '=', 'have.id')
                        ->join('users', 'have.userId', '=', 'users.id')
                        ->where('have.bookId', $bookId)
                        ->orderBy('reviews.id', 'asc')
                        ->get();
        foreach ($reviews as $review) {
            $created_at = Carbon::parse($review->created_at)->toDateString();
            $review->created_at = $created_at;
        }
        return $reviews;
    }

    // Method ini digunakan untuk mengembalikan id publisher berdasarkan id buku
    // @param $bookId : id buku
    // @return : id publisher
    public static function getPublisherIdByBookId($bookId)
    {
        return DB::table('books')
                    ->where('id', $bookId)
                    ->get()[0]->publisherId;
    }

    // Method ini digunakan untuk mengembalikan harga total dari satu atau beberapa buku
    // @param $arrBookId : array yang berisi id-id buku
    // @return : total harga buku
    public static function getTotalPrice($arrBookId)
    {
        $totalPrice = 0;
        foreach ($arrBookId as $book) {
            $totalPrice = $totalPrice + DB::table('books')->where('id', $book->bookId)->pluck('price')[0];
        }
        return $totalPrice;
    }

    // Method ini digunakan untuk mengembalikan harga total dari suatu buku
    // @param $bookId : id buku
    // @return : harga buku
    public static function getPrice($bookId)
    {
        return DB::table('books')->where('id', $bookId)->pluck('price')[0];
    }

    // Method ini digunakan untuk mengembalikan judul dari suatu buku
    // @param $bookId : id buku
    // @return : judul buku
    public static function getTitle($bookId)
    {
        return DB::table('books')->where('id', $bookId)->pluck('title')[0];
    }

    // Method ini digunakan untuk mengembalikan data buku dari array yang berisi id-id buku
    // @param $arrBookId : array berisi id-id buku
    // @return : data buku-buku
    public static function getBooksByArrBookId($arrBookId)
    {
        return DB::table('books')->whereIn('id', $arrBookId)->get();
    }

    // Method ini digunakan untuk mengembalikan nama publisher dari suatu buku
    // @param $bookId : id buku
    // @return : Nama publisher
    public static function getPublisherName($bookId)
    {
        $publisherId = DB::table('books')->where('id', $bookId)->pluck('publisherId')[0];
        return Publisher::getPublisherName($publisherId);
    }

    // Method ini digunakan untuk mengembalikan 'id cover ebook' dari suatu buku
    // @param $bookId : id buku
    // @return : id cover ebook
    public static function getEbookCoverId($bookId)
    {
        return DB::table('books')->where('id', $bookId)->pluck('ebookCoverId')[0];
    }

    // Method ini digunakan untuk mengembalikan data 'sample ebook' dari suatu buku
    // @param $bookId : id buku
    // @return : data 'sample ebook'
    public static function getSampleEbookFileId($bookId)
    {
        return DB::table('books')->where('id', $bookId)->pluck('sampleEbookFileId')[0];
    }

    // Method ini digunakan untuk mengembalikan data 'file ebook' dari suatu buku
    // @param $bookId : id buku
    // @return : data 'file ebook'
    public static function getEbookFileId($bookId)
    {
        return DB::table('books')->where('id', $bookId)->pluck('ebookFileId')[0];
    }

    // Method ini digunakan untuk mengembalikan data 'ebook' untuk ditampilkan pada halaman book_collection
    // @return : data buku
    public static function getBookDataForBookCollectionPage()
    {
        $books = DB::table('books')
                        ->join('have', 'have.bookId', '=', 'books.id')
                        ->join('ebook_covers', 'books.ebookCoverId', '=', 'ebook_covers.id')
                        ->where('have.userId', '=', session('id'))
                        ->select('title', 'author')
                        ->addSelect(DB::raw('`books`.`id` as id'))
                        ->addSelect(DB::raw('`ebook_covers`.`id` as ebookCoverId'))
                        ->addSelect(DB::raw('`ebook_covers`.`name` as ebookCoverFileName'))
                        ->get();
        foreach ($books as $book) {
            $book->didTheUserGiveAReview = Reviews::didTheUserGiveAReview($book->id);
        }
        return $books;
    }

    // Method ini digunakan untuk mengembalikan data 'ebook' untuk ditampilkan pada halaman give_review
    // @return : data buku
    public static function getBookDataForReviewPage($bookId)
    {
        $book = DB::table('books')
                    ->join('publishers', 'publishers.id', '=', 'books.publisherId')
                    ->join('ebook_covers', 'books.ebookCoverId', '=', 'ebook_covers.id')
                    ->where('books.id', $bookId)
                    ->select('books.id', 'title', 'author')
                    ->addSelect(DB::raw('`publishers`.`name` as publisherName'))
                    ->addSelect(DB::raw('`ebook_covers`.`id` as ebookCoverId'))
                    ->first();
        $book->ebookCoverURL = EbookCover::getEbookCoverURL($book->ebookCoverId);
        unset($book->getEbookCoverId);
        return $book;
    }

    // Method ini digunakan untuk mengembalikan boolean yang menyatakan apakah buku sudah dihapus atau belum
    // @param bookId : id buku
    // @return : boolean yang menyatakan apakah buku sudah dihapus atau belum
    public static function isBookNotDeleted($bookId)
    {
        $count = DB::table('books')
                        ->where('id', $bookId)
                        ->where('isDeleted', 0)
                        ->get()
                        ->count();
        return $count == 1;
    }

    // Method ini digunakan untuk mengembalikan data apakah buku
    // Data buku tersebut akan ditampilkan pada halaman info_publisher
    // @param publisherId : id publisher
    // @return : data ebook
    public static function getBookDataForPublisherInfoPage($publisherId)
    {
        $books = DB::table('books')
                        ->where('publisherId', $publisherId)
                        ->where('isDeleted', '0')
                        ->get();
        $data = [];
        foreach ($books as $book) {
            $rating = Reviews::getBookRating($book->id);
            $rating = number_format((float) $rating, 1, '.', '');
            array_push($data,[
                "id" => $book->id,
                "title" => $book->title,
                "author" => $book->author,
                "imageURL" => EbookCover::getEbookCoverURL($book->ebookCoverId),
                "synopsis" => $book->synopsis,
                "rating" => $rating,
                "ratingCount" => Reviews::getBookRatingCount($book->id),
                "soldCount" => BookSnapshot::getBookSoldCount($book->id),
                "price" => Book::convertPriceToCurrencyFormat($book->price),
            ]);
        }
        return $data;
    }

    // Method ini digunakan untuk mengembalikan data ebook
    // Data tersebut akan ditampilkan pada halaman info_order
    // @param orderId : id order
    // @return : data ebook yang sesuai dengan id order
    public static function getBookDataForOrderInfoPage($orderId)
    {
        $arrBookId = BookSnapshot::getArrBookIdByOrderId($orderId);
        $books = DB::table('books')
                        ->whereIn('id', $arrBookId)
                        ->select('id', 'title' ,'author', 'publisherId', 'ebookCoverId')
                        ->get();
        foreach ($books as $book) {
            $price = BookSnapshot::getPrice($book->id, $orderId);
            $book->price = Book::convertPriceToCurrencyFormat($price);
            $book->publisherName = Publisher::getPublisherName($book->publisherId);
            $book->coverURL = EbookCover::getEbookCoverURL($book->ebookCoverId);
            unset($book->publisherId);
            unset($book->ebookCoverId);
        }
        return $books;
    }
}
