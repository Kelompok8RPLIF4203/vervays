<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Cart
{
    public static function emptyUserCart()
    {
        $userId = session('id');
        DB::table('carts')->where('userId', $userId)->delete();
    }

    public static function getUserCartBookId()
    {
        $userId = session('id');
        return DB::table('carts')
                        ->where('carts.userId', $userId)
                        ->select('carts.bookId')
                        ->get();
    }

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

    private static function convertPriceToCurrencyFormat($price)
    {
        return number_format($price,0,',','.');
    }

    public static function removeAllBookByPublisherId($publisherId)
    {
        DB::table('carts')
                ->join('books', 'carts.bookId', '=', 'books.id')
                ->join('publishers', 'books.publisherId', '=', 'publishers.id')
                ->where('publishers.id', $publisherId)
                ->delete();
    }

    public static  function removeAllBookByBookId($bookId)
    {
        DB::table('carts')
            ->where('bookId', $bookId)
            ->delete();
    }
}
