<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\EmailVerificationToken;
use App\FlashMessages;
use App\Mail\UserVerificationMail;
use Illuminate\Support\Facades\Mail;

class SignUpController extends Controller
{
    public function index()
    {
        return view('pages.signup');
    }

    public function signUp(Request $request)
    {
        $errorMsg = [
            "firstName" => "Masukkan nama depan anda",
            "email.required" => "Masukkan alamat email anda",
            "email.email" => "Masukkan format email yang tepat",
            "password.required" => "Masukkan password",
            "password.min" => "Password harus lebih dari 7 karakter",
        ];
        $request->validate([
            "firstName" => "required",
            "email" => "required|email",
            "password" => "required|min:8",
        ], $errorMsg);
        $signUp = User::signUp($request->firstName, $request->lastName, $request->email, $request->password);
        if ($signUp == 0) {
            $data = [
                "emailErrorMessage" => "Email sudah terdaftar"
            ];
            return view('pages.signup', $data);
        }
        else {
            $token = EmailVerificationToken::store();
            Mail::to($request->email)->send(new UserVerificationMail($token, session('id')));
            return redirect()->route('email-verification');
        }
    }

    public function emailVerification()
    {
        return view('pages.email_verification', [
            "email" => User::getCurrentUserEmail(),
        ]);
    }

    public function verificateEmail(Request $request)
    {
        if (EmailVerificationToken::isEmailVerificationExist($request->get('id'),$request->get('token'))) {
            session(['id' => $request->get('id')]);
            User::verificateEmail($request->get('id'));

            $flashMessages = new FlashMessages();
            $flashMessages->userId = $request->get('id');
            $flashMessages->allotmentId = 1;
            $flashMessages->save();

            return redirect()->route('dashboard');
        }
        else {
            return view('errors.404');
        }
    }
}
