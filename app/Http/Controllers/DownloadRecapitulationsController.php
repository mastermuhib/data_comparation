<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Exports\ExportRecapDisResults;
use App\Exports\ExportRecapDResults;
use App\Exceptions\Handler;

class DownloadRecapitulationsController extends Controller
{
    
    
    public function excelKlasifikasi(Request $request, $arr){

        parse_str($arr, $filter);
        $status = [];

        $posts = DB::table('t_recaps as p')->join('t_clasifications as cs','cs.id','p.id_clasification')->join('districts as c','c.id','p.id_district');
        
        if ($filter['year'] != null) {
            $posts = $posts->where('year',$filter['year']);
        }

        if ($filter['klasifikasi'] != null) {
            $posts = $posts->where('id_clasification',$filter['klasifikasi']);
        }

        if ($filter['triwulan'] != null) {
            $posts = $posts->where('triwulan',$filter['triwulan']);
        }

        if (isset($filter['status'])) {
            $posts  = $posts->whereIn('p.s_status',$filter['status']);
            $status = $filter['status'];
        }

        $posts = $posts->select('cs.id as cs_id','c.id as c_id','c.name as kecamatan','cs.name as klasifikasi','triwulan','year','csid')->distinct();
        $posts = $posts->orderBy('c.id','asc')->orderBy('csid','asc')->get();
        $m=0;$f=0;$t=0;
        foreach ($posts as $k => $d) {
            //DataD($kec,$kualif,$triwulan,$year,$coloumn)
            $male = $this->DataD($d->c_id,$d->cs_id,$d->triwulan,$d->year,$status,'total_male');
            $female = $this->DataD($d->c_id,$d->cs_id,$d->triwulan,$d->year,$status,'total_female'); 
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

    public function excelDisabilitas(Request $request, $arr){

        parse_str($arr, $filter);
        $status = [];

        $posts = DB::table('t_recap_dis as p')->join('t_dissability as cs','cs.id','p.id_disability')->join('districts as c','c.id','p.id_district');
        
        if ($filter['year'] != null) {
            $posts = $posts->where('year',$filter['year']);
        }

        if ($filter['disabilitas'] != null) {
            $posts = $posts->where('id_disability',$filter['disabilitas']);
        }

        if ($filter['triwulan'] != null) {
            $posts = $posts->where('triwulan',$filter['triwulan']);
        }

        if (isset($filter['status'])) {
            $posts  = $posts->whereIn('p.s_status',$filter['status']);
            $status = $filter['status'];
        }

        $posts = $posts->select('cs.id as cs_id','c.id as c_id','c.name as kecamatan','cs.name as disabilitas','triwulan','year')->distinct();
        $posts = $posts->orderBy('c.id','asc')->orderBy('cs.id','asc')->get();
        $m=0;$f=0;$t=0;
        foreach ($posts as $k => $d) {
            //DataD($kec,$kualif,$triwulan,$year,$coloumn)
            $male = $this->DataDis($d->c_id,$d->cs_id,$d->triwulan,$d->year,$status,'total_male');
            $female = $this->DataDis($d->c_id,$d->cs_id,$d->triwulan,$d->year,$status,'total_female'); 
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
        
        return Excel::download(new ExportRecapDisResults($data), 'Rekap Data Disabilitas Bojonegoro per Kecamatan Triwulan'.$filter['triwulan'].' '.$filter['year'].'.xlsx');
    }

    
    public function DataD($kec,$kualif,$triwulan,$year,$status,$coloumn){
        if (count($status) > 0) {
            $posts = DB::table('t_recaps as p')->join('t_clasifications as cs','cs.id','p.id_clasification')->join('districts as c','c.id','p.id_district')->where('p.id_district',$kec)->where('id_clasification',$kualif)->where('triwulan',$triwulan)->where('year',$year)->whereIn('p.s_status',$status)->sum($coloumn);
        } else {
            $posts = DB::table('t_recaps as p')->join('t_clasifications as cs','cs.id','p.id_clasification')->join('districts as c','c.id','v.district_id')->where('v.district_id',$kec)->where('id_clasification',$kualif)->where('triwulan',$triwulan)->where('year',$year)->sum($coloumn);
        }
        
        return $posts;
    }

    public function DataDis($kec,$kualif,$triwulan,$year,$status,$coloumn){
        if (count($status) > 0) {
            $posts = DB::table('t_recap_dis as p')->join('t_dissability as cs','cs.id','p.id_disability')->join('districts as c','c.id','p.id_district')->where('p.id_district',$kec)->where('id_disability',$kualif)->where('triwulan',$triwulan)->where('year',$year)->whereIn('p.s_status',$status)->sum($coloumn);
        } else {
            $posts = DB::table('t_recap_dis as p')->join('t_dissability as cs','cs.id','p.id_disability')->join('districts as c','c.id','p.id_district')->where('p.id_district',$kec)->where('id_disability',$kualif)->where('triwulan',$triwulan)->where('year',$year)->sum($coloumn);
        }
        
        return $posts;
    }

}