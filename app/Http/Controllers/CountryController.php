<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Model\RoleModel;
use App\Model\CountryModel;
use App\Traits\Fungsi;
use Redirect;
use App\Exceptions\Handler;

class CountryController extends Controller
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
                
                return view('master.country.index',$data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'CountryController@index';
            $insert_error = parent::InsertErrorSystem($data);
            $error = parent::sidebar();
            $error['id'] = $insert_error;
            return view('errors.index',$error); // jika Metode Get
            //return response()->json($data); // jika metode Post
        }
    }

    public function listData()
    {
    	$admin = CountryModel::whereNull('deleted_at')
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
                    <button type="button" id="' . $d->id . '" aksi="nonaktif" tujuan="master_country" data="data_master_country" class="btn btn-success btn-sm aksi">Aktif</button>
                    </div>';
            } else {
                $status = '<div style="float: left; margin-left: 5px;">
                    <button type="button" id="' . $d->id . '" data="data_master_country" aksi="aktif" tujuan="master_country" class="btn btn-danger btn-sm aksi">Tidak Aktif</button>
                    </div>';
            }
            $no     = $no + 1;
            $data[] = array(
                $no,
                $d->name,
                $status,
                '<div style="float: left; margin-left: 5px;"><a href="/master/negara/'.$d->id.'" >
                    <button type="button" id="' . $d->id . '" class="btn btn-warning btn-sm edit_data" style="min-width: 110px;margin-left: 2px;margin-top:3px;text-align:left"><i class="fa fa-edit"></i> Edit</button></a>
                </div>
                <div style="float: left; margin-left: 5px;">
                    <button type="button" class="btn btn-danger btn-sm aksi btn-aksi" data="data_master_country"  id="' . $d->id . '" aksi="delete" tujuan="master_country" style="min-width: 110px;margin-left: 2px;margin-top:3px;text-align:left"><i class="fa fa-trash"></i> Hapus</button>
                </div>',
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
            $input       = $request->all();
            $id_admin    = Auth::guard('admin')->user()->id;
            $insertadmin = array(
                'name'         => $request->name,
                'status'       => 1,
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            );
            $insert = DB::table('countries')->insertGetId($insertadmin);
            if ($insert) {
                
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Menambah Data Negara '.$request->name.'','Negara');
                $data['code']    = 200;
                $data['message'] = 'Berhasil menambah Data Country';
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
            $data['controller'] = 'CountryController@post';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }


    public function nonactive(Request $request)
    {
        try {
            $nonactive         = CountryModel::find($request->id);
            $nonactive->status = 0;
            $nonactive->save();
            
            if ($nonactive) {
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Menonaktifkan Data Negara '.$request->id.'','Negara');
                $data['code']    = 200;
                $data['message'] = 'Berhasil Memblokir Data Country';
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
            $data['controller'] = 'CountryController@nonactive';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function active(Request $request)
    {
        try {
            $active         = CountryModel::find($request->id);
            $active->status = 1;
            $active->save();
            
            if ($active) {
                $id_admin    = Auth::guard('admin')->user()->id;
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Mengaktifkan Data Negara '.$request->id.'','Negara');
                $data['code']    = 200;
                $data['message'] = 'Berhasil Mengaktifkan Data Country';
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
            $data['controller'] = 'CountryController@active';
            $insert_error = parent::InsertErrorSystem($data);
            
            return response()->json($data); // jika metode Post
        }
    }

    public function delete(Request $request)
    {
        try {
            $delete             = CountryModel::find($request->id);
            $delete->status     = 0;
            $delete->deleted_at = date('Y-m-d');
            $delete->save();

            if ($delete) {
                $id_admin    = Auth::guard('admin')->user()->id;
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Menghapus Data Negara '.$request->id.'','Negara');
                $data['code']    = 200;
                $data['message'] = 'Berhasil Menghapus Data Country';
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
            $data['controller'] = 'CountryController@delete';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }


    public function detail($id)
    {
        try {
            $admin = CountryModel::find($id);
            $role_id = Auth::guard('admin')->user()->id_role;
            $data = parent::sidebar();
            if ($data['access'] == 0) {
                return redirect('/');
            } else {
                $data['name_adm'] = Auth::guard('admin')->user()->name;
                $data['data']      = $admin;
                $data['data_role'] = RoleModel::whereNull('deleted_at')->where('status', 1)->get();
                return view('master.country.dialog_edit', $data);
            }

        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'CountryController@detail';
            $insert_error = parent::InsertErrorSystem($data);
            $error = parent::sidebar();
            $error['id'] = $insert_error;
            return view('errors.500',$error); // jika Metode Get
            //return response()->json($data); // jika metode Post
        }
    }

    public function Update(Request $request)
    {
        //dd($request->nik);
        try {
            $input       = $request->all();
            $id_admin    = Auth::guard('admin')->user()->id;
            $insertadmin = array(
                'name'         => $request->name,
                'updated_at'   => date('Y-m-d H:i:s'),
            );
            $insert = CountryModel::where('id', $request->id)->update($insertadmin);
            if ($insert) {
                $data['code']    = 200;
                $data['message'] = 'Berhasil Mengupdate Data Country';
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
            $data['controller'] = 'CountryController@update';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }


}
