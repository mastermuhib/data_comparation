<?php

namespace App\Http\Controllers;

use App\Model\RoleModel;
use App\Model\RecapModel;
use App\Model\DistrictModel;
use App\Classes\upload;
use App\Traits\Fungsi;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\Handler;
use App\Exports\ExportRecapitulations;
use App\Exports\ExportRecapitulationsAll;

class RecapitulationsController extends Controller
{
    public function index()
    {
        try {
            $data = parent::sidebar();
            if ($data['access'] == 0) {
                return redirect('/');
            } else {
                $role_id           = Auth::guard('admin')->user()->id_role;
                $data['txt_button'] = "Tambah Pemeriksaan";
                $data['href'] = "medical-record/pemeriksaan-tahunan/action/add";
                $data['data_kec'] = DistrictModel::whereNull('deleted_at')->select('id','name')->get();
                //dd($data['id_adm_dept']);
                return view('recap.index', $data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'RecapitulationsController@index';
            $insert_error = parent::InsertErrorSystem($data);
            $error = parent::sidebar();
            $error['id'] = $insert_error;
            return view('errors.index',$error); // jika Metode Get
            //return response()->json($data); // jika metode Post
        }
    }

    public function district()
    {
        try {
            $data = parent::sidebar();
            if ($data['access'] == 0) {
                return redirect('/');
            } else {
                $role_id           = Auth::guard('admin')->user()->id_role;
                $data['txt_button'] = "Tambah Pemeriksaan";
                $data['href'] = "medical-record/pemeriksaan-tahunan/action/add";
                $data['data_kec'] = DistrictModel::whereNull('deleted_at')->select('id','name')->get();
                //dd($data['id_adm_dept']);
                return view('recap.district', $data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'RecapitulationsController@district';
            $insert_error = parent::InsertErrorSystem($data);
            $error = parent::sidebar();
            $error['id'] = $insert_error;
            return view('errors.index',$error); // jika Metode Get
            //return response()->json($data); // jika metode Post
        }
    }

    public function village()
    {
        
        try {
            $data = parent::sidebar();
            if ($data['access'] == 0) {
                return redirect('/');
            } else {
                $role_id           = Auth::guard('admin')->user()->id_role;
                $data['txt_button'] = "Tambah Pemeriksaan";
                $data['href'] = "medical-record/pemeriksaan-tahunan/action/add";
                $data['data_kec'] = DistrictModel::whereNull('deleted_at')->select('id','name')->get();
                //dd($data['id_adm_dept']);
                return view('recap.village', $data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'RecapitulationsController@village';
            $insert_error = parent::InsertErrorSystem($data);
            $error = parent::sidebar();
            $error['id'] = $insert_error;
            return view('errors.index',$error); // jika Metode Get
            //return response()->json($data); // jika metode Post
        }
    }


    public function list_data(Request $request)
    {


        $totalData = DB::table('t_recaps')->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $dir   = $request->input('order.0.dir');
        $search = $request->search;

        $posts = DB::table('physical_records as p')->join('students as s','s.id','p.id_student')->join('administrators as a','a.id','p.id_doctor')->join('table_scholls as ts','ts.id','p.id_scholl')->join('table_class as tc','tc.id','p.id_class')->whereNull('p.deleted_at');
        if ($search != null) {
            $posts = $posts->where(function ($query) use ($search,$request) {
                $query->where('scholl_name','ilike', "%{$search}%");
                $query->orWhere('a.admin_name','ilike', "%{$search}%");
                $query->orWhere('class_name','ilike', "%{$search}%");
                $query->orWhere('student_name','ilike', "%{$search}%");  
            });
        }

        if ($request->start_date != null || $request->start_date != '') {
            $posts = $posts->whereDate('p.date','>=',$request->start_date);
        }
        if ($request->end_date != null || $request->end_date != '') {
            $posts = $posts->whereDate('p.date','<=',$request->end_date);
        }

        if ($request->id_scholl != null) {
            $posts = $posts->where('p.id_scholl',$request->id_scholl);
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

        $posts = $posts->select('p.id','scholl_name','class_name','student_name','admin_name','p.date');
        if ($request->sort == 1) {
            $posts = $posts->orderBy('p.date','desc');
        }
        if ($request->sort == 2) {
            $posts = $posts->orderBy('student_name','asc');
        }

        $totalFiltered = $posts->count();
        $posts = $posts->limit($limit)->offset($start)->get();

        $data = array();
        if (!empty($posts)) {
            $no = 0;
            foreach ($posts as $d) {
                $no = $no + 1;

                $cek_role = parent::admin_data();
                if ($request->is_edit == 0) {
                    $action = '<div style="float: left; margin-left: 5px;"><a href="/medical-record/pemeriksaan-tahunan/'.base64_encode($d->id).'" >
                                <button type="button" class="btn btn-warning btn-sm" style="min-width: 110px;margin-left: 2px;margin-top:3px;text-align:left"><i class="fa fa-eye"></i> Detail</button></a>
                            </div>';
                    $edit = null;
                } else {
                    $edit = '<div style="float: left; margin-left: 5px;"><a href="/medical-record/pemeriksaan-tahunan/'.base64_encode($d->id).'" >
                                <button type="button" class="btn btn-warning btn-sm" style="min-width: 110px;margin-left: 2px;margin-top:3px;text-align:left"><i class="fa fa-edit"></i> Edit</button></a>
                            </div>';
                    $action =  $edit.'<div style="float: left; margin-left: 5px;">
                                    <button type="button" class="btn btn-danger btn-sm aksi btn-aksi"  id="' . $d->id . '" aksi="delete" tujuan="' . 'pemeriksaan' . '" data="' . '/data_pemeriksaan' . '" style="min-width: 110px;margin-left: 2px;margin-top:3px;text-align:left"><i class="fa fa-trash"></i> Hapus</button>
                                </div>';
                }
                //delete
                $column['no']        = $no;
                $column['scholl']    = $d->scholl_name.'<p class="text-info">('.$d->class_name.')</p>';
                $column['student']   = $d->student_name;
                $column['admin']   = $d->admin_name;
                $column['date']      = date('d F Y H:i',strtotime($d->date));
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

    public function calculate(Request $request, $arr){
        try {
            $village = DB::table('villages')->get();
            $clasification = DB::table('t_clasifications')->get();
            $triwulan = $request->triwulan;
            $year = $request->year;
            foreach ($village as $k => $v) {
                $t_male = DB::table('t_dpt')->where('gender','L')->where('id_village',$v->id)->count();
                $t_female = DB::table('t_dpt')->where('gender','P')->where('id_village',$v->id)->count();
                $total = (int)$t_male + (int)$t_female;
                $update = DB::table('villages')->where('id',$v->id)->update(['male_dpt'=>$t_male,'female_dpt'=>$t_female,'total_dpt'=>$total]);
                foreach ($clasification as $a => $b) {
                    if ($b->min == null) {
                        $male = DB::table('t_dpt')->where('gender','L')->where('id_village',$v->id)->where('age','<',$b->max)->count();
                        $female = DB::table('t_dpt')->where('gender','P')->where('id_village',$v->id)->where('age','<',$b->max)->count();
                    } else if($b->max == null){
                        $male = DB::table('t_dpt')->where('gender','L')->where('id_village',$v->id)->where('age','>',$b->min)->count();
                        $female = DB::table('t_dpt')->where('gender','P')->where('id_village',$v->id)->where('age','>',$b->min)->count();
                    } else {
                        $male = DB::table('t_dpt')->where('gender','L')->where('id_village',$v->id)->where('age','>=',$b->min)->where('age','<',$b->max)->count();
                        $female = DB::table('t_dpt')->where('gender','P')->where('id_village',$v->id)->where('age','>=',$b->min)->where('age','<',$b->max)->count();
                    }

                    $insert_recaps = array(
                        'id_village' => $v->id,
                        'group' => date('YmdHis'),
                        'id_clasification' => $b->id,
                        'total_male' => $male,
                        'total_female' => $female,
                        'triwulan' => $triwulan,
                        'year' => $year,                           
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    );
                    $id_recap = DB::table('t_dpt')->insertGetId($insert_recaps);  
                }

            }

            $data['code']    = 200;
            $data['message'] = 'Berhasil Memblokir Data City';
            return response()->json($data);
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'RecapitulationsController@calculate';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }    

    }

    public function export_excel(Request $request, $arr){

        parse_str($arr, $filter);

        $start  = "";
        $end    = "";
        $scholl = "";
        $class  = "";

        $posts = DB::table('physical_records as p')->join('students as s','s.id','p.id_student')->join('administrators as a','a.id','p.id_doctor')->join('table_scholls as ts','ts.id','p.id_scholl')->join('table_class as tc','tc.id','p.id_class')->whereNull('p.deleted_at');
        

        $search = $filter['search'];
        $posts = $posts->where(function ($query) use ($search) {
            if ($search != null) {
                $query->where('scholl_name','ilike', "%{$search}%");
                $query->orWhere('a.admin_name','ilike', "%{$search}%");
                $query->orWhere('class_name','ilike', "%{$search}%");
                $query->orWhere('student_name','ilike', "%{$search}%");
            } 
        });

        if ($filter['start_date'] != null || $filter['start_date'] != '') {
            $posts = $posts->whereDate('p.date','>=',$filter['start_date']);
            $start = date('d F Y',strtotime($filter['start_date']));
        }
        if ($filter['end_date'] != null || $filter['end_date'] != '') {
            $posts = $posts->whereDate('p.date','<=',$filter['end_date']);
            $end = ' sd '.date('d F Y',strtotime($filter['end_date']));
        }

        if ($filter['id_scholl'] != null) {
            $posts = $posts->where('p.id_scholl',$filter['id_scholl']);
            $data_scholl = DB::table('table_scholls')->where('id',$filter['id_scholl'])->select('scholl_name')->first();
            $scholl = $data_scholl->scholl_name;
        }

        if ($filter['id_class'] != null) {
            $posts = $posts->where('id_class',$filter['id_class']);
            $data_class = DB::table('table_class')->where('id',$filter['id_class'])->select('class_name')->first();
            $class = $data_class->class_name;
        }

        if ($filter['gender'] != null) {
            $posts = $posts->where('gender',$filter['gender']);
        }

        $posts = $posts->select('p.*','scholl_name','class_name','student_name','admin_name');
        if ($request->sort == 1) {
            $posts = $posts->orderBy('p.date','desc');
        }
        if ($request->sort == 2) {
            $posts = $posts->orderBy('student_name','asc');
        }
        $data['data'] = $posts->get();

        $data['title'] = 'Data Pemeriksaan Fisik '.$scholl.$class.$start.$end;
        //dd($data);
        //return view('report.excel.demoplot', $data);

        return Excel::download(new ExportRecapitulationsAll($data), 'Data Pemeriksaan Fisik '.$scholl.$class.$start.$end.'.xlsx');
    }

    
    public function post(Request $request)
    {
        // id bermasalah
        try {
            $input = $request->except('_token','isi');
            $input['id_admin'] = Auth::guard('admin')->user()->id;

            $input['created_at'] = date('Y-m-d H:i:s');
            $input['updated_at'] = date('Y-m-d H:i:s');
            $insert = DB::table('physical_records')->insertGetId($input);
            if ($insert) {
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Menambah Data Pemeriksaan '.$request->id_student.'','Pemeriksaan');
                $data['code']    = 200;
                $data['message'] = 'Berhasil menambah data pemeriksaan';
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
            $data['controller'] = 'RecapitulationsController@post';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    

    public function detail($id)
    {
       try {
            $id = base64_decode($id);
            $admin = PshycalModel::find($id);
            
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
                $data['data_scholl'] = SchollModel::whereNull('deleted_at')->get();
                $data['data_doctor'] = DB::table('administrators as a')->join('roles as r','r.id','a.id_role')->whereNull('a.deleted_at')->where('r_type',1)->select('a.id','admin_name as name')->orderBy('admin_name','asc')->get();
                return view('pshycal_record.dialog_edit', $data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'RecapitulationsController@detail';
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
            $admin = PshycalModel::find($id);
            
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
            $data['controller'] = 'RecapitulationsController@detail';
            $insert_error = parent::InsertErrorSystem($data);
            $error = parent::sidebar();
            $error['id'] = $insert_error;
            return view('errors.500',$error); // jika Metode Get
            //return response()->json($data); // jika metode Post
        }
    }

    

    public function print_detail($id)
    {
        // print("dilan");
        // try {
            $id = base64_decode($id);
            $data = parent::sidebar();
            if ($data['access'] == 0) {
                return redirect('/');
            } else {
                $data['data'] = PshycalModel::find($id);
                $data['user'] = DB::table('students as s')->leftJoin('cities as c','c.id','s.id_city')->join('student_class_relations as r','s.id','r.id_student')->where('r.is_active',1)->where('s.id',$data['data']->id_student)->select('s.id','student_name','nisn','email','phone','c.name','s.image','id_class','s.address')->first();
                
                $customPaper = array(0,0,141.7322834645669, 85.03937007874016);
                $pdf = PDF::loadView('pshycal_record_student',$data);
                return $pdf->stream();

                
            }
        // } catch (\Exception $e) {
        //     $data['code']    = 500;
        //     $data['message'] = $e->getMessage();
        //     $data['line'] = $e->getLine();
        //     $data['controller'] = 'MedicalRecordController@detail';
        //     $insert_error = parent::InsertErrorSystem($data);
        //     $error = parent::sidebar();
        //     $error['id'] = $insert_error;
        //     return view('errors.500',$error); // jika Metode Get
        //     //return response()->json($data); // jika metode Post
        // }
    }

}