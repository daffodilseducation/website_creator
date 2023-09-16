<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\MySettings;
use App\User;
use App\ClientUser;
use App\ClientDomain;
use App\UserLoginState;
use Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\MessageBag;
use Redirect;

class LoginController extends Controller {

    use AuthenticatesUsers;

    public function login(Request $request) {
        $sessionEmail = $request->session()->get('email');
        $userId = $request->session()->get('userId');
        if (isset($sessionEmail) && !empty($sessionEmail)) {
            $clientUser = ClientUser::where('email', '=', $sessionEmail)->where('user_id', '=', $userId)->first();
            $UserLoginState = UserLoginState::where('client_user_id', '=', $clientUser->id)->first();
            if (!empty($UserLoginState)) {
                if ($UserLoginState->login_status == 'no') {
                    $clientUser = [];
                    $request->session()->forget('email');
                    $request->session()->forget('userId');
                }
            }
        }
        //$secret = $request->get('secret');
        $secret = $_SERVER['QUERY_STRING'];
        if (!empty($clientUser)) {
            if ($secret) {
                $secretArr = explode('_', $secret);
                $userId = $secretArr[0];
                $secret1 = $secretArr[1];
                $config = MySettings::secretHost($secret1, $userId);
                $data = MySettings::encryptToken($sessionEmail, $config['decryption_key']);
                $domain = $config['login_redirect_url'];
                if (strpos($domain, '?') !== false) {
                    header("Location: $domain token=$data");
                    exit();
                }
                header("Location: $domain?token=$data");
                exit();
            } else {
                return redirect()->intended('dashboard');
            }
        }
        return view('login', compact('secret'));
    }


    public function dashboard(Request $request) {
        $sessionEmail = $request->session()->get('email');
        $userId = $request->session()->get('userId');
        if (isset($sessionEmail) && !empty($sessionEmail)) {
            //if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
            $user = ClientUser::where('email', '=', $sessionEmail)->where('user_id', '=', $userId)->first();
            $UserLoginState = UserLoginState::where('client_user_id', '=', $user->id)->first();
            if (!empty($UserLoginState)) {
                if ($UserLoginState->login_status == 'no') {
                    $clientUser = [];
                    $request->session()->forget('email');
                    $request->session()->forget('userId');
                }
            }
        }
        $secret = '';
        if (empty($user)) {
            return redirect('login');
        }
        return view('dashboard', compact('user'));
    }

    public function logout(Request $request) {
        $sessionEmail = $request->session()->get('email');
        $userId = $request->session()->get('userId');
        $clientUser = [];
        if (isset($sessionEmail) && !empty($sessionEmail)) {
            $clientUser = ClientUser::where('email', '=', $sessionEmail)->where('user_id', '=', $userId)->first();
        }
        if (!empty($clientUser)) {
            UserLoginState::updateOrCreate(
                    ['client_user_id' => $clientUser->id],
                    ['client_user_id' => $clientUser->id, 'login_status' => 'no']
            );
        }
        $request->session()->forget('email');
        $request->session()->forget('userId');
        return Redirect('login');
    }

    

    public function userLogin(Request $request) {
        $password = $request->post('password');
        $email = $request->post('email');
        $secrets = $request->post('secret');
        $secretArr = explode('_', $secrets);
        $userId = $secretArr[0];
        $secret = $secretArr[1];
        $clientUser = ClientUser::where('email', '=', $email)->where('user_id', '=', $userId)->first();
        if (!empty($clientUser)) {
            if (md5($password) == $clientUser->password){
            //if (Hash::check($password, $clientUser->password)) {
                $request->session()->put('email', $email);
                $request->session()->put('userId', $userId);
                $users = User::where('id', '=', $clientUser->user_id)->first();
                $decryption_key = $users->decryption_key;
                $token = MySettings::encryptToken($email, $decryption_key);
                UserLoginState::updateOrCreate(
                        ['client_user_id' => $clientUser->id],
                        ['client_user_id' => $clientUser->id, 'login_status' => 'yes', 'token' => $token]
                );

                if ($secret) {
                    // $data = base64_encode($email);
                    $config = MySettings::secretHost($secret, $userId);
                    if (empty($config)) {
                        //unset($_SESSION['email']);
                        $request->session()->forget('email');
                        $request->session()->forget('userId');
                        $errors = new MessageBag(['password' => ['invalid secret.']]); // if Auth::attempt fails (wrong credentials) create a new message bag instance.
                        return Redirect::back()->withErrors($errors)->withInput();
                    }
                    $data = MySettings::encryptToken($email, $config['decryption_key']);
                    $domain = $config['login_redirect_url'];
                    if (strpos($domain, '?') !== false) {
                        header("Location: $domain token=$data");
                        exit();
                    }
                    return redirect()->intended("$domain?token=$data");
                    exit();
                } else {
                    return redirect()->intended('dashboard');
                }
            } else {
                $errors = new MessageBag(['password' => ['invalid password.']]); // if Auth::attempt fails (wrong credentials) create a new message bag instance.
                return Redirect::back()->withErrors($errors)->withInput();
            }
        } else {
            $errors = new MessageBag(['password' => ['Email and password invalid.']]); // if Auth::attempt fails (wrong credentials) create a new message bag instance.
            return Redirect::back()->withErrors($errors)->withInput();
        }
    }

}
