<?php

namespace App\Http\Controllers;

use App\Model\Administrator;
use DB;
use Illuminate\Http\Request;
use Redirect;
use App\Exceptions\Handler;

date_default_timezone_set('Asia/Jakarta');
class CrudMenuController extends Controller
{
    public function data_for_form()
    {
        $data['parents'] = DB::table('menus')->where('menu_id', '!=', 0)->get();
        $path            = base_path('public/font-awesome-4.7.0.json');
        $icons           = json_decode(file_get_contents($path), true);
        $data['icons']   = $icons['4.7.0'];

        $max                     = DB::table('menus')->where('parent_menu_id', 0)->count();
        $data['max_serial_menu'] = $max + 1;

        return $data;
    }

    public function index()
    {
        try {
            $cek = parent::sidebar();
            if ($cek['access'] == 0) {
                return redirect('/');
            } else {
                $data = array_merge(parent::sidebar(), $this->data_for_form());
                return view('crud_menu.index', $data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'CrudMenuController@index';
            $insert_error = parent::InsertErrorSystem($data);
            $error = parent::sidebar();
            $error['id'] = $insert_error;
            return view('errors.index',$error); // jika Metode Get
            //return response()->json($data); // jika metode Post
        }
    }

    public function list_item()
    {
        $admin = DB::table('menus')
            ->orderBy('updated_at', 'desc')
            ->get();
        // Datatables Variables
        $draw   = 10;
        $start  = 0;
        $length = 10;

        $data = array();
        $no   = 0;
        foreach ($admin as $d) {
            $no = $no + 1;
            // $status = parent::get_status($d->status, $d->id, 'menu', 'list-menu');
            //$action = parent::get_action($d->id, 'menu', 'list-menu');
            $action = '<div style="float: left; margin-left: 5px;"><a href="/administrator/pengaturan-menu/'.$d->id.'" ><button type="button" class="btn btn-warning btn-sm" style="min-width: 110px;margin-left: 2px;margin-top:3px;text-align:left"><i class="fa fa-edit"></i> Detail</button></a></div>';
        //delete
            $action .= '<div style="float: left; margin-left: 5px;"><button type="button" class="btn btn-danger btn-sm aksi btn-aksi" id="' . $d->id . '" aksi="delete" tujuan="menu" data="list-menu" style="min-width: 110px;margin-left: 2px;margin-top:3px;text-align:left"><i class="fa fa-trash"></i> Hapus</button></div>';

            $menu = DB::table('menus')->where('menu_id', $d->parent_menu_id)->first();

            $icon   = '<i class="' . $d->icon . ' fa-3x"></i>';
            $data[] = array(
                $no,
                $d->name,
                $d->parent_menu_id == 0 ? '' : $menu->name,
                $icon,
                $d->parent_menu_id == 0 ? $d->number : '',
                $d->parent_menu_id == 0 ? '' : $d->number,
                $action,
            );
        }

        $output = array(
            "draw"            => $draw,
            "recordsTotal"    => count($admin),
            "recordsFiltered" => count($admin),
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

            if ($request->parent_menu_id != null) {
                //jika sub menu
                $parent_menu_id = $request->parent_menu_id;
                $menu_id        = 0;
                $number  = $request->serial_sub_menu;
                $icon           = '';

                if ($request->serial_sub_menu != $request->max_serial_sub_menu) {
                    DB::table('menus')
                        ->where('parent_menu_id', $request->parent_menu_id)
                        ->where('number', $request->serial_sub_menu)
                        ->update(['number' => $request->max_serial_sub_menu]);
                }
            } else {
                //jika menu
                $max = DB::table('menus')->orderBy('menu_id', 'desc')->first();

                $parent_menu_id = 0;
                $menu_id        = $max->menu_id + 1;
                $number  = $request->serial_menu;
                $icon           = $request->icon;

                if ($request->serial_menu != $request->max_serial_menu) {
                    DB::table('menus')
                        ->where('parent_menu_id', 0)
                        ->where('number', $request->serial_menu)
                        ->update(['number' => $request->max_serial_menu]);
                }
            }

            $input = [
                'parent_menu_id' => $parent_menu_id,
                'menu_id'        => $menu_id,
                'name'      => $request->name,
                'slug'           => $slug,
                'icon'           => $icon,
                'number'  => $number,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ];

            // dd($input);
            $menu_id = DB::table('menus')->insertGetId($input);

            $role = DB::table('roles')->orderBy('created_at', 'asc')->first();

            $role_menus = [
                'role_id'    => $role->id,
                'menu_id'    => $menu_id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $insert = DB::table('role_menus')->insert($role_menus);

            // $id_admin = Auth::guard('admin')->user()->id;
            if ($insert) {
                $data['menu']    = 1;
                $data['code']    = 200;
                $data['message'] = 'Berhasil menambah Menu';
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
            $data['controller'] = 'CrudMenuController@post';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function get_max_serial($parent_id)
    {
        $max        = DB::table('menus')->where('parent_menu_id', $parent_id)->orderBy('number', 'desc')->first();
        $max_serial = $max ? $max->number + 1 : 1;

        return response()->json($max_serial);
    }

    public function detail($id)
    {
        try {

            $cek = parent::sidebar();
            if ($cek['access'] == 0) {
                return redirect('/');
            } else {
                $select = DB::table('menus')->where('id', $id)->first();
                $data = array_merge(parent::sidebar(), $this->data_for_form());
                $data['max_serial_menu'] = $data['max_serial_menu'] - 1;
                $data['code']            = 200;
                $data['data']            = $select;
                if ($select->parent_menu_id != 0) {
                    $max                         = DB::table('menus')->where('parent_menu_id', $select->parent_menu_id)->orderBy('number', 'desc')->first();
                    $data['max_serial_sub_menu'] = $max->number ?? 1;
                } else {
                    $data['max_serial_sub_menu'] = 1;
                }
                return view('crud_menu.dialog_edit', $data);
            }
                
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'CrudMenuController@detail';
            $insert_error = parent::InsertErrorSystem($data);
            $error = parent::sidebar();
            $error['id'] = $insert_error;
            return view('errors.500',$error); // jika Metode Get
            //return response()->json($data); // jika metode Post
        }
    }

    public function update(Request $request)
    {
        try {
            $lower = strtolower($request->name);
            $slug  = preg_replace('/\s+/', '-', $lower);

            if ($request->parent_menu_id != null) {
                //jika sub menu
                $parent_menu_id = $request->parent_menu_id;
                $number  = $request->serial_sub_menu;
                $icon           = '';
                if ($request->parent_menu_id != $request->old_parent) {
                    //jika pindah parent
                    if ($request->serial_sub_menu != $request->max_serial_sub_menu) {
                        DB::table('menus')
                            ->where('parent_menu_id', $request->parent_menu_id)
                            ->where('number', $request->serial_sub_menu)
                            ->update(['number' => $request->max_serial_sub_menu]);
                    }
                    $old_subs = DB::table('menus')->where('parent_menu_id', $request->old_parent)->get();

                    if ($old_subs) {
                        foreach ($old_subs as $value) {
                            if ($value->number > $request->old_serial_sub) {
                                DB::table('menus')
                                ->where('parent_menu_id', $request->old_parent)
                                ->where('number', $value->number)
                                ->update(['number' => $value->number - 1]);
                            }
                        }
                    }
                } else {
                    //jika parent tetap
                    if ($request->serial_sub_menu != $request->old_serial_sub) {
                        DB::table('menus')
                            ->where('parent_menu_id', $request->parent_menu_id)
                            ->where('number', $request->serial_sub_menu)
                            ->update(['number' => $request->old_serial_sub]);
                    }
                }
            } else {
                //jika menu
                $parent_menu_id = 0;
                $number  = $request->serial_menu;
                $icon           = $request->icon;

                if ($request->serial_menu != $request->old_serial_menu) {
                    DB::table('menus')
                        ->where('parent_menu_id', 0)
                        ->where('number', $request->serial_menu)
                        ->update(['number' => $request->old_serial_menu]);
                }
            }

            $input = [
                'parent_menu_id' => $parent_menu_id,
                'name'      => $request->name,
                'icon'           => $icon,
                'number'  => $number,
                'updated_at'     => date('Y-m-d H:i:s'),
            ];

            $update = DB::table('menus')->where('id', $request->id)->update($input);

            if ($update) {
                $data['menu']    = 1;
                $data['code']    = 200;
                $data['message'] = 'Berhasil Mengupdate Data Menu';
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
            $data['controller'] = 'CrudMenuController@update';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function nonactive(Request $request)
    {
        try {
            $admin         = Administrator::find($request->id);
            $admin->status = 0;
            $admin->save();
            if ($admin) {
                $data['code']    = 200;
                $data['message'] = 'Berhasil Menonaktifkan Menu';
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
            $data['controller'] = 'CrudMenuController@nonactive';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function active(Request $request)
    {
        try {
            $admin         = Administrator::find($request->id);
            $admin->status = 1;
            $admin->save();
            if ($admin) {
                $data['code']    = 200;
                $data['message'] = 'Berhasil Memblokir Menu';
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
            $data['controller'] = 'CrudMenuController@active';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function delete(Request $request)
    {
        try {
            $delete = DB::table('menus')->where('id', $request->id)->delete();

            if ($delete) {
                $data['menu']    = 1;
                $data['code']    = 200;
                $data['message'] = 'Berhasil Menghapus Menu';
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
            $data['controller'] = 'CrudMenuController@delete';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }
}
