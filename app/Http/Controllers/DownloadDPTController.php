<?php

namespace App\Http\Controllers;

use App\Model\RoleModel;
use App\Model\DissabilityModel;
use App\Model\DistrictModel;
use App\Model\KlasifikasiModel;
use App\Classes\upload;
use App\Traits\Fungsi;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\Handler;
use App\Exports\ExportStatistic;
use App\Exports\ExportDpt;

class DownloadDPTController extends Controller
{
    public function index()
    {
        try {
            $data = parent::sidebar();
            if ($data['access'] == 0) {
                return redirect('/');
            } else {
                $role_id           = Auth::guard('admin')->user()->id_role;
                $data['txt_button'] = "Tambah Pemeriksaan";
                $data['href'] = "medical-record/pemeriksaan-tahunan/action/add";
                $data['data_kec'] = DistrictModel::whereNull('deleted_at')->select('id','name')->get();
                $data['data_klasifikasi'] = KlasifikasiModel::select('id','name')->get();
                $data['data_dis'] = DissabilityModel::select('id','name')->get();
                //dd($data['id_adm_dept']);
                return view('download.index', $data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'DownloadDPTController@index';
            $insert_error = parent::InsertErrorSystem($data);
            $error = parent::sidebar();
            $error['id'] = $insert_error;
            return view('errors.index',$error); // jika Metode Get
            //return response()->json($data); // jika metode Post
        }
    }

    public function calculate(Request $request)
    {
        $posts = $this->DataDpt($request,null);

        
        $total = $posts->select('gender')->count();
        $male = $posts->where('gender','L')->count();
        $female = $total - $male;
        $data['male'] = number_format($male);
        $data['female'] = number_format($female);
        $data['total'] = number_format($total);
        return response()->json($data);

    }
    
    public function list_data(Request $request)
    {

        $totalData = DB::table('districts')->count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $dir   = $request->input('order.0.dir');
        $search = $request->search;
        $status = $request->status;

        $posts = $this->DataDpt($request,null);

        $posts = $posts->select('c.id as c_id','c.name as kecamatan')->distinct();
        
        $totalFiltered = $posts->get()->count();
        $posts = $posts->limit($limit)->offset($start)->get();

        $data = array();
        if (!empty($posts)) {
            $no = $start;
            foreach ($posts as $k=>$d) {
                $no = $no + 1;

                $action = '<div style="float: left; margin-left: 5px;"><a href="" onclick="Download('.base64_encode($d->c_id).')" >
                                <button type="button" class="btn btn-warning btn-sm" style="min-width: 110px;margin-left: 2px;margin-top:3px;text-align:left"><i class="fa fa-download"></i> Download DPT</button></a>
                            </div>';
                $all = $this->DataDpt($request,$d->c_id);
                $total = $all->select('gender')->count();
                $male = $all->where('gender','L')->count();
                $female = $total - $male;            
                $column['no']       = $no;
                $column['kec']      = $d->kecamatan;
                $column['desa']     = $this->TVillage($d->c_id);
                $column['tps']      = $this->TTps($d->c_id);
                $column['male']     = $male;
                $column['female']   = $female;
                $column['total']    = $total;
                $column['actions']  = $action;
                $data[]             = $column;

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

    public function TVillage($id){
        $data = DB::table('t_dpt as p')->leftJoin('villages as v','v.id','p.id_village')->leftJoin('districts as c','c.id','v.district_id')->where('c.id',$id)->select('v.id')->distinct()->get()->count();
        return $data;
    }

    public function TTps($id){
        $data = DB::table('t_dpt as p')->leftJoin('villages as v','v.id','p.id_village')->leftJoin('districts as c','c.id','v.district_id')->where('c.id',$id)->select('p.tps','v.id')->distinct()->get()->count();
        return $data;
    }

    public function DataDpt($request,$kec){
        
        $posts = DB::table('t_dpt as p')->leftJoin('villages as v','v.id','p.id_village')->leftJoin('districts as c','c.id','v.district_id')->whereNotIn('p.status',['delete','tms']);
        
        if ($request->id_kec != null) {
            $posts = $posts->where('v.district_id',$request->id_kec);
        }

        if ($kec != null) {
            $posts = $posts->where('v.district_id',$kec);
        }

        if ($request->ektp != null) {
            $posts = $posts->where('ektp',$request->ektp);
        }

        if ($request->kawin != null) {
            $posts = $posts->where('marriage_sts',$request->kawin);
        }

        if (isset($request->disabilitas)) {
            $disabilitas = $request->disabilitas;
            if (count($disabilitas) > 0) {
                $posts = $posts->whereIn('p.disability',$disabilitas);
            }
        }

        if (isset($request->klasifikasi)) {
            $klasifikasi = $request->klasifikasi;
            if (count($klasifikasi) > 0) {
                $posts = $posts->whereIn('p.clasification',$klasifikasi);
            }
        }

        return $posts;
    }

    public function export_statistic(Request $request, $arr){

        parse_str($arr, $filter);

        $posts = DB::table('t_dpt as p')->leftJoin('villages as v','v.id','p.id_village')->leftJoin('districts as c','c.id','v.district_id')->whereNotIn('p.status',['delete','tms']);
        
        if ($filter['id_kec'] != null) {
            $posts = $posts->where('v.district_id',$filter['id_kec']);
        }
        
        if ($filter['ektp'] != null) {
            $posts = $posts->where('ektp',$filter['ektp']);
        }

        if ($filter['kawin'] != null) {
            $posts = $posts->where('marriage_sts',$filter['kawin']);
        }

        if (isset($filter['disabilitas'])) {
            $disabilitas = $filter['disabilitas'];
            if (count($disabilitas) > 0) {
                $posts = $posts->whereIn('p.disability',$disabilitas);
            }
        }

        if (isset($filter['klasifikasi'])) {
            $klasifikasi = $filter['klasifikasi'];
            if (count($klasifikasi) > 0) {
                $posts = $posts->whereIn('p.clasification',$klasifikasi);
            }
        }
        $posts = $posts->select('c.id as c_id','c.name as kecamatan')->distinct()->get();
        $m=0;$f=0;$t=0;
        foreach ($posts as $k => $d) {
            $all = $this->DataDownloadDpt($filter,$d->c_id);
            $total = $all->select('gender')->count();
            $male = $all->where('gender','L')->count();
            $female = $total - $male;            
            $m = $m+$male;
            $f = $f+$female;
            $t = $t+$total;
            $posts[$k]->male = $male; 
            $posts[$k]->female = $female;
            $posts[$k]->total = $total; 
            $posts[$k]->desa  = $this->TVillage($d->c_id);
            $posts[$k]->tps   = $this->TTps($d->c_id);
        }
       
        $data['data'] = $posts;
        $data['male'] = $m; 
        $data['female'] = $f;
        $data['total'] = $t;
        $data['kecamatan'] = "";
        $data['ektp'] = "";
        $data['mariage'] = "";
        $data['disabilitas'] = "";
        $data['klasifikasi'] = "";
                
        $date = date('d F Y H:i'); 
         
        return Excel::download(new ExportStatistic($data), 'Rekap Statistik DPT Bojonegoro '.$date.'.xlsx');
    }

    public function DataDownloadDpt($filter,$kec){
        
        $posts = DB::table('t_dpt as p')->leftJoin('villages as v','v.id','p.id_village')->leftJoin('districts as c','c.id','v.district_id')->whereNotIn('p.status',['delete','tms']);
        
        
        if ($kec != null) {
            $posts = $posts->where('v.district_id',$kec);
        }

        if ($filter['id_kec'] != null) {
            $posts = $posts->where('v.district_id',$filter['id_kec']);
        }
        
        if ($filter['ektp'] != null) {
            $posts = $posts->where('ektp',$filter['ektp']);
        }

        if ($filter['kawin'] != null) {
            $posts = $posts->where('marriage_sts',$filter['kawin']);
        }

        if (isset($filter['disabilitas'])) {
            $disabilitas = $filter['disabilitas'];
            if (count($disabilitas) > 0) {
                $posts = $posts->whereIn('p.disability',$disabilitas);
            }
        }

        if (isset($filter['klasifikasi'])) {
            $klasifikasi = $filter['klasifikasi'];
            if (count($klasifikasi) > 0) {
                $posts = $posts->whereIn('p.clasification',$klasifikasi);
            }
        }

        return $posts;
    }

}