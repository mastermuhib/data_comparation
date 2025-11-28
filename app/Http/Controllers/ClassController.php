<?php

namespace App\Http\Controllers;

use App\Model\RoleModel;
use App\Model\ClassModel;
use App\Model\SchollModel;
use App\Model\UserModel;
use App\Classes\upload;
use App\Traits\Fungsi;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\Handler;

class ClassController extends Controller
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
                //dd($data['id_adm_dept']);
                return view('class.index', $data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'ClassController@index';
            $insert_error = parent::InsertErrorSystem($data);
            $error = parent::sidebar();
            $error['id'] = $insert_error;
            return view('errors.index',$error); // jika Metode Get
            //return response()->json($data); // jika metode Post
        }
    }


    public function list_data(Request $request)
    {
        
        $limit = $request->input('length');
        $start = $request->input('start');
        $dir   = $request->input('order.0.dir');
        $search =  $request->input('search.value');
        $posts = DB::table('table_class as c')->join('table_scholls as s','s.id','c.id_scholl')->whereNull('c.deleted_at')->where(function ($query) use ($search,$request) {
            if ($search != null) {
                $query->where('scholl_name','ilike', "%{$search}%");
                $query->orWhere('class_name','ilike', "%{$search}%");
            } 
        });
        if ($request->id_scholl != null || $request->id_scholl != '') {
            $posts = $posts->where('id_scholl',$request->id_scholl);
        }
        $posts = $posts->select('c.*','scholl_name')->orderBy('c.created_at','desc');

        $totalFiltered = $posts->count();
        $totalData = $posts->count();

        $posts = $posts->limit($limit)->offset($start)->get();

        $data = array();
        if (!empty($posts)) {
            $no = 0;
            foreach ($posts as $d) {
                $no = $no + 1;

                if ($d->status == 1) {
                    $status = '<div style="float: left; margin-left: 5px;">
                        <a id="' . $d->id . '" aksi="nonaktif" tujuan="kelas" data="data_kelas" class="btn btn-success btn-sm aksi">Aktif</a>
                        </div>';
                } else {
                    $status = '<div style="float: left; margin-left: 5px;">
                        <button type="button" id="' . $d->id . '"data="data_kelas" aksi="aktif" tujuan="kelas" class="btn btn-danger btn-sm aksi">Tidak Aktif</button>
                        </div>';
                }

                $cek_role = parent::admin_data();
                if ($request->is_edit == 0) {
                    $action = " - ";
                    $edit = null;
                } else {
                    $edit = '<div style="float: left; margin-left: 5px;"><a href="/master/kelas/'.$d->id.'" >
                                <button type="button" class="btn btn-warning btn-sm" style="min-width: 110px;margin-left: 2px;margin-top:3px;text-align:left"><i class="fa fa-edit"></i> Edit</button></a>
                            </div>';
                    $action =  $edit.'<div style="float: left; margin-left: 5px;">
                                    <button type="button" class="btn btn-danger btn-sm aksi btn-aksi" data="data_cabang"  id="' . $d->id . '" aksi="delete" tujuan="' . 'kelas' . '" data="' . 'data_kelas' . '" style="min-width: 110px;margin-left: 2px;margin-top:3px;text-align:left"><i class="fa fa-trash"></i> Hapus</button>
                                </div>';
                }
                //delete
                $column['no']           = $no;
                $column['class']      = $d->class_name;
                $column['scholl'] = $d->scholl_name;
                $column['date'] = date('d F Y H:i',strtotime($d->created_at));
                $column['status']    = $status;
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

    public function post(Request $request)
    {
        // id bermasalah
        try {
            $input = $request->except('_token');

            if ($request->file('image')) {
                $input['image']  = parent::uploadFileS3($request->file('image'));
            } 

            $input['created_at'] = date('Y-m-d H:i:s');
            $input['updated_at'] = date('Y-m-d H:i:s');
            $insert = DB::table('table_class')->insertGetId($input);
            if ($insert) {
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Menambah Data Kelas '.$request->class_name.'','sekolah');
                $data['code']    = 200;
                $data['message'] = 'Berhasil menambah data kelas';
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
            $data['controller'] = 'ClassController@post';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function update(Request $request)
    {
        try {
        //dd($request->nik);
            $input = $request->except('_token');

            if ($request->file('image')) {
                $input['image']  = parent::uploadFileS3($request->file('image'));
            } 
            $data['updated_at'] = date('Y-m-d H:i:s');

            $insert = ClassModel::where('id', $request->id)->update($input);
            if ($insert) {
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Mengupdate Data kelas '.$request->class_name.'','kelas');
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
            $data['controller'] = 'ClassController@update';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function detail($id)
    {
        try {
            $admin = ClassModel::find($id);
            
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
                $data['data_role'] = RoleModel::whereNull('deleted_at')->where('status', 1)->get();
                $data['data_scholl'] = SchollModel::whereNull('deleted_at')->get();
                return view('class.dialog_edit', $data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'ClassController@detail';
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
            $admin         = ClassModel::find($request->id);
            $admin->status = 0;
            $admin->save();
            if ($admin) {
                $data['code']    = 200;
                $data['message'] = 'Berhasil Menonaktifkan Data Kelas';
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Menon aktifkan Data Kelas '.$admin->class_name.'','Kelas');
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
            $data['controller'] = 'ClassController@nonactive';
            $insert_error = parent::InsertErrorSystem($data);
            
            return response()->json($data); // jika metode Post
        }
    }

    public function active(Request $request)
    {
        try {
            $admin         = ClassModel::find($request->id);
            $admin->status = 1;
            $admin->save();
            if ($admin) {
                $data['code']    = 200;
               
                $data['message'] = 'Berhasil Mengapprove Kelas';
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Meng aktifkan Data Kelas '.$admin->class_name.'','Kelas');
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
            $data['controller'] = 'ClassController@active';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function delete(Request $request)
    {
        try {
            $admin             = ClassModel::find($request->id);
            $admin->status     = 0;
            $admin->deleted_at = date('Y-m-d');
            $admin->save();

            if ($admin) {
                $data['code']    = 200;
                $data['message'] = 'Berhasil Menghapus Data Kelas';
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Menghapus Data Kelas '.$admin->class_name.'','Kelas');
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
            $data['controller'] = 'ClassController@delete';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function get_class($id){
        $data = DB::table('table_class')->where('id_scholl',$id)->select('id','class_name as name')->orderBy('class_name','asc')->get();
        return json_encode($data);
    }

    public function get_student($id){
        $in_rel = DB::table('student_class_relations')->where('id_class',$id)->where('is_active',1)->pluck('id_student')->toArray();
        $data = DB::table('students')->whereIn('id',$in_rel)->whereNull('deleted_at')->select('id','student_name as name')->orderBy('student_name','asc')->get();
        return json_encode($data);
    }

    public function get_student_parent($id){
        $in_rel = DB::table('student_parent_relations')->where('id_student',$id)->pluck('id_parent')->toArray();
        $data = DB::table('student_parents')->whereIn('id',$in_rel)->whereNull('deleted_at')->select('id','student_parent_name as name')->orderBy('student_parent_name','asc')->get();
        return json_encode($data);
    }

    public function get_teacher($id){
        $data = [];
        $in_rel = DB::table('teacher_scholl_relations')->where('id_scholl',$id)->pluck('id_teacher')->toArray();
        $data = DB::table('teachers')->whereIn('id',$in_rel)->select('id','teacher_name as name')->orderBy('teacher_name','asc')->get();
        
        return json_encode($data);
    }

    public function get_student_with_type($id,$type){
        $data = [];
        if ($type == '1') {
            $in_rel = DB::table('student_class_relations')->where('id_class',$id)->where('is_active',1)->pluck('id_student')->toArray();
            $data = DB::table('students')->whereIn('id',$in_rel)->whereNull('deleted_at')->select('id','student_name as name')->orderBy('student_name','asc')->get();
        } else if($type == '2') {
            $class = DB::table('table_class')->where('id',$id)->select('id_scholl')->first();
            $in_rel = DB::table('teacher_scholl_relations')->where('id_scholl',$class->id_scholl)->pluck('id_teacher')->toArray();
            $data = DB::table('teachers')->whereIn('id',$in_rel)->select('id','teacher_name as name')->orderBy('teacher_name','asc')->get();

        } else {
            $in_rel = DB::table('student_class_relations')->where('id_class',$id)->where('is_active',1)->pluck('id_student')->toArray();
            $in_rel_parent = DB::table('student_parent_relations')->whereIn('id_student',$in_rel)->pluck('id_parent')->toArray();
            $data = DB::table('student_parents')->whereIn('id',$in_rel_parent)->whereNull('deleted_at')->select('id','student_parent_name as name')->orderBy('student_parent_name','asc')->get();

        }
        return json_encode($data);
    }

}