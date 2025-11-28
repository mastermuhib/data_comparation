<?php

namespace App\Http\Controllers;

use App\Model\RoleModel;
use App\Model\PromosiWebsiteModel;
use App\Model\UserModel;
use App\Classes\upload;
use App\Traits\Fungsi;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\Handler;

class MedicalController extends Controller
{
    public function index()
    {
        // dd(Medical Checkup::get());
        try {
            $data = parent::sidebar();
            if ($data['access'] == 0) {
                return redirect('/');
            } else {
                $role_id           = Auth::guard('admin')->user()->id_role;
                //dd($data['id_adm_dept']);
                return view('medical_checkup.index', $data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'MedicalController@index';
            $insert_error = parent::InsertErrorSystem($data);
            $error = parent::sidebar();
            $error['id'] = $insert_error;
            return view('errors.index',$error); // jika Metode Get
            //return response()->json($data); // jika metode Post
        }
    }

    public function get_data_medical_checkup(Request $request)
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
                        <a id="' . $d->id . '" aksi="nonaktif" tujuan="medical_checkup" data="data_medical_checkup" class="btn btn-success btn-sm aksi">Aktif</a>
                        </div>';
                } else {
                    $status = '<div style="float: left; margin-left: 5px;">
                        <button type="button" id="' . $d->id . '"data="data_medical_checkup" aksi="aktif" tujuan="medical_checkup" class="btn btn-danger btn-sm aksi">Tidak Aktif</button>
                        </div>';
                }

                $cek_role = parent::admin_data();
                if ($cek_role['role'] == 'viewer') {
                    $action = " - ";
                    $edit = null;
                } else {
                    $edit = '<div style="float: left; margin-left: 5px;"><a href="/menu-website/medical-checkup/'.$d->id.'" >
                                <button type="button" class="btn btn-warning btn-sm" style="min-width: 110px;margin-left: 2px;margin-top:3px;text-align:left"><i class="fa fa-edit"></i> Edit</button></a>
                            </div>';
                    $action =  $edit.'<div style="float: left; margin-left: 5px;">
                                    <button type="button" class="btn btn-danger btn-sm aksi btn-aksi" data="data_cabang"  id="' . $d->id . '" aksi="delete" tujuan="' . 'medical_checkup' . '" data="' . 'data_medical_checkup' . '" style="min-width: 110px;margin-left: 2px;margin-top:3px;text-align:left"><i class="fa fa-trash"></i> Hapus</button>
                                </div>';
                }
                //delete
                $icon = "No Foto";
                if ($d->image != null) {
                    $icon = '<img src="https://kandidat.s3-id-jkt-1.kilatstorage.id/'.$d->image.'" style="width:100px;">';
                }
                $text = strip_tags($d->description);
                $length_str = strlen($text);
                if ($length_str > 100) {
                    $text = substr($text, 0, 100).' ....';
                }

                $column['icon'] = $icon;
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
    
        $posts = DB::table('menu_websites as p')
            ->whereNull('p.deleted_at')->where('is_medical',1)->where(function ($query) use ($request) {
                $search = $request->search;
                if ($search != null) {
                    $query->where(static function ($query2) use ($search) {
                        $query2->where('description','ilike', "%{$search}%");
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
        
        if ($request->sort == 2) {
            $posts = $posts->orderBy('created_at','desc');
        } else {
            $posts = $posts->orderBy('created_at','asc');
        }

        
        return $posts;

    }

    public function post(Request $request)
    {
        try {

            if (isset($request->id)) {
                $existing = PromosiWebsiteModel::where('id',$request->id)->first();
            }

            $input = $request->all();
            if ($request->file('profile')) {
                $upload = new upload();
                $profile  = $upload->img2($request->profile);
            } else {
                if (isset($request->id)) {
                    $profile = $existing->icon;
                } else {
                    $profile = null;
                }
            }

            if (isset($request->id)) {

                $insertpart=array(
                            'description'=>$request->text
                            ,'created_by'=>Auth::guard('admin')->user()->id
                            ,'image'=>$profile
                            ,'updated_at' => date('Y-m-d H:i:s')
                            );
                $insert = PromosiWebsiteModel::where('id',$request->id)->update($insertpart);

                $data['message'] = 'Berhasil Megedit Data Medical Checkup';
                //logs
                $actifity = 'Megedit Data Medical Checkup';
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Mengedit Data Medical Checkup '.$request->name.'','Medical Checkup');
            } else {
                $insertpart=array(
                            'description'=>$request->text
                            ,'created_by'=>Auth::guard('admin')->user()->id
                            ,'image'=>$profile
                            ,'is_promotion'=>0
                            ,'is_medical' => 1
                            ,'created_at' => date('Y-m-d H:i:s')
                            ,'updated_at' => date('Y-m-d H:i:s')
                            );
                $insert = PromosiWebsiteModel::insertGetId($insertpart);
                $data['message'] = 'Berhasil Menambah Data ';
                //logs
                $actifity = 'Menambah Data Medical Checkup';
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Menambah Data Medical Checkup '.$request->name.'','Medical Checkup');
            }
                
            $data['code']    = 200;
            return response()->json($data);
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'MedicalController@posts';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function detail($id)
    {
        try {
            $admin = PromosiWebsiteModel::find($id);
            
            $data = parent::sidebar();
            if ($data['access'] == 0) {
                return redirect('/');
            } else {
                $role_id           = Auth::guard('admin')->user()->id_role;
                $data['code']      = 200;
                $data['data']      = $admin;
                $data['data_role'] = RoleModel::whereNull('deleted_at')->where('status', 1)->get();
                return view('medical_checkup.dialog_edit', $data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'MedicalController@detail';
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
            $admin         = PromosiWebsiteModel::find($request->id);
            $admin->status = 0;
            $admin->save();
            if ($admin) {
                $data['code']    = 200;
                $data['message'] = 'Berhasil Menonaktifkan Data Medical Checkup';
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Menon aktifkan Data Medical Checkup '.$admin->type_name.'','Medical Checkup');
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
            $data['controller'] = 'MedicalController@nonactive';
            $insert_error = parent::InsertErrorSystem($data);
            
            return response()->json($data); // jika metode Post
        }
    }

    public function active(Request $request)
    {
        try {
            $admin         = PromosiWebsiteModel::find($request->id);
            $admin->status = 1;
            $admin->save();
            if ($admin) {
                $data['code']    = 200;
               
                $data['message'] = 'Berhasil Mengapprove Medical Checkup';
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Meng aktifkan Data Medical Checkup '.$admin->type_name.'','Medical Checkup');
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
            $data['controller'] = 'MedicalController@active';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function delete(Request $request)
    {
        try {
            $admin             = PromosiWebsiteModel::find($request->id);
            $admin->status     = 0;
            $admin->deleted_at = date('Y-m-d');
            $admin->save();

            if ($admin) {
                $data['code']    = 200;
                $data['message'] = 'Berhasil Menghapus Data Medical Checkup';
                $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Menghapus Data Medical Checkup '.$admin->type_name.'','Medical Checkup');
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
            $data['controller'] = 'MedicalController@delete';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }


    public function get_role($id,$jenis)
    {
        $cek = DB::table('roles')->where('id',$id)->pluck('slug');
        $data['jenis'] = $cek[0];
        //dd($data['jenis']);
        if ($jenis == 'company') {

            $data['data_company'] = DB::table('company_registrations')->whereNull('is_delete')->get();

            return view('medical_checkup.get_company', $data);
        } else {
            return view('medical_checkup.get_kode', $data);
        }
        
    }
}