<?php

namespace App\Http\Controllers;

use App\Model\RoleModel;
use App\Model\TeacherModel;
use App\Model\SchollModel;
use App\Model\CityModel;
use App\Model\StudyModel;
use App\Model\UserModel;
use App\Classes\upload;
use App\Traits\Fungsi;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\Handler;

class TeacherController extends Controller
{
    public function index()
    {
        // dd(Kelas::get());
        try {
            $data = parent::sidebar();
            if ($data['access'] == 0) {
                return redirect('/');
            } else {
                $role_id           = Auth::guard('admin')->user()->id_role;
                $data['data_scholl'] = SchollModel::whereNull('deleted_at')->get();
                $data['data_city'] = CityModel::whereNull('deleted_at')->get();
                $data['txt_button'] = "Tambah Guru Baru";
                $data['href'] = "user/guru/action/add";
                //dd($data['id_adm_dept']);
                return view('teacher.index', $data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'TeacherController@index';
            $insert_error = parent::InsertErrorSystem($data);
            $error = parent::sidebar();
            $error['id'] = $insert_error;
            return view('errors.index',$error); // jika Metode Get
            //return response()->json($data); // jika metode Post
        }
    }


    public function list_data(Request $request)
    {
        
        $student = DB::table('teachers as s')->leftJoin('cities as c','c.id','s.id_city')->whereNull('s.deleted_at');
        if ($request->id_scholl != null) {
            $relation_scholl = DB::table('teacher_scholl_relations as s')->where('id_scholl',$request->id_scholl)->pluck('id_teacher')->toArray();
            $student = $student->whereIn('s.id',$relation_scholl);
        }

        if ($request->id_city != null) {
            $student = $student->where('s.id_city',$request->id_city);
        }

        if ($request->gender != null) {
            $student = $student->where('gender',$request->gender);
        }

        if ($request->search != null) {
            $student = $student->where(function ($query) use ($request) {
                $search = $request->search;
                $query->where('teacher_name','ilike', "%{$search}%");
                $query->orWhere('c.name','ilike', "%{$search}%");
            });
        }
        
        if ($request->sort == 1) {
            $student = $student->orderBy('s.created_at','desc');
        }
        if ($request->sort == 2) {
            $student = $student->orderBy('teacher_name','asc');
        }
        
        
        $student = $student->limit(10)->offset($request->start)->select('s.*','c.name')->get();
        $data['data'] = $student;
        if ($data['data']->isNotEmpty()) {
            foreach ($data['data'] as $k => $v) {
                $data['data'][$k]->image = env('BASE_IMG').$v->image;
                $data['data'][$k]->scholl = $this->GetScholl($v->id,'scholl_name');
                $data['data'][$k]->study = $this->GetStudy($v->id,'study_name');
            }
        }  

        return view('teacher.data', $data);
    }

    public function GetScholl($id,$coloumn){
        $return = " - ";
        $data = DB::table('teacher_scholl_relations as s')->join('table_scholls as t','t.id','s.id_scholl')->where('id_teacher',$id)->pluck($coloumn);
        if ($data->isNotEmpty()) {
            $return = implode(', ', $data->toArray());
        }
        return $return;
    }

    public function GetStudy($id,$coloumn){
        $return = " - ";
        $data = DB::table('teacher_study_relations as s')->join('table_studies as t','t.id','s.id_study')->where('id_teacher',$id)->pluck($coloumn);
        if ($data->isNotEmpty()) {
            $return = implode(', ', $data->toArray());
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
            $data['data_study'] = StudyModel::whereNull('deleted_at')->get();
            //dd($data['id_adm_dept']);
            return view('teacher.add', $data);
        }
    }

    public function post(Request $request)
    {
        // id bermasalah
        try {
            $input = $request->except('_token','id_scholl','id_study');

            if ($request->file('image')) {
                $input['image']  = parent::uploadFileS3($request->file('image'));
            } 

            $input['created_at'] = date('Y-m-d H:i:s');
            $input['updated_at'] = date('Y-m-d H:i:s');
            $insert = DB::table('teachers')->insertGetId($input);
            if ($insert) {
                //insert sekolah
                for ($i=0; $i < count($request->id_scholl); $i++) { 
                    $insert_class = DB::table('teacher_scholl_relations')->insert(['id_teacher'=>$insert,'id_scholl'=>$request->id_scholl[$i],'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
                }

                //insert mata pelajaran
                for ($i=0; $i < count($request->id_study); $i++) { 
                    $insert_class = DB::table('teacher_study_relations')->insert(['id_teacher'=>$insert,'id_study'=>$request->id_study[$i],'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
                }

                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Menambah Data guru '.$request->student_name.'','guru');
                $data['code']    = 200;
                $data['message'] = 'Berhasil menambah data guru';
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
            $data['controller'] = 'TeacherController@post';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function update(Request $request)
    {
        try {
        //dd($request->nik);
            $input = $request->except('_token','id_scholl','id_class','tgl_masuk','id_study');

            if ($request->file('image')) {
                $input['image']  = parent::uploadFileS3($request->file('image'));
            } 
            $data['updated_at'] = date('Y-m-d H:i:s');

            $insert = TeacherModel::where('id', $request->id)->update($input);
            if ($insert) {
                //insert sekolah
                DB::table('teacher_scholl_relations')->where('id_teacher',$request->id)->delete();
                for ($i=0; $i < count($request->id_scholl); $i++) { 
                    $insert_class = DB::table('teacher_scholl_relations')->insert(['id_teacher'=>$request->id,'id_scholl'=>$request->id_scholl[$i],'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
                }

                //insert mata pelajaran
                DB::table('teacher_study_relations')->where('id_teacher',$request->id)->delete();
                for ($i=0; $i < count($request->id_study); $i++) { 
                    $insert_class = DB::table('teacher_study_relations')->insert(['id_teacher'=>$request->id,'id_study'=>$request->id_study[$i],'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
                }
                $data['code']    = 200;
                $data['message'] = 'Berhasil Mengupdate data kelas';
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
            $data['controller'] = 'TeacherController@update';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function detail($id)
    {
        try {
            $id = base64_decode($id);
            $admin = TeacherModel::find($id);
            
            $data = parent::sidebar();
            if ($data['access'] == 0) {
                return redirect('/');
            } else {
                $role_id           = Auth::guard('admin')->user()->id_role;
                $data['code']      = 200;
                $data['data']      = $admin;
                $data['data_role'] = RoleModel::whereNull('deleted_at')->where('status', 1)->get();
                $data['data_city'] = CityModel::whereNull('deleted_at')->get();
                $in_array_scholl = DB::table('teacher_scholl_relations as s')->join('table_scholls as t','t.id','s.id_scholl')->where('id_teacher',$id)->pluck('id_scholl')->toArray();
                $in_array_study = DB::table('teacher_study_relations as s')->join('table_studies as t','t.id','s.id_study')->where('id_teacher',$id)->pluck('id_study')->toArray();
                $data['data_scholl'] = SchollModel::whereNull('deleted_at')->whereNotIn('id',$in_array_scholl)->get();
                $data['data_study'] = StudyModel::whereNull('deleted_at')->whereNotIn('id',$in_array_study)->get();
                $data['data_scholl_in'] = SchollModel::whereNull('deleted_at')->whereIn('id',$in_array_scholl)->get();
                $data['data_study_in'] = StudyModel::whereNull('deleted_at')->whereIn('id',$in_array_study)->get();
                return view('teacher.dialog_edit', $data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'TeacherController@detail';
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
            $admin         = TeacherModel::find($request->id);
            $admin->status = 0;
            $admin->save();
            if ($admin) {
                $data['code']    = 200;
                $data['message'] = 'Berhasil Menonaktifkan Data Kelas';
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Menon aktifkan Data Kelas '.$admin->category_name.'','Kelas');
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
            $data['controller'] = 'TeacherController@nonactive';
            $insert_error = parent::InsertErrorSystem($data);
            
            return response()->json($data); // jika metode Post
        }
    }

    public function active(Request $request)
    {
        try {
            $admin         = TeacherModel::find($request->id);
            $admin->status = 1;
            $admin->save();
            if ($admin) {
                $data['code']    = 200;
               
                $data['message'] = 'Berhasil Mengapprove Kelas';
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Meng aktifkan Data Kelas '.$admin->category_name.'','Kelas');
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
            $data['controller'] = 'TeacherController@active';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function delete(Request $request)
    {
        try {
            $admin             = TeacherModel::find($request->id);
            $admin->status     = 0;
            $admin->deleted_at = date('Y-m-d');
            $admin->save();

            if ($admin) {
                $data['code']    = 200;
                $data['message'] = 'Berhasil Menghapus Data Kelas';
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Menghapus Data Kelas '.$admin->category_name.'','Kelas');
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
            $data['controller'] = 'TeacherController@delete';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

}