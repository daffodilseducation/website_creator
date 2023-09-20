<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $guarded =[];

     public static function save_menus($req, $authUser){

          $file = $req->file('icon');
          if($file && $file->getClientOriginalName()){
               $path = public_path() . '/menu/icons/'; 
               if(!file_exists($path)) {
                        mkdir($path, 0777, true);
               }
               $file->move($path, $file->getClientOriginalName());
          }


          $dt = array();
          $dt['user_id'] = $authUser->id;
          $dt['parent_id'] = $req->get('parent_id') ? $req->get('parent_id') : 0;
          $dt['label'] = $req->get('label');
          $dt['slug'] = $req->get('slug');
          $dt['order_no'] = $req->get('order');
          $dt['icon'] = $file ? 'menu/icons/'.$file->getClientOriginalName() : "";
          $dt['status'] = 'Active';
          $menus = new Menu($dt);
          $menus->save();
        
    }
}
