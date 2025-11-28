<?php

namespace App\Http\Controllers;

use App\Model\LogAdmin;
use App\Model\LogError;
use App\Model\LogVacancyModel;
use App\Model\LogApproval;
use App\Traits\Fungsi;
use App\Model\SchollModel;
use App\CompanyVerifikasi;
use Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use DB;
use URL;
use DateTime;
use Illuminate\Routing\Controller as BaseController;
use Redirect;
use SendGrid\Mail\Mail;
use App\Classes\S3;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sidebar()
    {
        //dd(Auth::guard('admin')->user());
        $currentURL = url()->current();
        $arrayURL = explode("/",$currentURL);
        $jumlah = count($arrayURL);
        //dd($jumlah);
        dd(Auth::guard('admin')->user());
        $role_id         = Auth::guard('admin')->user()->id_role;
        $id_admin         = Auth::guard('admin')->user()->id;
        $data['id_admin'] = $id_admin;
        $data['id_cabang'] = Auth::guard('admin')->user()->id_cabang;
        $data['data_scholl'] = SchollModel::whereNull('deleted_at')->get();


        if ($jumlah == 3) {
            $id_submenu = DB::table('menus')->where('slug','dashboard')->pluck('id');
        } else if ($jumlah == 4) {
            // dd("oke");
            $menu = $arrayURL[3];
            $id_submenu = DB::table('menus')->where('slug',$menu)->pluck('id');
        } else {
            //ddd("sini");
            $menu = $arrayURL[3];
            $submenu = $arrayURL[4];
            $id_menu = DB::table('menus')->where('slug',$menu)->where('parent_menu_id',0)->pluck('menu_id');
           // dd($id_menu);
            if ($submenu == 'filter_user' || $submenu == 'detail') {
                $id_submenu = DB::table('menus')->where('slug','list-user-member')->where('parent_menu_id',$id_menu[0])->pluck('id');
            } else {
                $id_submenu = DB::table('menus')->where('slug',$submenu)->where('parent_menu_id',$id_menu[0])->pluck('id');
            }
            
        } 

        //dd($role_id);
        $validasi = DB::table('role_menus')->where('role_id',$role_id)->where('menu_id',$id_submenu[0])->first();
        
        //dd($validasi);
        //dd($validasi);
        if ($validasi == null) {
            $data['access'] = 0;
        } else {
            $data['access'] = 1;
            $data['menu']    = Fungsi::getmenu($role_id);
            //dd($data['menu']);
            $data['submenu'] = Fungsi::getsubmenu($role_id);
            $role = DB::table('roles')->where('id',$role_id)->pluck('slug');
            $data['role']    = $role[0];
        }

        $data_admin = DB::table('administrators')->where('id',$id_admin)->get();
        //dd($data_admin);
        if ($data_admin[0]->profile == null) {
            $data['admin_profile'] = base_img()."default_image.png";
        } else {
            $data['admin_profile'] = base_img().$data_admin[0]->profile;
        }

        $data['admin_name'] = $data_admin[0]->admin_name;
        $header_name = DB::table('menus')->where('id',$id_submenu)->pluck('name');
        $data['header_name'] = "";
        if ($header_name->isNotEmpty()) {
            $data['header_name'] = $header_name[0];
        }
        $data['akses'] = $validasi;
        //dd($data);

        //dd($data['data_chat']);
        //$data['jumlah_data_chat'] = count($data_chat);
        // dd($validasi);
        return $data;
    }

    public function uploadFileS3($file){
        $acces_key = env('AWS_ACCESS_KEY_ID');
        //dd($acces_key);
        $secret_key = env('AWS_SECRET_ACCESS_KEY');
        $s3 = new S3($acces_key,$secret_key);
        $bucket = 'kandidat';
        //$image = $file->hashName();
        $name = $this->cleanHazard(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        //dd($name);
        $image = $name.'_'.time().'.'.$file->getClientOriginalExtension();
        
        $file_path = public_path('images/'.$image);
        $file->move('images/', $image);
        $s3->putObjectFile($file_path, $bucket, $image, S3::ACL_PUBLIC_READ);
        //File::delete($file_path);

        return $image;
    }

    public function cleanHazard($string) {
       $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

       return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

    public function admin_data() {
        $role_id         = Auth::guard('admin')->user()->id_role;
        $id_admin         = Auth::guard('admin')->user()->id;
        $data['id_admin'] = $id_admin;
        $role = DB::table('roles')->where('id',$role_id)->pluck('slug');
        $data['role']    = $role[0];
        //$data['id_cabang'] = Auth::guard('admin')->user()->id_cabang;

        return $data;
    }

    public function ArrayCompany(){
        $role_id         = Auth::guard('admin')->user()->id_role;
        $id_admin         = Auth::guard('admin')->user()->id;
        $data['id_admin'] = $id_admin;
        $role = DB::table('roles')->where('id',$role_id)->pluck('slug');
        $rules    = $role[0];
        $admin_cabang = Auth::guard('admin')->user()->id_cabang;
        if ($rules == 'account-officer'){
            $array_m = DB::table('ao_company_relation as ao')->join('administrators as a','a.id','=','ao.id_admin')->join('company_registrations as c','c.id','=','ao.id_company')->join('company_verifikasi as cv','cv.id_company','=','c.company_id')->where('ao.id_admin',$id_admin);
            if ($admin_cabang != null) {
                $array_m = $array_m->where('cv.id_cabang',$admin_cabang);
            }
            $array_m = $array_m->pluck('c.company_id')->toArray();
            $posts   = $array_m ;
        } else {
            $terverifikasi = CompanyVerifikasi::whereNull('deleted_at');
            if ($admin_cabang != null) {
                $terverifikasi = $terverifikasi->where('id_cabang',$admin_cabang);
            }
            $terverifikasi = $terverifikasi->pluck('id_company')->toArray();
            $posts         = $terverifikasi;
        }
        return $posts;
    }

    public function LogAdmin($mac,$admin,$actifity,$menu)
    {
        date_default_timezone_set("Asia/Jakarta");
        $insertlog = array(
            'id_admin' => $admin
            , 'activity' => $actifity
            , 'menu' => $menu
            ,'mac_address' => $mac
            , 'created_at' => date('Y-m-d H:i:s')
            , 'updated_at' => date('Y-m-d H:i:s'),
        );
        LogAdmin::insert($insertlog);
        //dd("masuk");
    }

    public function get_status($status, $id, $tujuan, $url_data)
    {
        if ($status == 1) {
            $status = '<div style="float: left; margin-left: 5px;"><a id="' . $id . '" aksi="nonaktif" tujuan="' . $tujuan . '" data="' . $url_data . '" class="btn btn-success btn-sm aksi">Aktif</a></div>';
        } else {
            $status = '<div style="float: left; margin-left: 5px;"><a id="' . $id . '" aksi="aktif" tujuan="' . $tujuan . '" data="' . $url_data . '" class="btn btn-danger btn-sm aksi">Non Aktif</a></div>';
        }
        return $status;
    }

    public function get_action($id, $tujuan, $url_data)
    {
        //detail
        $action = '<div style="float: left; margin-left: 5px;"><button type="button" id="' . $id . '" class="btn btn-warning btn-sm edit_data" style="min-width: 110px;margin-left: 2px;margin-top:3px;text-align:left"><i class="fa fa-edit"></i> Detail</button></div>';
        //delete
        $action .= '<div style="float: left; margin-left: 5px;"><button type="button" class="btn btn-danger btn-sm aksi btn-aksi" id="' . $id . '" aksi="delete" tujuan="' . $tujuan . '" data="' . $url_data . '" style="min-width: 110px;margin-left: 2px;margin-top:3px;text-align:left"><i class="fa fa-trash"></i> Hapus</button></div>';
        return $action;
    }

    public function timeOri($id) {
        date_default_timezone_set("Asia/Jakarta");
        $data1 = DB::table('chat_user')->where('id_user',$id)->orderBy('created_at','desc')->pluck('created_at');
        if ($data1->isNotEmpty()) {
            $data2 = DB::table('chat_admin')->where('id_member',$id)->orderBy('created_at','desc')->pluck('created_at');
            if ($data2->isNotEmpty()) {
                if ($data1[0] > $data2[0]) {
                    
                    $times = $data1[0];
                } else {
                    
                    $times = $data2[0];
                }
            } else {
                
                $times = $data1[0];
            }
        } else {
            $data2 = DB::table('chat_admin')->where('id_member',$id)->orderBy('created_at','desc')->pluck('created_at');
            $times = $data2[0];
        }
        
        return $times;
    }

    public function InsertErrorSystem($data) {
        date_default_timezone_set("Asia/Jakarta");
        $id_o = null;
        if (isset(Auth::guard('admin')->user()->id)) {
            $id_o = Auth::guard('admin')->user()->id;
        }
        $data_insert = array(
            'exception' => $data['message'],
            'line_error' => $data['line'],
            'controller' => $data['controller'],
            'id_user'    => $id_o,
            );
        $insert = LogError::insertGetId($data_insert);
        return $insert;
    }

    public function AdminName($id) {
    $return = null;
    $data = DB::table('administrators')->where('id',$id)->pluck('admin_name');
        if ($data->isNotEmpty()) {
            $return = $data[0];
        }
        return $return;
    }

    

    public function GetColoumnValue($id,$table,$coloumn){
        $return = "";
        $data = DB::table($table)->where('id',$id)->pluck($coloumn);
        if ($data->isNotEmpty()) {
            $return = $data[0];
        }
        return $return;
    }

    public function ZenzifaWa($phone,$message){
        //Send Kode OTP Via WA
        $userkey=env('USERKEY_ZENZIFA');// userkey lihat di zenziva
        $passkey=env('PASSKEY_ZENZIFA');
        $url = "https://gsm.zenziva.net/api/sendWA/";
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $url);
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS,
        'userkey='.$userkey.'&passkey='.$passkey.'&nohp='.$phone.'&pesan='.$message);
        curl_setopt($curlHandle, CURLOPT_HEADER, 0);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curlHandle, CURLOPT_TIMEOUT,30);
        curl_setopt($curlHandle, CURLOPT_POST, 1);
        $results = curl_exec($curlHandle);

        return $results;
    }

    public function SendMailFunction($i_email, $i_name,$title,$substitute,$template_id){
        $email = new Mail();
        $email->setFrom("hidupbarudev@gmail.com", "IPEKA Notifications");
        $email->setSubject($title);
        $email->addTo($i_email, $i_name);
        $email->setTemplateId($template_id);

        $substitutions = $substitute;
        $email->addDynamicTemplateDatas($substitutions);
        $sendgrid = new \SendGrid(env('USERKEY_ZENZIFA'));
        try {
            $response = $sendgrid->send($email);

            // print $response->statusCode() . "\n";
            // print_r($response->headers());
            // print $response->body() . "\n";
            $code = $response->statusCode();
        } catch (Exception $e) {
            //echo 'Caught exception: '.  $e->getMessage(). "\n";
            $code = 500;
        }
        return $code;
    }

      
}
