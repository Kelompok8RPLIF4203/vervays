<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;

class EmailVerificationToken extends Model
{
    protected $table = 'email_verification_tokens';

    public static function store()
    {
        $data = new EmailVerificationToken();
        $faker = Faker::create('id_ID');
        $id = session('id');
        $token = $faker->md5;
        $data->userId = $id;
        $data->token = $token;
        $data->save();
        return $token;
    }

    public static function isEmailVerificationExist($userId, $token)
    {
        $count = EmailVerificationToken::where('userId', $userId)->where('token', $token)->count();
        return $count == 1;
    }

    public static function deleteByUserId($userId)
    {
        $tokens = EmailVerificationToken::where('userId', $userId);
        $tokens->delete();
    }
}
