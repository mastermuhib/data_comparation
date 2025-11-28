<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Administrator;
use Auth;
use Redirect;
use Illuminate\Support\MessageBag;
use DB;
use App\Exceptions\Handler;
use Illuminate\Support\Facades\Hash;
use App\Model\ParticipantModel;
use App\Traits\Fungsi;

class Logincontroller extends Controller
{
    public function login(Request $request)
    {
        try {
            //dd("masuk sinni");
            //dd($request->username);
            if ($request->username == null || $request->username == '') {
                //dd("masuk sinni");
                $errors = new MessageBag(['username' => ['Username wajib diisi']]);
                return Redirect::back()->withErrors($errors);
            }
            //dd("masuk sanna");

            if ($request->password == null || $request->password == '') {
                $errors = new MessageBag(['password' => ['Password wajib diisi']]);
                return Redirect::back()->withErrors($errors);
            }

            // dd(Administrator::get());
            // dd($request->all());
            $cek = Administrator::where('email', $request->username)->whereNull('deleted_at')->get();
            // $cekok = Administrator::get();
            //dd($cek);
            if ($cek->isNotEmpty()) {
                $role = $cek[0]->id_role;
                //dd($role);
                // $status = DB::table('roles')->where('id',$role)->pluck('slug');

                // if ($status[0] != 'company') {
                if (Auth::guard('admin')->attempt(['email' => $request->username, 'password' => $request->password])) {
                    // dd("success");
                    $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Login ke System','Login');
                    return redirect()->intended('/dashboard');

                } else {
                    $errors = new MessageBag(['password' => ['Your Email Or password invalid!. Please Check and Try Again!!!!']]);
                     return Redirect::back()->withErrors($errors);
                }
                // } else {
                //      $errors = new MessageBag(['password' => ['Email Tidak Terdaftar di System']]);
                //      return Redirect::back()->withErrors($errors);
                // }
            } else {
                 $errors = new MessageBag(['password' => ['Email Tidak Terdaftar di System']]);
                 return Redirect::back()->withErrors($errors);
            }
        // dd($request->all());
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'LoginController@login';
            $insert_error = parent::InsertErrorSystem($data);
            $error = parent::sidebar();
            $error['id'] = $insert_error;
            return view('errors.index',$error); // jika Metode Get
            //return response()->json($data); // jika metode Post
        }
    }

    public function logout(){
        try {
            $id_admin = Auth::guard('admin')->user()->id;
            date_default_timezone_set('Asia/Jakarta');
            $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Keluar dari System','Log Out');
            Auth::guard('admin')->logout();
            return redirect('/');
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'LoginController@logout';
            $insert_error = parent::InsertErrorSystem($data);
            $error = parent::sidebar();
            $error['id'] = $insert_error;
            return view('errors.index',$error); // jika Metode Get
            //return response()->json($data); // jika metode Post
        }
    }

    public function cronjobs_kirim_password(){
        try {
            //$id_admin = Auth::guard('admin')->user()->id;
            date_default_timezone_set('Asia/Jakarta');
            //$insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Cronjobs Mengirimkan Password','Cronjobs');
            $data = DB::table('participant')->whereNull('password')->whereNull('deleted_at')->orderBy('participant_name','asc')->take(10)->get();
            //dd($data);
            //$pass = $this->randomPassword();
            foreach ($data as $k => $v) {
                //$cekhp = substr($v->participant_phone, -1);
                //if ($cekhp == 0 || $cekhp == 1 || $cekhp == 2 || $cekhp == 3 ){ //Kondisi
                    $pass = $this->randomPassword();
                    $data_update = ['password'=>Hash::make($pass),'confirm_password'=>encrypt($pass),'created_otp'=>date('Y-m-d H:i:s'),'updated_at'=>null];
                    $update = ParticipantModel::where('id',$v->id)->update($data_update);
                    $message1 = 'Rahasia! Halo Alumni Teknik UI! Password: '.$pass.' bisa kamu gunakan untuk mengaktifkan akun di pemira.iluniteknik.org! Yuk, login!';
                    $phone = substr($v->participant_phone, 1);
                    //dd($phone);
                    //$send_message = Fungsi::BlastWA($message1,$phone);
                    $send_message = Fungsi::sendWa_zenzifa($phone,$message1);
                    $send_email = Fungsi::EmailSending($v->participant_email,$pass,$v->participant_name);
                //}
                
            }
            $count = DB::table('participant')->whereNull('password')->whereNull('deleted_at')->count();
            dd($count);
            
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'LoginController@cronjobs_kirim_password';
            $insert_error = parent::InsertErrorSystem($data);
            // $error = parent::sidebar();
            // $error['id'] = $insert_error;
            // return view('errors.index',$error); // jika Metode Get
            return response()->json($data); // jika metode Post
        }
    }

    public function cronjobs_kirim_password_two(){
        try {
            $id_admin = Auth::guard('admin')->user()->id;
            date_default_timezone_set('Asia/Jakarta');
            $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Cronjobs Mengirimkan Password','Cronjobs');
            $data = DB::table('participant')->whereNull('password')->whereNull('deleted_at')->orderBy('participant_name','asc')->take(30)->get();
            //dd($data);
            //$pass = $this->randomPassword();
            foreach ($data as $k => $v) {
                $cekhp = substr($v->participant_phone, -1);
                if ($cekhp == 5 || $cekhp == 6 || $cekhp == 4 ){ //Kondisi
                    $pass = $this->randomPassword();
                    $data_update = ['password'=>Hash::make($pass),'confirm_password'=>encrypt($pass),'created_otp'=>date('Y-m-d H:i:s'),'updated_at'=>null];
                    $update = ParticipantModel::where('id',$v->id)->update($data_update);
                    $message1 = 'Rahasia! Halo Alumni Teknik UI! Password: '.$pass.' bisa kamu gunakan untuk mengaktifkan akun di pemira.iluniteknik.org! Yuk, login!';
                    $phone = substr($v->participant_phone, 1);
                    //dd($phone);
                    $send_message = Fungsi::BlastWA_two($message1,$phone);
                    $send_email = Fungsi::EmailSending($v->participant_email,$pass,$v->participant_name);
                }
                
            }
            $count = DB::table('participant')->whereNull('password')->whereNull('deleted_at')->count();
            dd($count);
            
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'LoginController@cronjobs_kirim_password';
            $insert_error = parent::InsertErrorSystem($data);
            // $error = parent::sidebar();
            // $error['id'] = $insert_error;
            // return view('errors.index',$error); // jika Metode Get
            return response()->json($data); // jika metode Post
        }
    }

    public function cronjobs_kirim_password_tiga(){
        try {
            $id_admin = Auth::guard('admin')->user()->id;
            date_default_timezone_set('Asia/Jakarta');
            $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Cronjobs Mengirimkan Password','Cronjobs');
            $data = DB::table('participant')->whereNull('password')->whereNull('deleted_at')->orderBy('participant_name','asc')->take(30)->get();
            //dd($data);
            //$pass = $this->randomPassword();
            foreach ($data as $k => $v) {
                $cekhp = substr($v->participant_phone, -1);
                if ($cekhp == 7 || $cekhp == 8 || $cekhp == 9){ //Kondisi
                    $pass = $this->randomPassword();
                    $data_update = ['password'=>Hash::make($pass),'confirm_password'=>encrypt($pass),'created_otp'=>date('Y-m-d H:i:s'),'updated_at'=>null];
                    $update = ParticipantModel::where('id',$v->id)->update($data_update);
                    $message1 = 'Rahasia! Halo Alumni Teknik UI! Password: '.$pass.' bisa kamu gunakan untuk mengaktifkan akun di pemira.iluniteknik.org! Yuk, login!';
                    $phone = substr($v->participant_phone, 1);
                    //dd($phone);
                    $send_message = Fungsi::BlastWA_tiga($message1,$phone);
                    $send_email = Fungsi::EmailSending($v->participant_email,$pass,$v->participant_name);
                }
                
            }
            $count = DB::table('participant')->whereNull('password')->whereNull('deleted_at')->count();
            dd($count);
            
        } catch (\Exception $e) {
            $data['code']    = 500;
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['controller'] = 'LoginController@cronjobs_kirim_password';
            $insert_error = parent::InsertErrorSystem($data);
            // $error = parent::sidebar();
            // $error['id'] = $insert_error;
            // return view('errors.index',$error); // jika Metode Get
            return response()->json($data); // jika metode Post
        }
    }
 
    public function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!#$';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 11; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public function cronjobs_data_sama(){
        
        $data = ParticipantModel::whereNull('deleted_at')->get();
        $search = null;
        foreach ($data as $k => $v) {
            $same_by_npm = ParticipantModel::whereNull('deleted_at')->where('id','!=',$v->id)->where(function ($query) use ($search,$v) {
                    $query->where('nik',$v->nik)->where(function ($query2) use ($v) {
                        $query2->whereNotNull('nik')->where('nik','!=','');
                    });
                    $query->orWhere('nik2',$v->nik)->where(function ($query2) use ($v) {
                        $query2->whereNotNull('nik2')->where('nik2','!=','');
                    });
                    $query->orWhere('nik3',$v->nik)->where(function ($query2) use ($v) {
                        $query2->whereNotNull('nik3')->where('nik3','!=','');
                    });
                    $query->orWhere('nik',$v->nik2)->where(function ($query2) use ($v) {
                        $query2->whereNotNull('nik')->where('nik','!=','');
                    });
                    $query->orWhere('nik2',$v->nik2)->where(function ($query2) use ($v) {
                        $query2->whereNotNull('nik2')->where('nik2','!=','');
                    });
                    $query->orWhere('nik3',$v->nik2)->where(function ($query2) use ($v) {
                        $query2->whereNotNull('nik3')->where('nik3','!=','');
                    });
                    $query->orWhere('nik',$v->nik3)->where(function ($query2) use ($v) {
                        $query2->whereNotNull('nik')->where('nik','!=','');
                    });
                    $query->orWhere('nik2',$v->nik3)->where(function ($query2) use ($v) {
                        $query2->whereNotNull('nik2')->where('nik2','!=','');
                    });
                    $query->orWhere('nik3',$v->nik3)->where(function ($query2) use ($v) {
                        $query2->whereNotNull('nik3')->where('nik3','!=','');
                    });
                })->count();
            $same_by_name = ParticipantModel::whereNull('deleted_at')->where('id','!=',$v->id)->where('participant_name',$v->participant_name)->count();
            $same_by_email = ParticipantModel::whereNull('deleted_at')->where('id','!=',$v->id)->where('participant_email',$v->participant_name)->count();
            $same_by_phone = ParticipantModel::whereNull('deleted_at')->where('id','!=',$v->id)->where('participant_phone',$v->participant_name)->count();

            $data_insert = ['id_user'=>$v->id,
                            'same_by_phone'=>$same_by_phone,
                            'same_by_email'=>$same_by_email,
                            'same_by_name'=>$same_by_name,
                            'same_by_npm'=>$same_by_npm,
                           ];
            $cek = DB::table('participant_is_same')->where('id_user',$v->id)->get();
            if ($cek->isNotEmpty()) {
                $insert = DB::table('participant_is_same')->where('id_user',$v->id)->update($data_insert);
            } else {
                $insert = DB::table('participant_is_same')->insert($data_insert);
            }

        }
        dd("suksess");
    }

    public function pasien_failed(){
        $insertDB = DB::table('cronjobs')->insert(['cronjob_task'=>"Get Pasien Gagal",'type'=>3,'status'=>0,'created_at'=>date('Y-m-d H:i:s'),'date'=>date('Y-m-d')]);
        $data_pasien = DB::table('patients')->whereNull('patient_code')->orWhere('patient_code',0)->get();
        foreach ($data_pasien as $key => $value) {
            $curl = curl_init();

            $headers = array();
            $headers = array ('Authentication-Key: foobar','Content-Type: application/json','verif_token: EX_001klmnay!YZz001');

            $end_point = 'https://machine.genika.app/add_pasien';

            $data['nama'] = $value->patient_name;
            $data['gender'] = (int)$value->gender;
            $data['tanggal_lahir'] = $value->birthday;
            $data['email'] = $value->patient_email;
            $data['alamat'] = $value->address;

            $payload = json_encode($data); 

            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_USERPWD, "");
            curl_setopt($curl, CURLOPT_URL, $end_point);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($curl);
            curl_close($curl);
            // dd($response);
            $responseObject = json_encode($response, true);
            $get_code = str_replace('"', '', $responseObject);

            $update = DB::table('patients')->where('id',$value->id)->update(['patient_code'=>(int)$get_code]);
       
        }
        $insertDB = DB::table('cronjobs')->insert(['cronjob_task'=>"Get Pasien Gagal",'result'=>count($data_pasien),'type'=>3,'status'=>1,'created_at'=>date('Y-m-d H:i:s'),'date'=>date('Y-m-d')]);
        dd("success");
    }

    public function transactions_failed(){
        //dd("dancook");
        //kirim ke mesin
        $insertDB = DB::table('cronjobs')->insert(['cronjob_task'=>"Get Transaksi Gagal",'type'=>4,'status'=>0,'created_at'=>date('Y-m-d H:i:s'),'date'=>date('Y-m-d')]);
        $in_trans =  DB::table('relation_transaction_machine')->pluck('id_transaction')->toArray();
        //dd($in_trans);
        $data_transaksi = DB::table('transactions')->where('id','3eda2d0b-e8ac-4d08-a9b6-73ddf8f90dab')->get();
        //dd($data_transaksi);
        //
        $has = [];
        foreach ($data_transaksi as $k => $v) {
            $the_data = [];
            $data_x = DB::table('detail_transactions')->where('id_transaction',$v->id)->get();
            foreach ($data_x as $a => $b) {
                $data_pasien = DB::table('patients')->where('id',$b->id_pasien)->orWhere('id_user',$b->id_pasien)->first();
                $the_data[] = [
                    "code"           => $data_pasien->patient_code,
                    "jumlah_produk"  => $b->quantity,
                    "test"           => $this->getCarts($b->tipe,$b->id_product,$b->id_package),
                ];
            }
            $curl = curl_init();
            $headers = array();
            $headers = array ('Authentication-Key: foobar','Content-Type: application/json','verif_token: EX_001klmnay!YZz001');
            $end_point = 'https://machine.genika.app/add_invoice';
            $data_m['nominal']  = $v->nominal;
            $data_m['discount']     = $v->discount;
            $data_m['total']        = $v->total_off_pay;
            $data_m['data']     = $the_data;
            $data_m['tanggal']  = $v->tanggal_pengambilan;
            $payload = json_encode($data_m); 
            //dd($payload);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_USERPWD, ":");
            curl_setopt($curl, CURLOPT_URL, $end_point);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $responses = curl_exec($curl);
            curl_close($curl);
            //dd($responses);
            $responseObject = json_decode($responses, true);
            //dd($responseObject);
            if ($responseObject != null) {
                $has[] = $v->id;
                foreach ($responseObject as $resob) {
                    $code_tubes = $resob['code_tubes'];
                    //dd($code_tubes);
                    $tubes = $resob['tubes'];
                    $nama_tes = $resob['nama_tes'];
                    $jumlah = count($tubes);
                    //return $jumlah;

                    for ($k=0; $k < $jumlah;$k++) {
                        $data_mesins = [
                            "id_transaction"    => $v->id,
                            "id_machine"        => $resob['id_mesin'],
                            "code_patient"      => $resob['kode_pasien'],
                            "nomor_rekam_medis" => $resob['nomor_rekam'],
                            "code_machine"      => $resob['no_mesin'],
                            "code_tubes"        => $code_tubes[$k],
                            "tubes"             => $tubes[$k],
                            "nama_tes"          => $nama_tes[$k],
                            "created_at"        => date('Y-m-d H:i:s'),
                            "updated_at"        => date('Y-m-d H:i:s'),
                        ];
                        $simpan_mesin = DB::table('relation_transaction_machine')->insertGetId($data_mesins);
                    }
                }
            } 
        }
        $insertDB = DB::table('cronjobs')->insert(['cronjob_task'=>"Get Transaksi Gagal",'result'=>count($data_transaksi),'type'=>4,'status'=>1,'created_at'=>date('Y-m-d H:i:s'),'date'=>date('Y-m-d')]);
        dd($has);
    }

    public function getCarts($tipe,$id_product,$id_package)
    {
        
        if ($tipe == 1) {
           $myProdukss = DB::table('products')
                    ->where('id',$id_product)
                    ->select('product_name as nama','price','code','id')
                    ->get()
                    ->first();

            $harga_d =  (string)cekDiskon($myProdukss->id,1);
            $return[] = [
                "products"  => $myProdukss->nama,
                "harga"     => $harga_d,
                "code"      => $myProdukss->code,
            ];
        } else {
            $myProdukss = DB::table('relation_product_packages')
                        ->join('products','products.id','=','relation_product_packages.id_product')
                        ->where('relation_product_packages.id_package',$id_package)
                        ->select('products.product_name as nama','products.price','products.code','products.id')
                        ->get();

            foreach ($myProdukss as $mpss => $vsss) {
                    $harga_d = (string)cekDiskon($vsss->id,2);
                    $return[] = [
                        "products"  => $vsss->nama,
                        "harga"     => $harga_d,
                        "code"      => $vsss->code,
                    ];
            }
        }
  
        return $return;
    }

    public function cronjobs_tgl_lahir(){
        $data = DB::table('users')->whereNull('deleted_at')->get();
        foreach ($data as $k => $v) {
            $update = DB::table('patients')->where('id_user',$v->id)->update(['birthday'=>date('Y-m-d',strtotime($v->birthday))]);
        }
        dd("successs");
    }

}
