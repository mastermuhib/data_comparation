<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\RoleModel;
use App\MenuModel;
use App\CompanyModel;
use App\Model\DistrictModel;
use App\Model\KlasifikasiModel;
use App\Traits\Fungsi;
use App\Model\SchollModel;
use App\Model\MedicineModel;
use App\VacancyModel;
use Carbon\Carbon;
use Redirect;
use App\Model\ScheduleModel;
use PDF;

// use App\Model\RoleModel;
// use App\MenuModel;


class DashboardController extends Controller
{     

    public function index()
    {
        
        $data['data_kec'] = DistrictModel::whereNull('deleted_at')->select('id','name')->get();
        $data['data_klasifikasi'] = KlasifikasiModel::select('id','name')->get();
        $data['triwulan'] = DB::table('t_steps')->select('id','name','is_active','triwulan','year')->orderBy('is_active','desc')->get();
            // bisnis
              
        return view('index',$data);
      
    }

    public function dashboard()
    {
        $role_id = Auth::guard('admin')->user()->id_role;
        $data = parent::sidebar();
        $data['position_menu'] = "Dashboard";
        $bulan_ini = date('m');
        if ($data['access'] == 0) {
            return redirect('/');
        } else {  
            $admin_s = parent::admin_data();
            $rules = $admin_s['role'];
            $end = date('Y-m-d');
            $data['start'] = $end;
            // $data['start'] = date('Y-m-d',strtotime('-1 day',strtotime($end)));
            $data['end'] = $end;
            $data['header_name'] = '<span>Dashboard</span>';
            // $data['header_name'] = '<span>Dashboard</span> <input type="month" id="bdaymonth" name="bdaymonth" class="form-control ml-40" onchange="ChangeDashboard()" value="'.date('Y-m').'" style="margin-top: -30px;">';
            $data['data_kec'] = DistrictModel::whereNull('deleted_at')->select('id','name')->get();
            $data['data_klasifikasi'] = KlasifikasiModel::select('id','name')->get();
            $data['triwulan'] = DB::table('t_steps')->select('id','name','is_active','triwulan','year')->orderBy('is_active','desc')->get();
            // bisnis
              
        return view('dashboard',$data);
      }
    }

    public function get_triwulan($id)
    {
        $data = DB::table('t_steps')->where('id', $id)->select('triwulan','year')->first();

        echo json_encode($data);
    }

    public function getDpt($request){
            
        $dpt = DB::table('t_recaps as p')->leftJoin('districts as c','c.id','p.id_district')->where(function ($query) use ($request) {
            if ($request->triwulan != null) {
                $query->where('p.triwulan',$request->triwulan);
            } 
            if ($request->year != null) {
                $query->where('p.year',$request->year);
            } 
            if ($request->id_kec != null) {
                $query->where('c.id',$request->id_kec);
            } 
            
            if (isset($request->status)) {
                $query->whereIn('p.s_status',$request->status);
            } 
        });
        return $dpt;
    }

    public function get_dashboard(Request $request){

        $year      = $request->year;
        $triwulan  = $request->triwulan;
        $status    = $request->status; 
        $kec       = $request->id_kec;
        $array_gender_count = [];
        
        $dpt = $this->getDpt($request);

        $data['j_dptp']  = $dpt->sum('total_female');
        $data['j_dptl'] = $dpt->sum('total_male');
        $data['j_dpt'] = $data['j_dptp'] + $data['j_dptl'];

        $array_klasifikasi = [];
        $graph_klasifikasi = [];
        $array_series_klasifikasi = [];
        $array_disabilitas = [];
        $array_series_disabilitas = [];
        $array_mariage = [];
        $array_series_mariage = [];
        $array_ektp = [];
        $array_series_ektp = [];
        $l_ektp = array("Sudah","Belum");
        $l_mariage = array("Sudah","Belum","Pernah");
        
        $klasifikasi = DB::table('t_clasifications')->select('id','name')->orderBy('csid','asc')->get();
        $id_klasifikasi = DB::table('t_clasifications')->orderBy('csid','asc')->pluck('id')->toArray();
        
        $disabilitas = DB::table('t_dissability')->select('id','name')->orderBy('id','asc')->get();
        foreach ($klasifikasi as $k => $v) {
            $array_klasifikasi[]  = "'".$v->name."'";
            $dpt1 = $this->getDpt($request);
            $jumlah = $dpt1->where('id_clasification',$v->id)->sum('total');
            $array_series_klasifikasi[] = (int)$jumlah;
        }
        $graph_klasifikasi[] = [
          'name' => 'LK',
          'data' => $this->DataGraph($id_klasifikasi,'total_male',$year,$triwulan,$kec,$status)
        ];

        $graph_klasifikasi[] = [
          'name' => 'PR',
          'data' => $this->DataGraph($id_klasifikasi,'total_female',$year,$triwulan,$kec,$status)
        ];
       
        $data['klasifikasi']  = $array_klasifikasi;
        $data['klasifikasi_name']  = implode(', ', $array_klasifikasi);
        $data['klasifikasi_series'] = implode(', ', $array_series_klasifikasi);
        // $data['disabilitas_name']  = implode(', ', $array_disabilitas);
        // $data['disabilitas_series'] = implode(', ', $array_series_disabilitas);
        // $data['mariage_name']  = implode(', ', $array_mariage);
        // $data['mariage_series'] = implode(', ', $array_series_mariage);
        // $data['ektp_name']  = implode(', ', $array_ektp);
        // $data['ektp_series'] = implode(', ', $array_series_ektp);
        $data['data_graph'] = $graph_klasifikasi;
        
            
        //dd($data);
        return view('data_dashboard',$data);

    }

    

    public function DataGraph($array,$coloumn,$year,$triwulan,$kec,$status){
        $var = [];
        for ($i=0; $i < count($array); $i++) { 
            $dpt = DB::table('t_recaps as p')->leftJoin('districts as c','c.id','p.id_district')->where('id_clasification',$array[$i])->where(function ($query) use ($year,$triwulan,$kec,$status) {
                if ($triwulan != null) {
                    $query->where('p.triwulan',$triwulan);
                } 
                if ($year != null) {
                    $query->where('p.year',$year);
                } 
                if ($kec != null) {
                    $query->where('c.id',$kec);
                } 
                
                if (isset($status)) {
                    $query->whereIn('p.s_status',$status);
                } 
            });
            $dpt = $dpt->sum($coloumn);
            $var[] = (int)$dpt;
            
        }
        return $var;
    }

        
    public function getJumlah($date)
    {
        $jumlah = DB::table('transactions')
                ->where('status',1)
                ->whereMonth('created_at',$date)
                ->count();
        return $jumlah;
    }

    public function getNominal($date)
    {
        $penjualan = DB::table('transactions')
                ->where('status',1)
                ->whereMonth('created_at',$date)
                ->sum('total_off_pay');
        return $penjualan;
    }

    public function getUser($date)
    {
        $user = DB::table('users')
                ->where('status',1)
                ->whereMonth('created_at',$date)
                ->count();
        return $user;
    }


    public function getPasien($date)
    {
        $user = DB::table('patients')
                ->where('status',1)
                ->whereMonth('created_at',$date)
                ->count();
        return $user;
    }


    public function dasboard_schedule(Request $request)
    {
        $product = $this->DataSchedule($request);

        $product = $product->select('s.*','patient_name','branch_name','master_schedules.time as time');
        $limit = $request->input('length');
        $start = $request->input('start');
        $dir   = $request->input('order.0.dir');

        $totalFiltered = $product->count();
        $totalData = $product->count();

        $product = $product->limit($limit)->offset($start)->get();

        // dd($product);

        $data = array();
        $no   = 0;
        foreach ($product as $d) {
            $ids = "'select_txt_".$d->id."'";
            if ($d->status == 1) {
                $status = '<span class="text-success">Selesai</span>';
            } else {
                $status = '<span class="text-primary">Waiting</span>';
            }

            $action = '<a href="javascript:void(0)" id="'.$d->id.'" class="btn btn-success btn-sm d_detail"><span class="navi-icon"><i class="fas fa-eye"></i></span><span class="navi-text">Detail</span></a>';
            $action .= '<a href="javascript:void(0)" class="btn btn-danger ml-2 btn-sm aksi btn-aksi" id="' . $d->id.'" aksi="delete" tujuan="' . 'promosi' . '" data="' . 'data_promosi' . '"><span class="navi-icon"><i class="fa fa-trash"></i></span><span class="navi-text">Hapus</span></a>';
            $actions = " - ";

            $no     = $no + 1;
            $column['pasien']    = $d->patient_name;
            $column['cabang']    = $d->branch_name;
            $column['date'] = $d->day.' '.date('d F Y',strtotime($d->schedule_date));
            $column['time'] = date('H:i',strtotime($d->time));
            $column['status'] = $status;
            $column['number']    = $d->number;
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


      public function DataSchedule($request){
        $init = date('Y-m-d');
        // dd($request->all());
        $posts = ScheduleModel::join('schedule_patients as s','s.id_schedules','master_schedules.id')->join('patients as pt','s.id_patients','pt.id')->leftJoin('table_branchs as t','t.id','master_schedules.id_branch')->whereNull('master_schedules.deleted_at')->where(static function ($query) use ($request) {

            // if ($request->tgl_start != null) {
            //     $query->whereDate('s.schedule_date',$request->tgl_start);   
            // }
            
            if ($request->tgl_start != null) {
                $query->where('s.schedule_date','>=',$request->tgl_start);
            } 

            if ($request->akhir != null) {
                $query->where('s.schedule_date','<=',date('Y-m-d',strtotime($request->akhir . "+1 days")));
            } 
            
        });
        return $posts;             
    }
   

    public function merchant_category()
    {
        // $merchant_category = DB::table('table_category_merchant');
        $data = DB::table('table_merchant as m')
        ->leftJoin('table_category_merchant as cm', 'cm.id', '=', 'm.merchant_category')
        ->select( DB::raw('count(*) as total'), 'cm.category_merchant_name')
        ->groupBy('m.merchant_category', 'cm.category_merchant_name')
        ->whereNull('m.deleted_at')
        ->whereNull('cm.deleted_at')
        ->get();
        $datas = array();
        $labels = array();
        $fills = array();

        foreach ($data as $key => $value) {
            # code...
            $labels[] = $value->category_merchant_name;
            $fills[] =  $value->total;
        }
        $datas = [ $labels, $fills];
        
        return response()
            ->json($datas);
    }

    

    public function menu_category()
    {
        // $menu_category = DB::table('table_category_menu');
        $data = DB::table('table_product_menus as pm')
        ->leftJoin('table_category_product as cm', 'cm.id', '=', 'pm.id_category')
        ->select( DB::raw('count(*) as total'), 'cm.category_product_name')
        ->groupBy('pm.id_category', 'cm.category_product_name')
        ->whereNull('pm.deleted_at')
        ->whereNull('cm.deleted_at')
        ->get();
        $datas = array();
        $labels = array();
        $fills = array();

        foreach ($data as $key => $value) {
            # code...
            $labels[] = $value->category_product_name;
            $fills[] =  $value->total;
        }
        $datas = [ $labels, $fills];
        
        return response()
            ->json($datas);
    }


    public function type_product()
    {
        // $menu_category = DB::table('table_category_menu');
        $data = DB::table('table_product_menus as pm')
        ->leftJoin('table_type_product as tp', 'tp.id', '=', 'pm.id_type_product')
        ->select( DB::raw('count(*) as total'), 'tp.type_product_name')
        ->groupBy('pm.id_type_product', 'tp.type_product_name')
        ->whereNull('pm.deleted_at')
        ->whereNull('tp.deleted_at')
        ->get();
        $datas = array();
        $labels = array();
        $fills = array();

        foreach ($data as $key => $value) {
            # code...
            $labels[] = $value->type_product_name;
            $fills[] =  $value->total;
        }
        $datas = [ $labels, $fills];
        
        return response()
            ->json($datas);
    }

    public function get_print_barcode($id){

        $data['data'] = DB::table('relation_transaction_machine as r')->join('patients as p','r.code_patient','p.patient_code')->where('id_transaction',$id)->distinct('code_patient','nama_tes')->join('users as u','u.id','p.id_user')->select('p.*','code_machine','code_tubes','tubes','nomor_rekam_medis','nama_tes','u.address as alamat','u.birthday as ultah','user_phone')->get();
        $data['code'] = '536474747474';
        $customPaper = array(0,0,141.7322834645669, 85.03937007874016);
        $pdf = PDF::loadView('get_barcode',$data)->setPaper($customPaper, 'potrait');
        return $pdf->stream();

        //return view('get_barcode',$data);
    }  
}