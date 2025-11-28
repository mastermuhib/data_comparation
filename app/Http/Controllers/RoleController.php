<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\Fungsi;
use Auth;
use App\Model\RoleModel;
use App\Model\RoleMenuModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\Handler;
use Redirect;


class RoleController extends Controller
{
    public function index()
    {
        try {
        	$role_id = Auth::guard('admin')->user()->id_role;
            $data = parent::sidebar();
            if ($data['access'] == 0) {
                return redirect('/');
            } else {
                $data['name_adm'] = Auth::guard('admin')->user()->name;
                
                $data['menu_choose']      = Fungsi::getmenuall();
                $data['submenu_choose']   = Fungsi::getsubmenuall();
                $data['menu']             = Fungsi::getmenu($role_id);
                $data['submenu']          = Fungsi::getsubmenu($role_id);
                //$data['jurusan']          = DepartementModel::where('status',1)->get();
                // dd($data);
            	return view('role.index',$data) ;
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'RoleController@';
            $insert_error = parent::InsertErrorSystem($data);
            $error = parent::sidebar();
            $error['id'] = $insert_error;
            return view('errors.index',$error); // jika Metode Get
            //return response()->json($data); // jika metode Post
        }
    }

    public function list_data()
    {

    	$role = RoleModel::whereNull('roles.deleted_at')->select('roles.name as role_name', 'roles.status as status', 'roles.id as id')->get();
        // Datatables Variables
        $draw   = 10;
        $start  = 0;
        $length = 10;

        $data = array();
        $no   = 0;
        foreach ($role as $d) {
            if ($d->status == 1) {
                $status = '<div style="float: left; margin-left: 5px;">
                    <button type="button" id="' . $d->id . '" aksi="nonaktif" tujuan="role" data="data_role" class="btn btn-success btn-sm aksi">Aktif</button>
                    </div>';
            } else {
                $status = '<div style="float: left; margin-left: 5px;">
                    <button type="button" id="' . $d->id . '" data="data_role" aksi="aktif" tujuan="role" class="btn btn-danger btn-sm aksi">Tidak Aktif</button>
                    </div>';
            }
            
                $jurusan = $d->major_name;
            
            $no     = $no + 1;
            $data[] = array(
                $no,
                $d->role_name,
                $status,
                '<div style="float: left; margin-left: 5px;"><a href="/administrator/role-admin/'.$d->id.'" >
                    <button type="button" class="btn btn-warning btn-sm" style="min-width: 110px;margin-left: 2px;margin-top:3px;text-align:left"><i class="fa fa-edit"></i> Edit</button></a>
                </div>
                <div style="float: left; margin-left: 5px;">
                    <button type="button" class="btn btn-danger btn-sm aksi btn-aksi" data="data_role"  id="' . $d->id . '" aksi="delete" tujuan="role" style="min-width: 110px;margin-left: 2px;margin-top:3px;text-align:left"><i class="fa fa-trash"></i> Hapus</button>
                </div>',
            );
        }

        $output = array(
            "draw"            => $draw,
            "recordsTotal"    => count($role),
            "recordsFiltered" => count($role),
            "data"            => $data,
        );
        echo json_encode($output);
        exit();
    }

    public function post(Request $request)
    {
        try {
            $lower = strtolower($request->name);
            $slug  = preg_replace('/\s+/', '-', $lower);
        	$id_admin   = Auth::guard('admin')->user()->id;
            $insertrole = array(
                'name'           => $request->name,
                'slug'           => $slug,
                'status'         => 1,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),

            );
            $idnya_role = RoleModel::insertGetId($insertrole);
            $menus      = $request->menu;
            $submenu    = $request->submenu;
            if (isset($request->submenu)) {
                $merge = array_merge($menus, $submenu);
            } else {
                $merge = $menus;
            }

            //dd($merge);

            if (!empty($merge)) {

                foreach ($merge as $k => $v) {
                    $menu2      = $merge[$k];
                    $insertmenu = array(
                        'role_id'    => $idnya_role,
                        'menu_id'    => $menu2,
                        'created_at' => date('Y-m-d H:m:s'),
                        'is_add' => 0,
                        'is_edit' => 0,
                        'is_delete' => 0,
                        'is_activate' => 0,
                        'updated_at' => date('Y-m-d H:m:s'),
                    );
                    $insert2 = RoleMenuModel::insert($insertmenu);
                }
            }
            if ($idnya_role) {         
                $data['code']    = 200;
                $data['message'] = 'Berhasil menambah Data role';
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Menambah Data Role '.$request->name.'','Role');
                return response()->json($data);
            } else {
                $data['code']    = 500;
                $data['message'] = 'Maaf Ada yang Error ';
                return response()->json($data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'RoleController@post';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function update(Request $request){
        try {
            $nama = $request->name;
                $updaterole = [
                    'name'=>$nama,
                    'status'=>1,
                    'updated_at'=>date('Y-m-d H:m:s')
                ];

                DB::table('roles')
                    ->where('id', $request->id)
                    ->update($updaterole);
                
                DB::table('role_menus')->where('role_id',$request->id)->delete();
                $menus = $request->menu;
                $submenu = $request->submenu;
                $merge = array_merge($menus,$submenu);

                    foreach ($merge as $k => $v) {
                        $menu2 = $merge[$k];
                        $insertmenu=array(
                                'role_id'=>$request->id
                                ,'menu_id'=>$menu2
                                
                        );
                        $insert2 = DB::table('role_menus')->insert($insertmenu);
                    }
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Mengupdate Data Role '.$request->name.'','Role');
                $data['code']    = 200;
                $data['message'] = 'Berhasil Mengupdate Data Role';
            return json_encode($data);
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'RoleController@update';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function nonaktif(Request $request)
    {
        try {
            $nonactive         = RoleModel::find($request->id);
            $nonactive->status = 0;
            $nonactive->save();

            if ($nonactive) {
                $id_admin    = Auth::guard('admin')->user()->id;
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Menon aktifkan Data Role '.$request->id.'','Role');
                $data['code']    = 200;
                $data['message'] = 'Berhasil Memblokir Data Bidang Usaha';
                return response()->json($data);
            } else {
                $data['code']    = 500;
                $data['message'] = 'Maaf Ada yang Error ';
                return response()->json($data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'RoleController@nonactive';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function aktif(Request $request)
    {
        try {
            $active         = RoleModel::find($request->id);
            $active->status = 1;
            $active->save();

            if ($active) {
                $id_admin    = Auth::guard('admin')->user()->id;
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Mengaktifkan Data Role '.$request->id.'','Role');
                $data['code']    = 200;
                $data['message'] = 'Berhasil Mengaktifkan Data Bidang Usaha';
                return response()->json($data);
            } else {
                $data['code']    = 500;
                $data['message'] = 'Maaf Ada yang Error ';
                return response()->json($data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'RoleController@active';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function delete(Request $request)
    {
        try {
            $active         = RoleModel::find($request->id);
            $active->status = 0;
            $active->deleted_at = date('Y-m-d H:m:s');
            $active->save();

            if ($active) {
                $id_admin    = Auth::guard('admin')->user()->id;
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Menghapus Data Role '.$request->id.'','Role');
                $data['code']    = 200;
                $data['message'] = 'Berhasil Mengaktifkan Data Bidang Usaha';
                return response()->json($data);
            } else {
                $data['code']    = 500;
                $data['message'] = 'Maaf Ada yang Error ';
                return response()->json($data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'RoleController@deleted';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function detail($id)
    {
        

        try {
            $data = parent::sidebar();
            $role = RoleModel::find($id);
            if ($data['access'] == 0) {
                return redirect('/');
            } else {
                $data['name_adm'] = Auth::guard('admin')->user()->name;
                
                $data['data']             = $role;
                $role_id                  = Auth::guard('admin')->user()->id_role;
                $data['menu']             = Fungsi::getmenu1($role_id);
                $data['submenu']          = Fungsi::getsubmenu1($role_id);

                $data['mymenu']           = Fungsi::getmenuall1();
                $data['mysubmenu']        = Fungsi::getsubmenuall1();
                // dd($data);
                return view('role.dialog_edit',$data) ;
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'RoleController@detail';
            $insert_error = parent::InsertErrorSystem($data);
            $error = parent::sidebar();
            $error['id'] = $insert_error;
            return view('errors.500',$error); // jika Metode Get
            //return response()->json($data); // jika metode Post
        }
    }
   
}
