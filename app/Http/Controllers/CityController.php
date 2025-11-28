<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\CityModel;
use App\Model\CountryModel;
use App\Model\LogAdmin;
use App\Model\ProvinceModel;
use App\Model\RoleModel;
use App\Traits\Fungsi;
use Auth;
use DB;
use Redirect;
use App\Exceptions\Handler;

class CityController extends Controller
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
                $data['data_country'] = CountryModel::whereNull('deleted_at')->get();

                return view('master.city.index', $data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'CityController@index';
            $insert_error = parent::InsertErrorSystem($data);
            $error = parent::sidebar();
            $error['id'] = $insert_error;
            return view('errors.index',$error); // jika Metode Get
            //return response()->json($data); // jika metode Post
        }
    }


    public function list_data(Request $request)
    {


        $totalData = DB::table('cities')->whereNull('deleted_at')->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $dir   = $request->input('order.0.dir');
        $search = $request->input('search.value');

        $posts = CityModel::whereNull('deleted_at')->where(function ($query) use ($search,$request) {
            if ($search != null) {
                $query->where('name','ilike', "%{$search}%");
            } 
        })->orderBy('name');
        $totalFiltered = $posts->count();
        $posts = $posts->limit($limit)->offset($start)->get();

        $data = array();
        if (!empty($posts)) {

            $no = 0;
           
            foreach ($posts as $d) {
                $no = $no + 1;
                $province = ProvinceModel::find($d->province_id);
            	$country  = CountryModel::find($province->country_id);

                if ($d->status == 1) {
                    $status = '<div style="float: left; margin-left: 5px;">
                        <a id="' . $d->id . '" aksi="nonaktif" tujuan="City" data="data_master_city" class="btn btn-success btn-sm aksi">Aktif</a>
                        </div>';
                } else {
                    $status = '<div style="float: left; margin-left: 5px;">
                        <button type="button" id="' . $d->id . '"data="data_master_city" aksi="aktif" tujuan="City" class="btn btn-danger btn-sm aksi">Tidak Aktif</button>
                        </div>';
                }


                $action = '<div style="float: left; margin-left: 5px;"><a href="/master/kota/'.$d->id.'" >
                    <button type="button" class="btn btn-warning btn-sm" style="min-width: 110px;margin-left: 2px;margin-top:3px;text-align:left"><i class="fa fa-edit"></i> Edit</button></a>
                </div>
                <div style="float: left; margin-left: 5px;">
                    <button type="button" class="btn btn-danger btn-sm aksi btn-aksi" data="data_master_city"  id="' . $d->id . '" aksi="delete" tujuan="City" style="min-width: 110px;margin-left: 2px;margin-top:3px;text-align:left"><i class="fa fa-trash"></i> Hapus</button>
                </div>';

                $nestedData['no']           = $no;
                $nestedData['name']   		= $d->name;
                $nestedData['province']     = $province->name;
                $nestedData['country']      =  $country->name;
                $nestedData['status']        = $status;
                $nestedData['action']        = $action;
                $data[]                      = $nestedData;

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

    public function get_cities($prov_id)
    {
        $cities = CityModel::where('province_id', $prov_id)
            ->whereNull('deleted_at')
            ->orderBy('name', 'asc')->get();

        echo json_encode($cities);
    }

    

    public function nonactive(Request $request)
    {
        try {
            $nonactive         = CityModel::find($request->id);
            $nonactive->status = 0;
            $nonactive->save();

            if ($nonactive) {
                $id_admin    = Auth::guard('admin')->user()->id;
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Menon aktifkan Data Kota '.$request->id.'','Kota');
                $data['code']    = 200;
                $data['message'] = 'Berhasil Memblokir Data City';
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
            $data['controller'] = 'CityController@nonactive';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function active(Request $request)
    {
        try {
            $active         = CityModel::find($request->id);
            $active->status = 1;
            $active->save();

            if ($active) {
                $id_admin    = Auth::guard('admin')->user()->id;
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Mengaktifkan Data Kota '.$request->id.'','Kota');
                $data['code']    = 200;
                $data['message'] = 'Berhasil Mengaktifkan Data City';
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
            $data['controller'] = 'CityController@active';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function delete(Request $request)
    {
        try {
            $delete             = CityModel::find($request->id);
            $delete->status     = 0;
            $delete->deleted_at = date('Y-m-d');
            $delete->save();

            if ($delete) {
                $id_admin    = Auth::guard('admin')->user()->id;
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Menghapus Data Kota '.$request->id.'','Kota');
                $data['code']    = 200;
                $data['message'] = 'Berhasil Menghapus Data City';
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
            $data['controller'] = 'CityController@delete';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function detail($id)
    {
        try {
            $query = CityModel::find($id);
            $data = parent::sidebar();
            if ($data['access'] == 0) {
                return redirect('/');
            } else {
                $role_id = Auth::guard('admin')->user()->id_role;
                $data['name_adm'] = Auth::guard('admin')->user()->name;
                $province              = ProvinceModel::where('id', $query->province_id)->first();
                $query->country_id     = $province->country_id;
                $data['data']          = $query;
                $data['data_country']  = CountryModel::all();
                $data['data_province'] = ProvinceModel::where('country_id', $query->country_id)->get();
                // return response()->json($data);
                return view('master.city.dialog_edit', $data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'CityController@detail';
            $insert_error = parent::InsertErrorSystem($data);
            $error['id'] = $insert_error;
            return view('errors.500',$error); // jika Metode Get
        }
    }

    public function update(Request $request)
    {
        //dd($request->nik);
        try {
            $input       = $request->all();
            $id_admin    = Auth::guard('admin')->user()->id;
            $insertadmin = array(
                'name'        => $request->name,
                'province_id' => $request->province,
                'updated_at'  => date('Y-m-d H:i:s'),
            );
            $insert = CityModel::where('id', $request->id)->update($insertadmin);
            if ($insert) {
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Mengubah Data Kota '.$request->id.'','Kota');
                $data['code']    = 200;
                $data['message'] = 'Berhasil Mengupdate Data City';
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
            $data['controller'] = 'CityController@update';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }


    public function province($country_id)
    {
        $provinces = ProvinceModel::where('country_id', $country_id)
            ->whereNull('deleted_at')
            ->orderBy('name', 'asc')->get();

        echo json_encode($provinces);
    }

    public function post(Request $request)
    {
        try {
            $input       = $request->all();
            $id_admin    = Auth::guard('admin')->user()->id;
            $insertadmin = array(
                'name' => $request->name, 
                'province_id' => $request->province, 
                'status' => 1, 
                'created_at' => date('Y-m-d H:i:s'), 
                'updated_at' => date('Y-m-d H:i:s'),
            );
            $insert = DB::table('cities')->insertGetId($insertadmin);
            if ($insert) {
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Menambah Data Kota '.$request->name.'','Kota');
                $data['code']    = 200;
                $data['message'] = 'Berhasil menambah Data City';
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
            $data['controller'] = 'CityController@update';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }
}
