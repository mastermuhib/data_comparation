<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\Fungsi;
use App\Classes\upload;
use App\Model\UserModel;
use App\Model\CabangModel;
use App\Model\RoleModel;
use Auth;
use DB;
use Redirect;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\Handler;
class UserController extends Controller
{
    public function index()
    {
        $role_id = Auth::guard('admin')->user()->role_id;
        $data = parent::sidebar();
        if ($data['access'] == 0) {
            return redirect('/');
        } else {
            $data['name_adm'] = Auth::guard('admin')->user()->name;
            $nama_role = RoleModel::where('id',$role_id)->pluck('name');
            $data['data_cabang'] = CabangModel::whereNull('deleted_at')->get();

            return view('user.index', $data);
        }
        
    }

    public function list_data(Request $request)
    {
        $product = $this->AtDataUser($request);
        if ($request->sort == 0) {
            $product = $product->orderBy('user_name','asc');
        }
        if ($request->sort == 1) {
            $product = $product->orderBy('user_name','desc');
        }
        if ($request->sort == 2) {
            $product = $product->orderBy('created_at','asc');
        }
        if ($request->sort == 3) {
            $product = $product->orderBy('created_at','desc');
        }

        $product = $product->select('users.*');
        $limit = $request->input('length');
        $start = $request->input('start');
        $dir   = $request->input('order.0.dir');

        $totalFiltered = $product->count();
        $totalData = $product->count();

        $product = $product->limit($limit)->offset($start)->get();

        $data = array();
        $no   = 0;
        foreach ($product as $d) {
            $ids = "'select_txt_".$d->id."'";
            if ($d->status == 1) {
                $status = '<div style="float: left; margin-left: 5px;">
                    <button type="button" id="' . $d->id . '" aksi="nonaktif" tujuan="master_cabang" data="data_cabang" class="btn btn-success btn-sm aksi">Aktif</button>
                    </div>';
            } else {
                $status = '<div style="float: left; margin-left: 5px;">
                    <button type="button" id="' . $d->id . '" data="data_cabang" aksi="aktif" tujuan="master_cabang" class="btn btn-warning btn-sm aksi">Tidak Aktif</button>
                    </div>';
            }

            //$action = '<a href="javascript:void(0)" id="'.$d->id.'" class="btn btn-success btn-sm d_detail"><span class="navi-icon"><i class="fas fa-edit"></i></span><span class="navi-text">Edit</span></a>';
            $action = '<a href="/user/list-user/'.$d->id.'"  class="btn btn-success btn-sm d_detail"><span class="navi-icon"><i class="fas fa-eye"></i></span><span class="navi-text">Detail</span></a>';
            $action .= '<a href="javascript:void(0)" class="btn btn-danger ml-2 btn-sm aksi btn-aksi" id="' . $d->id.'" aksi="delete" tujuan="' . 'user' . '" data="' . 'data_user' . '"><span class="navi-icon"><i class="fa fa-trash"></i></span><span class="navi-text">Hapus</span></a>';
            $no     = $no + 1;
            $column['name']      = $d->user_name;
            $column['nik']      = $d->nik;
            $column['phone'] = $d->user_phone;
            $column['email'] = $d->user_email;
            $column['status'] = $status;
            $column['date'] = date('d F Y H:i',strtotime($d->created_at));
            $column['actions']   = $action;
            $data[]              = $column;
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data,
        );

        echo json_encode($json_data);
    }

    public function get_data_user(Request $request)
    {
        $posts = $this->AtDataUser($request);
        $return = $posts->count();
        return $return;
    }

    public function AtDataUser($request){
        $posts = UserModel::whereNull('deleted_at')->where(function ($query) use ($request) {
            $search = $request->search;
            if ($request->search != null) {
                $query->where(static function ($query2) use ($search) {
                    $query2->where('user_name','ilike', "%{$search}%");
                    $query2->orWhere('user_phone','ilike', "%{$search}%");
                    $query2->orWhere('user_email','ilike', "%{$search}%");
                    $query2->orWhere('nik','ilike', "%{$search}%");
                });
            } 
            if ($request->tgl_start != null) {
                $query->whereDate('created_at','>=',$request->tgl_start);   
            }
            if ($request->tgl_end != null) {
                $query->whereDate('created_at','<=',date('Y-m-d',strtotime($request->tgl_end . "+1 days")));   
            } 
            if($request->status != null){
                $query->where('status',$request->status);
            } 
        });

        return $posts;
                    
    }

    public function post(Request $request)
    {
        $input = $request->all();
        if ($request->file('icon')) {
            $upload = new upload();
            $profile  = $upload->img2($request->icon);
        } else {
            $profile = null;
        }
        $lower = strtolower($request->name);
        $slug  = preg_replace('/\s+/', '-', $lower);
        $id_admin    = Auth::guard('admin')->user()->id;
        $insertadmin = array(
            'producs_name' => $request->name,
            'description' => $request->deskripsi,
            'price_walkin' => $request->price_walkin,
            'price_home_service' => $request->price_home_service,
            'person_can_discount' => $request->person_can_discount,
            'is_percentage' => $request->is_percentage,
            'nominal_discount' => $request->nominal_discount,
            'amount_discount' => $request->amount_discount,
            'is_max_pot' => $request->is_max_pot,
            'maksimal_discount' => $request->maksimal_discount,
            'id_admin' => $id_admin,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'slug' => $slug,
            'icon' => $profile,
            'branch_id' => $request->branch_id,
            'status' => 1, 
            'created_at' => date('Y-m-d H:i:s'), 
            'updated_at' => date('Y-m-d H:i:s'),
        );
        $insert = UserModel::insertGetId($insertadmin);
        if ($insert) {
            // $insertlog = array(
            //     'id_admin' => $id_admin
            //     , 'actifity' => 'Menambah Data City Baru (' . $request->name . ')'
            //     , 'status' => 1
            //     ,'id_object'=> $insert
            //     , 'type_object' => 21
            //     , 'created_at' => date('Y-m-d H:i:s')
            //     , 'updated_at' => date('Y-m-d H:i:s'),
            // );
            // $insert2         = LogAdmin::create($insertlog);
            $data['code']    = 200;
            $data['message'] = 'Berhasil menambah Data Cabang';
            return response()->json($data);
        } else {
            $data['code']    = 500;
            $data['message'] = 'Maaf Ada yang Error ';
            return response()->json($data);
        }
    }

    public function nonactive(Request $request)
    {
        $nonactive         = UserModel::find($request->id);
        $nonactive->status = 0;
        $nonactive->save();

        if ($nonactive) {
            $id_admin    = Auth::guard('admin')->user()->id;
            // $insertlog = array(
            //     'id_admin' => $id_admin
            //     , 'actifity' => 'menonaktifkan Data City (' . $nonactive->name . ')'
            //     , 'status' => 1
            //     ,'id_object'=> $request->id
            //     , 'type_object' => 21
            //     , 'created_at' => date('Y-m-d H:i:s')
            //     , 'updated_at' => date('Y-m-d H:i:s'),
            // );
            // $insert2         = LogAdmin::create($insertlog);
            $data['code']    = 200;
            $data['message'] = 'Berhasil Menon Aktifkan Data User';
            return response()->json($data);
        } else {
            $data['code']    = 500;
            $data['message'] = 'Maaf Ada yang Error ';
            return response()->json($data);
        }
    }

    public function active(Request $request)
    {
        $nonactive         = UserModel::find($request->id);
        $nonactive->status = 1;
        $nonactive->deleted_at = null;
        $nonactive->save();

        if ($nonactive) {
            $id_admin    = Auth::guard('admin')->user()->id;
            // $insertlog = array(
            //     'id_admin' => $id_admin
            //     , 'actifity' => 'menonaktifkan Data City (' . $nonactive->name . ')'
            //     , 'status' => 1
            //     ,'id_object'=> $request->id
            //     , 'type_object' => 21
            //     , 'created_at' => date('Y-m-d H:i:s')
            //     , 'updated_at' => date('Y-m-d H:i:s'),
            // );
            // $insert2         = LogAdmin::create($insertlog);
            $data['code']    = 200;
            $data['message'] = 'Berhasil Meng Aktifkan Data User';
            return response()->json($data);
        } else {
            $data['code']    = 500;
            $data['message'] = 'Maaf Ada yang Error ';
            return response()->json($data);
        }
    }

    public function reset_password(Request $request)
    {
        try {
            $pass = $this->randomPassword();
            $admin = UserModel::where('id',$request->id)->update(['password'=>Hash::make($pass),'confirm_password'=>encrypt($pass)]);
            $user = UserModel::where('id',$request->id)->first();
            if ($admin) {
                $data['code']    = 200;
                $data['message'] = 'Berhasil Mereset Password Participant';

                $message1 = 'Rahasia! Halo pelanggan setia Genika Lab! Password: '.$pass.' bisa kamu gunakan untuk login di aplikasi kamu';
                $send_message = Fungsi::BlastWA($user->user_phone,$message1);
                //dd($send_message);
                //$insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Mereset Passsword Peserta '.$request->id.'','Participant');
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
            $data['controller'] = 'userController@reset_password';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }
    }

    public function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&()';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 11; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public function delete(Request $request)
    {
        $delete             = UserModel::find($request->id);
        $delete->status     = 0;
        $delete->deleted_at = date('Y-m-d');
        $delete->save();

        if ($delete) {
            $id_admin    = Auth::guard('admin')->user()->id;
            // $insertlog = array(
            //     'id_admin' => $id_admin
            //     , 'actifity' => 'Menghapus Data City(' . $delete->name . ')'
            //     , 'status' => 1
            //     ,'id_object'=> $request->id
            //     , 'type_object' => 21
            //      , 'created_at' => date('Y-m-d H:i:s')
            //      , 'updated_at' => date('Y-m-d H:i:s'),
            // );
            // $insert2         = LogAdmin::create($insertlog);
            $data['code']    = 200;
            $data['message'] = 'Berhasil Menghapus Data User';
            return response()->json($data);
        } else {
            $data['code']    = 500;
            $data['message'] = 'Maaf Ada yang Error ';
            return response()->json($data);
        }
    }

    public function detail($id)
    {
        $query = UserModel::find($id);
        if ($query) {
            $data['code']          = 200;
            $data['data']          = $query;
            // return response()->json($data);
            return view('user.detail', $data);
        } else {
            $data['code'] = 500;
            $data['data'] = 'Maaf Data Kosong';
            return response()->json($data);
        }
    }

    public function detail_user($id)
    {
        $query = UserModel::find($id);
        $role_id = Auth::guard('admin')->user()->role_id;
        $data = parent::sidebar();
        if ($data['access'] == 0) {
            return redirect('/');
        } else {
            $data['name_adm'] = Auth::guard('admin')->user()->name;
            $nama_role = RoleModel::where('id',$role_id)->pluck('name');
            $data['data_cabang'] = CabangModel::whereNull('deleted_at')->get();
            $data['negara'] = DB::table('countries')->whereNull('deleted_at')->get();
            if ($query) {
                $data['code']          = 200;
                $data['data']          = $query;
                // return response()->json($data);
                return view('user.edit', $data);
            } else {
                $data['code'] = 500;
                $data['data'] = 'Maaf Data Kosong';
                return response()->json($data);
            }
        }
    }

    public function update(Request $request)
    {
        $input = $request->except('_token');
        $update = UserModel::where('id', $request->id)->update($input);
        if ($update) {
            //simpan di system roche
            $patient = DB::table('patients')->where('is_self',1)->where('id_user',$request->id)->first();
            $alamat = $request->address;
            if ($request->address == '' || $request->address == null) {
                $alamat = "Indonesia";
            }
            $rochesystem = parent::UpdatePasien($request->user_name,$request->gender,date('Y-m-d', strtotime($request->birthday)),$alamat,$request->user_email,$patient->patient_code);
            $data['code']    = 200;
            $data['message'] = 'Berhasil Mnegupdate Data User';
            return response()->json($data);
        } else {
            $data['code']    = 500;
            $data['message'] = 'Maaf Ada yang Error ';
            return response()->json($data);
        }
    }

    public function search_person(Request $request){
        $search = $request->input('term', '');
        $persons = DB::table('users')->whereNull('users.deleted_at')
            ->where(function ($query) use ($search) {
                $query->where('user_name','ilike', '%'.$search.'%')->orWhere('nik','ilike', '%'.$search.'%')->orWhere('user_email','ilike', '%'.$search.'%')->orWhere('user_phone','ilike', '%'.$search.'%');
        })->get();

        foreach ($persons as $key => $value) {
            
            $nik = $value->nik; 
            $persons[$key]->id = $value->id;
            $persons[$key]->text = $value->user_name." (".$nik." ))";
        }

        return ['results' => $persons];

    }

    public function data_pemesan($id){
        $data['data'] = DB::table('users')->where('id',$id)->first();
        return view('transaksi.data_pemesan', $data);

    }

    public function data_pasien($id){
        $data = DB::table('patients')->where('id_user',$id)->select('id','patient_name as name')->get();
        if ($data->isNotEmpty()) {
            echo json_encode($data);
        } else {
            $return = "404";
            return $return;
        }   
    }

    public function ganti_pasien($no,$id){
        $data['no'] = $no;
        if ($id == '0') {
            $data['id'] = 0;
            return view('transaksi.data_pasien', $data);
        } else {
            $data['id'] = 1;
            $data['data'] = DB::table('patients')->where('id',$id)->first();
            return view('transaksi.data_pasien', $data);
        }
    }

    public function get_keluarga($id){

        return view('user.data_family');
    }

    public function get_transaksi($id){

        return view('user.data_transaksi');
    }

    public function get_hasil($id){

        return view('user.data_hasil');
    }
    
}