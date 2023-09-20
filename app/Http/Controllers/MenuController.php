<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\ClientUser;
use App\ClientDomain;
use App\Menu;
use App\UserLoginState;
use App\Helpers\MySettings;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
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
    
     public function menu(Request $request) {
        $userId = Auth::user()->id;
        if (!empty($userId)) {
            $ClientDomain = Menu::where('user_id', '=', $userId)->get();
        }
        return view('pages.menu.index', compact('ClientDomain'));
    }
    
    public function createMenu(Request $request) {
        //session_start();
        //unset($_SESSION['email']);
        $userId = Auth::user()->id;
        return view('pages.menu.create_menu', compact('userId'));
    }
    
    public function domainDetails(Request $request, $id) {
        $ClientDomain = ClientDomain::where('id', '=', $id)->first();
        return view('pages.domain.details', compact('ClientDomain'));
    }
    
    public function editMenu(Request $request, $id) {
        $ClientDomain = ClientDomain::where('id', '=', $id)->first();
        return view('pages.domain.edit', compact('ClientDomain'));
    }

    public function postCreateMenu(Request $request) {
        echo "<pre>";
        print_r($request->all()); die;
        $menuSave = Menu::save_menus($request, Auth::user());
        return redirect()->intended('menu');
    }
    
    public function postUpdateMenu(Request $request) {
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
