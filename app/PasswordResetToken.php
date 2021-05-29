<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PasswordResetToken extends Model
{
    protected $table = 'password_reset_tokens';

    public static function isPasswordResetRequestExist($userId, $token)
    {
        $count = PasswordResetToken::where('userId', $userId)->where('token', $token)->count();
        return $count == 1;
    }

    public static function deleteByUserId($userId)
    {
        $tokens = PasswordResetToken::where('userId', $userId);
        $tokens->delete();
    }

    public static function store($userId, $token)
    {
        $data = new PasswordResetToken();
        $data->userId = $userId;
        $data->token = $token;
        $data->save();
    }
}
