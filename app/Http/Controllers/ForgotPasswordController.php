<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Mail;
use App\ClientUser;
use Illuminate\Support\MessageBag;
use Redirect;

class ForgotPasswordController extends Controller {
    public function getEmail() {

        return view('email');
    }

    public function postEmail(Request $request) {
        /*$request->validate([
            'email' => 'required|email|exists:users',
        ]);*/
        
        
        $clientUser = ClientUser::where('email', '=', $request->email)->first();
        if (empty($clientUser)) {
           $errors = new MessageBag(['email' => ['The selected email is invalid. ']]); // if Auth::attempt fails (wrong credentials) create a new message bag instance.
           return Redirect::back()->withErrors($errors)->withInput();
        }
        
        $token = str_random(64);

        DB::table('password_resets')->insert(
                ['email' => $request->email, 'token' => $token, 'created_at' => Carbon::now()]
        );

        Mail::send('verify', ['token' => $token], function($message) use($request) {
            $message->to($request->email);
            $message->subject('Reset Password Notification');
        });

        return back()->with('message', 'We have e-mailed your password reset link!');
    }

}
