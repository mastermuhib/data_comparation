<?php

namespace App\Http\Controllers;

use App\Model\RoleModel;
use App\Model\MedicineModel;
use App\Model\SchollModel;
use App\Model\UserModel;
use App\Classes\upload;
use App\Traits\Fungsi;
use PDF;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\Handler;

class MedicineController extends Controller
{
    public function index()
    {
        // dd(Obat::get());
        //dd(Auth::guard('admin')->user()->id_scholl);
        try {
            $data = parent::sidebar();
            if ($data['access'] == 0) {
                return redirect('/');
            } else {
                $role_id           = Auth::guard('admin')->user()->id_role;
                $data['txt_button'] = "Tambah Obat Baru";
                $data['href'] = "master/medicine/action/add";
                //dd($data['id_adm_dept']);
                return view('medicine.index', $data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'MedicineController@index';
            $insert_error = parent::InsertErrorSystem($data);
            $error = parent::sidebar();
            $error['id'] = $insert_error;
            return view('errors.index',$error); // jika Metode Get
            //return response()->json($data); // jika metode Post
        }
    }


    public function listData(Request $request)
    {


        $totalData = DB::table('table_medicines')->whereNull('deleted_at')->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $dir   = $request->input('order.0.dir');
        $search = $request->input('search.value');

        $posts = MedicineModel::whereNull('deleted_at')->where(function ($query) use ($search,$request) {
            if ($search != null) {
                $query->where('medicine','ilike', "%{$search}%");
            } 
        })->orderBy('medicine','asc');
        $totalFiltered = $posts->count();
        $posts = $posts->limit($limit)->offset($start)->get();

        $data = array();
        if (!empty($posts)) {

            $no = 0;
           
            foreach ($posts as $d) {
                $no = $no + 1;

                if ($d->status == 1) {
                    $status = '<div style="float: left; margin-left: 5px;">
                        <a id="' . $d->id . '" aksi="nonaktif" tujuan="medicine" data="data_medicine" class="btn btn-success btn-sm aksi">Aktif</a>
                        </div>';
                } else {
                    $status = '<div style="float: left; margin-left: 5px;">
                        <button type="button" id="' . $d->id . '"data="data_medicine" aksi="aktif" tujuan="medicine" class="btn btn-danger btn-sm aksi">Tidak Aktif</button>
                        </div>';
                }

                if ($d->icon != null) {
                    $medicine = '<div class="d-flex align-items-center"><div class="symbol symbol-40 symbol-sm flex-shrink-0"><img class="" src="'.env('BASE_IMG').$d->icon.'" alt="photo"></div><div class="ml-4"><div class="text-dark-75 font-weight-bolder font-size-lg mb-0">'.$d->medicine.'</div></div></div>';
                } else {
                    $medicine = '<div class="d-flex align-items-center"><div class="symbol symbol-40 symbol-light-warning flex-shrink-0"><span class="symbol-label font-size-h4 font-weight-bold">'.substr($d->medicine, 0, 1).'</span></div><div class="ml-4"><div class="text-dark-75 font-weight-bolder font-size-lg mb-0">'.$d->medicine.'</div></div></div>';
                }


                $action = '<div style="float: left; margin-left: 5px;"><a href="/master/medicine/'.base64_encode($d->id).'" >
                    <button type="button" class="btn btn-warning btn-sm" style="min-width: 110px;margin-left: 2px;margin-top:3px;text-align:left"><i class="fa fa-edit"></i> Edit</button></a>
                </div>
                <div style="float: left; margin-left: 5px;">
                    <button type="button" class="btn btn-danger btn-sm aksi btn-aksi" data="data_medicine"  id="' . $d->id . '" aksi="delete" tujuan="medicine" style="min-width: 110px;margin-left: 2px;margin-top:3px;text-align:left"><i class="fa fa-trash"></i> Hapus</button>
                </div>';

                $nestedData['no']           = $no;
                $nestedData['medicine']     = $medicine;
                $nestedData['used']          = $this->usedMedicine($d->id);
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

    public function list_used(Request $request)
    {


        $limit = $request->input('length');
        $start = $request->input('start');
        $dir   = $request->input('order.0.dir');
        $search =  $request->input('search.value');

        $posts = DB::table('detail_medical_records as d')->join('medical_records as m','m.id','d.id_medical_record')->join('medical_categories as mc','mc.id','m.id_category')->join('students as st','st.id','m.id_student')->join('table_class as c','c.id','m.id_class')->join('table_scholls as s','s.id','c.id_scholl')->leftJoin('administrators as a','a.id','m.id_admin')->whereNull('m.deleted_at')->where('d.id_medicine',$request->id);
        $posts = $posts->where(function ($query) use ($search,$request) {
            if ($search != null) {
                $query->where('scholl_name','ilike', "%{$search}%");
                $query->orWhere('a.admin_name','ilike', "%{$search}%");
                $query->orWhere('class_name','ilike', "%{$search}%");
                $query->orWhere('student_name','ilike', "%{$search}%");
            } 
        });

        if ($request->id_scholl != null) {
            $posts = $posts->where('id_scholl',$request->id_scholl);
        }

        if ($request->id_class != null) {
            $posts = $posts->where('id_class',$request->id_class);
        }

        if ($request->gender != null) {
            $posts = $posts->where('gender',$request->gender);
        }

        if ($request->id_student != null) {
            $posts = $posts->where('id_student',$request->id_student);
        }

        $posts = $posts->select('category_name','scholl_name','class_name','student_name','admin_name','dosis','st.image','d.created_at');
        if ($request->sort == 1) {
            $posts = $posts->orderBy('m.record_date','desc');
        }
        if ($request->sort == 2) {
            $posts = $posts->orderBy('student_name','asc');
        }

        $totalFiltered = $posts->count();
        $totalData = $posts->count();

        $posts = $posts->limit($limit)->offset($start)->get();
        $data = array();
        if (!empty($posts)) {

            $no = 0;
           
            foreach ($posts as $d) {
                $no = $no + 1;

                if ($d->image != null) {
                    $student = '<div class="d-flex align-items-center"><div class="symbol symbol-40 symbol-sm flex-shrink-0"><img class="" src="'.env('BASE_IMG').$d->image.'" alt="photo"></div><div class="ml-4"><div class="text-dark-75 font-weight-bolder font-size-lg mb-0">'.$d->student_name.'</div><a href="javascript:void(0)" class="text-muted font-weight-bold text-hover-primary">'.$d->scholl_name.' - '.$d->class_name.'</a></div></div>';
                } else {
                    $student = '<div class="d-flex align-items-center"><div class="symbol symbol-40 symbol-light-warning flex-shrink-0"><span class="symbol-label font-size-h4 font-weight-bold">'.substr($d->student_name, 0, 1).'</span></div><div class="ml-4"><div class="text-dark-75 font-weight-bolder font-size-lg mb-0">'.$d->student_name.'</div><a href="javascript:void(0)" class="text-muted font-weight-bold text-hover-primary">'.$d->scholl_name.' - '.$d->class_name.'</a></div></div>';
                }

                $nestedData['no']           = $no;
                $nestedData['student']      = $student;
                $nestedData['category']     = $d->category_name;
                $nestedData['date']         = date('d M Y H:i',strtotime($d->created_at));
                $nestedData['dosis']        = $d->dosis;
                $nestedData['doctor']       = $d->admin_name;
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

    public function usedMedicine($id){
        $return = " Belum Terpakai ";
    
        // $data = DB::table('detail_medical_records')->where('id_medicine',$id)->sum('dosis');
        $data =  DB::table('detail_medical_records as d')
                ->join('medical_records as m','m.id','d.id_medical_record')
                ->join('medical_categories as mc','mc.id','m.id_category')
                ->join('students as st','st.id','m.id_student')
                ->join('table_class as c','c.id','m.id_class')
                ->join('table_scholls as s','s.id','c.id_scholl')
                ->leftJoin('administrators as a','a.id','m.id_admin')
                ->whereNull('m.deleted_at')
                ->where('d.id_medicine',$id)
                ->sum('dosis');
        if ($data > 0) {
            $return = '<a href="/master/medicine/used/'.base64_encode($id).'" ><span class="text-success">'.$data.' Terpakai</span></a>';
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
            $data['header_name'] = "Tambah Obat Baru";
            //dd($data['id_adm_dept']);
            return view('medicine.add', $data);
        }
    }

    public function post(Request $request)
    {
        // id bermasalah
        try {
            $input = $request->except('_token','id_scholl','id_class','tgl_masuk');

            if ($request->file('icon')) {
                $input['icon']  = parent::uploadFileS3($request->file('icon'));
            } 

            $input['created_at'] = date('Y-m-d H:i:s');
            $input['updated_at'] = date('Y-m-d H:i:s');
            $insert = DB::table('table_medicines')->insertGetId($input);
            if ($insert) {
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Menambah Data Obat '.$request->medicine.'','Obat');
                $data['code']    = 200;
                $data['message'] = 'Berhasil menambah data obat';
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
            $data['controller'] = 'MedicineController@post';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function update(Request $request)
    {
        try {
        //dd($request->nik);
            $input = $request->except('_token','id_scholl','id_class','tgl_masuk');

            if ($request->file('icon')) {
                $input['icon']  = parent::uploadFileS3($request->file('icon'));
            } 
            $data['updated_at'] = date('Y-m-d H:i:s');

            $insert = MedicineModel::where('id', $request->id)->update($input);
            if ($insert) {
                
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Mengupdate Data obat '.$request->medicine.'','Obat');
                $data['code']    = 200;
                $data['message'] = 'Berhasil Mengupdate data obat';
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
            $data['controller'] = 'MedicineController@update';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function detail($id)
    {
       try {
            $id = base64_decode($id);
            $admin = MedicineModel::find($id);
            
            $data = parent::sidebar();

            if ($admin == null) {
                //dd("ID Tidak ditemukan");
                return view('errors.not_found',$data);
            }
            if ($data['access'] == 0) {
                return redirect('/');
            } else {
                $role_id           = Auth::guard('admin')->user()->id_role;
                $data['code']      = 200;
                $data['data']      = $admin;
                return view('medicine.dialog_edit', $data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'MedicineController@detail';
            $insert_error = parent::InsertErrorSystem($data);
            $error = parent::sidebar();
            $error['id'] = $insert_error;
            return view('errors.500',$error); // jika Metode Get
            //return response()->json($data); // jika metode Post
        }
    }

    public function used($id)
    {
       try {
            $ids = base64_decode($id);
            $admin = MedicineModel::find($ids);
            
            $data = parent::sidebar();
            if ($data['access'] == 0) {
                return redirect('/');
            } else {
                $role_id           = Auth::guard('admin')->user()->id_role;
                $data['code']      = 200;
                $data['data']      = $admin;
                $data['id']        = $id;
                return view('medicine.used', $data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'MedicineController@detail';
            $insert_error = parent::InsertErrorSystem($data);
            $error = parent::sidebar();
            $error['id'] = $insert_error;
            return view('errors.500',$error); // jika Metode Get
            //return response()->json($data); // jika metode Post
        }
    }

    
    public function used_print($id)
    {
       try {
            $id = base64_decode($id);
            $admin = MedicineModel::find($id);
            
            $data = parent::sidebar();
            if ($data['access'] == 0) {
                return redirect('/');
            } else {
                $role_id           = Auth::guard('admin')->user()->id_role;
                $data['code']      = 200;
                $data['data']      = $admin;
                // data used 
                $data['data_medicine'] = DB::table('detail_medical_records as d')
                                        ->join('medical_records as m','m.id','d.id_medical_record')
                                        ->join('medical_categories as mc','mc.id','m.id_category')
                                        ->join('students as st','st.id','m.id_student')
                                        ->join('table_class as c','c.id','m.id_class')
                                        ->join('table_scholls as s','s.id','c.id_scholl')
                                        ->leftJoin('administrators as a','a.id','m.id_admin')
                                        ->whereNull('m.deleted_at')->where('d.id_medicine',$id)
                                        ->select('category_name','scholl_name','class_name','student_name','admin_name','dosis','st.image','d.created_at')
                                        ->get();
                // return view('print_medicine',$data);
                $pdf = PDF::loadView('print_medicine',$data);
                return $pdf->stream();
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'MedicineController@detail';
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
            $admin         = MedicineModel::find($request->id);
            $admin->status = 0;
            $admin->save();
            if ($admin) {
                $data['code']    = 200;
                $data['message'] = 'Berhasil Menonaktifkan Data Obat';
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Menon aktifkan Data Obat '.$admin->category_name.'','Obat');
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
            $data['controller'] = 'MedicineController@nonactive';
            $insert_error = parent::InsertErrorSystem($data);
            
            return response()->json($data); // jika metode Post
        }
    }

    public function active(Request $request)
    {
        try {
            $admin         = MedicineModel::find($request->id);
            $admin->status = 1;
            $admin->save();
            if ($admin) {
                $data['code']    = 200;
               
                $data['message'] = 'Berhasil Mengapprove Obat';
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Meng aktifkan Data Obat '.$admin->category_name.'','Obat');
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
            $data['controller'] = 'MedicineController@active';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function delete(Request $request)
    {
        try {
            $admin             = MedicineModel::find($request->id);
            $admin->status     = 0;
            $admin->deleted_at = date('Y-m-d');
            $admin->save();

            if ($admin) {
                $data['code']    = 200;
                $data['message'] = 'Berhasil Menghapus Data Obat';
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Menghapus Data Obat '.$admin->category_name.'','Obat');
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
            $data['controller'] = 'MedicineController@delete';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

}