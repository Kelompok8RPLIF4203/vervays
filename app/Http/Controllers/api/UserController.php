<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function updateProfile(Request $request)
    {
        User::updateProfile(
            $request->post('firstName'),
            $request->post('lastName'),
            $request->post('birthDay'),
            $request->post('phoneNum'),
            $request->post('gender')
        );
    }

    public function isPasswordTrue(Request $request)
    {
        return response()->json(User::isPasswordTrue(session('id'), $request->post('password')));
    }

    public function updatePassword(Request $request)
    {
        return User::updatePassword(session('id'), $request->post('password'));
    }

    public function destroy()
    {
        return User::destroy();
    }
}
