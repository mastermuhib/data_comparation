<?php

use Illuminate\Database\Seeder;
use App\Model\MenuModel;
use App\Model\RoleModel;
class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()

    {
            date_default_timezone_set('Asia/Jakarta');
            DB::table('menus')->insert([
                  ['name' =>  'Master Feedback','parent_menu_id' => 9,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'feedback','icon'=>'null','no_urut'=>6],
                  ['name' =>  'Master Sugestion','parent_menu_id' => 9,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'sugestion','icon'=>'null','no_urut'=>7],
                  ['name' =>  'Master Delivery / Pengiriman','parent_menu_id' => 9,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'delivery','icon'=>'null','no_urut'=>8],
              ]);
            //seeder2
            DB::table('role_menus')->truncate();
            $data_array = MenuModel::all();
            $id_role = RoleModel::select('id')->pluck('id');
            foreach ($data_array as $k => $v) {
                date_default_timezone_set('Asia/Jakarta');
                DB::table('role_menus')->insert(
                    ['role_id' => $id_role[0],  'menu_id' => $v->id,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')]
                );
            }
      }
}