<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Cart
{
    // Method ini digunakan untuk mengosongkan keranjang belenja user
    public static function emptyUserCart()
    {
        $userId = session('id'); // mengambil id user yang sedang login
        DB::table('carts')->where('userId', $userId)->delete(); // Menghapus isi keranjang belanja user
    }

    // Method ini digunakan untuk mengambil id-id buku yang ada di keranjang belanja user
    public static function getUserCartBookId()
    {
        $userId = session('id'); // mengambil id user yang sedang login
        return DB::table('carts')
                        ->where('carts.userId', $userId)
                        ->select('carts.bookId')
                        ->get();
    }

    // Method ini digunakan untuk menentukan apakah sebuah buku ada di keranjang belanja user
    // @param $bookId : id buku yang akan dicek
    public static function whetherTheUserHasAddedBookToCart($bookId)
    {
        $userId = session('id');
        $count = DB::table('carts')
                        ->where('userId', $userId)
                        ->where('bookId', $bookId)
                        ->count();
        if ($count == 1) {
            return json_encode(true);
        }
        return json_encode(false);
    }

    // Method ini digunakan untuk menentukan apakah sebuah buku ada di keranjang belanja user
    // Method ini dipanggil oleh method lain yang ada di class ini
    // @param $bookId : id buku yang akan dicek
    public static function whetherTheUserHasAddedBookToCartForModel($bookId)
    {
        $userId = session('id');
        $count = DB::table('carts')
                        ->where('userId', $userId)
                        ->where('bookId', $bookId)
                        ->count();
        if ($count == 1) {
            return true;
        }
        return false;
    }

    // Method ini digunakan untuk menambahkan sebuah buku ke keranjang belanja
    // @param $bookId : id buku yang akan ditambahkan ke keranjang belanja
    public static function addBookToCart($bookId)
    {
        if (!Cart::whetherTheUserHasAddedBookToCartForModel($bookId)) {
            $userId = session('id');
            DB::table('carts')->insert([
                'bookId' => $bookId,
                'userId' => $userId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }

    // Method ini digunakan untuk menghapus buku dari keranjang belanja
    // @param $bookId : id buku yang akan ditambahkan ke keranjang belanja
    public static  function removeBookFromCart($bookId)
    {
        if (Cart::whetherTheUserHasAddedBookToCartForModel($bookId)) {
            $userId = session('id');
            DB::table('carts')
                ->where('bookId', $bookId)
                ->where('userId', $userId)
                ->delete();
        }
    }

    // Method ini digunakan untuk mendapatkan data keranjang belanja user
    public static function getUserCart()
    {
        $userId = session('id');
        $cart = DB::table('carts')
                        ->join('books', 'carts.bookId', '=', 'books.id')
                        ->join('publishers', 'books.publisherId', '=', 'publishers.id')
                        ->join('ebook_covers', 'books.ebookCoverId', '=', 'ebook_covers.id')
                        ->where('carts.userId', $userId)
                        ->select('carts.bookId', 'books.title', 'books.author', 'books.price', 'ebookCoverId')
                        ->addSelect(DB::raw('`publishers`.`name` as publisherName'))
                        ->addSelect(DB::raw('`ebook_covers`.`name` as ebookCoverName'))
                        ->get();
        foreach ($cart as $book) {
            $book->priceForHuman = Cart::convertPriceToCurrencyFormat($book->price);
        }
        return response()->json($cart);
    }

    // Method ini digunakan untuk mengonversi string ke format mata uang
    private static function convertPriceToCurrencyFormat($price)
    {
        return number_format($price,0,',','.');
    }

    // Method ini digunakan untuk menghapus semua buku dari suatu publisher di semua keranjang belanja user
    public static function removeAllBookByPublisherId($publisherId)
    {
        DB::table('carts')
                ->join('books', 'carts.bookId', '=', 'books.id')
                ->join('publishers', 'books.publisherId', '=', 'publishers.id')
                ->where('publishers.id', $publisherId)
                ->delete();
    }

    // Method ini digunakan untuk menghapus sebuah buku di semua keranjang belanja user
    public static  function removeAllBookByBookId($bookId)
    {
        DB::table('carts')
            ->where('bookId', $bookId)
            ->delete();
    }
}
