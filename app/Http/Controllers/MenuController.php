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

        $chilsMenus = Menu::getChildMenus($id);
        if(!empty($chilsMenus)){
            Menu::whereIn('id', $chilsMenus)->delete();
        }
        return redirect('/menus')->with('success', 'Menu deleted!');
        

        
      // $MenuData = Menu::find($id);
      // $parent_id =  Menu::Where("parent_id",$id)->count();
      
      // if($parent_id > 0){
      //   return redirect('/menu')->with('success', "you can't delete this menu");
      // }else{
      //   $MenuData->delete();
      //   return redirect('/menu')->with('success', 'Menu deleted!');
      // }
      
        //
    }
    
     public function menu(Request $request) {
        $userId = Auth::user()->id;
        if (!empty($userId)) {
            $MenuData = Menu::where('user_id', '=', $userId)->where('parent_id', '=', null)->get();
        }
        // $chilsMenus = Menu::getChildMenus(1);
        // echo "<pre>"; print_r($chilsMenus);exit;
        return view('pages.menu.index', compact('MenuData'));
    }
    
    public function createMenu(Request $request) {
        //session_start();
        //unset($_SESSION['email']);
        $userId = Auth::user()->id;
        $parent_id = !empty($_GET['parent_id']) ? $_GET['parent_id'] : null;
        return view('pages.menu.create_menu', compact('userId','parent_id'));
    }
    
    public function domainDetails(Request $request, $id) {
        $ClientDomain = ClientDomain::where('id', '=', $id)->first();
        return view('pages.domain.details', compact('ClientDomain'));
    }
    
    public function editMenu(Request $request, $id) {
        $MenuData = Menu::where('id', '=', $id)->first();
        return view('pages.menu.edit', compact('MenuData'));
    }

    public function postCreateMenu(Request $request) {
        $menuSave = Menu::save_menus($request, Auth::user());
        return redirect()->intended('menus');
    }
    
    public function postUpdateMenu(Request $request) {
        $menuSave = Menu::update_menus($request, Auth::user());
        return redirect()->intended('menus');
    }
    
}
