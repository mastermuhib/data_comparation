<?php

namespace App\Http\Controllers;

use App\Administrator;
use App\Model\RoleModel;
use App\Model\SchollModel;
use App\Classes\upload;
use App\Traits\Fungsi;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\Handler;

class AdministratorController extends Controller
{
    public function index()
    {
        // dd(Administrator::get());
        try {
            $data = parent::sidebar();
            if ($data['access'] == 0) {
                return redirect('/');
            } else {
                $role_id           = Auth::guard('admin')->user()->id_role;
                $data['data_role'] = RoleModel::whereNull('deleted_at')->where('status', 1)->get();
                $data['data_scholl'] = SchollModel::whereNull('deleted_at')->get();
                
                return view('admin.index', $data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'Administrator@index';
            $insert_error = parent::InsertErrorSystem($data);
            $error = parent::sidebar();
            $error['id'] = $insert_error;
            return view('errors.index',$error); // jika Metode Get
            //return response()->json($data); // jika metode Post
        }
    }

    public function list_item(Request $request)
    {
        
        $totalData = Administrator::whereNull('deleted_at')->count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $dir   = $request->input('order.0.dir');

        $posts = DB::table('administrators as a')->join('roles', 'roles.id', 'a.id_role')
            ->select('admin_name', 'roles.name as role_name', 'email', 'a.status', 'a.id')
            ->whereNull('a.deleted_at')
            ->orderBy('admin_name');

        $search = $request->input('search.value');

        if ($search) {
            $posts = $posts->where('admin_name', 'ilike', "%{$search}%");
        }

        $totalFiltered = $posts->count();

        $posts = $posts->limit($limit)->offset($start)->get();

        $data = array();
        if (!empty($posts)) {
            $no = 0;
            foreach ($posts as $d) {
                $no = $no + 1;

                if ($d->status == 1) {
                    $status = '<div style="float: left; margin-left: 5px;"><a id="' . $d->id . '" aksi="nonaktif" tujuan="' . 'Administrator' . '" data="' . 'data_admin' . '" class="btn btn-success btn-sm aksi">Aktif</a></div>';
                } else {
                    $status = '<div style="float: left; margin-left: 5px;"><a id="' . $d->id . '" aksi="aktif" tujuan="' . 'Administrator' . '" data="' . 'data_admin' . '" class="btn btn-danger btn-sm aksi">Non Aktif</a></div>';
                }

                $action = '<a href="/administrator/list-admin/'.$d->id.'"  class="btn btn-success btn-sm d_detail" style="min-width: 120px;margin-left: 7px;margin-top:3px;text-align:left"><span class="navi-icon"><i class="fas fa-edit"></i></span><span class="navi-text">Edit</span></a>';
                //delete
                $action .= '<div style="float: left; margin-left: 5px;"><button type="button" class="btn btn-danger btn-sm aksi btn-aksi" id="' . $d->id . '" aksi="delete" tujuan="' . 'Administrator' . '" data="' . 'data_admin' . '" style="min-width: 120px;margin-left: 2px;margin-top:3px;text-align:left"><i class="fa fa-trash"></i> Hapus</button></div>';
                $action .= '<div style="float: left; margin-left: 5px;"><button type="button" class="btn btn-info btn-sm edit_password" id="' . $d->id . '" style="min-width: 120px;margin-left: 2px;margin-top:3px;text-align:left"><i class="fa fa-key"></i> Ganti Password</button></div>';

                $column['name']      = $d->admin_name;
                $column['role_name'] = $d->role_name;
                $column['email']     = $d->email;
                $column['status']    = $status;
                $column['actions']   = $action;
                $data[]              = $column;

            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data,
        );

        echo json_encode($json_data);

    }

    public function postAdmin(Request $request)
    {
        try {
            $input = $request->all();
            if ($request->file('profile')) {
                $profile  = parent::uploadFileS3($request->file('profile'));
            } else {
                $profile = null;
            }

            //LYWNdkyX8koF3ReBQGELUKMgq7GIZcuBBRH4dyD8.png
            $id_admin                  = Auth::guard('admin')->user()->id;
            $input['status']           = 'aktif';
            $input['password']         = Hash::make($request->password);
            $input['confirm_password'] = Hash::make($request->confirm_password);
            $insertadmin=array(
                        'admin_name'=>$request->name
                        ,'phone'=>$request->phone
                        ,'email'=>$request->email
                        ,'address'=>$request->address
                        ,'password'=> Hash::make($request->password)
                        ,'confirm_password'=>encrypt($request->password)
                        ,'id_role'=>$request->role_id
                        ,'id_scholl'=>$request->id_scholl
                        ,'profile'=>$profile
                        ,'status'=>1
                        ,'created_at'=>date('Y-m-d H:i:s')
                        ,'updated_at'=>date('Y-m-d H:i:s')
                        );
            $insert = Administrator::insertGetId($insertadmin);
            
            if ($insert) {
                $actifity = 'Menambah Data Admin';
                $object = Administrator::where('email',$request->email)->first();
                //parent::create_log($actifity, $object->id, null);
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Menambah Data Admin '.$request->name.'','Administrator');
                $data['code']    = 200;
                $data['message'] = 'Berhasil ' . $actifity;

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
            $data['controller'] = 'Administrator@postAdmin';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function detail($id)
    {
        try {
            $data = parent::sidebar();
            if ($data['access'] == 0) {
                return redirect('/');
            } else {
                $role_id           = Auth::guard('admin')->user()->id_role;
                $data['data_role'] = RoleModel::whereNull('deleted_at')->where('status', 1)->get();
                $data['data_scholl'] = SchollModel::whereNull('deleted_at')->get();
                $admin = Administrator::find($id);
                $data['data']      = $admin;
                
                return view('admin.dialog_edit', $data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'Administrator@detail';
            $insert_error = parent::InsertErrorSystem($data);
            $error = parent::sidebar();
            $error['id'] = $insert_error;
            return view('errors.index',$error); // jika Metode Get
            //return response()->json($data); // jika metode Post
        }
    }

    public function ubah_password($id)
    {
        $data['data'] = Administrator::find($id);
        return view('admin.edit_password', $data);
    }

    public function update_password(Request $request)
    {
        try {
            if ($request->new_password == $request->confirm_password) {
                $update_password = array(
                    'password'         => Hash::make($request->new_password),
                    'confirm_password' => Hash::make($request->confirm_password),
                    'updated_at'       => date('Y-m-d H:i:s'),
                );
                Administrator::find($request->id)->update($update_password);
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Mengubah Password Admin '.$request->id.'','Administrator');
                $data['code']    = 200;
                $data['message'] = 'Berhasil Mengubah Password';
                return response()->json($data);
            } else {
                $data['code']    = 500;
                $data['message'] = 'Old Password is wrong !';
                return response()->json($data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'Administrator@update_password';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function update(Request $request)
    {
        try {
            $input = $request->all();
            $data_admin = Administrator::where('id',$request->id)->get();
            if ($request->file('profile')) {
                $input['profile']  = parent::uploadFileS3($request->file('profile'));
            } else {
                $input['profile'] = $data_admin[0]->profile;
            }

            $update = Administrator::find($request->id)->update($input);
            if ($update) {
                $data['code']    = 200;
                $data['message'] = 'Berhasil Mengupdate Data Admin';
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Mengubah Data Admin '.$request->id.'','Administrator');
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
            $data['controller'] = 'Administrator@update';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function nonactive(Request $request)
    {
        try {
            $admin         = Administrator::find($request->id);
            $admin->status = 'nonaktif';
            $admin->save();
            if ($admin) {
                $data['code']    = 200;
                $data['message'] = 'Berhasil Menonaktifkan Data Admin';
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Menon aktifkan Data Admin '.$request->id.'','Administrator');
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
            $data['controller'] = 'Administrator@nonaktif';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function active(Request $request)
    {
        try {
            $admin         = Administrator::find($request->id);
            $admin->status = 'aktif';
            $admin->save();
            if ($admin) {
                $data['code']    = 200;
                $data['message'] = 'Berhasil Mengaktifkan Data Admin';
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Mengaktifkan Data Admin '.$request->id.'','Administrator');
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
            $data['controller'] = 'Administrator@active';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function delete(Request $request)
    {
        try {
            $admin             = Administrator::find($request->id);
            $admin->status     = 0;
            $admin->deleted_at = date('Y-m-d');
            $admin->save();

            if ($admin) {
                $data['code']    = 200;
                $data['message'] = 'Berhasil Menghapus Data Admin';
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Menghapus Data Admin '.$request->id.'','Administrator');
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
            $data['controller'] = 'Administrator@delete';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }


    public function get_role($id,$jenis)
    {
        $cek = DB::table('roles')->where('id',$id)->pluck('slug');
        $data['jenis'] = $cek[0];
        //dd($data['jenis']);
        if ($jenis == 'company') {

            $data['data_company'] = DB::table('company_registrations')->whereNull('is_delete')->get();

            return view('admin.get_company', $data);
        } else {
            return view('admin.get_kode', $data);
        }
        
    }

}
