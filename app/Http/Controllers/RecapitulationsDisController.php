<?php

namespace App\Http\Controllers;

use App\Model\RoleModel;
use App\Model\RecapModel;
use App\Model\DistrictModel;
use App\Model\DissabilityModel;
use App\Classes\upload;
use App\Traits\Fungsi;
use Maatwebsite\Excel\Facades\Excel;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\Handler;


class RecapitulationsDisController extends Controller
{
    public function index()
    {
        try {
            $data = parent::sidebar();
            if ($data['access'] == 0) {
                return redirect('/');
            } else {
                $role_id           = Auth::guard('admin')->user()->id_role;
                
                $data['data_kec'] = DistrictModel::whereNull('deleted_at')->select('id','name')->get();
                $data['data_disabilitas'] = DissabilityModel::select('id','name')->get();
                $data['triwulan'] = DB::table('t_steps')->where('is_disabilitas',1)->select('id','name','is_active','triwulan','year')->orderBy('is_active','desc')->get();
                //dd($data['id_adm_dept']);
                return view('recap.disabilitas.index', $data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'RecapitulationsDisController@index';
            $insert_error = parent::InsertErrorSystem($data);
            $error = parent::sidebar();
            $error['id'] = $insert_error;
            return view('errors.index',$error); // jika Metode Get
            //return response()->json($data); // jika metode Post
        }
    }

    
    public function list(Request $request)
    {
        
        $limit = $request->input('length');
        $start = $request->input('start');
        $dir   = $request->input('order.0.dir');
        $status = $request->status;
        $search = $request->search;

        $posts = DB::table('t_recap_dis as p')->join('t_dissability as cs','cs.id','p.id_disability')->join('districts as c','c.id','p.id_district');
        
        if ($request->year != null) {
            $posts = $posts->where('year',$request->year);
        }

        if ($request->disabilitas != null) {
            $posts = $posts->where('id_disability',$request->disabilitas);
        }

        if ($request->id_kec != null) {
            $posts = $posts->where('id_district',$request->id_kec);
        }

        if ($request->triwulan != null) {
            $posts = $posts->where('triwulan',$request->triwulan);
        }

        if (isset($request->status)) {
            $posts = $posts->whereIn('p.s_status',$request->status);
        }

        $posts = $posts->select('cs.id as cs_id','c.id as c_id','c.name as kecamatan','cs.name as disabilitas','triwulan','year')->distinct();
        $posts = $posts->orderBy('c.id','asc')->orderBy('cs.id','asc');

        $totalFiltered = $posts->get()->count();
        $posts = $posts->limit($limit)->offset($start)->get();
        
        $data = array();
        if (!empty($posts)) {
            $no = $start;
            foreach ($posts as $d) {
                $no = $no + 1;

                $action =  '<div style="float: left; margin-left: 5px;">
                                    <button type="button" class="btn btn-danger btn-sm aksi btn-aksi"  id="' . $d->c_id . '" aksi="delete" tujuan="' . 'pemeriksaan' . '" data="' . '/data_pemeriksaan' . '" style="min-width: 110px;margin-left: 2px;margin-top:3px;text-align:left"><i class="fa fa-trash"></i> Hapus</button>
                                </div>';
                //$total = (int)$d->total_male + (int)$d->total_female;
                $male = $this->DataD($d->c_id,$d->cs_id,$d->triwulan,$d->year,$status,'total_male');
                $female = $this->DataD($d->c_id,$d->cs_id,$d->triwulan,$d->year,$status,'total_female'); 
                $total = (int)$male + (int)$female;               
                
                //delete
                $column['no']       = $no;
                $column['kec']      = $d->kecamatan;
                $column['disabilitas'] = $d->disabilitas;
                $column['male']     = $male;
                $column['female']   = $female;
                $column['total']    = $total;
                $column['actions']  = $action;
                $data[]             = $column;

            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalFiltered),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data,
        );
        echo json_encode($json_data);
    }


    public function DataD($kec,$kualif,$triwulan,$year,$status,$coloumn){
        $posts = DB::table('t_recap_dis as p')->join('t_dissability as cs','cs.id','p.id_disability')->join('districts as c','c.id','p.id_district')->where('p.id_district',$kec)->where('id_disability',$kualif)->where('triwulan',$triwulan)->where('year',$year)->whereIn('p.s_status',$status)->sum($coloumn);
        return $posts;
    }

    public function DataDT($group,$kualif,$coloumn){
        $posts = DB::table('t_recap_dis as p')->join('t_clasifications as cs','cs.id','p.id_clasification')->join('villages as v','v.id','p.id_village')->join('districts as c','c.id','v.district_id')->where('group',$group)->where('id_clasification',$kualif)->sum($coloumn);
        return $posts;
    }

    public function calculate(Request $request){
        try {
            
            $district = DB::table('districts')->select('id')->get();
            $disabilitas = DB::table('t_dissability')->get();
            $triwulan = $request->triwulan;
            $year = $request->year;
            $group = date('YmdHis');
            $s_ktp = array('s','b');
            $s_mariage = array('S','B','P');
            $s_status = array('aktif','baru','tms','ubah','delete');
            //dd($village);
            $check = DB::table('t_steps')->where('year',$request->year)->where('triwulan',$request->triwulan)->where('is_disabilitas',1)->count();
            if ($check > 0) {
                DB::table('t_recap_dis')->where('year',$request->year)->where('triwulan',$request->triwulan)->delete();
            }
            foreach ($district as $k => $v) {
                
                $array_village = DB::table('villages')->where('district_id',$v->id)->pluck('id')->toArray();
                foreach ($disabilitas as $a => $b) {
                    for ($k=0; $k < count($s_ktp); $k++) { 
                        for ($m=0; $m < count($s_mariage); $m++) { 
                            for ($s=0; $s < count($s_status); $s++) { 
                                $male = DB::table('t_dpt')->whereIn('id_village',$array_village)->where('status',$s_status[$s])->where('marriage_sts',$s_mariage[$m])->where('ektp',$s_ktp[$k])->where('gender','L')->where('disability',$b->id)->count();
                                $female = DB::table('t_dpt')->whereIn('id_village',$array_village)->where('status',$s_status[$s])->where('marriage_sts',$s_mariage[$m])->where('ektp',$s_ktp[$k])->where('gender','P')->where('disability',$b->id)->count(); 
                                $total = (int)$male + (int)$female;                  
                                $insert_recaps = array(
                                    'id_district' => $v->id,
                                    'group' => $group,
                                    'id_disability' => $b->id,
                                    's_mariage' => $s_mariage[$m],
                                    's_ktp' => $s_ktp[$k],
                                    's_status' => $s_status[$s],
                                    'total_male' => $male,
                                    'total' => $total,
                                    'total_female' => $female,
                                    'triwulan' => $triwulan,
                                    'year' => $year,                           
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'updated_at' => date('Y-m-d H:i:s')
                                );
                                $id_recap = DB::table('t_recap_dis')->insert($insert_recaps); 
                            }
                        }
                    }
                     
                }

            }

            if ($check == 0) {
                DB::table('t_steps')->where('is_disabilitas',1)->update(['is_active'=>0]);
                $month = date('m');
                if ($triwulan == 1) {
                    $name = 'Triwulan I '.$request->year;
                } else if($triwulan == 2){
                    $name = 'Triwulan II '.$request->year;
                } else if($triwulan == 3){
                    $name = 'Triwulan III '.$request->year;
                } else {
                    $name = 'Triwulan IV '.$request->year;
                }
                $insert_step = array(
                    'month' => $month,
                    'name' => $name,
                    'is_disabilitas' => 1,
                    'triwulan' => $triwulan,
                    'year' => $year,                           
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                );
                DB::table('t_steps')->insert($insert_step);
            }

            $data['code']    = 200;
            $data['message'] = 'Berhasil Mengkalkulasi Data Disabilitas';
            return response()->json($data);
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'RecapitulationsDisController@calculate';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }    

    }
    
}