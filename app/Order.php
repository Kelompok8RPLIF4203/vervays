<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

// source code ini digunakan sebagai model dari tabel 'order' yang ada di database
// Melalui souce code ini, web vervays bisa mengambil, menghapus, menambah, dan memperbarui data pada tabel 'order'

class Order extends Model
{
    // PG artinya Payment Gateway
    
    // Method ini digunakan untuk mengembalikan status user dalam halaman ebook_info
    // @param $bookId : id buku
    // @return : status user (seperti enum)
    public static function getUserRoleForEbookInfoPage($bookId)
    {
        // Status 1 : Sebagai publisher
        // Status 2 : Sebagai buyer yang blm membeli buku
        // Status 3 : Sebagai buyer yang sedang atau sudah membeli buku

        // mengambil user id dari session
        $userId = session('id');
        
        // mengambil id publisher dari id buku
        $publisherId = Book::getPublisherIdByBookId($bookId);

        // mengambil id user dari id publisher
        $publisherUserId = Publisher::getUserIdByPublisherId($publisherId);

        if ($publisherUserId == $userId) { // Jika publisher sedang membuka halaman ebook_info
            return 1;
        }
        else if (Order::whetherTheBuyerHasntPurchasedBook($userId, $bookId)) { // Jika buyer belum membeli buku
            return 2;
        }
        return 3; // jika buyer sedang atau sudah membeli buku
    }
    
    // Method ini digunakan untuk mengembalikan boolean apakah buyer belum membeli buku
    // @param $buyerId : id buyer
    // @param $bookId : id buku
    // @return : boolean apakah buyer belum membeli buku
    private static function whetherTheBuyerHasntPurchasedBook($buyerId, $bookId)
    {
        if (Order::whetherTheBuyerHasAlreadyPurchasedBook($buyerId, $bookId) || Order::whetherTheBuyerIsBuyingBook($buyerId, $bookId)) {
            return false;
        }
        return true;
    }

    // Method ini digunakan untuk mengembalikan boolean apakah buyer sudah membeli buku
    // @param $buyerId : id buyer
    // @param $bookId  : id buku
    // @return : boolean apakah buyer sudah membeli buku
    private static function whetherTheBuyerHasAlreadyPurchasedBook($buyerId, $bookId)
    {
        $count = DB::table('orders')
                        ->join('users', 'users.id', '=', 'orders.userId')
                        ->join('book_snapshots', 'book_snapshots.orderId', '=', 'orders.id')
                        ->where('users.id', $buyerId)
                        ->where('book_snapshots.bookId', $bookId)
                        ->where('status', 'success')
                        ->count(); // mendapatkan data banyak order yang sesuai dengan parameter
        if ($count != 0) { // jika tidak ada data
            return true;
        }
        return false; // jika ada data
    }

    // Method ini digunakan untuk mengembalikan boolean apakah buyer sedang membeli buku
    // @param $buyerId : id buyer
    // @param $bookId  : id buku
    // @return : boolean apakah buyer sedang membeli buku
    private static function whetherTheBuyerIsBuyingBook($buyerId, $bookId)
    {
        $count = DB::table('orders')
                        ->join('users', 'users.id', '=', 'orders.userId')
                        ->join('book_snapshots', 'book_snapshots.orderId', '=', 'orders.id')
                        ->where('users.id', $buyerId)
                        ->where('book_snapshots.bookId', $bookId)
                        ->where('status', 'pending') // yang status ordernya 'pending'
                        ->count();  // mendapatkan data banyak order yang sesuai dengan parameter
        if ($count != 0) { // jika tidak ada data
            return true;
        }
        return false; // jika ada data
    }

    // Method ini digunakan untuk mengonversi integer ke format rupiah
    // @param $price : harga (integer)
    // @return : string rupiah hasil konversi
    private static function convertPriceToCurrencyFormat($price)
    {
        return number_format($price,0,',','.');
    }

    // Method ini digunakan untuk membuat id order baru
    // id order akan digunakan untuk menyimpan order baru
    // @param $price : harga (integer)
    // @return : string rupiah hasil konversi
    private static function getNewOrderId()
    {
        return DB::table('orders')->count() + 1;
    }

    // Method ini digunakan untuk membuat dan menyimpan order baru
    // @param $paymentMethod : metode pembayaran (integer);
    // @return : id order yang telah dibuat
    public static function createOrder($paymentMethod)
    {
        $createdAt = Carbon::now(); // menyimpan current time
        $dt = $createdAt->copy()->addHours(24); // menyimpan waktu tenggat pembayaran (24 jam dari current time)
        $dt->second = 0; // Membulatkan waktu tenggat
        $faker = Faker::create('id_ID'); // Membuat objek faker yang berhubungan dengan country indonesia
        $backCode = $faker->swiftBicNumber; // Membuat back code dari faker
        $orderId = Order::getNewOrderId(); // menyimpan id order baru
        $midtransOrderId = $orderId."-".$backCode; // menyimpan id order untuk dikirimkan ke PG
        $arrBookId = Cart::getUserCartBookId(); // mendapatkan id-id buku dalam keranjang belanja user
        $totalPrice = 0;  // inisialisasi total harga
        foreach ($arrBookId as $bookId) { // menghitung total harga
            $totalPrice += Book::getPrice($bookId->bookId);
        }
        $paymentCode = Order::getPaymentCode($paymentMethod, $orderId); // mendapatkan kode pembaran
        Cart::emptyUserCart(); // mengosongkan keranjang belanja user
        if ($paymentMethod == "1") { // Jika metode pembayarannya mengunakan BNI VA
            PaymentGateway::postTransactionToMidtransWithBNIVAPayment($midtransOrderId, $totalPrice); // mengirim data order ke PG
        }
        else if ($paymentMethod == "2") { // Jika metode pembayarannya menggunakan indomaret
            PaymentGateway::postTransactionToMidtransWithIndomaretPayment($midtransOrderId, $totalPrice); // mengirim data order ke PG
        }
        Order::store($orderId, $backCode, $paymentMethod, $paymentCode, $dt, $createdAt); // menyimpan data order ke database
        BookSnapshot::storeBookSnaphshotsByArrBookIdAndOrderId($arrBookId, $orderId); // menyimpan data ebook ke tabel 'book snapshot'
        return $orderId;
    }

    // Method ini digunakan untuk memperbarui payment code dari sebuah order
    // @param $orderId : id order (integer);
    public static function updatePaymentCodeFromMidtrans($orderId)
    {
        $backCode = DB::table('orders')->where('id', $orderId)->pluck('backIdCode')[0]; // mendapatkan back code
        $midtransOrderId = $orderId."-".$backCode; // menyimpan order id yang ada di PG
        $paymentMethodId = DB::table('orders')->where('id', $orderId)->pluck('paymentId')[0]; // mendapatkan data paymentId
        $paymentCode = PaymentGateway::getPaymentCodeFromMidtrans($midtransOrderId, $paymentMethodId); // mendapatkan data paymentCode dari PG
        DB::table('orders')->where('id', $orderId)->update([ // update payment code ke row order
            "paymentCode" => $paymentCode,
            "updated_at" => Carbon::now(),
        ]);
    }

    // Method ini digunakan untuk memperbarui payment code dari sebuah order
    // @param $id          : id order (integer);
    // @param $backCode    : backCode dari order (string);
    // @param $paymentId   : metode pembayaran (integer);
    // @param $paymentCode : kode pembaayaran (string);
    // @param $expiredTime : waktu tenggat pembayaran (timestamp);
    // @param $createdAt   : waktu order dibuat (timestamp);
    private static function store($id, $backCode , $paymentId, $paymentCode, $expiredTime, $createdAt)
    {
        $userId = session('id'); // mengambil id user dari session
        DB::table('orders')->insert([ // memasukkan data order ke database
            "id" => $id,
            "paymentId" => $paymentId,
            "userId" => $userId,
            "backIdCode" => $backCode,
            "paymentCode" => $paymentCode,
            "expiredTime" => $expiredTime,
            "created_at" => $createdAt,
            "updated_at" => $createdAt,
        ]);
    }

    // Method ini digunakan untuk membuat payment code berdasarkan parameter
    // @param $paymentId : id pembayaran (integer);
    // @param $orderId   : id order (integer);
    // @return kode pembayaran
    private static function getPaymentCode($paymentId, $orderId)
    {
        if ($paymentId == 1) { // jika metode pembayarannya menggunakan BNI VA
            return "21".$orderId;
        }
        else if ($paymentId == 2) { // jika metode pembayarannya menggunakan indomaret
            return "22".$orderId;
        }
        else {
            return "23".$orderId;
        }
    }

    // Method ini mengembalikan status transaksi
    // @param $bookId : id buku (integer);
    public static function whetherTheTransactionIsPendingOrSuccess($bookId)
    {
        if (Order::whetherTheBuyerHasAlreadyPurchasedBook(session('id'), $bookId)) {
            return "success";
        }
        return "pending";
    }

    // Method ini memperbarui status transaksi
    // Status transaksi didapatkan dari PG
    // Method ini diapanggil di middleware
    public static function updateStatus()
    {
        // Mendapatkan data order yang masih pending (dengan user yg sesuai)
        $orders = DB::table('orders')->where('status', 'pending')->where('userId', session('id'))->get();

        foreach ($orders as $order) { // untuk setiap order
            $midtransOrderId = $order->id."-".$order->backIdCode; // menyimpan order id
            $transactionStatus = PaymentGateway::getTransactionStatusFromMidtrans($midtransOrderId); // menyimpan status transaksi
            if($transactionStatus == "settlement") { // jika transaksinya berhasil
                DB::table('orders')->where('id', $order->id)->update([ // update status transaksi mnjd 'success'
                    "status" => "success",
                    "updated_at" => Carbon::now(),
                ]);
                $arrBookId = DB::table('orders')
                                        ->join('book_snapshots', 'orders.id', '=', 'book_snapshots.orderId')
                                        ->where('orders.id', $order->id)
                                        ->pluck('book_snapshots.bookId'); // mendapatkan id-id buku yang diorder
                foreach ($arrBookId as $bookId) { // untuk setiap id buku
                    $publisherId = Book::getPublisherIdByBookId($bookId); // mendapatkan id publisher dari id buku
                    $price = BookSnapshot::getPrice($bookId, $order->id); // mendapatkan harga buku
                    Publisher::addBalance($publisherId, $price); // menambah saldo publisher sesuai harga buku
                    Have::store(session('id'), $bookId); // menyimpan buku di tabel 'have' agar user dapat membaca buku
                }
            }
            else if($transactionStatus == "cancel" || $transactionStatus == "expire") { // jika transaksinya gagal
                DB::table('orders')->where('id', $order->id)->update([ // update status transaksi mnjd 'failed'
                    "status" => "failed",
                    "updated_at" => Carbon::now(),
                ]);
            }
        }
    }

    // Method ini digunakan untuk meng-update status transaksi publisher.
    // Jika ada transaksi yang statusnya masih "pending" namun buyer sudah membayar, maka status transaksi tersebut diubah menjadi "success"
    public static function updateStatusForPublisher()
    {
        $publisherId = Publisher::getPublisherIdWithUserId(session('id')); // mengambil id publisher

        // Variabel $orders menyimpan data order yang berkaitan dengan publisher
        $orders = DB::table('orders') // dari tabel orders
                        ->join('book_snapshots', 'orders.id', '=', 'book_snapshots.orderId') // join dengan tabel book_snapshots
                        ->join('books', 'book_snapshots.bookId', '=', 'books.id') // join dengan tabel books
                        ->join('publishers', 'books.publisherId', '=', 'publishers.id') // join dengan tabel publishers
                        ->where('publishers.id', $publisherId) // filter dengan id publishers
                        ->where('status', 'pending') // filter yang statusnya masih pending
                        ->select(DB::raw('`orders`.`id` as id')) // memilih orders.id dengan alias id
                        ->addSelect(DB::raw('`orders`.`backIdCode` as backIdCode')) // memilih orders.backIdCode dengan alias backIdCode
                        ->addSelect(DB::raw('`orders`.`userId` as userOwnerId')) // memilih orders.userId dengan alias userOwnerId
                        ->get(); // mendapatkan hasil query
        foreach ($orders as $order) {
            $midtransOrderId = $order->id."-".$order->backIdCode; // Menyimpan orderId yang ada di PG
            $transactionStatus = PaymentGateway::getTransactionStatusFromMidtrans($midtransOrderId); // mengambil status transaksi
            if($transactionStatus == "settlement") { // jika transaksinya selesai
                DB::table('orders')->where('id', $order->id)->update([ // update status transaksi yang ada di database menjadi "success"
                    "status" => "success",
                    "updated_at" => Carbon::now(),
                ]);

                // Variabel $arrBookId menyipan id-id buku yang dibeli pada order
                $arrBookId = DB::table('orders')
                                        ->join('book_snapshots', 'orders.id', '=', 'book_snapshots.orderId')
                                        ->where('orders.id', $order->id)
                                        ->pluck('book_snapshots.bookId');
                foreach ($arrBookId as $bookId) {
                    $publisherId = Book::getPublisherIdByBookId($bookId); // mendapatkan id publisher
                    $price = BookSnapshot::getPrice($bookId, $order->id); // mendapatkan harga buku
                    Publisher::addBalance($publisherId, $price); // menambah saldo publisher
                    Have::store($order->userOwnerId, $bookId); // menyimpan buku dalam koleksi user
                }
            }
            else if($transactionStatus == "cancel" || $transactionStatus == "expire") { // jika transaksinya gagal
                DB::table('orders')->where('id', $order->id)->update([ // update status transaksi yang ada di database menjadi "failed"
                    "status" => "failed",
                    "updated_at" => Carbon::now(),
                ]);
            }
        }
    }

    // Method ini digunakan untuk mengembalikan data order user
    // @param $userId : id user
    public static function getUserOrders($userId)
    {
        $orders = DB::table('orders')
                        ->select('id', 'created_at', 'status')
                        ->where('userId', $userId)
                        ->orderBy('created_at', 'desc')
                        ->get(); // mendapatkan data order
        foreach ($orders as $order) {
            $order->created_at = Carbon::parse($order->created_at)->toDateString(); // mengubah field created_at menjadi string
            $order->totalPrice = Order::getTotalPrice($order->id); // mendapatkan total harga order
        }
        return $orders;
    }

    // method ini digunakan untuk mengembalikan total harga dari sebuah order
    // @param $orderId : id dari order yang akan dikembalikan total harganya
    public static function getTotalPrice($orderId)
    {
        return BookSnapshot::getTotalOrderPrice($orderId);
    }

    // method ini digunakan untuk mengembalikan id - id buku dari sebuah order
    // @param $orderId : id dari order yang akan dikembalikan id - id bukunya
    public static function getBooksByOrderId($orderId)
    {
        $arrBookId = BookSnapshot::getArrBookIdByOrderId($orderId);
        return Book::getBooksByArrBookId($arrBookId);
    }

    // method ini digunakan untuk mengambil data sebuah order dari database
    // @param $orderId : id order yang akan diambil datanya
    public static function getOrderForOrderInfoPage($orderId)
    {
        // Variabel $order menyimpan data order dari database
        $order = DB::table('orders')
                    ->where('id', $orderId)
                    ->select('id', 'created_at', 'status', 'paymentId', 'paymentCode', 'expiredTime')
                    ->first();
        $dt = Carbon::parse($order->created_at); // parsing field created_at menjadi object Carbon
        $order->createdDate = $dt->toDateString(); // menyimpan tanggal created_at sebagai string
        $order->createdTime = $dt->toTimeString(); // menyimpan waktu created_at sebagai string
        $dt = Carbon::parse($order->expiredTime); // parsing field expiredTime menjadi object Carbon
        $order->expiredDate = $dt->toDateString(); // menyimpan tanggal expiredTime sebagai string
        $order->expiredTime = $dt->toTimeString(); // menyimpan waktu expiredTime sebagai string
        $order->totalPrice = BookSnapshot::getTotalOrderPrice($order->id); // mendapatkan total harga order
        $order->totalPrice = Order::convertPriceToCurrencyFormat($order->totalPrice); // mengonversi totalPrice menjadi string (dalam format rupiah)
        $order->codeName = Payment::getCodeName($order->paymentId); // mendapatkan nama metode pembayaran
        $order->paymentMethod = Payment::getName($order->paymentId); // mendapatkan id metode pembayaran
        return $order;
    }

    // mendapatkan id metode pembayaran dari sebuah order
    // @param $orderId : id order yang akan id metode pembayarannya
    public static function getPaymentId($orderId)
    {
        return DB::table('orders')->where('id', $orderId)->pluck('paymentId')[0];
    }

    // Method ini digunakan untuk membatalkan semua pesanan dari seorang buyer
    // @param $userId : id user yang akan dibatalkan pesanannya
    public static function cancelAllOrderByUserId($userId)
    {
        DB::table('orders')->where('userId', $userId)->update([
            "status" => "failed",
            "updated_at" => Carbon::now(),
        ]);
    }

}
