<?php

namespace App\Http\Controllers;

use App\Model\RoleModel;
use App\Model\MedicalRecord;
use App\Model\SchollModel;
use App\Model\UserModel;
use App\Classes\upload;
use App\Traits\Fungsi;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\Handler;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportMedicalReport;
use App\Exports\ExportMedicalReportAll;



class MedicalRecordController extends Controller
{
    public function index()
    {
        // dd(medical::get());
        try {
            $data = parent::sidebar();
            if ($data['access'] == 0) {
                return redirect('/');
            } else {
                $role_id             = Auth::guard('admin')->user()->id_role;
                $data['data_scholl'] = SchollModel::whereNull('deleted_at')->get();
                $data['txt_button']  = "Tambah Medical Record Baru";
                $data['href']        = "medical-record/list/add";
                $end                 = date('Y-m-d');
                $start               = date('Y-m-d',strtotime($end . "-30 days"));
                $data['end']         = $end;
                $data['start']       = $start;
                //dd($data['id_adm_dept']);
                return view('medical_record.index', $data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'MedicalRecordController@index';
            $insert_error = parent::InsertErrorSystem($data);
            $error = parent::sidebar();
            $error['id'] = $insert_error;
            return view('errors.index',$error); // jika Metode Get
            //return response()->json($data); // jika metode Post
        }
    }

    public function add()
    {
        // dd(medical::get());
        try {
            $data = parent::sidebar();
            if ($data['access'] == 0) {
                return redirect('/');
            } else {
                $role_id           = Auth::guard('admin')->user()->id_role;
                $data['data_scholl'] = SchollModel::whereNull('deleted_at')->get();
                $data['data_category'] = DB::table('medical_categories')->whereNull('deleted_at')->get();
                $data['medicines'] = DB::table('table_medicines')->where('status',1)->select('id','medicine')->orderBy('medicine','desc')->get();
                //dd($data['id_adm_dept']);
                return view('medical_record.add', $data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'MedicalRecordController@add';
            $insert_error = parent::InsertErrorSystem($data);
            $error = parent::sidebar();
            $error['id'] = $insert_error;
            return view('errors.index',$error); // jika Metode Get
            //return response()->json($data); // jika metode Post
        }
    }

    public function add_medicine($no){
        $data['no'] = $no;
        $data['medicines'] = DB::table('table_medicines')->where('status',1)->select('id','medicine')->orderBy('medicine','desc')->get(); 
        return view('medical_record.add_medicine', $data);
    }


    public function list_data(Request $request)
    {
        
        $limit = $request->input('length');
        $start = $request->input('start');
        $dir   = $request->input('order.0.dir');
        $search =  $request->search;

        $posts = DB::table('medical_records as m')->leftJoin('medical_categories as mc','mc.id','m.id_category')->leftJoin('students as st','st.id','m.id_student')->leftJoin('table_class as c','c.id','m.id_class')->leftJoin('table_scholls as s','s.id','c.id_scholl')->leftJoin('administrators as a','a.id','m.id_admin')->whereNull('m.deleted_at');
        
        if ($search != null) {
            $posts = $posts->where(function ($query) use ($search,$request) {
                $query->where('scholl_name','ilike', "%{$search}%");
                $query->orWhere('a.admin_name','ilike', "%{$search}%");
                $query->orWhere('class_name','ilike', "%{$search}%");
                $query->orWhere('student_name','ilike', "%{$search}%");
            });
        }

        if ($request->start_date != null || $request->start_date != '') {
            $posts = $posts->whereDate('m.record_date','>=',$request->start_date);
        }
        if ($request->end_date != null || $request->end_date != '') {
            $posts = $posts->whereDate('m.record_date','<=',$request->end_date);
        }

        if ($request->id_scholl != null) {
            $posts = $posts->where('c.id_scholl',$request->id_scholl);
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

        $posts = $posts->select('m.*','scholl_name','class_name','student_name','admin_name');
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
                //$action = " - ";

                $cek_role = parent::admin_data();
                if ($request->is_edit == 0) {
                    $action = " - ";
                    $edit = null;
                } else {

                    $edit = '<div style="float: left; margin-left: 5px;"><a href="/medical-record/list/'.base64_encode($d->id).'/0" >
                                <button type="button" class="btn btn-warning btn-sm" style="min-width: 110px;margin-left: 2px;margin-top:3px;text-align:left"><i class="fa fa-edit"></i> Edit</button></a>
                            </div>';
                    $action =  $edit.'<div style="float: left; margin-left: 5px;">
                                    <button type="button" class="btn btn-danger btn-sm aksi btn-aksi" data="data_medical"  id="' . $d->id . '" aksi="delete" tujuan="' . 'medical' . '" data="' . '/data_medical' . '" style="min-width: 110px;margin-left: 2px;margin-top:3px;text-align:left"><i class="fa fa-trash"></i> Hapus</button>
                                </div>';
                }
                //delete
                $column['no']        = $no;
                $column['scholl']    = $d->scholl_name;
                $column['class']     = $d->class_name;
                $column['student']   = $d->student_name;
                $column['admin']   = $d->admin_name;
                $column['problem']   = $d->problem;
                $column['solving']   = $d->solving;
                $column['date']      = date('d F Y H:i',strtotime($d->record_date));
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

    public function export_excel(Request $request, $arr){

        parse_str($arr, $filter);
        $posts = DB::table('medical_records as m')->leftJoin('medical_categories as mc','mc.id','m.id_category')->leftJoin('students as st','st.id','m.id_student')->leftJoin('table_class as c','c.id','m.id_class')->leftJoin('table_scholls as s','s.id','c.id_scholl')->leftJoin('administrators as a','a.id','m.id_admin')->whereNull('m.deleted_at');
        $search = $filter['search'];
        $posts = $posts->where(function ($query) use ($search) {
            if ($search != null) {
                $query->where('scholl_name','ilike', "%{$search}%");
                $query->orWhere('a.admin_name','ilike', "%{$search}%");
                $query->orWhere('class_name','ilike', "%{$search}%");
                $query->orWhere('student_name','ilike', "%{$search}%");
            } 
        });
        $start  = "";
        $end    = "";
        $scholl = "";
        $class  = "";

        if ($filter['start_date'] != null || $filter['start_date'] != '') {
            
            $posts = $posts->whereDate('m.record_date','>=',$filter['start_date']);
            $start = date('d F Y',strtotime($filter['start_date']));
                
        }
        if ($filter['end_date'] != null || $filter['end_date'] != '') {
            $posts = $posts->whereDate('m.record_date','<=',$filter['end_date']);
            $end = ' sd '.date('d F Y',strtotime($filter['end_date']));
        }

        if ($filter['id_scholl'] != null) {
            $posts = $posts->where('c.id_scholl',$filter['id_scholl']);
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

        $posts = $posts->select('m.*','scholl_name','class_name','student_name','admin_name');
        if ($filter['sort'] == 1) {
            $posts = $posts->orderBy('m.record_date','desc');
        }
        if ($filter['sort'] == 2) {
            $posts = $posts->orderBy('student_name','asc');
        }

        $data['data'] = $posts->get();
        //dd($data['data']);
        $data['title'] = 'Data Medikal Record '.$scholl.$class.$start.$end;
        //dd($data);
        //return view('report.excel.demoplot', $data);

        return Excel::download(new ExportMedicalReportAll($data), 'Data Medikal Record '.$scholl.$class.$start.$end.'.xlsx');
    }

    public function post(Request $request)
    {
        // id bermasalah
        try {
            $input = $request->except('_token','id_scholl','notes','medicine','dosis','yourTable_length');
            if ($request->file('image')) {
                $input_send['image']  = parent::uploadFileS3($request->file('image'));
            } 
            $input_send['id_class'] = $request->id_class;
            $input_send['id_student'] = $request->id_student;
            $input_send['record_date'] = $request->record_date;
            $input_send['id_category'] = $request->id_category;
            $input_send['problem'] = $request->problem;
            $input_send['solving'] = $request->solving;
            $input_send['updated_at'] = date('Y-m-d H:i:s');
            $input_send['id_admin'] = Auth::guard('admin')->user()->id;
            $insert = DB::table('medical_records')->insertGetId($input_send);
            if ($insert) {
                //obat
                for ($i=0; $i < count($request->id_medicine); $i++) { 
                    $insert_detail = DB::table('detail_medical_records')->insert(['id_medical_record'=>$insert,'id_medicine'=>$request->id_medicine[$i],'dosis'=>$request->dosis[$i],'notes'=>$request->notes[$i],'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
                }
                // send wa ke orang tua
                // $data_send = DB::table('student_parent_relations as r')->join('students as s','s.id','r.id_student')->join('student_parents as p','p.id','r.id_parent')->where('id_student',$request->id_student)->select('student_name','student_parent_name','p.phone')->get();
                // if ($data_send->isNotEmpty()) {
                //     foreach ($data_send as $k => $v) {
                //         $first = substr($v->phone, 0, 1);
                //         if ($first == '0') {
                //             $phone = "+62".substr($v->phone, 1);
                //         } else {
                //             $phone = "+62".$v->phone;
                //         }

                //         $message = "Yth ".$v->student_parent_name.". anak Anda yang bernama ".$v->student_name." mengalamai keluhan ".$request->problem." dan kami sudah melakukan tindakan ".$request->solving.". Sekian terima kasih";
                //         $send_wa = parent::ZenzifaWa($phone,$message);
                //         //dd($send_wa);
                //     }
                // }

                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Menambah Data medical '.$request->problem.'','medical record');
                $data['code']    = 200;
                $data['message'] = 'Berhasil menambah data medical';
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
            $data['controller'] = 'MedicalRecordController@post';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function update(Request $request)
    {
        try {
        //dd($request->nik);
         
            $input = $request->except('_token','id_scholl','notes','medicine','dosis','yourTable_length');
            if ($request->file('image')) {
                $input_send['image']  = parent::uploadFileS3($request->file('image'));
            } 
            // $data['updated_at'] = date('Y-m-d H:i:s');
            $input_send['id_class'] = $request->id_class;
            $input_send['id_student'] = $request->id_student;
            $input_send['record_date'] = $request->record_date;
            $input_send['id_category'] = $request->id_category;
            $input_send['problem'] = $request->problem;
            $input_send['solving'] = $request->solving;
            $input_send['updated_at'] = date('Y-m-d H:i:s');
            $input_send['id_admin'] = Auth::guard('admin')->user()->id;
            $insert = MedicalRecord::where('id', $request->id)->update($input_send);
            DB::table('detail_medical_records')->where('id_medical_record',$request->id)->delete();
            for ($i=0; $i < count($request->id_medicine); $i++) { 
                $insert_detail = DB::table('detail_medical_records')->insert(['id_medical_record'=>$request->id,'id_medicine'=>$request->id_medicine[$i],'dosis'=>$request->dosis[$i],'notes'=>$request->notes[$i],'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
            }
            if ($insert) {
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Mengupdate Data medical '.$request->class_name.'','medical');
                $data['code']    = 200;
                $data['message'] = 'Berhasil Mengupdate data medical';
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
            $data['controller'] = 'MedicalRecordController@update';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function detail($id,$type)
    {
        try {
            $id = base64_decode($id);
            $data = parent::sidebar();
            if ($data['access'] == 0) {
                return redirect('/');
            } else {
                $data['id'] = $id;
                $data['data_scholl'] = SchollModel::whereNull('deleted_at')->get();
                $data['data_category'] = DB::table('medical_categories')->whereNull('deleted_at')->get();
                if ($type == 0) {
                    $record = MedicalRecord::find($id);
                    if ($record == null) {
                        //dd("ID Tidak ditemukan");
                        return view('errors.not_found',$data);
                    }
                    $data['data'] = $record;
                    //dd($data['data']);
                    $data['data_medicine'] = DB::table('detail_medical_records')->where('id_medical_record',$record->id)->get();
                    $data['user'] = DB::table('students as s')->leftJoin('cities as c','c.id','s.id_city')->join('student_class_relations as r','s.id','r.id_student')->where('r.is_active',1)->where('s.id',$record->id_student)->select('s.id','student_name','nisn','email','phone','c.name','s.image','id_class')->first();
                    $data['type'] = $type;
                    $data['id_user'] = $record->id_student;
                } else {
                    $data['user'] = DB::table('students as s')->leftJoin('cities as c','c.id','s.id_city')->join('student_class_relations as r','s.id','r.id_student')->where('r.is_active',1)->where('s.id',$id)->select('s.id','student_name','nisn','email','phone','c.name','s.image','id_class')->first();
                    if ($data['user'] == null) {
                        //dd("ID Tidak ditemukan");
                        return view('errors.not_found',$data);
                    }
                    $data['type'] = $type;
                    $data['id_user'] = $id;
                    
                }
                $data['medicines'] = DB::table('table_medicines')->where('status',1)->select('id','medicine')->orderBy('medicine','desc')->get();
                return view('medical_record.dialog_edit', $data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'MedicalRecordController@detail';
            $insert_error = parent::InsertErrorSystem($data);
            $error = parent::sidebar();
            $error['id'] = $insert_error;
            return view('errors.500',$error); // jika Metode Get
            //return response()->json($data); // jika metode Post
        }
    }


    public function printPdf($id,$type)
    {
        // print("dilan");
        // try {
            $id = base64_decode($id);
            $data = parent::sidebar();
            if ($data['access'] == 0) {
                return redirect('/');
            } else {
                $data['data_category'] = DB::table('medical_categories')->whereNull('deleted_at')->get();
                if ($type == 0) {
                    $record = MedicalRecord::find($id);
                    $data['data'] = $record;
                    //dd($data['data']);
                    // $data['data_medicine'] = DB::table('detail_medical_records')->where('id_medical_record',$record->id)->get();
                    $data['user'] = DB::table('students as s')->leftJoin('cities as c','c.id','s.id_city')->join('student_class_relations as r','s.id','r.id_student')->where('r.is_active',1)->where('s.id',$record->id_student)->select('s.id','student_name','nisn','email','phone','c.name','s.image','id_class','s.address')->first();
                    $data['type'] = $type;
                    $data['id_user'] = $record->id_student;
                } else {
                    $data['user'] = DB::table('students as s')->leftJoin('cities as c','c.id','s.id_city')->join('student_class_relations as r','s.id','r.id_student')->where('r.is_active',1)->where('s.id',$id)->select('s.id','student_name','nisn','email','phone','c.name','s.image','id_class','s.address')->first();
                    $data['type'] = $type;
                    $data['id_user'] = $id;
                    
                }
                $posts = DB::table('medical_records as m')->join('medical_categories as mc','mc.id','m.id_category')->join('students as st','st.id','m.id_student')->join('table_class as c','c.id','m.id_class')->join('table_scholls as s','s.id','c.id_scholl')->whereNull('m.deleted_at');
                $posts = $posts->where(function ($query) use ($id) {
                    if ($id != null) {
                        $query->where('id_student',$id);
                    } 
                });

                $data['data_medicine'] = $posts->get();
                // $data_saved = array();
                // $data_saved = $posts->get();
                // $data_saved.foreacht 
                // foreach ($data_saved as $key => $value) {
                //     # code...
                // }
                // $column['date']      = date('d F Y H:i',strtotime($d->record_date));
                
                // return view('medical_record.dialog_edit', $data);
                // print($data['user']);
                // var_dump($data['data_medicine']);
                // return view('medical_report_student', $data);
                $customPaper = array(0,0,141.7322834645669, 85.03937007874016);
                $pdf = PDF::loadView('medical_report_student',$data);
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



    public function printExcel($id,$type)
    {
        // print("dilan");
        // try {
            $id = base64_decode($id);
            $data = parent::sidebar();
            if ($data['access'] == 0) {
                return redirect('/');
            } else {
                $data['data_category'] = DB::table('medical_categories')->whereNull('deleted_at')->get();
                if ($type == 0) {
                    $record = MedicalRecord::find($id);
                    $data['data'] = $record;
                    //dd($data['data']);
                    // $data['data_medicine'] = DB::table('detail_medical_records')->where('id_medical_record',$record->id)->get();
                    $data['user'] = DB::table('students as s')->leftJoin('cities as c','c.id','s.id_city')->join('student_class_relations as r','s.id','r.id_student')->where('r.is_active',1)->where('s.id',$record->id_student)->select('s.id','student_name','nisn','email','phone','c.name','s.image','id_class')->first();
                    $data['type'] = $type;
                    $data['id_user'] = $record->id_student;
                } else {
                    $data['user'] = DB::table('students as s')->leftJoin('cities as c','c.id','s.id_city')->join('student_class_relations as r','s.id','r.id_student')->where('r.is_active',1)->where('s.id',$id)->select('s.id','student_name','nisn','email','phone','c.name','s.image','id_class')->first();
                    $data['type'] = $type;
                    $data['id_user'] = $id;
                    
                }
                $posts = DB::table('medical_records as m')->join('medical_categories as mc','mc.id','m.id_category')->join('students as st','st.id','m.id_student')->join('table_class as c','c.id','m.id_class')->join('table_scholls as s','s.id','c.id_scholl')->whereNull('m.deleted_at');
                $posts = $posts->where(function ($query) use ($id) {
                    if ($id != null) {
                        $query->where('id_student',$id);
                    } 
                });
                $data['data_medicine'] = $posts->get();
                // $customPaper = array(0,0,141.7322834645669, 85.03937007874016);
                // $pdf = PDF::loadView('medical_report_student',$data);
                // return $pdf->stream();
                // return Excel::download($data, 'medical_report_student.xlsx');
                return Excel::download(new ExportMedicalReport($data),'medical_report_student.xlsx');
            }
      
    }

    

    public function delete(Request $request)
    {
        try {
            $admin             = MedicalRecord::find($request->id);
            $admin->status     = 0;
            $admin->deleted_at = date('Y-m-d');
            $admin->save();

            if ($admin) {
                $data['code']    = 200;
                $data['message'] = 'Berhasil Menghapus Data medical';
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Menghapus Data medical '.$admin->category_name.'','medical');
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
            $data['controller'] = 'MedicalRecordController@delete';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function get_student_data($id){
        $data['data'] = DB::table('students as s')->leftJoin('cities as c','c.id','s.id_city')->where('s.id',$id)->select('s.id','student_name','nisn','email','phone','c.name','s.image')->first();
        return view('medical_record.data_siswa', $data);
    }


    

}