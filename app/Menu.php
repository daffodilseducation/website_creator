<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

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
          $dt['parent_id'] = $req->get('parent_id') ? $req->get('parent_id') : null;
          $dt['label'] = $req->get('label');
          $dt['slug'] = $req->get('slug');
          $dt['order_no'] = $req->get('order');
          $dt['icon'] = $file ? 'menu/icons/'.$file->getClientOriginalName() : "";
          $dt['status'] = $req->get('status');
          $menus = new Menu($dt);
          $menus->save();
        
    }

    public static function update_menus($req, $authUser){

          $menu = Menu::find($req->get('id'));
          $file = $req->file('icon');
          if($file && $file->getClientOriginalName()){
               // to delete
               if(!empty($menu->icon) && file_exists(public_path($menu->icon))){
                      unlink(public_path($menu->icon));
               }
               // to delete ends
               $path = public_path() . '/menu/icons/'; 
               if(!file_exists($path)) {
                        mkdir($path, 0777, true);
               }
               $file->move($path, $file->getClientOriginalName());
          }elseif($req->get('icon_removed') == 1){
               if(!empty($menu->icon) && file_exists(public_path($menu->icon))){
                      unlink(public_path($menu->icon));
               }
          }


          $dt = array();
          $dt['user_id'] = $authUser->id;
          // $dt['parent_id'] = $req->get('parent_id') ? $req->get('parent_id') : 0;
          $dt['label'] = $req->get('label');
          $dt['slug'] = $req->get('slug');
          $dt['order_no'] = $req->get('order');
          if($file){
               $dt['icon'] = $file ? 'menu/icons/'.$file->getClientOriginalName() : "";
          }elseif($req->get('icon_removed') == 1){
               $dt['icon'] = null;
          }
          $dt['status'] = $req->get('status');
          // $menus = new Menu($dt);
          // $menus->save();

          $user = Menu::where('id', $req->get('id'))
                ->update($dt);
        
    }

    public static function getTree($rootids){
        if(empty($rootids)){
            return;
        }
        $rootids = trim($rootids, ",");
        // $child_orgs_ids = '';

         $raw_sql = "SELECT GROUP_CONCAT(m.id) as child_ids
                          FROM  menus  as m
                          WHERE m.parent_id in ($rootids) ";


          $orgs  =  DB::select(DB::raw($raw_sql));
          //$orgs = json_decode(json_encode($orgs),true);
          
          $menu_ids = trim($orgs[0]->child_ids,',');
          if(!empty($menu_ids)){
              $menu_ids .= ','.self::getTree($menu_ids);
              
          }
         return trim($menu_ids, ',');
       }

    public static function getChildMenus($menu_id){
          // echo "<pre>"; print_r($enable_parent_child);exit;
          $childs = self::getTree($menu_id);   
          $childs = trim($childs,',');         
          $childs = !empty($childs) ? explode(',', $childs) : [];
          $childs[] = $menu_id;
          return $childs;
     }
}
