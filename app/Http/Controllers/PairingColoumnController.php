<?php

namespace App\Http\Controllers;

use App\Model\RoleModel;
use App\Model\dptModel;
use App\Model\DistrictModel;
use App\Model\KlasifikasiModel;
use App\Model\CityModel;
use App\Model\UserModel;
use Maatwebsite\Excel\Facades\Excel;
use App\Model\Tabel1DBModel;
use App\Model\Tabel2DBModel;
use App\Classes\upload;
use App\Traits\Fungsi;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Exports\ExportPairingResults;
use App\Exceptions\Handler;

class PairingColoumnController extends Controller
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
                return view('dpt.banding', $data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'PairingColoumnController@pairing';
            $insert_error = parent::InsertErrorSystem($data);
            $error = parent::sidebar();
            $error['id'] = $insert_error;
            return view('errors.index',$error); 
        }
    }

    public function post(Request $request){
        
        try {
            
            $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain','csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/vnd.ms-excel','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            
            $nik1 = (int)$request->nik1 - 1;
            $nik2 = (int)$request->nik2 - 1;
            $page = 0;
            if(empty($_FILES['file1']['name'])) {
                $data['code']    = 500;
                $data['message'] = "File Kosong";
                return response()->json($data);
            } else {
                if(in_array($_FILES['file1']['type'],$csvMimes)){
                    if(is_uploaded_file($_FILES['file1']['tmp_name'])){ 
                        // check file size
                        if(filesize($_FILES['file1']['tmp_name']) > 51200000000000000) {
                            $data['code']    = 500;
                            $data['message'] = "File Maksimal 500 Mb";
                        } else {
                            //open uploaded csv file with read only mode
                            $csvFile1 = fopen($_FILES['file1']['tmp_name'], 'r');
                            //skip first line
                            fgets($csvFile1);
                            //parse data from csv file line by line
                            //$data = fgetcsv($csvFile);
                            while(($csv_excel1 = fgets($csvFile1)) !== FALSE){
                        
                                $line = explode("#", $csv_excel1);
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
                                                                
                                Tabel1DBModel::create($array);                         

                            }
                        }
                        
                    }                   
                    //close opened csv file
                    fclose($csvFile1);                     
                            
                    
                } else {
                    $data['code']    = 500;
                    $data['message'] = "Tipe File Tidak Sesuai. Pastikan file bertipe csv";
                    return response()->json($data);
                }

                if(in_array($_FILES['file1']['type'],$csvMimes)){
                    //pairing function
                    if(is_uploaded_file($_FILES['file2']['tmp_name'])){ 
                        // check file size
                        if(filesize($_FILES['file2']['tmp_name']) > 51200000000000000) {
                            $data['code']    = 500;
                            $data['message'] = "File Maksimal 500 Mb";
                        } else {
                            //open uploaded csv file with read only mode
                            $csvFile2 = fopen($_FILES['file2']['tmp_name'], 'r');
                            //skip first line
                            fgets($csvFile2);
                            //parse data from csv file line by line
                            //$data = fgetcsv($csvFile);
                            while(($csv_excel2 = fgets($csvFile2)) !== FALSE){
                        
                                $line = explode("#", $csv_excel2);
                                //$line = $csv_excel;
                                //dd($line);
                                $status = "Tidak ada";
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
                                $nik = str_replace('"', '', $line[$nik2]);
                                //dd($nik);
                                $check = Tabel1DBModel::where('col'.$nik1,$nik)->count();
                                if ($check > 0) {
                                    $status = "Ada";
                                }

                                $array['col'.$count] = $status;
                                Tabel2DBModel::create($array);                         

                            }
                        }
                        
                    } 
                    //close opened csv file
                    fclose($csvFile2);   

                } else {
                    $data['code']    = 500;
                    $data['message'] = "Tipe File Tidak Sesuai. Pastikan file bertipe csv";
                    return response()->json($data);
                }
                $data['code']    = 200;
                $data['page']  = (int)$page;
                $data['message'] = "Berhasil Mengimport Data DPT";
                return response()->json($data);
            }
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'PairingColoumnController@post_import_dpt';
            $insert_error = parent::InsertErrorSystem($data);
            return response()->json($data); // jika metode Post
        }

    }
        
    public function download($coloumn){
       
        $data['data'] = Tabel2DBModel::select('*')->get()->toArray();
        //dd($data['data']);
        $data['coloumn'] = $coloumn;
        $date = date('d F Y H:i'); 
        Tabel1DBModel::whereNotNull('created_at')->delete();
        Tabel2DBModel::whereNotNull('created_at')->delete();   

        return Excel::download(new ExportPairingResults($data), 'Hasil Banding Data'.$date.'.xlsx');
    }

    
}