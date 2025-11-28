<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Model\RoleModel;
use App\Model\LogError;
use App\Traits\Fungsi;
use Redirect;
use App\Exceptions\Handler;

class LogErrorController extends Controller
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
                
                return view('logs.error.index',$data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'LogErrorController@index';
            $insert_error = parent::InsertErrorSystem($data);
            $error = parent::sidebar();
            $error['id'] = $insert_error;
            return view('errors.index',$error); // jika Metode Get
            //return response()->json($data); // jika metode Post
        }
    }

    public function list_data(Request $request)
    {

        $totalData = LogError::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $dir   = $request->input('order.0.dir');
        $search = $request->input('search.value');

        $posts = LogError::leftJoin('students as p','p.id','log_errors.id_user')->leftJoin('administrators as a','a.id','log_errors.id_user')->orderBy('log_errors.failed_at','desc')->where(function ($query) use ($search,$request) {
            if ($search != null) {
                $query->where('student_name','ilike', "%{$search}%")->orWhere('admin_name','ilike', "%{$search}%")->orWhere('controller','ilike', "%{$search}%");
            } 
        });

        if (Auth::guard('admin')->user()->is_superadmin == 0) {
            $posts = $posts->where('id_user',Auth::guard('admin')->user()->id);
        }

        $posts = $posts->select('log_errors.*','student_name','admin_name');

        $totalFiltered = $posts->count();
        $posts = $posts->limit($limit)->offset($start)->get();

        $data = array();
        if (!empty($posts)) {

            $no = 0;
           
            foreach ($posts as $d) {
                $no = $no + 1;
                if ($d->tipe_user == 1) {
                    $name = $d->student_name;
                } else if($d->tipe_user == 2) {
                    $name = $d->admin_name;
                }

                if ($d->is_view == 1) {
                    $is_view = '<span class="text-success"> Sudah dilihat </span>';
                } else {
                    $is_view = 'Belum dilihat';
                }

                if ($d->is_solved == 1) {
                    $is_solved = '<span class="text-success"> Sudah diperbaiki </span>';
                } else {
                    $is_solved = "Belum diperbaiki";
                }

                if ($d->tipe_user == 1) {
                    $tipe = "Peserta";
                } else if ($d->tipe_user == 2) {
                    $tipe = "Admin";
                }

                $action = '<a href="javascript:void(0)" class="text-success"><i class="fas fa-eye"></i></a>';

                $nestedData['no']           = $no;
                $nestedData['name']         = $name;
                $nestedData['tipe']         = $tipe;
                $nestedData['controller']    = $d->controller.' line '.$d->line_error;
                $nestedData['is_view']       = $is_view;
                $nestedData['is_solved']       = $is_solved;
                $nestedData['tanggal']       = date('d F Y H:i',strtotime($d->failed_at));
                $nestedData['action']       = $action;
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

}