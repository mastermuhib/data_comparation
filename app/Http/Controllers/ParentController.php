<?php

namespace App\Http\Controllers;

use App\Model\RoleModel;
use App\Model\ParentModel;
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

class ParentController extends Controller
{
    public function index()
    {
        // dd(orang tua::get());
        try {
            $data = parent::sidebar();
            if ($data['access'] == 0) {
                return redirect('/');
            } else {
                $role_id           = Auth::guard('admin')->user()->id_role;
                $data['data_scholl'] = SchollModel::whereNull('deleted_at')->get();
                $data['data_city'] = CityModel::whereNull('deleted_at')->get();
                $data['txt_button'] = "Tambah Orang Tua Baru";
                $data['href'] = "user/parent/action/add";
                //dd($data['id_adm_dept']);
                return view('parent.index', $data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'ParentController@index';
            $insert_error = parent::InsertErrorSystem($data);
            $error = parent::sidebar();
            $error['id'] = $insert_error;
            return view('errors.index',$error); // jika Metode Get
            //return response()->json($data); // jika metode Post
        }
    }


    public function list_data(Request $request)
    {
        
        $parent = DB::table('student_parents as s')->leftJoin('cities as c','c.id','s.id_city')->whereNull('s.deleted_at');
        if ($request->id_scholl != null) {
            $relation_scholl = DB::table('student_parent_relations as s')->join('students as st','st.id','s.id_student')->join('student_class_relations as sr','st.id','sr.id_student')->join('table_class as c','c.id','sr.id_class')->where('sr.is_active',1)->where('c.id_scholl',$request->id_scholl)->pluck('s.id_parent')->toArray();
            $parent = $parent->whereIn('s.id',$relation_scholl);
        }

        if ($request->id_city != null) {
            $parent = $parent->where('s.id_city',$request->id_city);
        }

        if ($request->gender != null) {
            $parent = $parent->where('gender',$request->gender);
        }

        if ($request->search != null) {
            $parent = $parent->where(function ($query) use ($request) {
                $search = $request->search;
                $query->where('student_parent_name','ilike', "%{$search}%");
                $query->orWhere('c.name','ilike', "%{$search}%");
                $query->orWhere('parent_type','ilike', "%{$search}%");
            });
        }
        
        if ($request->sort == 1) {
            $parent = $parent->orderBy('s.created_at','desc');
        }
        if ($request->sort == 2) {
            $parent = $parent->orderBy('student_parent_name','asc');
        }
        
        
        $parent = $parent->limit(10)->offset($request->start)->select('s.*','c.name')->get();
        $data['data'] = $parent;
        if ($data['data']->isNotEmpty()) {
            foreach ($data['data'] as $k => $v) {
                //$data['data'][$k]->image = env('BASE_IMG').$v->image;
                $data['data'][$k]->student = $this->GetStudent($v->id);
                if (Auth::guard('admin')->user()->id_scholl != null) {
                    $data['data'][$k]->phone = substr($v->phone, 0, 3)."**********";
                }
                if (Auth::guard('admin')->user()->id_scholl != null) {
                    $data['data'][$k]->email = substr($v->email, 0, 3)."**********";
                }
            }
        }  

        return view('parent.data', $data);
    }

    public function GetStudent($id){
        $return = " - ";
        $data = DB::table('student_parent_relations as s')->join('students as t','t.id','s.id_student')->where('id_parent',$id)->pluck('student_name');
        if ($data->isNotEmpty()) {
            $return = implode(', ', $data->toArray());
        }
        return $return;
    }

    public function add_student($no){
        $data['no'] = $no;
        $data['data_scholl'] = SchollModel::whereNull('deleted_at')->get();
        return view('parent.add_student', $data);
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
            //dd($data['id_adm_dept']);
            return view('parent.add', $data);
        }
    }

    public function post(Request $request)
    {
        // id bermasalah
        try {
            $input = $request->except('_token','id_scholl','id_student');

            if ($request->file('image')) {
                $input['image']  = parent::uploadFileS3($request->file('image'));
            } 

            $input['created_at'] = date('Y-m-d H:i:s');
            $input['updated_at'] = date('Y-m-d H:i:s');
            $insert = DB::table('student_parents')->insertGetId($input);
            if ($insert) {
                //insert relasi siswa
                for ($i=0; $i < count($request->id_student); $i++) { 
                    $insert_class = DB::table('student_parent_relations')->insert(['id_parent'=>$insert,'id_student'=>$request->id_student[$i],'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
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
            $data['controller'] = 'ParentController@post';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function update(Request $request)
    {
        try {
        //dd($request->nik);
            $input = $request->except('_token','id_scholl','id_student');

            if ($request->file('image')) {
                $input['image']  = parent::uploadFileS3($request->file('image'));
            } 
            $data['updated_at'] = date('Y-m-d H:i:s');

            $insert = ParentModel::where('id', $request->id)->update($input);
            if ($insert) {
                //insert siswa
                DB::table('student_parent_relations')->where('id_parent',$request->id)->delete();
                //insert relasi siswa
                for ($i=0; $i < count($request->id_student); $i++) { 
                    $insert_class = DB::table('student_parent_relations')->insert(['id_parent'=>$request->id,'id_student'=>$request->id_student[$i],'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
                }

                
                $data['code']    = 200;
                $data['message'] = 'Berhasil Mengupdate data orang tua';
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
            $data['controller'] = 'ParentController@update';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function detail($id)
    {
        try {
            $id = base64_decode($id);
            $admin = ParentModel::find($id);
            
            $data = parent::sidebar();
            if ($data['access'] == 0) {
                return redirect('/');
            } else {
                $role_id           = Auth::guard('admin')->user()->id_role;
                $data['code']      = 200;
                $data['data']      = $admin;
                $data['data_role'] = RoleModel::whereNull('deleted_at')->where('status', 1)->get();
                $data['data_city'] = CityModel::whereNull('deleted_at')->get();
                $data['data_scholl'] = SchollModel::whereNull('deleted_at')->get();
                $data['student'] = DB::table('student_parent_relations')->where('id_parent',$id)->get();
                //dd($data['student']);
                return view('parent.dialog_edit', $data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'ParentController@detail';
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
            $admin         = ParentModel::find($request->id);
            $admin->status = 0;
            $admin->save();
            if ($admin) {
                $data['code']    = 200;
                $data['message'] = 'Berhasil Menonaktifkan Data orang tua';
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Menon aktifkan Data orang tua '.$admin->category_name.'','orang tua');
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
            $data['controller'] = 'ParentController@nonactive';
            $insert_error = parent::InsertErrorSystem($data);
            
            return response()->json($data); // jika metode Post
        }
    }

    public function active(Request $request)
    {
        try {
            $admin         = ParentModel::find($request->id);
            $admin->status = 1;
            $admin->save();
            if ($admin) {
                $data['code']    = 200;
               
                $data['message'] = 'Berhasil Mengapprove orang tua';
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Meng aktifkan Data orang tua '.$admin->category_name.'','orang tua');
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
            $data['controller'] = 'ParentController@active';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function delete(Request $request)
    {
        try {
            $admin             = ParentModel::find($request->id);
            $admin->status     = 0;
            $admin->deleted_at = date('Y-m-d');
            $admin->save();

            if ($admin) {
                $data['code']    = 200;
                $data['message'] = 'Berhasil Menghapus Data orang tua';
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Menghapus Data orang tua '.$admin->category_name.'','orang tua');
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
            $data['controller'] = 'ParentController@delete';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

}