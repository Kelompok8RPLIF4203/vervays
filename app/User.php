<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Faker\Factory as Faker;

class User
{
    public static function checkLogin($email, $password)
    {
        $user = DB::table('users')
            ->where('email', $email)
            ->where('isDeleted', '0')
            ->select('id', 'password')
            ->first();
        if ($user == null || !Hash::check($password, $user->password)) {
            return 0;
        }
        else {
            session(['id' => $user->id]);
            return $user->id;
        }
    }

    public static function signUp($firstName, $lastName, $email, $password)
    {
        $user = DB::table('users')
            ->where('email', $email)
            ->where('isDeleted', '0')
            ->first();
        if ($user == null) {
            $id = User::getUsersCount()+1;
            $lastName = $lastName == null ? "" : $lastName;
            DB::table('users')->insert([
                "id" => $id,
                "firstName" => $firstName,
                "lastName" => $lastName,
                "isDeleted" => 0,
                "email" => $email,
                "password" => Hash::make($password),
            ]);
            session(['id' => $id]);
            return 1;
        }
        else {
            return 0;
        }
    }

    public static function getFirstName($id)
    {
        $result = DB::table('users')
            ->where('id', $id)
            ->select('firstName')
            ->get();
        return $result[0]->firstName;
    }

    public static function getLastName($id)
    {
        $result = DB::table('users')
            ->where('id', $id)
            ->select('lastName')
            ->get();
        return $result[0]->lastName;
    }

    private static function getUsersCount() {
        return DB::table('users')->get()->count();
    }

    public static function IsTheEmailNotVerified()
    {
        $id = session('id');
        $value = DB::table('users')
            ->select('email_verified_at')
            ->where('id', $id)
            ->first()
            ->email_verified_at;
        if ($value == null) {
            return true;
        }
        return false;
    }

    public static function verificateEmail($userId)
    {
        EmailVerificationToken::deleteByUserId($userId);
        DB::table('users')
            ->where('id', $userId)
            ->update([
                "email_verified_at" => Carbon::now(),
            ]);
    }

    public static function getCurrentUserEmail()
    {
        $id = session('id');
        return DB::table('users')
            ->where('id', $id)
            ->first()
            ->email;
    }

    public static function createResetPasswordToken($email)
    {
        $faker = Faker::create('id_ID');
        $token = $faker->md5;
        $id = User::getIdByEmail($email);
        if ($id == 0) { //Jika email tidak terdaftar
            $token = "";
        }
        else { // Jika email terdaftar
            PasswordResetToken::deleteByUserId(User::getIdByEmail($email)); //Menghapus token reset password jika ada
            PasswordResetToken::store(User::getIdByEmail($email), $token); //Menyimpan token reset
        }
        return $token;
    }

    public static function getFirstNameByEmail($email)
    {
        $result = DB::table('users')
            ->where('email', $email)
            ->select('firstName')
            ->get();
        return $result[0]->firstName;
    }

    public static function getIdByEmail($email) {
        $result = DB::table('users')
            ->where('email', $email)
            ->where('isDeleted', '0')
            ->select('id')
            ->get();
        return $result[0]->id ?? 0;
    }

    public static function updatePassword($userId, $newPassword)
    {
        $value = DB::table('users')
                    ->where('id', $userId)
                    ->where('isDeleted', '0')
                    ->first();
        if ($value != null) {
            DB::table('users')
                ->where('id', $userId)
                ->where('isDeleted', '0')
                ->update([
                    "password" => Hash::make($newPassword),
                ]);
            PasswordResetToken::deleteByUserId($userId); //Menghapus token reset password jika ada
            return true; // Tanda jika berhasil update password
        }
        return false; // Tanda jika gagal update password
    }

    public static function getUserDataForAccountSettingPage($userId)
    {
        $user = DB::table('users')
                    ->where('id', $userId)
                    ->select('id', 'email', 'firstName', 'lastName', 'birthDay', 'phoneNumber', 'gender', 'created_at')
                    ->first();
        $user->name = User::getFirstName($userId)." ".(User::getLastName($userId) ?? "");
        $parsedDate = Carbon::parse($user->created_at);
        $user->created_at_month = $parsedDate->month;
        $user->created_at_year = $parsedDate->year;
        return $user;
    }

    public static function updateProfile($firstName, $lastName, $birthDay, $phoneNum, $gender)
    {
        $userId = session('id');
        if ($firstName != "") {
            DB::table('users')->where('id', $userId)->update(["firstName" => $firstName,]);
        }
        if ($lastName != "") {
            DB::table('users')->where('id', $userId)->update(["lastName" => $lastName,]);
        }
        if ($birthDay != "") {
            DB::table('users')->where('id', $userId)->update(["birthDay" => $birthDay,]);
        }
        if ($phoneNum != "") {
            DB::table('users')->where('id', $userId)->update(["phoneNumber" => $phoneNum,]);
        }
        if ($gender != "") {
            DB::table('users')->where('id', $userId)->update(["gender" => $gender,]);
        }
    }

    public static function isPasswordTrue($userId, $password)
    {
        $hashedPassword = DB::table('users')->where('id', $userId)->pluck('password')[0];
        return Hash::check($password, $hashedPassword);
    }

    public static function getPublisherId($userId)
    {
        return DB::table('users')->where('id', $userId)->pluck('publisherId')[0];
    }

    public static function destroy()
    {
        $userId = session('id');
        if (Publisher::isUserAPublisher($userId)) { //Jika pengguna termasuk penerbit
            $publisherId = Publisher::getPublisherIdWithUserId($userId);
            if (Publisher::getBalance($publisherId) > 0) { // Jika pengguna masih memiliki saldo penerbit
                return "Maaf, akun tidak dapat dihapus karena anda masih memiliki saldo (cairkan semua saldo agar dapat menghapus akun)";
            }
            else {
                Publisher::destroy($publisherId);
            }
        }
        DB::table('users')->where('id', $userId)->update([
            "isDeleted" => 1,
        ]);
        Order::cancelAllOrderByUserId($userId);
        session(['id' => 0]);
        return "success";
    }
}
