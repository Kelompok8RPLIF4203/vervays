<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\PasswordResetToken;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    public function index()
    {
        return view('pages.login');
    }

    public function checkLogin(Request $request)
    {
        $errorMsg = [
            "email.required" => "Masukkan alamat email anda",
            "email.email" => "Masukkan format email yang tepat",
            "password.required" => "Masukkan password",
            "password.min" => "Password harus lebih dari 7 karakter",
        ];
        $request->validate([
            "email" => "required|email",
            "password" => "required|min:8"
        ], $errorMsg);

        $id = User::checkLogin($request->email, $request->password);
        if ($id == 0) {
            return view('pages.login', ["InvalidInputErrorMessage" => "Email atau password salah"]);
        }
        else {
            return redirect()->route('dashboard');
        }
    }

    public function beginResetPassword()
    {
        return view('pages.reset_password.begin');
    }

    public function resetPassword(Request $request)
    {
        $this->validate($request, [
            "email" => 'required|email'
        ], [
            "email.required" => 'Masukkan alamat email',
            "email.email" => 'Masukkan email dengan format yang benar',
        ]);
        $email = $request->email;
        $token = User::createResetPasswordToken($email);
        if (isset($token) && $token !== "") {
            Mail::to($request->email)->send(new ForgotPasswordMail($token, $email));
        }
        return redirect()->route('reset-password-sent');
    }

    public function resetPasswordSent()
    {
        return view('pages.reset_password.sent');
    }

    public function changePassword(Request $request)
    {
        $id = User::getIdByEmail($request->get('email'));
        if (PasswordResetToken::isPasswordResetRequestExist($id, $request->get('token'))) {
            $data = [
                "id" => $id,
            ];
            return view('pages.reset_password.change_password', $data);
        }
        else {
            return view('errors.404');
        }
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            "password" => "required|min:8",
            "id" => "required"
        ]);
        $updatePassword = User::updatePassword($request->get('id'), $request->get('password'));
        if ($updatePassword) {
            session(['id' => $request->get('id')]);
        }
        return redirect()->route('signup');
    }
}
