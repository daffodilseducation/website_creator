<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;
use App\ClientUser;
use Hash;

class ResetPasswordController extends Controller {

    public function getPassword($token) {

        return view('reset', ['token' => $token]);
    }

    public function updatePassword(Request $request) {

        $request->validate([
            'email' => 'required|email|exists:client_users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);

        $updatePassword = DB::table('password_resets')
                ->where(['email' => $request->email, 'token' => $request->token])
                ->first();

        if (!$updatePassword)
            return back()->withInput()->with('error', 'Invalid token!');

        $user = ClientUser::where('email', $request->email)
                ->update(['password' => md5($request->password)]);

        DB::table('password_resets')->where(['email' => $request->email])->delete();

        return redirect('/login')->with('message', 'Your password has been changed!');
    }

}
