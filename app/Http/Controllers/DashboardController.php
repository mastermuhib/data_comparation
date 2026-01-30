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

    public function getDptDis($request){
            
        $dpt = DB::table('t_recap_dis as p')->leftJoin('districts as c','c.id','p.id_district')->where(function ($query) use ($request) {
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

    public function get_table_dashboard(Request $request){

        $year      = $request->year;
        $triwulan  = $request->triwulan;
        $status    = $request->status; 
        $kec       = $request->id_kec;
        $array_gender_count = [];
        $graph_klasifikasi_kecamatan = [];
        $data['klasifikasi'] = DB::table('t_clasifications')->orderBy('csid','asc')->pluck('name')->toArray();
        $id_klasifikasi = DB::table('t_clasifications')->orderBy('csid','asc')->pluck('id')->toArray();
        $district = DB::table('districts')->select('id','name')->orderBy('id','desc')->get();
        foreach ($district as $k => $d) {
            $graph_klasifikasi_kecamatan[] = [
              'name' => $d->name,
              'lk' => $this->DataGraph($id_klasifikasi,'total_male',$year,$triwulan,$d->id,$status),
              'pr' => $this->DataGraph($id_klasifikasi,'total_female',$year,$triwulan,$d->id,$status),
              'total' => $this->DataGraph($id_klasifikasi,'total',$year,$triwulan,$d->id,$status)
            ];
        }
        $data['data_klasifikasi'] = $graph_klasifikasi_kecamatan;
        //dd($graph_klasifikasi_kecamatan);
        $data['disabilitas']    = DB::table('t_dissability')->where('id','!=',0)->orderBy('id','asc')->pluck('name')->toArray();
        $id_disabilitas = DB::table('t_dissability')->where('id','!=',0)->orderBy('id','asc')->pluck('id')->toArray();
        foreach ($district as $k => $v) {
            $graph_disabilitas_kecamatan[] = [
              'name' => $v->name,
              'lk' => $this->DataGraphDis($id_disabilitas,'total_male',$year,$triwulan,$v->id,$status),
              'pr' => $this->DataGraphDis($id_disabilitas,'total_female',$year,$triwulan,$v->id,$status),
              'total' => $this->DataGraphDis($id_disabilitas,'total',$year,$triwulan,$v->id,$status)
            ];
        }
        $data['data_disabilitas'] = $graph_disabilitas_kecamatan;
        return view('table_data_dashboard',$data);
    }

    public function get_dashboard(Request $request){

        $year      = $request->year;
        $triwulan  = $request->triwulan;
        $status    = $request->status; 
        $kec       = $request->id_kec;
        $array_gender_count = [];
        
        $dpt = $this->getDpt($request);

        $j_dptp = $dpt->sum('total_female');
        $j_dptl = $dpt->sum('total_male');
        $data['j_dpt'] = $j_dptp + $j_dptl;
        $data['j_dptp']  = $j_dptp;
        $data['j_dptl'] = $j_dptl;
        $data['p_dptp'] = ($j_dptp / $data['j_dpt']) * 100;
        $data['p_dptl'] = ($j_dptl / $data['j_dpt']) * 100;

        $array_klasifikasi = [];
        $graph_klasifikasi = [];
        $array_series_klasifikasi = [];
        $array_disabilitas = [];
        $graph_disabilitas = [];
        $array_series_disabilitas = [];
        $array_series_mariage = [];
        $array_series_ektp = [];
        $array_ektp = [];
        $array_mariage = [];
        $graph_klasifikasi_kecamatan = [];
        $prosentase_klasifikasi = [];
        $prosentase_disabilitas = [];
        $i_ektp = array("s","b");
        $i_mariage = array("S","B","P");
        $l_ektp = array("Sudah","Belum");
        $l_mariage = array("Sudah","Belum","Pernah");
        
        $klasifikasi = DB::table('t_clasifications')->select('id','name')->orderBy('csid','asc')->get();
        $id_klasifikasi = DB::table('t_clasifications')->orderBy('csid','asc')->pluck('id')->toArray();

            
        foreach ($klasifikasi as $k => $v) {
            $array_klasifikasi[]  = "'".$v->name."'";
            $dpt1 = $this->getDpt($request);
            $jumlah = $dpt1->where('id_clasification',$v->id)->sum('total');
            $array_series_klasifikasi[] = (int)$jumlah;
        }
        $graph_klasifikasi[] = [
          'name' => 'Laki - Laki',
          'data' => $this->DataGraph($id_klasifikasi,'total_male',$year,$triwulan,$kec,$status)
        ];

        $graph_klasifikasi[] = [
          'name' => 'Perempuan',
          'data' => $this->DataGraph($id_klasifikasi,'total_female',$year,$triwulan,$kec,$status)
        ];

        $data_klasifikasi = $this->DataGraph($id_klasifikasi,'total',$year,$triwulan,$kec,$status);
        $total_k = 0;
        for ($dk=0; $dk < count($data_klasifikasi); $dk++) { 
            $total_k = $total_k + $data_klasifikasi[$dk];
        }
        for ($dk=0; $dk < count($data_klasifikasi); $dk++) { 
            $pros = ($data_klasifikasi[$dk] / $total_k) * 100;
            $prosentase_klasifikasi[] = ['total'=>$data_klasifikasi[$dk],'prosentase'=>$pros]; 
        }


        $disabilitas    = DB::table('t_dissability')->where('id','!=',0)->select('id','name')->orderBy('id','asc')->get();
        $id_disabilitas = DB::table('t_dissability')->where('id','!=',0)->orderBy('id','asc')->pluck('id')->toArray();
        foreach ($disabilitas as $k => $v) {
            $array_disabilitas[]  = "'".$v->name."'";
            $dis = $this->getDptDis($request);
            $jumlah = $dis->where('id_disability',$v->id)->sum('total');
            $array_series_disabilitas[] = (int)$jumlah;
        }
        $graph_disabilitas[] = [
          'name' => 'Laki - Laki',
          'data' => $this->DataGraphDis($id_disabilitas,'total_male',$year,$triwulan,$kec,$status)
        ];

        $graph_disabilitas[] = [
          'name' => 'Perempuan',
          'data' => $this->DataGraphDis($id_disabilitas,'total_female',$year,$triwulan,$kec,$status)
        ];

        $data_disabilitas = $this->DataGraphDis($id_disabilitas,'total',$year,$triwulan,$kec,$status);
        $total_d = 0;
        for ($dd=0; $dd < count($data_disabilitas); $dd++) { 
            $total_d = $total_d + $data_disabilitas[$dd];
        }
        for ($dd=0; $dd < count($data_disabilitas); $dd++) {  
            $prosd = ($data_disabilitas[$dd] / $total_d) * 100;
            $prosentase_disabilitas[] = ['total'=>$data_disabilitas[$dd],'prosentase'=>$prosd]; 
        }

        for ($i=0; $i < count($i_ektp); $i++) {
            $array_ektp[]  = "'".$l_ektp[$i]."'"; 
            $dptk = $this->getDpt($request);
            $jumlah = $dptk->where('s_ktp',$i_ektp[$i])->sum('total');
            $array_series_ektp[] = (int)$jumlah;
        }

        for ($im=0; $im < count($i_mariage); $im++) {
            $array_mariage[]  = "'".$l_mariage[$im]."'"; 
            $dptm = $this->getDpt($request);
            $jumlah = $dptm->where('s_mariage',$i_mariage[$im])->sum('total');
            $array_series_mariage[] = (int)$jumlah;
        }
       
        $data['klasifikasi']  = $array_klasifikasi;
        $data['disabilitas']  = $array_disabilitas;
        $data['klasifikasi_name']  = implode(', ', $array_klasifikasi);
        $data['klasifikasi_series'] = implode(', ', $array_series_klasifikasi);
        $data['disabilitas_name']  = implode(', ', $array_disabilitas);
        $data['disabilitas_series'] = implode(', ', $array_series_disabilitas);
        $data['mariage_name']  = implode(', ', $array_mariage);
        $data['mariage_series'] = implode(', ', $array_series_mariage);
        $data['ektp_name']  = implode(', ', $array_ektp);
        $data['ektp_series'] = implode(', ', $array_series_ektp);
        $data['data_graph'] = $graph_klasifikasi;
        $data['data_graph_dis'] = $graph_disabilitas;
        $data['prosentase_klasifikasi'] = $prosentase_klasifikasi;
        $data['prosentase_disabilitas'] = $prosentase_disabilitas;
        
            
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

    public function DataGraphDis($array,$coloumn,$year,$triwulan,$kec,$status){
        $var = [];
        for ($i=0; $i < count($array); $i++) { 
            $dpt = DB::table('t_recap_dis as p')->leftJoin('districts as c','c.id','p.id_district')->where('id_disability',$array[$i])->where(function ($query) use ($year,$triwulan,$kec,$status) {
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

        
    public function get_print_barcode($id){

        $data['data'] = DB::table('relation_transaction_machine as r')->join('patients as p','r.code_patient','p.patient_code')->where('id_transaction',$id)->distinct('code_patient','nama_tes')->join('users as u','u.id','p.id_user')->select('p.*','code_machine','code_tubes','tubes','nomor_rekam_medis','nama_tes','u.address as alamat','u.birthday as ultah','user_phone')->get();
        $data['code'] = '536474747474';
        $customPaper = array(0,0,141.7322834645669, 85.03937007874016);
        $pdf = PDF::loadView('get_barcode',$data)->setPaper($customPaper, 'potrait');
        return $pdf->stream();

        //return view('get_barcode',$data);
    }  
}