<?php

namespace App\Http\Controllers;

use App\Model\RoleModel;
use App\Model\dptModel;
use App\Model\DistrictModel;
use App\Model\CityModel;
use App\Model\UserModel;
use App\Classes\upload;
use App\Traits\Fungsi;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\Handler;

class DptController extends Controller
{
    public function index()
    {
        //dd("cukk");
        // dd(Kelas::get());
        //dd(Auth::guard('admin')->user()->id_scholl);
        try {
            $data = parent::sidebar();
            if ($data['access'] == 0) {
                return redirect('/');
            } else {
                $role_id           = Auth::guard('admin')->user()->id_role;
                $data['data_kec'] = DistrictModel::whereNull('deleted_at')->select('id','name')->get();
                $data['txt_button'] = "Tambah DPT Baru";
                $data['href'] = "user/siswa/action/add";
                //dd($data['id_adm_dept']);
                return view('dpt.index', $data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'DptController@index';
            $insert_error = parent::InsertErrorSystem($data);
            $error = parent::sidebar();
            $error['id'] = $insert_error;
            return view('errors.index',$error); // jika Metode Get
            //return response()->json($data); // jika metode Post
        }
    }

    public function import()
    {
        // dd(Kelas::get());
        //dd(Auth::guard('admin')->user()->id_scholl);
        try {
            $data = parent::sidebar();
            if ($data['access'] == 0) {
                return redirect('/');
            } else {
                $role_id           = Auth::guard('admin')->user()->id_role;
                //dd($data['id_adm_dept']);
                return view('dpt.import', $data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'DptController@import';
            $insert_error = parent::InsertErrorSystem($data);
            $error = parent::sidebar();
            $error['id'] = $insert_error;
            return view('errors.index',$error); // jika Metode Get
            //return response()->json($data); // jika metode Post
        }
    }

    public function post_import_dpt(Request $request){
        
        try {
            
            $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain','csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/vnd.ms-excel');
            //dd($_FILES);
            //(isset($line[])) ? "" : null ; $originalString);
            
            if(empty($_FILES['file']['name'])) {
                $data['code']    = 500;
                $data['message'] = "File Kosong";
            } else {
                if(in_array($_FILES['file']['type'],$csvMimes)){
                    if(is_uploaded_file($_FILES['file']['tmp_name'])){ 
                        // check file size
                        if(filesize($_FILES['file']['tmp_name']) > 51200000000000000) {
                            $data['code']    = 500;
                            $data['message'] = "File Maksimal 500 Mb";
                        } else {
                            //open uploaded csv file with read only mode
                            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
                            //skip first line
                            fgetcsv($csvFile);
                            //parse data from csv file line by line
                            //$data = fgetcsv($csvFile);
                            while(($csv_excel = fgetcsv($csvFile)) !== FALSE){
                                
                                $line = explode("#", $csv_excel[0]);
                                
                                $id_village =  (isset($line[2])) ? $line[2] : null ; 
                                $village = (isset($line[3])) ? $line[3] : null ;
                                $dpid = (isset($line[4])) ? $line[4] : null ; 
                                $nkk = (isset($line[5])) ? $line[5] : null ; 
                                $nik = (isset($line[6])) ? $line[6] : null ; 
                                $name = (isset($line[7])) ? $line[7] : null ; 
                                $tmp_lahir = (isset($line[8])) ? $line[8] : null ; 
                                $tgl_lahir = (isset($line[9])) ? $line[9] : null ; 
                                $kawin = (isset($line[10])) ? $line[10] : null ; 
                                $gender = (isset($line[11])) ? $line[11] : null ; 
                                $address = (isset($line[12])) ? $line[12] : null ; 
                                $rt = (isset($line[13])) ? $line[13] : null ; 
                                $rw = (isset($line[14])) ? $line[14] : null ; 
                                $dis = (isset($line[15])) ? $line[15] : null ; 
                                $ektp = (isset($line[16])) ? $line[16] : null ; 
                                $ket = (isset($line[17])) ? $line[17] : null ; 
                                $sumber = (isset($line[18])) ? $line[18] : null ; 
                                $tps_id = (isset($line[19])) ? $line[19] : null ; 
                                $tps = (isset($line[20])) ? $line[20] : null ; 
                                $updated = (isset($line[21])) ? $line[21] : null ; 
                                $status = (isset($line[22])) ? $line[22] : null ; 
                                $rank = (isset($line[23])) ? $line[23] : null ; 
                                $tahapan = (isset($line[24])) ? $line[24] : null ; 
                                $clasification = (isset($line[25])) ? $line[25] : null ; 
                                $age = (isset($line[26])) ? $line[26] : null ; ;
                                
                                
                                $insert_class = array(
                                    'id_village' => $id_village,
                                    'village' => $village,
                                    'dpid' => $dpid,
                                    'id_tps' => $tps_id,
                                    'tps' => $tps,
                                    'nkk' => $nkk,
                                    'nik' => $nik,
                                    'name' => $name,
                                    'birth_place' => $tmp_lahir,
                                    'birth_day' => $tgl_lahir,
                                    'gender' => $gender,
                                    'marriage_sts' => $kawin,
                                    'address' => $address,
                                    'disability' => $dis,
                                    'rt' => $rt,
                                    'rw' => $rw,
                                    'ektp' => $ektp,
                                    'rank' => $rank,
                                    'source' => $sumber,
                                    'description' => $ket,
                                    'status' => $status,
                                    'tahapan' => $tahapan,
                                    'last_update' => $updated,
                                    'clasification' => $clasification,
                                    'age' => $age,                           
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'updated_at' => date('Y-m-d H:i:s')
                                );
                                $id_class = DB::table('t_dpt')->insertGetId($insert_class);                               

                            }
                        }
                        
                    }                   
                    //close opened csv file
                    fclose($csvFile);
        
                    $data['code']    = 200;
                    $data['message'] = "Berhasil Mengimport Data DPT";
                } else {
                    $data['code']    = 500;
                    $data['message'] = "Tipe File Tidak Sesuai. Pastikan file bertipe csv";
                }
                return response()->json($data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'DptController@post_import_dpt';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }

    }


    
    public function list_data(Request $request)
    {

        $totalData = DB::table('t_dpt')->count();
        $totalFiltered = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
        $dir   = $request->input('order.0.dir');
        $search = $request->search;

        $posts = DB::table('t_dpt as p')->leftJoin('villages as v','v.id','p.id_village')->leftJoin('districts as c','c.id','v.district_id');
        if ($search != null) {
            $posts = $posts->where(function ($query) use ($search,$request) {
                $query->where('p.name','ilike', "%{$search}%");
                $query->orWhere('v.name','ilike', "%{$search}%");
                $query->orWhere('c.name','ilike', "%{$search}%");
                $query->orWhere('nik','ilike', "%{$search}%"); 
                $query->orWhere('nkk','ilike', "%{$search}%");  
            });
        }

        
        if ($request->id_kec != null) {
            $posts = $posts->where('v.district_id',$request->id_kec);
        }

        if ($request->id_kel != null) {
            $posts = $posts->where('id_village',$request->id_kel);
        }

        if ($request->gender != null) {
            $posts = $posts->where('gender',$request->gender);
        }

        $posts = $posts->select('p.*','v.name as desa','c.name as kecamatan');
        if ($request->sort == 1) {
            $posts = $posts->orderBy('c.id','asc');
        }
        if ($request->sort == 2) {
            $posts = $posts->orderBy('p.name','asc');
        }

        $totalFiltered = $posts->count();
        $posts = $posts->limit($limit)->offset($start)->get();

        $data = array();
        if (!empty($posts)) {
            $no = 0;
            foreach ($posts as $d) {
                $no = $no + 1;

                $action = '<div style="float: left; margin-left: 5px;"><a href="/medical-record/pemeriksaan-tahunan/'.base64_encode($d->dpid).'" >
                                <button type="button" class="btn btn-warning btn-sm" style="min-width: 110px;margin-left: 2px;margin-top:3px;text-align:left"><i class="fa fa-eye"></i> Detail</button></a>
                            </div>';

                $column['no']       = $no;
                $column['kec']      = $d->kecamatan;
                $column['kel']      = $d->desa;
                $column['nik']      = $d->nik;
                $column['name']     = $d->name;
                $column['gender']   = $d->gender;
                $column['status']   = $d->status;
                $column['tps']      = $d->tps;
                $column['actions']  = $action;
                $data[]             = $column;

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


    public function add()
    {
        $data = parent::sidebar();
        if ($data['access'] == 0) {
            return redirect('/');
        } else {
            $role_id           = Auth::guard('admin')->user()->id_role;
            $data['data_scholl'] = SchollModel::whereNull('deleted_at')->get();
            $data['data_city'] = CityModel::whereNull('deleted_at')->get();
            $data['header_name'] = "Tambah Siswa Baru";
            //dd($data['id_adm_dept']);
            return view('dpt.add', $data);
        }
    }

    public function post(Request $request)
    {
        // id bermasalah
        try {
            $input = $request->except('_token','id_scholl','id_class','tgl_masuk');

            if ($request->file('image')) {
                $input['image']  = parent::uploadFileS3($request->file('image'));
            } 

            $input['created_at'] = date('Y-m-d H:i:s');
            $input['updated_at'] = date('Y-m-d H:i:s');
            $insert = DB::table('dpts')->insertGetId($input);
            if ($insert) {
                $insert_class = DB::table('dpt_class_relations')->insert(['id_dpt'=>$insert,'id_class'=>$request->id_class,'tgl_masuk'=>$request->tgl_masuk,'description'=>'Siswa Baru','is_active'=>1,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Menambah Data Siswa '.$request->dpt_name.'','siswa');
                $data['code']    = 200;
                $data['message'] = 'Berhasil menambah data siswa';
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
            $data['controller'] = 'DptController@post';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function update(Request $request)
    {
        try {
        //dd($request->nik);
            $input = $request->except('_token','id_scholl','id_class','tgl_masuk');

            if ($request->file('image')) {
                $input['image']  = parent::uploadFileS3($request->file('image'));
            } 
            $data['updated_at'] = date('Y-m-d H:i:s');

            $insert = dptModel::where('id', $request->id)->update($input);
            if ($insert) {
                $cek_same_class = DB::table('dpt_class_relations')->where('id_dpt',$request->id)->where('is_active',1)->pluck('id_class');
                if ($cek_same_class != $request->id_class) {
                    $nonactive = DB::table('dpt_class_relations')->where('id_dpt',$request->id)->update(['is_active'=>0]);
                    $insert_class = DB::table('dpt_class_relations')->insert(['id_dpt'=>$request->id,'id_class'=>$request->id_class,'tgl_masuk'=>$request->tgl_masuk,'description'=>'Pindah kelas','is_active'=>1,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
                }
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Mengupdate Data Siswa '.$request->dpt_name.'','kelas');
                $data['code']    = 200;
                $data['message'] = 'Berhasil Mengupdate data kelas';
                return response()->json($data);
            } else {
                $data['code']    = 500;
                $data['message'] = 'Maaf Ada yang Error ';
                $data['insert']  = $request->id;
                return response()->json($data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'DptController@update';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function detail($ids)
    {
        try {
            $id = base64_decode($ids);
            //dd($id);
            $admin = dptModel::find($id);
            //dd($admin);
            
            $data = parent::sidebar();
            if ($admin == null) {
                //dd("ID Tidak ditemukan");
                return view('errors.not_found',$data);
            }
            //dd("masuk sini");
            if ($data['access'] == 0) {
                return redirect('/');
            } else {
                $role_id           = Auth::guard('admin')->user()->id_role;
                $data['code']      = 200;
                $data['data']      = $admin;
                $data['data_role'] = RoleModel::whereNull('deleted_at')->where('status', 1)->get();
                $data['data_scholl'] = SchollModel::whereNull('deleted_at')->get();
                $data['data_city'] = CityModel::whereNull('deleted_at')->get();
                $data['id_scholl'] = $this->GetScholl($admin->id,'id_scholl');
                $data['id_class'] = $this->GetClass($admin->id,'id_class');
                $data['tgl_masuk'] = $this->GetClass($admin->id,'tgl_masuk');
                return view('dpt.dialog_edit', $data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'DptController@detail';
            $insert_error = parent::InsertErrorSystem($data);
            $error = parent::sidebar();
            $error['id'] = $insert_error;
            return view('errors.500',$error); // jika Metode Get
            //return response()->json($data); // jika metode Post
        }
    }

    public function nonactive(Request $request)
    {
        try {
            $admin         = dptModel::find($request->id);
            $admin->status = 0;
            $admin->save();
            if ($admin) {
                $data['code']    = 200;
                $data['message'] = 'Berhasil Menonaktifkan Data Kelas';
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Menon aktifkan Data Kelas '.$admin->dpt_name.'','Kelas');
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
            $data['controller'] = 'DptController@nonactive';
            $insert_error = parent::InsertErrorSystem($data);
            
            return response()->json($data); // jika metode Post
        }
    }

    public function active(Request $request)
    {
        try {
            $admin         = dptModel::find($request->id);
            $admin->status = 1;
            $admin->save();
            if ($admin) {
                $data['code']    = 200;
               
                $data['message'] = 'Berhasil Mengapprove Kelas';
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Meng aktifkan Data Kelas '.$admin->dpt_name.'','Kelas');
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
            $data['controller'] = 'DptController@active';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function delete(Request $request)
    {
        try {
            $admin             = dptModel::find($request->id);
            $admin->status     = 0;
            $admin->deleted_at = date('Y-m-d');
            $admin->save();

            if ($admin) {
                $data['code']    = 200;
                $data['message'] = 'Berhasil Menghapus Data Kelas';
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Menghapus Data Kelas '.$admin->dpt_name.'','Kelas');
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
            $data['controller'] = 'DptController@delete';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

}