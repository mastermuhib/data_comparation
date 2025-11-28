<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Model\RoleModel;
use App\Model\CountryModel;
use App\Model\ProvinceModel;
use App\Traits\Fungsi;
use redirect;
use App\Exceptions\Handler;

class ProvinceController extends Controller
{
    public function index()
    {
        try {
            $data = parent::sidebar();
            if ($data['access'] == 0) {
                return redirect('/');
            } else {
            	$role_id = Auth::guard('admin')->user()->id_role;
                $data['name_adm'] = Auth::guard('admin')->user()->name;
                
                $data['data_country'] = CountryModel::whereNull('deleted_at')->get();
                

                return view('master.province.index',$data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'ProvinceController@index';
            $insert_error = parent::InsertErrorSystem($data);
            $error = parent::sidebar();
            $error['id'] = $insert_error;
            return view('errors.index',$error); // jika Metode Get
            //return response()->json($data); // jika metode Post
        }
    }

    public function get_provinces($country_id)
    {
        $provinces = ProvinceModel::where('country_id', $country_id)
            ->whereNull('deleted_at')
            ->orderBy('name', 'asc')->get();

        echo json_encode($provinces);
    }

    public function listData()
    {
         $admin = ProvinceModel::whereNull('deleted_at')
            ->orderBy('name')
            ->get();
        // Datatables Variables
        $draw   = 10;
        $start  = 0;
        $length = 10;

        $data = array();
        $no   = 0;
        foreach ($admin as $d) {
            if ($d->status == 1) {
                $status = '<div style="float: left; margin-left: 5px;">
                    <button type="button" id="' . $d->id . '" aksi="nonaktif" tujuan="master_province" data="data_master_province" class="btn btn-success btn-sm aksi">Aktif</button>
                    </div>';
            } else {
                $status = '<div style="float: left; margin-left: 5px;">
                    <button type="button" id="' . $d->id . '" data="data_master_province" aksi="aktif" tujuan="master_province" class="btn btn-danger btn-sm aksi">Tidak Aktif</button>
                    </div>';
            }
            $no      = $no + 1;
            $country = CountryModel::find($d->country_id);
            $data[]  = array(
                $no,
                $d->name,
                $country->name,
                $status,
                '<div style="float: left; margin-left: 5px;"><a href="/master/provinsi/'.$d->id.'" >
                    <button type="button" class="btn btn-warning btn-sm" style="min-width: 110px;margin-left: 2px;margin-top:3px;text-align:left"><i class="fa fa-edit"></i> Edit</button></a>
                </div>
                <div style="float: left; margin-left: 5px;">
                    <button type="button" class="btn btn-danger btn-sm aksi btn-aksi" data="data_master_province"  id="' . $d->id . '" aksi="delete" tujuan="master_province" style="min-width: 110px;margin-left: 2px;margin-top:3px;text-align:left"><i class="fa fa-trash"></i> Hapus</button>
                </div>',
            );
        }

        $output = array(
            // 'dd' => $country_name,
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
            $input       = $request->all();
            $id_admin    = Auth::guard('admin')->user()->id;
            $insertadmin = array(
                'name' => $request->name
                , 'country_id' => $request->country_id
                , 'status' => 1
                , 'created_at' => date('Y-m-d H:i:s')
                , 'updated_at' => date('Y-m-d H:i:s'),
            );
            $insert = DB::table('provinces')->insertGetId($insertadmin);
            if ($insert) {
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Menambah Data Provinsi '.$request->name.'','Provinsi');
                $data['code']    = 200;
                $data['message'] = 'Berhasil menambah Data Province';
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
            $data['controller'] = 'ProvinceController@post';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }


    public function nonactive(Request $request)
    {
        try {
            $nonactive         = ProvinceModel::find($request->id);
            $nonactive->status = 0;
            $nonactive->save();

            if ($nonactive) {
                $id_admin    = Auth::guard('admin')->user()->id;
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Menon aktifkan Data Provinsi '.$request->id.'','Provinsi');
                $data['code']    = 200;
                $data['message'] = 'Berhasil Memblokir Data Province';
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
            $data['controller'] = 'ProvinceController@detail';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function active(Request $request)
    {
        try {
            $active         = ProvinceModel::find($request->id);
            $active->status = 1;
            $active->save();

            if ($active) {
                $id_admin    = Auth::guard('admin')->user()->id;
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Mengaktifkan Data Provinsi '.$request->id.'','Provinsi');

                $data['code']    = 200;
                $data['message'] = 'Berhasil Mengaktifkan Data Province';
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
            $data['controller'] = 'ProvinceController@active';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }


    public function detail($id)
    {
        try {
            $admin = ProvinceModel::find($id);
            $data = parent::sidebar();
            if ($data['access'] == 0) {
                return redirect('/');
            } else {
                $role_id = Auth::guard('admin')->user()->id_role;
                $data['name_adm'] = Auth::guard('admin')->user()->name;
                $data['data']         = $admin;
                $data['data_country'] = CountryModel::all();
                // return response()->json($data);
                return view('master.province.dialog_edit', $data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'ProvinceController@detail';
            $insert_error = parent::InsertErrorSystem($data);
            $error = parent::sidebar();
            $error['id'] = $insert_error;
            return view('errors.500',$error); // jika Metode Get
            //return response()->json($data); // jika metode Post
        }
    }


   public function update(Request $request)
    {
        //dd($request->nik);
        try {
            $input       = $request->all();
            $id_admin    = Auth::guard('admin')->user()->id;
            $insertadmin = array(
                'name' => $request->name
                , 'country_id' => $request->country_id
                , 'updated_at' => date('Y-m-d H:i:s'),
            );
            $insert = ProvinceModel::where('id', $request->id)->update($insertadmin);
            if ($insert) {
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Mengubah Data Provinsi '.$request->name.'','Provinsi');
                $data['code']    = 200;
                $data['message'] = 'Berhasil Mengupdate Data Province';
                return response()->json($data);
            } else {
                $data['code']    = 500;
                $data['message'] = 'Maaf Ada yang Error ';
                $data['insert']  = $insertadmin;
                return response()->json($data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'ProvinceController@update';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function delete(Request $request)
    {
        try {
            $delete             = ProvinceModel::find($request->id);
            $delete->status     = 0;
            $delete->deleted_at = date('Y-m-d');
            $delete->save();

            if ($delete) {
                $id_admin    = Auth::guard('admin')->user()->id;
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Menghapus Data Provinsi '.$request->id.'','Provinsi');
                $data['code']    = 200;
                $data['message'] = 'Berhasil Menghapus Data Province';
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
            $data['controller'] = 'ProvinceController@delete';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }


}
