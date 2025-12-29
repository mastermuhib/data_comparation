<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Exports\ExportRecapResults;
use App\Exports\ExportRecapDResults;
use App\Exports\ExportRecapVResults;
use App\Exceptions\Handler;

class DownloadRecapitulationsController extends Controller
{
    
    public function excelRecap(Request $request, $arr){

        parse_str($arr, $filter);

        $posts = DB::table('t_recaps as p')->join('t_clasifications as cs','cs.id','p.id_clasification')->join('villages as v','v.id','p.id_village')->join('districts as c','c.id','v.district_id');
        
        if ($filter['year'] != null) {
            $posts = $posts->where('year',$filter['year']);
        }

        if ($filter['klasifikasi'] != null) {
            $posts = $posts->where('id_clasification',$filter['klasifikasi']);
        }

        if ($filter['triwulan'] != null) {
            $posts = $posts->where('triwulan',$filter['triwulan']);
        }

        $posts = $posts->select('cs.id as cs_id','group','csid','triwulan','year','cs.name as klasifikasi')->distinct();
        
        $posts = $posts->orderBy('csid','asc')->get();
        $m=0;$f=0;$t=0;
        foreach ($posts as $k => $d) {
            $male = $this->DataDT($d->group,$d->cs_id,'total_male');
            $female = $this->DataDT($d->group,$d->cs_id,'total_female'); 
            $total = (int)$male + (int)$female;
            $m = $m+$male;
            $f = $f+$female;
            $t = $t+$total;
            $posts[$k]->male = $male; 
            $posts[$k]->female = $female;
            $posts[$k]->total = $total; 
        }
        //dd($posts);
       
        $data['data'] = $posts;
        $data['male'] = $m; 
        $data['female'] = $f;
        $data['total'] = $t;
        $data['triwulan'] = $filter['triwulan'];
        $data['year'] = $filter['year'];
        //dd($data['data']);
        
        $date = date('d F Y H:i'); 
         

        return Excel::download(new ExportRecapResults($data), 'Rekap Klasifikasi Usia Bojonegoro Triwulan'.$filter['triwulan'].' '.$filter['year'].'.xlsx');
    }

    public function excelDistrict(Request $request, $arr){

        parse_str($arr, $filter);

        $posts = DB::table('t_recaps as p')->join('t_clasifications as cs','cs.id','p.id_clasification')->join('villages as v','v.id','p.id_village')->join('districts as c','c.id','v.district_id');
        
        if ($filter['year'] != null) {
            $posts = $posts->where('year',$filter['year']);
        }

        if ($filter['klasifikasi'] != null) {
            $posts = $posts->where('id_clasification',$filter['klasifikasi']);
        }

        if ($filter['triwulan'] != null) {
            $posts = $posts->where('triwulan',$filter['triwulan']);
        }

        $posts = $posts->select('cs.id as cs_id','c.id as c_id','c.name as kecamatan','cs.name as klasifikasi','triwulan','year','csid')->distinct();
        $posts = $posts->orderBy('c.id','asc')->orderBy('csid','asc')->get();
        $m=0;$f=0;$t=0;
        foreach ($posts as $k => $d) {
            //DataD($kec,$kualif,$triwulan,$year,$coloumn)
            $male = $this->DataD($d->c_id,$d->cs_id,$d->triwulan,$d->year,'total_male');
            $female = $this->DataD($d->c_id,$d->cs_id,$d->triwulan,$d->year,'total_female'); 
            $total = (int)$male + (int)$female;
            $m = $m+$male;
            $f = $f+$female;
            $t = $t+$total;
            $posts[$k]->male = $male; 
            $posts[$k]->female = $female;
            $posts[$k]->total = $total; 
        }
        
        $data['data'] = $posts;
        $data['male'] = $m; 
        $data['female'] = $f;
        $data['total'] = $t;
        $data['triwulan'] = $filter['triwulan'];
        $data['year'] = $filter['year'];
        //dd($data['data']);
        
        return Excel::download(new ExportRecapDResults($data), 'Rekap Klasifikasi Usia Bojonegoro per Kecamatan Triwulan'.$filter['triwulan'].' '.$filter['year'].'.xlsx');
    }

    public function excelVillage(Request $request, $arr){

        parse_str($arr, $filter);

        $posts = DB::table('t_recaps as p')->join('t_clasifications as cs','cs.id','p.id_clasification')->join('villages as v','v.id','p.id_village')->join('districts as c','c.id','v.district_id');
        
        if ($filter['year'] != null) {
            $posts = $posts->where('year',$filter['year']);
        }

        if ($filter['klasifikasi'] != null) {
            $posts = $posts->where('id_clasification',$filter['klasifikasi']);
        }

        if ($filter['triwulan'] != null) {
            $posts = $posts->where('triwulan',$filter['triwulan']);
        }

        $posts = $posts->select('cs.id as cs_id','group','csid','triwulan','year','cs.name as klasifikasi')->distinct();
        
        $posts = $posts->orderBy('csid','asc')->get();
        $m=0;$f=0;$t=0;
        foreach ($posts as $k => $d) {
            $male = $this->DataDT($d->group,$d->cs_id,'total_male');
            $female = $this->DataDT($d->group,$d->cs_id,'total_female'); 
            $total = (int)$male + (int)$female;
            $m = $m+$male;
            $f = $f+$female;
            $t = $t+$total;
            $posts[$k]->male = $male; 
            $posts[$k]->female = $female;
            $posts[$k]->total = $total; 
        }
        //dd($posts);
       
        $data['data'] = $posts;
        $data['male'] = $m; 
        $data['female'] = $f;
        $data['total'] = $t;
        $data['triwulan'] = $filter['triwulan'];
        $data['year'] = $filter['year'];
        //dd($data['data']);
        
        $date = date('d F Y H:i'); 
         

        return Excel::download(new ExportRecapVResults($data), 'Rekap Klasifikasi Usia Bojonegoro per Desa Triwulan'.$filter['triwulan'].' '.$filter['year'].'.xlsx');
    }

    public function DataD($kec,$kualif,$triwulan,$year,$coloumn){
        $posts = DB::table('t_recaps as p')->join('t_clasifications as cs','cs.id','p.id_clasification')->join('villages as v','v.id','p.id_village')->join('districts as c','c.id','v.district_id')->where('v.district_id',$kec)->where('id_clasification',$kualif)->where('triwulan',$triwulan)->where('year',$year)->sum($coloumn);
        return $posts;
    }

    public function DataDT($group,$kualif,$coloumn){
        $posts = DB::table('t_recaps as p')->join('t_clasifications as cs','cs.id','p.id_clasification')->join('villages as v','v.id','p.id_village')->join('districts as c','c.id','v.district_id')->where('group',$group)->where('id_clasification',$kualif)->sum($coloumn);
        return $posts;
    }
}