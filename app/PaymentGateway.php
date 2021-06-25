<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    // Method ini digunakan untuk mengirim data order ke PG (Payment Gateway) dengan metode pembarannya menggunakan BNI VA
    // @param $midtransOrderId : id order yang akan digunakan di PG (string);
    // @param $totalAmount     : total dana dalam transaksi (integer);
    public static function postTransactionToMidtransWithBNIVAPayment($midtransOrderId, $totalAmount)
    {
        $curl = curl_init(); // inisiasi cURL

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.sandbox.midtrans.com/v2/charge",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "{ \"payment_type\": \"bank_transfer\", \"transaction_details\": {\"gross_amount\": {$totalAmount}, \"order_id\": \"$midtransOrderId\" }, \"customer_details\": { \"email\": \"noreply@example.com\", \"first_name\": \"Vervays\", \"last_name\": \"user\", \"phone\": \"+6281 1234 1234\" }, \"item_details\": [ { \"id\": \"ebook\", \"price\": {$totalAmount}, \"quantity\": 1, \"name\": \"Ebook\" } ], \"bank_transfer\":{ \"bank\": \"bni\", \"va_number\": \"12345678\" } }",
        CURLOPT_HTTPHEADER => array(
            "Accept: application/json",
            "Content-Type: application/json",
            env("MIDTRANS_AUTHORIZATION")
        ),
        )); // mengirim data transaksi

        $response = curl_exec($curl);

        curl_close($curl); // menutup curl
        // echo $response;
    }

    // Method ini digunakan untuk mengirim data order ke PG (Payment Gateway) dengan metode pembayarannya menggunakan Indomaret
    // @param $midtransOrderId : id order yang akan digunakan di PG (string)
    // @param $totalAmount     : total dana dalam transaksi (integer)
    public static function postTransactionToMidtransWithIndomaretPayment($midtransOrderId, $totalAmount)
    {
        $curl = curl_init(); // inisiasi curl

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.sandbox.midtrans.com/v2/charge",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>"{
            \"payment_type\": \"cstore\",
            \"transaction_details\": {
                \"gross_amount\": {$totalAmount},
                \"order_id\": \"{$midtransOrderId}\"
            },
            \"customer_details\": {
                \"email\": \"noreply@example.com\",
                \"first_name\": \"Vervays\",
                \"last_name\": \"user\",
                \"phone\": \"+6281 1234 1234\"
            },
            \"item_details\": [
            {
               \"id\": \"item01\",
               \"price\": {$totalAmount},
               \"quantity\": 1,
               \"name\": \"Ebook1\"
            }
           ],
          \"cstore\": {
            \"store\": \"Indomaret\",
            \"message\": \"Message to display\"
          }
        }",
        CURLOPT_HTTPHEADER => array(
            "Accept: application/json",
            "Content-Type: application/json",
            env("MIDTRANS_AUTHORIZATION")
        ),
        )); // mengirim data transaksi

        $response = curl_exec($curl);

        curl_close($curl); // menutup curl
        // echo $response;
    }

    // Method ini mengembalikan status transaksi
    // Status transaksi didapatkan dari PG
    // Method ini diapanggil di middleware
    // @param $orderId : id order (integer)
    public static function getRealStatus($orderId)
    {
        $curl = curl_init(); // inisiasi curl

        curl_setopt_array($curl, array(
        CURLOPT_URL => "http://localhost:8000/transaction/$orderId",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_POSTFIELDS =>"{\r\n    \"paymentId\" : 1,\r\n    \"paymentCode\" : 213\r\n}",
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json"
        ),
        )); // Membuat request

        $response = curl_exec($curl); // Mendapatkan hasil request

        curl_close($curl); // menutup curl
        return json_decode($response, true)["status"]; //mengembalikan status order
    }

    // Method ini digunakan untuk mengembalikan status sebuah transaksi
    // Data status transaksi diambil dari PG
    // @param $midtransOrderId : order id yang akan dikembalikan statusnya
    public static function getTransactionStatusFromMidtrans($midtransOrderId)
    {
        $curl = curl_init(); // inisialisasi cURL

        // menyimpan data cURL
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.sandbox.midtrans.com/v2/$midtransOrderId/status",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Accept: application/json",
            "Content-Type: application/json",
            "Authorization: Basic U0ItTWlkLXNlcnZlci1RMkhTRE5pX1pfcUxGNjRQdEplLUo3RWw6"
        ),
        ));

        $response = curl_exec($curl); // mengeksekusi dan mengambil hasil cURL

        curl_close($curl); // menutup cURL

        return PaymentGateway::getTransactionStatusFromResponseMidtrans($response); // return status transaksi
    }

    // Method ini digunakan untuk mengembalikan status transaksi berdasarkan dari response cURL
    // @param $response : response dari cURL
    private static function getTransactionStatusFromResponseMidtrans($response)
    {
        $start = strpos($response, "transaction_status") + 21; // index pertama dari status transaksi
        
        // mendapatkan status transaksi
        $temp = "";
        for ($i=$start; $i < strlen($response) - 1; $i++) { 
            $temp = $temp.$response[$i];
        }
        $response = $temp;
        $temp = "";
        $end = strpos($response, ",") - 1;
        for ($i=0; $i < $end; $i++) { 
            $temp = $temp.$response[$i];
        }
        return $temp;
    }

    // Method ini digunakan untuk mengembalikan kode pembayaran dari PG
    // @param $orderId       : id order
    // @param $paymentMethod : id metode pembayaran
    public static function getPaymentCodeFromMidtrans($orderId, $paymentMethod)
    {
        $curl = curl_init(); // inisialisasi cURL

        // data cURL
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.sandbox.midtrans.com/v2/$orderId/status",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Accept: application/json",
            "Content-Type: application/json",
            "Authorization: Basic U0ItTWlkLXNlcnZlci1RMkhTRE5pX1pfcUxGNjRQdEplLUo3RWw6"
        ),
        ));

        $response = curl_exec($curl); // mengeksekusi dan mendapatkan hasil cURL

        curl_close($curl); // menutup cURL
        return PaymentGateway::getPaymentCodeFromMidtransResponse($response, $paymentMethod); // return kode pembayaran
    }

    // Method ini digunakan untuk mengembalikan kode pembayaran
    // @param $response      : Respon cURL
    // @param $paymentMethod : Metode pembayaran yang digunakan
    private static function getPaymentCodeFromMidtransResponse($response, $paymentMethod)
    {
        if ($paymentMethod == 1) {
            $start = strpos($response, "va_number\"") + 12;
            $temp = "";
            for ($i=$start; $i < strlen($response) - 1; $i++) { 
                $temp = $temp.$response[$i];
            }
            $response = $temp;
            $temp = "";
            $end = strpos($response, "\"");
            for ($i=0; $i < $end; $i++) { 
                $temp = $temp.$response[$i];
            }
            return $temp;
        }
        else {
            $start = strpos($response, "payment_code\"") + 15;
            $temp = "";
            for ($i=$start; $i < strlen($response) - 1; $i++) { 
                $temp = $temp.$response[$i];
            }
            $response = $temp;
            $temp = "";
            $end = strpos($response, "\"");
            for ($i=0; $i < $end; $i++) { 
                $temp = $temp.$response[$i];
            }
            return $temp;
        }
    }
}
