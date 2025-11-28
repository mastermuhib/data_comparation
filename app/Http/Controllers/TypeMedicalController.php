<?php

namespace App\Http\Controllers;

use App\Model\RoleModel;
use App\Model\CategoryMedical;
use App\Model\UserModel;
use App\Classes\upload;
use App\Traits\Fungsi;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\Handler;

class TypeMedicalController extends Controller
{
    public function index()
    {
        // dd(Kategori Medical::get());
        try {
            $data = parent::sidebar();
            if ($data['access'] == 0) {
                return redirect('/');
            } else {
                $role_id           = Auth::guard('admin')->user()->id_role;
                //dd($data['id_adm_dept']);
                return view('category_medical.index', $data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'TypeMedicalController@index';
            $insert_error = parent::InsertErrorSystem($data);
            $error = parent::sidebar();
            $error['id'] = $insert_error;
            return view('errors.index',$error); // jika Metode Get
            //return response()->json($data); // jika metode Post
        }
    }

    public function get_data_tipe_medical(Request $request)
    {  
        $posts = $this->GetDataP($request)->count();
        return $posts;

    }

    public function list_data(Request $request)
    {
        
        $limit = $request->input('length');
        $start = $request->input('start');
        $dir   = $request->input('order.0.dir');
        $posts = $this->GetDataP($request);

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
                        <a id="' . $d->id . '" aksi="nonaktif" tujuan="tipe_medical" data="data_tipe_medical" class="btn btn-success btn-sm aksi">Aktif</a>
                        </div>';
                } else {
                    $status = '<div style="float: left; margin-left: 5px;">
                        <button type="button" id="' . $d->id . '"data="data_tipe_medical" aksi="aktif" tujuan="tipe_medical" class="btn btn-danger btn-sm aksi">Tidak Aktif</button>
                        </div>';
                }

                $cek_role = parent::admin_data();
                if ($request->is_edit == 0) {
                    $action = " - ";
                    $edit = null;
                } else {
                    $edit = '<div style="float: left; margin-left: 5px;"><a href="/medical-record/kategori/'.$d->id.'" >
                                <button type="button" class="btn btn-warning btn-sm" style="min-width: 110px;margin-left: 2px;margin-top:3px;text-align:left"><i class="fa fa-edit"></i> Edit</button></a>
                            </div>';
                    $action =  $edit.'<div style="float: left; margin-left: 5px;">
                                    <button type="button" class="btn btn-danger btn-sm aksi btn-aksi" data="data_cabang"  id="' . $d->id . '" aksi="delete" tujuan="' . 'tipe_medical' . '" data="' . 'data_tipe_medical' . '" style="min-width: 110px;margin-left: 2px;margin-top:3px;text-align:left"><i class="fa fa-trash"></i> Hapus</button>
                                </div>';
                }
                //delete
                $text = strip_tags($d->description);
                $length_str = strlen($text);
                if ($length_str > 100) {
                    $text = substr($text, 0, 100).' ....';
                }

                $column['title']      = $d->category_name;
                $column['text'] = $text;
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

    public function GetDataP($request)
    {
    
        $posts = DB::table('medical_categories as p')
            ->whereNull('p.deleted_at')->where(function ($query) use ($request) {
                $search = $request->search;
                if ($search != null) {
                    $query->where(static function ($query2) use ($search) {
                        $query2->where('category_name','ilike', "%{$search}%");
                        $query2->orWhere('description','ilike', "%{$search}%");
                    });
                } 
                if ($request->tgl_start != null) {
                    $query->where('p.created_at','>=',$request->tgl_start);
                }
                if ($request->status != null) {
                    $query->where('p.status',$request->status);
                }

                if ($request->tgl_end != null) {
                    $query->where('p.created_at','<=',date('Y-m-d',strtotime($request->tgl_end . "+1 days")));
                }
            })
            ->select('p.*');
        if ($request->sort == 0) {
            $posts = $posts->orderBy('category_name','asc');
        } else if ($request->sort == 1) {
            $posts = $posts->orderBy('category_name','desc');
        } else if ($request->sort == 2) {
            $posts = $posts->orderBy('created_at','desc');
        } else {
            $posts = $posts->orderBy('created_at','asc');
        }

        
        return $posts;

    }

    public function post(Request $request)
    {
        try {

            $lower = strtolower($request->name);
            $slug  = preg_replace('/\s+/', '-', $lower);

            
            $insertpart=array(
                        'category_name'=>$request->name
                        ,'slug'=>$slug
                        ,'color'=>$request->color
                        ,'description'=>$request->text
                        ,'created_by'=>Auth::guard('admin')->user()->id
                        ,'status' => 1
                        ,'created_at' => date('Y-m-d H:i:s')
                        ,'updated_at' => date('Y-m-d H:i:s')
                        );
            $insert = CategoryMedical::insertGetId($insertpart);
            $data['message'] = 'Berhasil Menambah Data Kategori Medical';
            //logs
            $actifity = 'Menambah Data Kategori Medical';
            $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Menambah Data Kategori Medical '.$request->name.'','Kategori Medical');
                
            $data['code']    = 200;
            return response()->json($data);
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'TypeMedicalController@posts';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function update(Request $request)
    {
        try {

            $lower = strtolower($request->name);
            $slug  = preg_replace('/\s+/', '-', $lower);

            if (isset($request->id)) {
                $existing = CategoryMedical::where('id',$request->id)->first();
            }

            $insertpart=array(
                        'category_name'=>$request->name
                        ,'color'=>$request->color
                        ,'slug'=>$slug
                        ,'description'=>$request->text
                        ,'created_by'=>Auth::guard('admin')->user()->id
                        ,'updated_at' => date('Y-m-d H:i:s')
                        );
            $insert = CategoryMedical::where('id',$request->id)->update($insertpart);

            $data['message'] = 'Berhasil Megedit Data Kategori Medical';
            //logs
            $actifity = 'Megedit Data Kategori Medical';
            $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Mengedit Data Kategori Medical '.$request->name.'','Kategori Medical');

            $data['code']    = 200;
            return response()->json($data);
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'TypeMedicalController@update';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function detail($id)
    {
        try {
            $admin = CategoryMedical::find($id);
            
            $data = parent::sidebar();
            if ($data['access'] == 0) {
                return redirect('/');
            } else {
                $role_id           = Auth::guard('admin')->user()->id_role;
                $data['code']      = 200;
                $data['data']      = $admin;
                $data['data_role'] = RoleModel::whereNull('deleted_at')->where('status', 1)->get();
                return view('category_medical.dialog_edit', $data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'TypeMedicalController@detail';
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
            $admin         = CategoryMedical::find($request->id);
            $admin->status = 0;
            $admin->save();
            if ($admin) {
                $data['code']    = 200;
                $data['message'] = 'Berhasil Menonaktifkan Data Kategori Medical';
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Menon aktifkan Data Kategori Medical '.$admin->category_name.'','Kategori Medical');
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
            $data['controller'] = 'TypeMedicalController@nonactive';
            $insert_error = parent::InsertErrorSystem($data);
            
            return response()->json($data); // jika metode Post
        }
    }

    public function active(Request $request)
    {
        try {
            $admin         = CategoryMedical::find($request->id);
            $admin->status = 1;
            $admin->save();
            if ($admin) {
                $data['code']    = 200;
               
                $data['message'] = 'Berhasil Mengapprove Kategori Medical';
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Meng aktifkan Data Kategori Medical '.$admin->category_name.'','Kategori Medical');
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
            $data['controller'] = 'TypeMedicalController@active';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function delete(Request $request)
    {
        try {
            $admin             = CategoryMedical::find($request->id);
            $admin->status     = 0;
            $admin->deleted_at = date('Y-m-d');
            $admin->save();

            if ($admin) {
                $data['code']    = 200;
                $data['message'] = 'Berhasil Menghapus Data Kategori Medical';
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Menghapus Data Kategori Medical '.$admin->category_name.'','Kategori Medical');
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
            $data['controller'] = 'TypeMedicalController@delete';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

}