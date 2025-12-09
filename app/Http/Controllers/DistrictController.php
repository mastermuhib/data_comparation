<?php

namespace App\Http\Controllers;

use App\Model\CountryModel;
use App\Model\DistrictModel;
use App\Model\VillageModel;
use App\Model\RoleModel;
use App\Traits\Fungsi;
use Auth;
use DB;
use Illuminate\Http\Request;
use Redirect;
use App\Exceptions\Handler;

class DistrictController extends Controller
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

                $regenci = DistrictModel::get()->first();
                // dd($regenci);
               
                return view('master.district.index', $data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'DistrictController@index';
            $insert_error = parent::InsertErrorSystem($data);
            $error = parent::sidebar();
            $error['id'] = $insert_error;
            return view('errors.index',$error); // jika Metode Get
            //return response()->json($data); // jika metode Post
        }
    }

    public function list_data(Request $request)
    {

        $totalData = DB::table('districts')->whereNull('deleted_at')->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $dir   = $request->input('order.0.dir');
        $search =  $request->input('search.value');
        $posts = DistrictModel::whereNull('deleted_at')->where(function ($query) use ($search,$request) {
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
                $city     = CityModel::find($d->regency_id);
        	    $province = ProvinceModel::find($city->province_id);

                if ($d->status == 1) {
                    $status = '<div style="float: left; margin-left: 5px;">
                        <a id="' . $d->id . '" aksi="nonaktif" tujuan="District" data="data_master_district" class="btn btn-success btn-sm aksi">Aktif</a>
                        </div>';
                } else {
                    $status = '<div style="float: left; margin-left: 5px;">
                        <button type="button" id="' . $d->id . '"data="data_master_district" aksi="aktif" tujuan="District" class="btn btn-danger btn-sm aksi">Tidak Aktif</button>
                        </div>';
                }


                $action = '<div style="float: left; margin-left: 5px;"><a href="/master/kecamatan/'.$d->id.'" >
                    <button type="button" class="btn btn-warning btn-sm" style="min-width: 110px;margin-left: 2px;margin-top:3px;text-align:left"><i class="fa fa-edit"></i> Edit</button></a>
                </div>
                <div style="float: left; margin-left: 5px;">
                    <button type="button" class="btn btn-danger btn-sm aksi btn-aksi" data="data_master_district"  id="' . $d->id . '" aksi="delete" tujuan="District" style="min-width: 110px;margin-left: 2px;margin-top:3px;text-align:left"><i class="fa fa-trash"></i> Hapus</button>
                </div>';

                $nestedData['no']           = $no;
                $nestedData['name']   		= $d->name;
                $nestedData['city']     	= $city->name;
                $nestedData['province']     = $province->name;
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
            $input      = $request->all();
            $id_admin   = Auth::guard('admin')->user()->id;
            $insertData = array(
                'id'    => rand(10000,99999),
                'name' => $request->name, 
                'regency_id' => $request->city_id, 
                'status' => 1, 
                'created_at' => date('Y-m-d H:i:s'), 
                'updated_at' => date('Y-m-d H:i:s'),
            );

            // $insert = DB::table('districts')->insert($insertData);
            // return response()->json($insertData);
            $insert = DB::table('districts')->insertGetId($insertData);
            if ($insert) {
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Menambah Data kecamatan '.$request->name.'','kecamatan');
                $data['code']    = 200;
                $data['message'] = 'Berhasil menambah Data District';
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
            $data['controller'] = 'DistrictController@post';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function nonactive(Request $request)
    {
        try {
            $nonactive         = DistrictModel::find($request->id);
            $nonactive->status = 0;
            $nonactive->save();

            if ($nonactive) {
                $id_admin    = Auth::guard('admin')->user()->id;
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Menon aktifkan Data kecamatan '.$request->id.'','kecamatan');
                $data['code']    = 200;
                $data['message'] = 'Berhasil Memblokir Data District';
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
            $data['controller'] = 'DistrictController@nonactive';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function active(Request $request)
    {
        //delete gakk bisa
        try {
            $active         = DistrictModel::find($request->id);
            $active->status = 1;
            $active->save();

            if ($active) {
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Mengaktifkan Data kecamatan '.$request->id.'','kecamatan');
                $data['code']    = 200;
                $data['message'] = 'Berhasil Mengaktifkan Data District';
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
            $data['controller'] = 'DistrictController@active';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function delete(Request $request)
    {
        try {
            $delete             = DistrictModel::find($request->id);
            $delete->status     = 0;
            $delete->deleted_at = date('Y-m-d H:i:s');
            $delete->save();


            if ($delete) {
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Mengubah Data kecamatan '.$request->id.'','kecamatan');
                $data['code']    = 200;
                $data['message'] = 'Berhasil Menghapus Data District';
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
            $data['controller'] = 'DistrictController@deleted';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function detail($id)
    {
        try {
            $query = DistrictModel::find($id);
            $data = parent::sidebar();
            if ($data['access'] == 0) {
                return redirect('/');
            } else {
                $role_id = Auth::guard('admin')->user()->id_role;
                $data['name_adm'] = Auth::guard('admin')->user()->name;
                $city               = CityModel::where('id', $query->regency_id)->first();
                $province           = ProvinceModel::where('id', $city->province_id)->first();
                $query->province_id = $city->province_id;
                $query->country_id  = $province->country_id;
                $data['data']       = $query;
                $data['countries']  = CountryModel::all();
                $data['provinces']  = ProvinceModel::where('country_id', $province->country_id)->get();
                $data['cities']     = CityModel::where('province_id', $city->province_id)->get();
                // return response()->json($data);
                return view('master.district.dialog_edit', $data);
               
                return view('master.district.index', $data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'DistrictController@detail';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function update(Request $request)
    {
        try {
        //dd($request->nik);
            $input      = $request->all();
            $id_admin   = Auth::guard('admin')->user()->id;
            $insertData = array(
                'name'        => $request->name,
                'regency_id'     => $request->city_id,
                'updated_at'  => date('Y-m-d H:i:s'),
            );

            $insert = DistrictModel::where('id', $request->id)->update($insertData);
            if ($insert) {
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Mengupdate Data kecamatan '.$request->name.'','kecamatan');
                $data['code']    = 200;
                $data['message'] = 'Berhasil Mengupdate Data District';
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
            $data['controller'] = 'DistrictController@detail';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function get_village($id)
    {
        $data = VillageModel::where('district_id', $id)
            ->whereNull('deleted_at')
            ->orderBy('name', 'asc')->get();

        echo json_encode($data);
    }
}
