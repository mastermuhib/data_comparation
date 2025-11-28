<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Model\RoleModel;
use App\Model\LogAdmin;
use App\Model\LogApproval;
use App\Model\ParticipantModel;
use App\Model\MajorModel;
use App\Model\DepartementModel;
use App\Traits\Fungsi;
use Redirect;
use App\Exceptions\Handler;

class LogAdminController extends Controller
{
    public function index()
    {
        try {
        	$role_id = Auth::guard('admin')->user()->id_role;
            $data = parent::sidebar();
            if ($data['access'] == 0) {
                return redirect('/');
            } else {
                $data['name_adm'] = Auth::guard('admin')->user()->name;
                
                return view('logs.admin.index',$data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'LogAdminController@index';
            $insert_error = parent::InsertErrorSystem($data);
            $error = parent::sidebar();
            $error['id'] = $insert_error;
            return view('errors.index',$error); // jika Metode Get
            //return response()->json($data); // jika metode Post
        }
    }

    public function index_approval()
    {
        try {
            $role_id = Auth::guard('admin')->user()->id_role;
            $data = parent::sidebar();
            if ($data['access'] == 0) {
                return redirect('/');
            } else {
                $data['name_adm'] = Auth::guard('admin')->user()->name;
                
                return view('logs.admin.index_approval',$data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'LogAdminController@index_approval';
            $insert_error = parent::InsertErrorSystem($data);
            $error = parent::sidebar();
            $error['id'] = $insert_error;
            return view('errors.index',$error); // jika Metode Get
            //return response()->json($data); // jika metode Post
        }
    }

    public function list_data(Request $request)
    {

        $totalData = LogAdmin::join('administrators as a','a.id','log_admins.id_admin')->whereNull('deleted_at')->count();

        //$totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $dir   = $request->input('order.0.dir');
        $search = $request->input('search.value');

        $posts = LogAdmin::join('administrators as a','a.id','log_admins.id_admin')->whereNull('deleted_at')->orderBy('log_admins.created_at','desc')->where(function ($query) use ($search,$request) {
            if ($search != null) {
                $query->where('admin_name','ilike', "%{$search}%")->orWhere('activity','ilike', "%{$search}%");
            } 
        });
        if (Auth::guard('admin')->user()->is_superadmin == 0) {
            $posts = $posts->where('id_admin',Auth::guard('admin')->user()->id);
        }
        $posts = $posts->select('log_admins.*','admin_name');

        $totalFiltered = $posts->count();
        $posts = $posts->limit($limit)->offset($start)->get();

        $data = array();
        if (!empty($posts)) {

            $no = 0;
           
            foreach ($posts as $d) {
               $no = $no + 1;

                $nestedData['no']           = $no;
                $nestedData['name']         = $d->admin_name;
                $nestedData['menu']    = $d->menu;
                $nestedData['aktifitas']       = $d->activity;
                $nestedData['tanggal']       = date('d F Y H:i',strtotime($d->created_at));
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

    public function list_data_approval(Request $request)
    {

        $limit = $request->input('length');
        $start = $request->input('start');
        $dir   = $request->input('order.0.dir');
        $search = $request->input('search.value');

        $posts = LogApproval::join('administrators as a','a.id','logs_approval.id_admin')->join('participant as p','p.id','logs_approval.id_user')->whereNull('p.deleted_at')->whereNull('a.deleted_at')->orderBy('logs_approval.created_at','desc')->where(function ($query) use ($search,$request) {
            if ($search != null) {
                $query->where('admin_name','ilike', "%{$search}%");
                $query->orWhere('participant_name','ilike', "%{$search}%");
                $query->orWhere('participant_email','ilike', "%{$search}%");
                $query->orWhere('participant_phone','ilike', "%{$search}%");
                $query->orWhere('participant_nik','ilike', "%{$search}%");
                $query->orWhere('participant_nik2','ilike', "%{$search}%");
                $query->orWhere('participant_nik3','ilike', "%{$search}%");
            } 
        })->select('logs_approval.*','admin_name','participant_name','p.id as id_p','participant_email');

        $totalFiltered = $posts->count();
        $totalData = $totalFiltered;
        $posts = $posts->limit($limit)->offset($start)->get();

        $data = array();
        if (!empty($posts)) {

            $no = 0;
           
            foreach ($posts as $d) {
               $no = $no + 1;
               if ($d->status == 0) {
                  $status = "Membatalkan Approval / Penolakan";
               } else if($d->status == 1){
                  $status = "Mengapprove Peserta";
               } else {
                   $status = "Menolak Peserta";
               }

                $nestedData['no']       = $no;
                $nestedData['name']     = $d->admin_name;
                $nestedData['status']   = $status;
                $nestedData['peserta']  = $d->participant_name;
                $nestedData['jurusan']  = $this->getJurusan($d->id_p,$d->tingkatan);
                $nestedData['email']    = $d->participant_email;
                $nestedData['tanggal']  = date('d F Y H:i',strtotime($d->created_at));
                $data[]                 = $nestedData;
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

    public function getJurusan($id,$tingkatan) {
        $return = null;
        $data = ParticipantModel::where('id',$id)->get();
        $data_jurusan = null;
        $data_departement = null;
        $thn_masuk = null;
        $nik = null;
        if($tingkatan == '1') {
            if ($data[0]->id_majority != null) {
                // if ($data[0]->is_approved == 0) {
                //     $status = '<span class="text-info">Menunggu Approval</span>';
                // } elseif($data[0]->is_approved == 1) {
                //     $status = '<span class="text-success">Diterima</span>';
                // } else {
                //     $status = '<span class="text-danger">Ditolak</span>';
                // }
                $status = null;

                $jurusan = MajorModel::where('id',$data[0]->id_majority)->pluck('major_name');
                $departement = DepartementModel::where('id',$data[0]->id_departement)->pluck('departement_name');
                if ($jurusan->isNotEmpty()) {
                    $data_jurusan = $jurusan[0];
                }
                if ($departement->isNotEmpty()) {
                    $data_departement = $departement[0];
                }

                if ($data[0]->nik != null) {
                    $nik = '<b class="ml-1"> | '.$data[0]->nik.' | </b>';
                }

                if ($data[0]->entry_year != null) {
                    $thn_masuk = '('.$data[0]->entry_year.' - '.$data[0]->graduated_year.')';
                }
                $return = '<p><b>'.$data[0]->study_level.'</b> - '.$data_departement.' - '.$data_jurusan.' '.$nik.' '.$thn_masuk.'<span class="ml-2">'.$status.'</span></p>';
            }
        } else if($tingkatan == '2') {
            if ($data[0]->id_majority2 != null) {
                // if ($data[0]->is_approved2 == 0) {
                //     $status = '<span class="text-info">Menunggu Approval</span>';
                // } elseif($data[0]->is_approved2 == 1) {
                //     $status = '<span class="text-success">Diterima</span>';
                // } else {
                //     $status = '<span class="text-danger">Ditolak</span>';
                // }
                $status = null;

                $jurusan = MajorModel::where('id',$data[0]->id_majority2)->pluck('major_name');
                $departement = DepartementModel::where('id',$data[0]->id_departement2)->pluck('departement_name');
                if ($jurusan->isNotEmpty()) {
                    $data_jurusan = $jurusan[0];
                }
                if ($departement->isNotEmpty()) {
                    $data_departement = $departement[0];
                }

                if ($data[0]->nik2 != null) {
                    $nik = '<b class="ml-1"> | '.$data[0]->nik2.' | </b>';
                }

                if ($data[0]->entry_year2 != null) {
                    $thn_masuk = '('.$data[0]->entry_year2.' - '.$data[0]->graduated_year2.')';
                }
                $return = '<p><b>'.$data[0]->study_level2.'</b> - '.$data_departement.' - '.$data_jurusan.' '.$nik.' '.$thn_masuk.'<span class="ml-2">'.$status.'</span></p>';
                
            }
        } else if($tingkatan == '3') {
            if ($data[0]->id_majority3 != null) {
                // if ($data[0]->is_approved3 == 0) {
                //     $status = '<span class="text-info">Menunggu Approval</span>';
                // } elseif($data[0]->is_approved3 == 1) {
                //     $status = '<span class="text-success">Diterima</span>';
                // } else {
                //     $status = '<span class="text-danger">Ditolak</span>';
                // }
                $status = null;

                $jurusan = MajorModel::where('id',$data[0]->id_majority3)->pluck('major_name');
                $departement = DepartementModel::where('id',$data[0]->id_departement3)->pluck('departement_name');
                if ($jurusan->isNotEmpty()) {
                    $data_jurusan = $jurusan[0];
                }
                if ($departement->isNotEmpty()) {
                    $data_departement = $departement[0];
                }

                if ($data[0]->nik3 != null) {
                    $nik = '<b class="ml-1"> | '.$data[0]->nik3.' | </b>';
                }

                if ($data[0]->entry_year3 != null) {
                    $thn_masuk = '('.$data[0]->entry_year3.' - '.$data[0]->graduated_year3.')';
                }
                $return = '<p><b>'.$data[0]->study_level3.'</b> - '.$data_departement.' - '.$data_jurusan.' '.$nik.' '.$thn_masuk.'<span class="ml-2">'.$status.'</span></p>';
                
            }
        }

        return $return;

                
    }

}