<?php

namespace App\Http\Controllers;

use App\Model\RoleModel;
use App\Model\dptModel;
use App\Model\DistrictModel;
use App\Model\KlasifikasiModel;
use App\Model\CityModel;
use App\Model\UserModel;
use Maatwebsite\Excel\Facades\Excel;
use App\Model\TemporaryMonggoDB;
use App\Classes\upload;
use App\Traits\Fungsi;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Exports\ExportPairingResults;
use App\Exceptions\Handler;

class PairingDptController extends Controller
{
    
    public function pairing()
    {
        
        try {
            $data = parent::sidebar();
            if ($data['access'] == 0) {
                return redirect('/');
            } else {
                $role_id           = Auth::guard('admin')->user()->id_role;
                //dd($data['id_adm_dept']);
                return view('dpt.pairing', $data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'DptController@pairing';
            $insert_error = parent::InsertErrorSystem($data);
            $error = parent::sidebar();
            $error['id'] = $insert_error;
            return view('errors.index',$error); 
        }
    }

    public function post_pairing_dpt(Request $request){
        
        try {
            
            $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain','csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/vnd.ms-excel','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            
            $nik_location = (int)$request->nik - 1;
            $page = 0;
            if(empty($_FILES['file']['name'])) {
                $data['code']    = 500;
                $data['message'] = "File Kosong";
            } else {
                if(in_array($_FILES['file']['type'],$csvMimes)){
                    if(is_uploaded_file($_FILES['file']['tmp_name'])){ 
                        // check file size
                        if(filesize($_FILES['file']['tmp_name']) > 51200000000000000) {
                            $data['code']    = 500;
                            $data['message'] = "File Maksimal 500 Mb";
                        } else {
                            //open uploaded csv file with read only mode
                            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
                            //skip first line
                            fgets($csvFile);
                            //parse data from csv file line by line
                            //$data = fgetcsv($csvFile);
                            while(($csv_excel = fgets($csvFile)) !== FALSE){
                        
                                $line = explode("#", $csv_excel);
                                //$line = $csv_excel;
                                //dd($line);
                                $status = "Tidak ada di Sidalih";
                                $count = count($line);
                                $page = $count;
                                $array = [];
                                for ($i=0; $i < $count; $i++) { 
                                    $clean = str_replace('"', '', $line[$i]);
                                    $clean = trim(preg_replace('/\s\s+/', ' ', $clean));
                                    // if ($i == $nik_location) {
                                    //     $clean = "'".$clean;
                                    // }
                                    $array['col'.$i] = $clean;
                                }
                                $nik = str_replace('"', '', $line[$nik_location]);
                                //dd($nik);
                                $check = DB::table('t_dpt')->where('nik',$nik)->whereNotIn('status',['tms','delete'])->count();
                                if ($check > 0) {
                                    $status = "Ada di Sidalih";
                                }

                                $array['col'.$count] = $status;
                                TemporaryMonggoDB::create($array);                         

                            }
                        }
                        
                    }                   
                    //close opened csv file
                    fclose($csvFile);
        
                    $data['code']    = 200;
                    $data['page']  = (int)$page;
                    $data['message'] = "Berhasil Mengimport Data DPT";
                } else {
                    $data['code']    = 500;
                    $data['message'] = "Tipe File Tidak Sesuai. Pastikan file bertipe csv";
                }
                return response()->json($data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'DptController@post_import_dpt';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }

    }
        
    public function download_pairing($coloumn){
       
        $data['data'] = TemporaryMonggoDB::select('*')->get()->toArray();
        //dd($data['data']);
        $data['coloumn'] = $coloumn;
        $date = date('d F Y H:i'); 
        TemporaryMonggoDB::whereNotNull('created_at')->delete();   

        return Excel::download(new ExportPairingResults($data), 'Hasil Sanding Data Aktif'.$date.'.xlsx');
    }

    public function die()
    {
        
        try {
            $data = parent::sidebar();
            if ($data['access'] == 0) {
                return redirect('/');
            } else {
                $role_id           = Auth::guard('admin')->user()->id_role;
                //dd($data['id_adm_dept']);
                return view('dpt.pairing_die', $data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'DptController@pairing';
            $insert_error = parent::InsertErrorSystem($data);
            $error = parent::sidebar();
            $error['id'] = $insert_error;
            return view('errors.index',$error); 
        }
    }

    public function post_pairing_die(Request $request){
        
        try {
            
            $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain','csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/vnd.ms-excel','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            
            $nik_location = (int)$request->nik - 1;
            $page = 0;
            if(empty($_FILES['file']['name'])) {
                $data['code']    = 500;
                $data['message'] = "File Kosong";
            } else {
                if(in_array($_FILES['file']['type'],$csvMimes)){
                    if(is_uploaded_file($_FILES['file']['tmp_name'])){ 
                        // check file size
                        if(filesize($_FILES['file']['tmp_name']) > 51200000000000000) {
                            $data['code']    = 500;
                            $data['message'] = "File Maksimal 500 Mb";
                        } else {
                            //open uploaded csv file with read only mode
                            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
                            //skip first line
                            fgets($csvFile);
                            //parse data from csv file line by line
                            //$data = fgetcsv($csvFile);
                            while(($csv_excel = fgets($csvFile)) !== FALSE){
                        
                                $line = explode("#", $csv_excel);
                                //$line = $csv_excel;
                                //dd($line);
                                $status = "Tidak Valid";
                                $count = count($line);
                                $page = $count;
                                $array = [];
                                for ($i=0; $i < $count; $i++) { 
                                    $clean = str_replace('"', '', $line[$i]);
                                    $clean = trim(preg_replace('/\s\s+/', ' ', $clean));
                                    // if ($i == $nik_location) {
                                    //     $clean = "'".$clean;
                                    // }
                                    $array['col'.$i] = $clean;
                                }
                                $nik = str_replace('"', '', $line[$nik_location]);
                                //dd($nik);
                                $check = DB::table('t_dpt')->where('nik',$nik)->whereNotIn('status',['tms','delete'])->count();
                                if ($check > 0) {
                                    $status = "Valid";
                                }

                                $array['col'.$count] = $status;
                                TemporaryMonggoDB::create($array);                         

                            }
                        }
                        
                    }                   
                    //close opened csv file
                    fclose($csvFile);
        
                    $data['code']    = 200;
                    $data['page']  = (int)$page;
                    $data['message'] = "Berhasil Mengimport Data DPT";
                } else {
                    $data['code']    = 500;
                    $data['message'] = "Tipe File Tidak Sesuai. Pastikan file bertipe csv";
                }
                return response()->json($data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'DptController@post_import_die';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }

    }
        
    public function download_pairing_die($coloumn){
       
        $data['data'] = TemporaryMonggoDB::select('*')->get()->toArray();
        //dd($data['data']);
        $data['coloumn'] = $coloumn;
        $date = date('d F Y H:i'); 
        TemporaryMonggoDB::whereNotNull('created_at')->delete();   

        return Excel::download(new ExportPairingResults($data), 'Hasil Sanding Data Meninggal'.$date.'.xlsx');
    }

}