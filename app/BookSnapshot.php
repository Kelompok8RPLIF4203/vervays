<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookSnapshot
{
    // Method ini digunakan untuk mengembalikan harga buku
    // @param $bookId  : id buku
    // @param $orderId : id order
    public static function getPrice($bookId, $orderId)
    {
        return DB::table('book_snapshots')
                    ->where('bookId', $bookId)
                    ->where('orderId', $orderId)
                    ->pluck('price')[0];
    }

    // Method ini digunakan untuk mengembalikan total harga dari sebuah order
    // @param $orderId : id order
    public static function getTotalOrderPrice($orderId)
    {
        return DB::table('book_snapshots')
                    ->where('orderId', $orderId)
                    ->select(DB::raw('SUM(`price`) as totalPrice'))
                    ->get()[0]->totalPrice;
    }

    // Method ini digunakan untuk mengembalikan id-id buku dari sebuah order
    // @param $orderId : id order
    public static function getArrBookIdByOrderId($orderId)
    {
        return DB::table('book_snapshots')->where('orderId', $orderId)->pluck('bookId');
    }

    // Method ini digunakan untuk menyimpan BookSnapshot baru
    // $arrBookId : id-id buku yang akan disimpan
    // $orderId   : id order
    public static function storeBookSnaphshotsByArrBookIdAndOrderId($arrBookId, $orderId)
    {
        foreach ($arrBookId as $book) {
            $now = Carbon::now();
            DB::table('book_snapshots')->insert([
                "bookId" => $book->bookId,
                "orderId" => $orderId,
                "price" => Book::getPrice($book->bookId),
                "created_at" => $now,
                "updated_at" => $now,
            ]);
        }
    }

    // Method ini digunakan untuk mengembalikan nilai berupa berapa banyak sebuah buku berhasil terjual
    // @param $id : id BookSnaphot
    public static function getBookSoldCount($id)
    {
        $soldCount = DB::table('book_snapshots')
            ->join('orders', 'book_snapshots.orderId', '=', 'orders.id')
            ->where('book_snapshots.bookId', $id)
            ->where('orders.status', 'success')
            ->count();
        return $soldCount ?? 0;
    }
}
