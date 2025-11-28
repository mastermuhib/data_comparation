<?php

namespace App\Http\Controllers;

use App\Model\CountryModel;
use App\Model\SchollModel;
use App\Model\DistrictModel;
use App\Model\ProvinceModel;
use App\Model\RoleModel;
use App\Model\CityModel;
use App\Traits\Fungsi;
use Auth;
use DB;
use App\RegencyModel;
use Illuminate\Http\Request;
use Redirect;
use App\Exceptions\Handler;

class SchollController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        try {
            $data = parent::sidebar();
            if ($data['access'] == 0) {
                return redirect('/');
            } else {
                $role_id = Auth::guard('admin')->user()->id_role;
                $data['name_adm'] = Auth::guard('admin')->user()->name;
                $data['data_province'] = ProvinceModel::whereNull('deleted_at')->get();
               
                return view('master.scholl.index', $data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'SchollController@index';
            $insert_error = parent::InsertErrorSystem($data);
            $error = parent::sidebar();
            $error['id'] = $insert_error;
            return view('errors.index',$error); // jika Metode Get
            //return response()->json($data); // jika metode Post
        }
    }

    public function list_data(Request $request)
    {

        $totalData = DB::table('table_scholls')->whereNull('deleted_at')->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $dir   = $request->input('order.0.dir');
        $search =  $request->input('search.value');
        $posts = DB::table('table_scholls as s')->join('provinces as p','p.id','s.id_province')->join('cities as c','c.id','s.id_city')->whereNull('s.deleted_at')->where(function ($query) use ($search,$request) {
            if ($search != null) {
                $query->where('scholl_name','ilike', "%{$search}%");
                $query->orWhere('p.name','ilike', "%{$search}%");
                $query->orWhere('c.name','ilike', "%{$search}%");
            } 
        })->select('s.*','p.name as province','c.name as city')->orderBy('s.created_at','desc');
        $totalFiltered = $posts->count();
        $posts = $posts->limit($limit)->offset($start)->get();

        $data = array();
        if (!empty($posts)) {

            $no = 0;
           
            foreach ($posts as $d) {
               $no = $no + 1;

                if ($d->status == 1) {
                    $status = '<div style="float: left; margin-left: 5px;">
                        <a id="' . $d->id . '" aksi="nonaktif" tujuan="sekolah" data="data_master_sekolah" class="btn btn-success btn-sm aksi">Aktif</a>
                        </div>';
                } else {
                    $status = '<div style="float: left; margin-left: 5px;">
                        <button type="button" id="' . $d->id . '"data="data_master_sekolah" aksi="aktif" tujuan="sekolah" class="btn btn-danger btn-sm aksi">Tidak Aktif</button>
                        </div>';
                }

                if ($request->is_edit == 0) {
                    $action = " - ";
                } else {
                    $action = '<div style="float: left; margin-left: 5px;"><a href="/master/sekolah/'.$d->id.'" >
                        <button type="button" class="btn btn-warning btn-sm" style="min-width: 110px;margin-left: 2px;margin-top:3px;text-align:left"><i class="fa fa-edit"></i> Edit</button></a>
                    </div>
                    <div style="float: left; margin-left: 5px;">
                        <button type="button" class="btn btn-danger btn-sm aksi btn-aksi" data="data_master_sekolah"  id="' . $d->id . '" aksi="delete" tujuan="sekolah" style="min-width: 110px;margin-left: 2px;margin-top:3px;text-align:left"><i class="fa fa-trash"></i> Hapus</button>
                    </div>';
                }


                $nestedData['no']           = $no;
                $nestedData['name']  = $d->scholl_name;
                $nestedData['city']     	= $d->city;
                $nestedData['province']     = $d->province;
                $nestedData['status']       = $status;
                $nestedData['action']       = $action;
                $data[]                     = $nestedData;

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

    public function post(Request $request)
    {
        // id bermasalah
        try {
            $input = $request->except('_token');

            if ($request->file('image')) {
                $input['image']  = parent::uploadFileS3($request->file('image'));
            } 

            $input['created_at'] = date('Y-m-d H:i:s');
            $input['updated_at'] = date('Y-m-d H:i:s');
            $insert = DB::table('table_scholls')->insertGetId($input);
            if ($insert) {
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Menambah Data Sekolah '.$request->name.'','sekolah');
                $data['code']    = 200;
                $data['message'] = 'Berhasil menambah data sekolah';
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
            $data['controller'] = 'SchollController@post';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function nonactive(Request $request)
    {
        try {
            $nonactive         = SchollModel::find($request->id);
            $nonactive->status = 0;
            $nonactive->save();

            if ($nonactive) {
                $id_admin    = Auth::guard('admin')->user()->id;
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Menon aktifkan Data Sekolah '.$request->id.'','sekolah');
                $data['code']    = 200;
                $data['message'] = 'Berhasil Memblokir data sekolah';
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
            $data['controller'] = 'SchollController@nonactive';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function active(Request $request)
    {
        //delete gakk bisa
        try {
            $active         = SchollModel::find($request->id);
            $active->status = 1;
            $active->save();

            if ($active) {
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Mengaktifkan Data Sekolah '.$request->id.'','sekolah');
                $data['code']    = 200;
                $data['message'] = 'Berhasil Mengaktifkan data sekolah';
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
            $data['controller'] = 'SchollController@active';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function delete(Request $request)
    {
        try {
            $delete             = SchollModel::find($request->id);
            $delete->status     = 0;
            $delete->deleted_at = date('Y-m-d H:i:s');
            $delete->save();


            if ($delete) {
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Mengubah Data Sekolah '.$request->id.'','sekolah');
                $data['code']    = 200;
                $data['message'] = 'Berhasil Menghapus data sekolah';
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
            $data['controller'] = 'SchollController@deleted';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function detail($id)
    {
        try {
            $query = SchollModel::find($id);
            $data = parent::sidebar();
            if ($query == null) {
                //dd("ID Tidak ditemukan");
                return view('errors.not_found',$data);
            }
            if ($data['access'] == 0) {
                return redirect('/');
            } else {
                $role_id = Auth::guard('admin')->user()->id_role;
                $data['name_adm'] = Auth::guard('admin')->user()->name;
                
                $data['data']       = $query;
                //dd($data['data']);
                $data['data_province'] = ProvinceModel::whereNull('deleted_at')->get();
                // return response()->json($data);
                return view('master.scholl.dialog_edit', $data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'SchollController@detail';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function update(Request $request)
    {
        try {
        //dd($request->nik);
            $input = $request->except('_token');

            if ($request->file('image')) {
                $input['image']  = parent::uploadFileS3($request->file('image'));
            } 
            $input['updated_at'] = date('Y-m-d H:i:s');

            $insert = SchollModel::where('id', $request->id)->update($input);
            if ($insert) {
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Mengupdate Data Sekolah '.$request->name.'','sekolah');
                $data['code']    = 200;
                $data['message'] = 'Berhasil Mengupdate data sekolah';
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
            $data['controller'] = 'SchollController@detail';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function get_table_scholls($city_id)
    {
        $data = SchollModel::where('regency_id', $city_id)
            ->whereNull('deleted_at')
            ->orderBy('scholl_name', 'asc')->get();

        echo json_encode($data);
    }
}
