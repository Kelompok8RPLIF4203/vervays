<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookSnapshot
{
    public static function getPrice($bookId, $orderId)
    {
        return DB::table('book_snapshots')
                    ->where('bookId', $bookId)
                    ->where('orderId', $orderId)
                    ->pluck('price')[0];
    }

    public static function getTotalOrderPrice($orderId)
    {
        return DB::table('book_snapshots')
                    ->where('orderId', $orderId)
                    ->select(DB::raw('SUM(`price`) as totalPrice'))
                    ->get()[0]->totalPrice;
    }

    public static function getArrBookIdByOrderId($orderId)
    {
        return DB::table('book_snapshots')->where('orderId', $orderId)->pluck('bookId');
    }

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
