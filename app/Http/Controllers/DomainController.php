<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\ClientUser;
use App\ClientDomain;
use App\UserLoginState;
use App\Helpers\MySettings;
use Illuminate\Support\Facades\Auth;

class DomainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
     public function domain(Request $request) {
        $userId = Auth::user()->id;
        if (!empty($userId)) {
            $ClientDomain = ClientDomain::where('user_id', '=', $userId)->get();
        }
        return view('pages.domain.index', compact('ClientDomain'));
    }
    
    public function createDomain(Request $request) {
        //session_start();
        //unset($_SESSION['email']);
        $userId = Auth::user()->id;
        return view('pages.domain.create_domail', compact('userId'));
    }
    
    public function domainDetails(Request $request, $id) {
        $ClientDomain = ClientDomain::where('id', '=', $id)->first();
        return view('pages.domain.details', compact('ClientDomain'));
    }
    
    public function editDomain(Request $request, $id) {
        $ClientDomain = ClientDomain::where('id', '=', $id)->first();
        return view('pages.domain.edit', compact('ClientDomain'));
    }

    public function postCreateDomain(Request $request) {
        
        $userId = $request->get('user_id');
        $decryption_key = '3ff360b29079ceec22d47d27d905f96c8868d0353dc96de533f70dc73e30e38c';
        //$decryption_key = shell_exec('openssl rand -hex 32');
       // echo $decryption_key;die;
        $data = [
            'user_id' => $request->get('user_id'),
            'domain' => $request->get('domain'),
            'login_redirect_url' => $request->get('login_redirect_url'),
            'logout_redirect_url' => $request->get('logout_redirect_url'),
            'decryption_key' => $decryption_key,
            'status' => $request->get('status')
        ];
        $ClientDomain = new ClientDomain($data);
        $ClientDomain->save();
        if (!empty($ClientDomain)) {
            $domainId = $ClientDomain->id;
            $passphrase = $decryption_key;
            $secreteKey = MySettings::encryptToken($domainId, $passphrase);
            $secreteKey = $userId.'_'.$secreteKey;
            ClientDomain::updateOrCreate(
                    ['id' => $ClientDomain->id],
                    ['secret_key' => $secreteKey]
            );
        }
        return redirect()->intended('domain');
    }
    
    public function postUpdateDomain(Request $request) {
        //$decryption_key = shell_exec('openssl rand -hex 32');
       // echo $decryption_key;die;
            $id = $request->get('domain_id');
            $domain = $request->get('domain');
            $login_redirect_url = $request->get('login_redirect_url');
            $logout_redirect_url = $request->get('logout_redirect_url');
            $status = $request->get('status');
            ClientDomain::updateOrCreate(
                    ['id' => $id],
                    ['domain' => $domain,'login_redirect_url' => $login_redirect_url,'logout_redirect_url' => $logout_redirect_url,'status' => $status]
            );
        return redirect()->intended('domain');
    }
}
