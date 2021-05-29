<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Publisher
{
    public static function updateNama($nama, $idUser)
    {
        DB::table('publishers')->where('userId',$idUser)
            ->update([
                "name" => $nama,
            ]);
    }

    public static function updateDeskripsi($deskripsi, $idUser)
    {
        DB::table('publishers')->where('userId',$idUser)
            ->update([
                "description" => $deskripsi,
            ]);
    }

    public static function updateFoto($foto, $idUser, $idFoto) {
        DB::table('profile_photos')->insert([
            "id" => $idFoto,
            "name" => $foto,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::table('publishers')->where('userId', $idUser)
            ->update([
                "profilePhotoId" => $idFoto,
            ]);
    }

    public static function getNewProfilePhotoId()
    {
        return DB::table('profile_photos')->get()->count() + 1;
    }

    public static function getPublisherIdWithUserId($userId)
    {
        return DB::table('publishers')
            ->select('id')
            ->where('userId', $userId)
            ->first()
            ->id;
    }

    public static function doesThePublisherHaveThatBook($publisherId, $bookId)
    {
        $value = DB::table('books')
            ->join('publishers', 'publishers.id', '=', 'books.publisherId')
            ->where('publishers.id', $publisherId)
            ->where('books.isDeleted', 0)
            ->where('books.id', $bookId)
            ->count();
        if ($value == 1) {
            return true;
        }
        return false;
    }

    public static function getPublisherName($publisherId)
    {
        return DB::table('publishers')
                    ->where('id', $publisherId)
                    ->pluck('name')[0];
    }

    public static function getPublisherData($userId)
    {
        $publisher = DB::table('publishers')
            ->select('id', 'profilePhotoId', 'publishers.name', 'description', 'balance', 'created_at')
            ->where('userId', $userId)
            ->first();
        $photo = DB::table('profile_photos')
            ->select('name')
            ->where('id', $publisher->profilePhotoId)
            ->first();
        $balanceForHuman = number_format($publisher->balance,2,',','.');
        $photoURL = '/image/profile_photos/'.$publisher->profilePhotoId;
        $photoURL = $photoURL.'/'.$photo->name;
        $photoURL = url($photoURL);
        $parsedDate = Carbon::parse($publisher->created_at);
        return [
            "photoURL" => $photoURL,
            "name" => $publisher->name,
            "description" => $publisher->description,
            "balance" => $publisher->balance,
            "balanceForHuman" => $balanceForHuman,
            "month" => Publisher::convert_month_int_to_string_word($parsedDate->month),
            "year" => $parsedDate->year,
        ];
    }

    private static function convert_month_int_to_string_word($month) {
        if ($month == 1) {
            return "Januari";
        }
        if ($month == 2) {
            return "Februari";
        }
        if ($month == 3) {
            return "Maret";
        }
        if ($month == 4) {
            return "April";
        }
        if ($month == 5) {
            return "Mei";
        }
        if ($month == 6) {
            return "Juni";
        }
        if ($month == 7) {
            return "Juli";
        }
        if ($month == 8) {
            return "Agustus";
        }
        if ($month == 9) {
            return "September";
        }
        if ($month == 10) {
            return "Oktober";
        }
        if ($month == 11) {
            return "November";
        }
        return "Desember";
    }

    public static function getUserIdByPublisherId($publisherId)
    {
        return DB::table('publishers')
                ->where('id', $publisherId)
                ->select('userId')
                ->pluck('userId')[0];
    }

    public static function addBalance($publisherId, $balance)
    {
        $currentBalance = DB::table('publishers')->where('id', $publisherId)->pluck('balance')[0];
        $balance = $balance + $currentBalance;
        DB::table('publishers')->where('id', $publisherId)->update([
            "balance" => $balance,
        ]);
    }

    public static function getBalance($publisherId)
    {
        return DB::table('publishers')->where('id', $publisherId)->pluck('balance')[0];
    }

    public static function withdrawBalance($publisherId, $amount, $bankId, $accountOwner)
    {
        $currentBalance = Publisher::getBalance($publisherId);
        $currentBalance = $currentBalance - $amount;
        if ($currentBalance >= 0 && $amount >= 30000) {
            DB::table('publishers')->where('id', $publisherId)->update([
                "balance" => $currentBalance,
            ]);
            Cashout::store($publisherId, $bankId, $amount, $accountOwner);
        }
    }

    public static function getPublisherDataForPublisherInfoPage($publisherId)
    {
        $publisher = DB::table('publishers')
                            ->where('id', $publisherId)
                            ->select('id', 'profilePhotoId', 'name', 'description', 'created_at')
                            ->first();
        $photo = DB::table('profile_photos')
                        ->select('name')
                        ->where('id', $publisher->profilePhotoId)
                        ->first();
        $photoURL = '/image/profile_photos/'.$publisher->profilePhotoId;
        $photoURL = $photoURL.'/'.$photo->name;
        $photoURL = url($photoURL);
        $parsedDate = Carbon::parse($publisher->created_at);
        return [
            "photoURL" => $photoURL,
            "name" => $publisher->name,
            "description" => $publisher->description,
            "month" => Publisher::convert_month_int_to_string_word($parsedDate->month),
            "year" => $parsedDate->year,
        ];
    }

    public static function isUserAPublisher($userId)
    {
        return DB::table('publishers')->where('userId', $userId)->get()->count() == 1;
    }

    private static function getPublishersCount() {
        return DB::table('publishers')->get()->count();
    }

    public static function bePublisher($id) {
        $user = DB::table('publishers')
                    ->join('users', 'users.id', '=', 'publishers.userId')
                    ->where('userId', $id)
                    ->where('users.isDeleted', 0)
                    ->first();
        if ($user == null) { //Belum menjadi publisher
            $name = User::getFirstName($id) . ' '
                . User::getLastName($id);
            $now = Carbon::now();
            DB::table('publishers')->insert([
                "id" => Publisher::getPublishersCount()+1,
                "userId" => $id,
                "profilePhotoId" => 1,
                "name" => $name,
                "description" => "-",
                "balance" => 0,
                "month" => $now->month,
                "year" => $now->year,
            ]);
        }
    }

    public static function destroy($id)
    {
        Book::deleteAllPublisherBooks($id);
        DB::table('publishers')->where('id', $id)->update(['isDeleted'=> 1,]);
    }
}
