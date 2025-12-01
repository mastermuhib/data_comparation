<?php

namespace App\Http\Controllers;

use App\Model\RoleModel;
use App\Model\dptModel;
use App\Model\SchollModel;
use App\Model\CityModel;
use App\Model\UserModel;
use App\Classes\upload;
use App\Traits\Fungsi;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\Handler;

class DptTemporaryController extends Controller
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
                $data['data_scholl'] = SchollModel::whereNull('deleted_at')->get();
                $data['data_city'] = CityModel::whereNull('deleted_at')->get();
                $data['txt_button'] = "Tambah Siswa Baru";
                $data['href'] = "user/siswa/action/add";
                //dd($data['id_adm_dept']);
                return view('dpt.index', $data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'DptTemporaryController@index';
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
                $data['data_scholl'] = SchollModel::whereNull('deleted_at')->get();
                //dd($data['id_adm_dept']);
                return view('dpt.import', $data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'DptTemporaryController@import';
            $insert_error = parent::InsertErrorSystem($data);
            $error = parent::sidebar();
            $error['id'] = $insert_error;
            return view('errors.index',$error); // jika Metode Get
            //return response()->json($data); // jika metode Post
        }
    }

    public function post_import_siswa(Request $request){
        
        try {
            
            $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain','csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/vnd.ms-excel');
            //dd($_FILES);
            //str_replace("#", "", $originalString);
            
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
                            while(($line = fgetcsv($csvFile)) !== FALSE){
                                $cek_kelas = DB::table('table_class')->where('class_name',$line[1])->where('id_scholl',$request->id_scholl)->pluck('id');
                                if ($cek_kelas->isEmpty()) {
                                    $insert_class = array(
                                        'id_scholl' => $request->id_scholl,
                                        'class_name' => $line[1],
                                        'created_at' => date('Y-m-d H:i:s'),
                                        'updated_at' => date('Y-m-d H:i:s'),
                                    );
                                    $id_class = DB::table('table_class')->insertGetId($insert_class);
                                } else {
                                    $id_class = $cek_kelas[0];
                                }
                                $gender = 1;
                                if ($line[3] == 'Perempuan' || $line[3] == 'perempuan' || $line[3] == 'Wanita' || $line[3] == 'wanita' || $line[3] == 'PR' || $line[3] == 'Pr' || $line[3] == 'pr' || $line[3] == '2' || $line[3] == 'P' || $line[3] == 'p') {
                                    $gender = 2;
                                }

                                $cek_dpt = DB::table('dpts')->where('dpt_name',$line[0])->where('active_class_id',$id_class)->pluck('id');
                                if ($cek_dpt->isEmpty()) {
                                    
                                    $insert_dpt = array(
                                        'dpt_name' => $line[0],
                                        'active_class_id' => $id_class,
                                        'gender' => $gender,
                                        'created_at' => date('Y-m-d H:i:s'),
                                        'updated_at' => date('Y-m-d H:i:s'),
                                    );
                                    $id_dpt = DB::table('dpts')->insertGetId($insert_dpt);
                                   // }
                                   // relasi siswa kelas dpt_class_relations
                                    $insert_rel = array(
                                        'id_dpt' => $id_dpt,
                                        'id_class' => $id_class,
                                        'tgl_masuk' => date('Y-m-d'),
                                        'created_at' => date('Y-m-d H:i:s'),
                                        'updated_at' => date('Y-m-d H:i:s'),
                                    );
                                    $insert = DB::table('dpt_class_relations')->insertGetId($insert_rel);
                                }
                               
                            }
                        }
                        
                    }                   
                    //close opened csv file
                    fclose($csvFile);
        
                    $data['code']    = 200;
                    $data['message'] = "Berhasil Mengimport Data Alamat";
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
            $data['controller'] = 'AddressController@post_import_siswa';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }

    }


    public function list_data(Request $request)
    {
        $data['is_edit'] = $request->is_edit;
        $data['is_delete'] = $request->is_delete;
        
        $dpt = DB::table('dpts as s')->leftJoin('cities as c','c.id','s.id_city')->where('s.status',1);
        if ($request->id_scholl != null) {
            $relation_scholl = DB::table('dpt_class_relations as s')->join('table_class as c','c.id','s.id_class')->where('s.is_active',1)->where('id_scholl',$request->id_scholl)->pluck('id_dpt')->toArray();
            $dpt = $dpt->whereIn('s.id',$relation_scholl);
        }

        if ($request->id_class != null) {
            $relation_class = DB::table('dpt_class_relations as s')->where('s.is_active',1)->where('id_class',$request->id_class)->pluck('id_dpt')->toArray();
            $dpt = $dpt->whereIn('s.id',$relation_class);
        }

        if ($request->gender != null) {
            $dpt = $dpt->where('gender',$request->gender);
        }

        if ($request->search != null) {
            $dpt = $dpt->where(function ($query) use ($request) {
                $search = $request->search;
                $query->where('dpt_name','ilike', "%{$search}%");
                $query->orWhere('c.name','ilike', "%{$search}%");
            });
        }
        
        if ($request->sort == 1) {
            $dpt = $dpt->orderBy('s.created_at','desc');
        }
        if ($request->sort == 2) {
            $dpt = $dpt->orderBy('dpt_name','asc');
        }
        
        
        $dpt = $dpt->limit(9)->offset($request->start)->select('s.*','c.name')->get();
        $data['data'] = $dpt;
        if ($data['data']->isNotEmpty()) {
            foreach ($data['data'] as $k => $v) {
                //$data['data'][$k]->image = env('BASE_IMG').$v->image;
                $data['data'][$k]->scholl = $this->GetScholl($v->id,'scholl_name');
                $data['data'][$k]->class = $this->GetClass($v->id,'class_name');
                if (Auth::guard('admin')->user()->id_scholl != null) {
                    $data['data'][$k]->phone = substr($v->phone, 0, 3)."**********";
                }
                if (Auth::guard('admin')->user()->id_scholl != null) {
                    $data['data'][$k]->email = substr($v->email, 0, 3)."**********";
                }
            }
        }  

        return view('dpt.data', $data);
    }

    public function cek_load_siswa(Request $request)
    {
        
        $dpt = DB::table('dpts as s')->leftJoin('cities as c','c.id','s.id_city')->where('s.status',1);
        if ($request->id_scholl != null) {
            $relation_scholl = DB::table('dpt_class_relations as s')->join('table_class as c','c.id','s.id_class')->where('s.is_active',1)->where('id_scholl',$request->id_scholl)->pluck('id_dpt')->toArray();
            $dpt = $dpt->whereIn('s.id',$relation_scholl);
        }

        if ($request->id_class != null) {
            $relation_class = DB::table('dpt_class_relations as s')->where('s.is_active',1)->where('id_class',$request->id_class)->pluck('id_dpt')->toArray();
            $dpt = $dpt->whereIn('s.id',$relation_class);
        }

        if ($request->gender != null) {
            $dpt = $dpt->where('gender',$request->gender);
        }

        if ($request->search != null) {
            $dpt = $dpt->where(function ($query) use ($request) {
                $search = $request->search;
                $query->where('dpt_name','ilike', "%{$search}%");
                $query->orWhere('c.name','ilike', "%{$search}%");
            });
        }
        
        if ($request->sort == 1) {
            $dpt = $dpt->orderBy('s.created_at','desc');
        }
        if ($request->sort == 2) {
            $dpt = $dpt->orderBy('dpt_name','asc');
        }
        
        $data['jumlah'] = 0;

        $dpt = $dpt->offset($request->start)->count();
        if ($dpt > $request->start) {
            $data['jumlah'] = 1;
        }

        //dd($data);

        return json_encode($data);
    }

    public function GetScholl($id,$coloumn){
        $return = null;
        $data = DB::table('dpt_class_relations as s')->join('table_class as c','c.id','s.id_class')->join('table_scholls as t','t.id','c.id_scholl')->where('s.is_active',1)->where('id_dpt',$id)->pluck($coloumn);
        if ($data->isNotEmpty()) {
            $return = $data[0];
        }
        return $return;
    }

    public function GetClass($id,$coloumn){
        $return = null;
        $data = DB::table('dpt_class_relations as s')->join('table_class as c','c.id','s.id_class')->where('s.is_active',1)->where('id_dpt',$id)->pluck($coloumn);
        if ($data->isNotEmpty()) {
            $return = $data[0];
        }
        return $return;
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
            $data['controller'] = 'DptTemporaryController@post';
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
            $data['controller'] = 'DptTemporaryController@update';
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
            $data['controller'] = 'DptTemporaryController@detail';
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
            $data['controller'] = 'DptTemporaryController@nonactive';
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
            $data['controller'] = 'DptTemporaryController@active';
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
            $data['controller'] = 'DptTemporaryController@delete';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

}