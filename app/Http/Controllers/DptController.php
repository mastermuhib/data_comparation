<?php

namespace App\Http\Controllers;

use App\Model\RoleModel;
use App\Model\dptModel;
use App\Model\DistrictModel;
use App\Model\KlasifikasiModel;
use App\Model\CityModel;
use App\Model\UserModel;
use Maatwebsite\Excel\Facades\Excel;
use App\Model\TemporaryMonggoDB;
use App\Model\ChangeDataMonggoDB;
use App\Classes\upload;
use App\Traits\Fungsi;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Exports\ExportPairingResults;
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
                $data['data_klasifikasi'] = KlasifikasiModel::select('id','name')->get();
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
                            fgets($csvFile);
                            //parse data from csv file line by line
                            //$data = fgetcsv($csvFile);
                            while(($csv_excel = fgets($csvFile)) !== FALSE){
                                
                                $line = explode("#", $csv_excel);
                                
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
                                    'id_village' => trim(preg_replace('/\s\s+/', ' ',$id_village)),
                                    'village' => trim(preg_replace('/\s\s+/', ' ',$village)),
                                    'dpid' => trim(preg_replace('/\s\s+/', ' ',$dpid)),
                                    'id_tps' => trim(preg_replace('/\s\s+/', ' ',$tps_id)),
                                    'tps' => trim(preg_replace('/\s\s+/', ' ',$tps)),
                                    'nkk' => trim(preg_replace('/\s\s+/', ' ',$nkk)),
                                    'nik' => trim(preg_replace('/\s\s+/', ' ',$nik)),
                                    'name' => trim(preg_replace('/\s\s+/', ' ',$name)),
                                    'birth_place' => trim(preg_replace('/\s\s+/', ' ',$tmp_lahir)),
                                    'birth_day' => trim(preg_replace('/\s\s+/', ' ',$tgl_lahir)),
                                    'gender' => trim(preg_replace('/\s\s+/', ' ',$gender)),
                                    'marriage_sts' => trim(preg_replace('/\s\s+/', ' ',$kawin)),
                                    'address' => trim(preg_replace('/\s\s+/', ' ',$address)),
                                    'disability' => trim(preg_replace('/\s\s+/', ' ',$dis)),
                                    'rt' => trim(preg_replace('/\s\s+/', ' ',$rt)),
                                    'rw' => trim(preg_replace('/\s\s+/', ' ',$rw)),
                                    'ektp' => trim(preg_replace('/\s\s+/', ' ',$ektp)),
                                    'rank' => trim(preg_replace('/\s\s+/', ' ',$rank)),
                                    'source' => trim(preg_replace('/\s\s+/', ' ',$sumber)),
                                    'description' => trim(preg_replace('/\s\s+/', ' ',$ket)),
                                    'status' => trim(preg_replace('/\s\s+/', ' ',$status)),
                                    'tahapan' => trim(preg_replace('/\s\s+/', ' ',$tahapan)),
                                    'last_update' => trim(preg_replace('/\s\s+/', ' ',$updated)),
                                    'clasification' => trim(preg_replace('/\s\s+/', ' ',$clasification)),
                                    'age' => trim(preg_replace('/\s\s+/', ' ',$age)),                           
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

    

    public function calculate(Request $request)
    {
        $posts = $this->DataDpt($request);

        
        $total = $posts->select('gender')->count();
        $male = $posts->where('gender','L')->count();
        $female = $total - $male;
        $data['male'] = number_format($male);
        $data['female'] = number_format($female);
        $data['total'] = number_format($total);
        return response()->json($data);

    }
    
    public function list_data(Request $request)
    {

        $totalData = DB::table('t_dpt')->count();
        $totalFiltered = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
        $dir   = $request->input('order.0.dir');
        $search = $request->search;
        $status = $request->status;

        $posts = $this->DataDpt($request);

        $posts = $posts->select('p.*','v.name as desa','c.name as kecamatan');
        
        $totalFiltered = $posts->count();
        $posts = $posts->limit($limit)->offset($start)->get();

        $data = array();
        if (!empty($posts)) {
            $no = $start;
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

    public function DataDpt($request){
        $search      = $request->search;
        
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

        if (isset($request->status)) {
            $status      = $request->status;
            if (count($status) > 0) {
                $posts = $posts->whereIn('p.status',$status);
            }
        }

        if (isset($request->klasifikasi)) {
            $klasifikasi = $request->klasifikasi;
            if (count($klasifikasi) > 0) {
                $posts = $posts->whereIn('p.clasification',$klasifikasi);
            }
        }

        return $posts;
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
            $data['header_name'] = "Data DPT";
            //dd($data['id_adm_dept']);
            return view('dpt.add', $data);
        }
    }

    public function detail_ubah_data($ids)
    {
        $id = base64_decode($ids);
        $data = parent::sidebar();
        if ($data['access'] == 0) {
            return redirect('/');
        } else {
            $role_id           = Auth::guard('admin')->user()->id_role;
            $data['data'] = DB::table('t_change_datas')->where('id',$id)->first();
            $data['header_name'] = "Riwayat Ubah Data DPT";
            //dd($id);
            //dd($data['data']);
            return view('dpt.list_ubah_data', $data);
        }
    }

    public function ubah_data()
    {
        $data = parent::sidebar();
        if ($data['access'] == 0) {
            return redirect('/');
        } else {
            $role_id           = Auth::guard('admin')->user()->id_role;
            //dd($data['id_adm_dept']);
            return view('dpt.ubah-data', $data);
        }
    }

    public function data_ubah(Request $request)
    {

        $totalData = DB::table('t_change_datas')->count();
        $totalFiltered = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
        $dir   = $request->input('order.0.dir');
        $search = $request->search;
        $status = $request->status;

        $posts = DB::table('t_change_datas as p');
        if ($search != null) {
            $posts = $posts->where(function ($query) use ($search,$request) {
                $query->where('p.code','ilike', "%{$search}%");
                $query->orWhere('p.triwulan','ilike', "%{$search}%");
            });
        }

        $posts = $posts->select('p.*');
        
        $totalFiltered = $posts->count();
        $posts = $posts->limit($limit)->offset($start)->get();

        $data = array();
        if (!empty($posts)) {
            $no = $start;
            foreach ($posts as $d) {
                $no = $no + 1;

                $action = '<div style="float: left; margin-left: 5px;"><a href="/dpt/ubah-data/'.base64_encode($d->id).'" target="_blank" >
                                <button type="button" class="btn btn-warning btn-sm" style="min-width: 110px;margin-left: 2px;margin-top:3px;text-align:left"><i class="fa fa-eye"></i> Detail</button></a>
                            </div>';

                $column['no']       = $no;
                $column['date']     = $d->created_at;
                $column['triwulan'] = 'Triwulan - '.$d->triwulan.' '.$d->year;
                $column['type']     = $d->type;
                $column['total']    = $d->total;
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

    public function post_ubah_data(Request $request)
    {
        // id bermasalah
        try {
            $input = $request->except('_token','file','nik','old','new');
            $code = date('YmdHis');
            $line_nik = (int)$request->nik - 1;
            $line_old = (int)$request->old - 1;
            $line_new = (int)$request->new - 1;

            //insert ke mongo
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
                            fgets($csvFile);
                            //parse data from csv file line by line
                            //$data = fgetcsv($csvFile);
                            $total = 0;
                            while(($csv_excel = fgets($csvFile)) !== FALSE){
                                $total = $total + 1;
                                $line = explode("#", $csv_excel);
                                
                                $nik      =  (isset($line[$line_nik])) ? $line[$line_nik] : null ; 
                                $old_data = (isset($line[$line_old])) ? $line[$line_old] : null ;
                                $new_data = (isset($line[$line_new])) ? $line[$line_new] : null ; 

                                $nik = str_replace('"', '', $nik);
                                $nik = trim(preg_replace('/\s\s+/', ' ', $nik));

                                $old_data = str_replace('"', '', $old_data);
                                $old_data = trim(preg_replace('/\s\s+/', ' ', $old_data));
                                
                                $new_data = str_replace('"', '', $new_data);
                                $new_data = trim(preg_replace('/\s\s+/', ' ', $new_data));
                                
                                $insert = array(
                                    'nik' => trim(preg_replace('/\s\s+/', ' ',$nik)),
                                    'old_data' => trim(preg_replace('/\s\s+/', ' ',$old_data)),
                                    'new_data' => trim(preg_replace('/\s\s+/', ' ',$new_data)),
                                    'type' => $request->type,
                                    'code' => $code
                                );
                                ChangeDataMonggoDB::create($insert);                               

                            }
                            $input['total']  = $total;
                        }
                        
                    }                   
                    //close opened csv file
                    fclose($csvFile);
        
                    
                } else {
                    $data['code']    = 500;
                    $data['message'] = "Tipe File Tidak Sesuai. Pastikan file bertipe csv";
                }
                
            }
            
            $input['code']  = $code;
            $input['created_at'] = date('Y-m-d H:i:s');
            $input['updated_at'] = date('Y-m-d H:i:s');
            $insert = DB::table('t_change_datas')->insertGetId($input);
            if ($insert) {
                
                $data['code']    = 200;
                $data['message'] = 'Berhasil menambah Ubah Data';
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
            $data['controller'] = 'DptController@post_ubah_data';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function data_detail_ubah(Request $request)
    {

        $totalData = ChangeDataMonggoDB::where('code',$request->code)->count();
        $totalFiltered = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
        $dir   = $request->input('order.0.dir');
        $search = $request->search;
        $status = $request->status;

        $posts = ChangeDataMonggoDB::where('code',$request->code);
        if ($search != null) {
            $posts = $posts->where(function ($query) use ($search,$request) {
                $query->where('nik','ilike', "%{$search}%");
                $query->orWhere('old_data','ilike', "%{$search}%");
                $query->orWhere('new_data','ilike', "%{$search}%");
            });
        }

        $posts = $posts->select('*');
        
        $totalFiltered = $posts->count();
        $posts = $posts->limit($limit)->offset($start)->get();

        $data = array();
        if (!empty($posts)) {
            $no = $start;
            foreach ($posts as $d) {
                $no = $no + 1;

                $column['no']       = $no;
                $column['nik']      = $d->nik;
                $column['old']      = $d->old_data;
                $column['new']      = $d->new_data;
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
    
}