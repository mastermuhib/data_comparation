<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\MenuModel;
use DB;
use SendGrid\Mail\Mail;

trait Fungsi {
    public static function getmenu1($role_id)
    {
        $menu = DB::table('menus')->whereNull('deleted_at')->join('role_menus','menus.id','=','role_menus.menu_id')->where('role_id',$role_id)->where('menus.parent_menu_id',0)->select('menus.name as name','number','slug','icon','menus.menu_id as menu_id','parent_menu_id')->orderBy('number','asc')->get();
        
        return $menu;   

    }

    public static function getmenuall1()
    {
        $menu = DB::table('menus')->whereNull('deleted_at')->where('menus.parent_menu_id',0)->select('menus.name as name','number','slug','icon','menus.menu_id as menu_id','parent_menu_id','menus.id as id')->orderBy('number','asc')->get(); 
         // print_r($menu);
         // exit();
        return $menu;   

    }

    public static function getsubmenu1($role_id)
    {
        $submenu = DB::table('menus')->whereNull('deleted_at')->join('role_menus','menus.id','=','role_menus.menu_id')->where('role_id',$role_id)->where('menus.menu_id',0)->select('menus.name as name','number','slug','icon','menus.menu_id as menu_id','parent_menu_id')->orderBy('number','asc')->get();
        return $submenu;
    }

    public static function getsubmenuall1()
    {
        $submenu = DB::table('menus')->whereNull('deleted_at')->where('menus.menu_id',0)->select('menus.name as name','number','slug','icon','menus.menu_id as menu_id','parent_menu_id','menus.id as id')->orderBy('number','asc')->get();
        return $submenu;
    }
	
	public static function getmenu($role_id)
    {
    	$menu = DB::select("select b.id as id,b.name as name,b.menu_id as menu_id,b.slug as slug,b.icon as icon,b.number from menus b join role_menus r on b.id = r.menu_id where r.role_id = '$role_id' and b.parent_menu_id = '0' order By b.number asc;");  
         // print_r($menu);
         // exit();
        return $menu;   

    }

    public static function getmenuall()
    {
        $menu = DB::select("select b.id as id,b.name as name,b.menu_id as menu_id,b.slug as slug from menus b where b.parent_menu_id = '0';");  
         // print_r($menu);
         // exit();
        return $menu;   

    }

    public static function getsubmenu($role_id)
    {
    	 $submenu = DB::select("select b.id as id,b.name as name,b.parent_menu_id as parent_menu_id,b.slug as slug,b.icon as icon,number from menus b join role_menus r on b.id = r.menu_id where r.role_id = '$role_id' and b.menu_id = '0' order by b.number asc;");
        return $submenu;
    }

    public static function getsubmenuall()
    {
         $submenu = DB::select("select b.id as id,b.name as name,b.parent_menu_id as parent_menu_id,b.slug as slug from menus b where b.menu_id = '0';");
        return $submenu;
    }


    public static function S3_PATH(){
        $env = 'https://kandidat.s3-id-jkt-1.kilatstorage.id';
        return $env;
    }
}

?>