<?php

use Illuminate\Database\Seeder;
use App\Model\MenuModel;
use App\Model\RoleModel;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()

    {
        date_default_timezone_set('Asia/Jakarta');
        DB::table('menus')->truncate();
        DB::table('menus')->insert([
            ['name' =>  'Dashboard',  'parent_menu_id' => 0,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 1,'slug' =>'dashboard','icon'=>'fas fa-tachometer-alt','number'=>1],
            ['name' =>  'Administrator',  'parent_menu_id' => 0,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 2,'slug' =>'administrator','icon'=>'fas fa-user-secret','number'=>2],
            ['name' =>  'DPT',  'parent_menu_id' => 0,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 3,'slug' =>'dpt','icon'=>'fab fa-cotton-bureau','number'=>3],
            ['name' =>  'Master',  'parent_menu_id' => 0,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 4,'slug' =>'master','icon'=>'fas fa-database','number'=>4],
            ['name' =>  'Logs',  'parent_menu_id' => 0,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 5,'slug' =>'logs','icon'=>'fa fa-history','number'=>5],
            // sub menu
            ['name' =>  'Tambah Admin','parent_menu_id' => 2,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'add-admin','icon'=>'null','number'=>1],
            ['name' =>  'List Admin','parent_menu_id' => 2,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'list-admin','icon'=>'null','number'=>2],
            ['name' =>  'Role Admin','parent_menu_id' => 2,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'role-admin','icon'=>'null','number'=>3],
            ['name' =>  'Pengaturan Menu','parent_menu_id' => 2,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'pengaturan-menu','icon'=>'null','number'=>4],
            ['name' =>  'List DPT','parent_menu_id' => 3,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'list','icon'=>'null','number'=>1],
            ['name' =>  'List Triwulan','parent_menu_id' => 3,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'step','icon'=>'null','number'=>1],
            ['name' =>  'Riwayat DPT','parent_menu_id' => 3,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'history','icon'=>'null','number'=>1],
            ['name' =>  'Master Kecamatan','parent_menu_id' => 4,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'kecamatan','icon'=>'null','number'=>4],
            ['name' =>  'Master Desa','parent_menu_id' => 4,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'desa','icon'=>'null','number'=>5],
            ['name' =>  'Logs Admin','parent_menu_id' => 5,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'logs_admin','icon'=>'null','number'=>1],
            ['name' =>  'Logs Error','parent_menu_id' => 5,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s'),'menu_id' => 0,'slug' =>'logs_error','icon'=>'null','number'=>3],
            ]);
        date_default_timezone_set('Asia/Jakarta');
        // seeder departement
        DB::table('roles')->truncate();
        DB::table('roles')->insert(
            ['name' =>  'SUPERADMIN','slug'=>'superadmin',  'status' => 1,'created_at' => date('Y-m-d'),'updated_at' => date('Y-m-d')]
        );
        
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
        //seeder3
        DB::table('administrators')->truncate();
        $data_array = RoleModel::all();
        foreach ($data_array as $k => $v) {
                date_default_timezone_set('Asia/Jakarta');
                DB::table('administrators')->insert(
                    ['id_role' => $v->id,'admin_name' => 'admin',  'phone' => '081320938989','email' => 'admin@gmail.com','password' => bcrypt('admin123'),'confirm_password' => encrypt('admin123'),'address' => 'surabaya','status' => 1,'created_at' => date('Y-m-d H:m:s'),'updated_at' => date('Y-m-d H:m:s')]
                );
        }
    }
}
