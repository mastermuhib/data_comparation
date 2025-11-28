<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\upload;
use App\Traits\Fungsi;
use App\Model\NotifikasiModel;
use App\Model\SchollModel;
use App\Model\RoleModel;
use Auth;
use DB;
use Redirect;

class NotifikasiController extends Controller
{
    public function index()
    {
    	$role_id = Auth::guard('admin')->user()->role_id;
        $data = parent::sidebar();
        if ($data['access'] == 0) {
            return redirect('/');
        } else {
              $data['name_adm'] = Auth::guard('admin')->user()->name;
              $data['data_scholl'] = SchollModel::whereNull('deleted_at')->get();

            return view('notifications.index', $data);
        }
    }

    public function list_data()
    {
    	 $admin = DB::table('t_notifications as n')
                ->leftjoin('students as s','s.id','=','n.id_user')
                ->leftjoin('table_scholls as sc','sc.id','=','n.id_scholl')
                ->leftjoin('table_class as c','c.id','=','n.id_class')
                ->leftjoin('student_parents as sp','sp.id','=','n.id_parent')
                ->leftjoin('teachers as t','t.id','=','n.id_teacher');
        if(Auth::guard('admin')->user()->id_scholl != null) {
            $admin = $admin->where('n.id_scholl',Auth::guard('admin')->user()->id_scholl);
        }

        $admin = $admin->select('n.*','student_name','scholl_name','class_name','student_parent_name','teacher_name')
                ->whereNull('n.deleted_at')
                ->orderBy('n.created_at', 'desc')
                ->get();
        // Datatables Variables
        $draw   = 10;
        $start  = 0;
        $length = 10;

        $data = array();
        $no   = 0;
        foreach ($admin as $d) {
           if ($d->status == 1) {
                $status = '<div style="float: left; margin-left: 5px;">
                    <button type="button" id="' . $d->id . '" aksi="nonaktif" tujuan="notifikasi" data="data_notifikasi" class="btn btn-success btn-sm aksi">Aktif</button>
                    </div>';
            } else {
                $status = '<div style="float: left; margin-left: 5px;">
                    <button type="button" id="' . $d->id . '" data="data_notifikasi" aksi="aktif" tujuan="notifikasi" class="btn btn-danger btn-sm aksi">Non Aktif</button>
                    </div>';
            }
            if ($d->tipe == '0'){
                $name = "Semua User";
                $tipe = "User Umum";
            } else if ($d->tipe == '1'){
                $name = "Semua Siswa";
                $tipe = "Siswa";
            } else if ($d->tipe == '2'){
                $name = "Semua Guru";
                $tipe = "Guru";
            } else {
                $name = "Semua Orang Tua";
                $tipe = "Orang Tua";
            }
            
            if ($d->scholl_name != null) {
                $name = $d->scholl_name;
                if ($d->class_name != null) {
                    $name .= " - ".$d->class_name;
                }

                if ($d->student_parent_name != null) {
                    $name .= " - ".$d->student_parent_name;
                }

                if ($d->student_name != null) {
                    $name .= " - ".$d->student_name;
                }

                if ($d->teacher_name != null) {
                    $name .= " - ".$d->teacher_name;
                }
            } 

            $text = strip_tags($d->text);
            $length_str = strlen($text);
            if ($length_str > 100) {
                $text = substr($text, 0, 100).' ....';
            }

            $no     = $no + 1;
            $data[] = array(
                $no,
                $tipe,
                $d->title,
                $name,
                $text,
                date('d F Y H:i',strtotime($d->created_at)),
                '<div style="float: left; margin-left: 5px;">
                    <button type="button" class="btn btn-danger btn-sm aksi btn-aksi" data="data_notifikasi"  id="' . $d->id . '" aksi="delete" tujuan="notifikasi" style="min-width: 110px;margin-left: 2px;margin-top:3px;text-align:left"><i class="fa fa-trash"></i> Hapus</button>
                </div>',
            );
        }
         $output = array(
            "draw"            => $draw,
            "recordsTotal"    => count($admin),
            "recordsFiltered" => count($admin),
            "data"            => $data,
        );
        echo json_encode($output);
        exit();
    }

    public function post(Request $request)
    {
        $input = $request->all();
        $image = null;
        if ($request->file('image')) {
            $image  = parent::uploadFileS3($request->file('image'));
        } 

        //umum
        $is_umum = 1;
        if ($request->id_scholl != null || $request->id_scholl != '') {
            $is_umum = 0;
        }
        $messages = strip_tags($request->deskripsi);

        if ($request->tipe == 0) {
            //$user = DB::table('users')->whereNull('deleted_at')->whereNotNull('user_email')->get();
            $insertadmin = array(
                'id_scholl' => $request->id_scholl,
                'id_class' => $request->id_class,
                'text' => $request->deskripsi,
                'title' => $request->title,
                'status'      => 1,
                'tipe'      => $request->tipe,
                'is_umum' => $is_umum,
                'created_by' => Auth::guard('admin')->user()->id,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
                );
                $insert = DB::table('t_notifications')->insertGetId($insertadmin);
                // kirim ke siswa
                $siswa = DB::table('students')->where('status',1)->select('id','student_name','email')->get();
                foreach ($siswa as $k => $v) {
                    $substitute = [
                        "name" => $v->student_name,
                        "message" => strip_tags($request->deskripsi),
                        "sekolah" => 'Yayasan IPEKA Kantor Pusat'
                    ];
                    //send email
                    $send_email = parent::SendMailFunction($v->email, $v->student_name,'Notifikasi UKS',$substitute,'d-864064d3888d48dc8e34f002b68125fb');
                }

                // kirim ke guru
                $guru = DB::table('teachers')->where('status',1)->select('id','teacher_name','email')->get();
                foreach ($guru as $a => $b) {
                    $substitute = [
                        "name" => $b->teacher_name,
                        "message" => strip_tags($request->deskripsi),
                        "sekolah" => 'Yayasan IPEKA Kantor Pusat'
                    ];
                    //send email
                    $send_email = parent::SendMailFunction($b->email, $b->teacher_name,'Notifikasi UKS',$substitute,'d-864064d3888d48dc8e34f002b68125fb');
                }

                // kirim ke orang tua
                $ortu = DB::table('student_parents')->where('status',1)->select('id','student_parent_name','email')->get();
                foreach ($ortu as $c => $d) {
                    $substitute = [
                        "name" => $d->student_parent_name,
                        "message" => strip_tags($request->deskripsi),
                        "sekolah" => 'Yayasan IPEKA Kantor Pusat'
                    ];
                    //send email
                    $send_email = parent::SendMailFunction($d->email, $d->student_parent_name,'Notifikasi UKS',$substitute,'d-864064d3888d48dc8e34f002b68125fb');
                }
            $insert_log = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Menambah Notifikasi Umum','Notifikasi');
        //khusus
        } else if($request->tipe == 1) {
            if ($request->id_scholl != null || $request->id_scholl != '') {
                $scholl_name = DB::table('table_scholls')->where('id',$request->id_scholl)->pluck('scholl_name');
                if (count($request->id_user) > 0) {
                    if ($request->id_user[0] != null || $request->id_user[0] != '') {
                        for ($i=0; $i < count($request->id_user); $i++) { 
                            $insertadmin = array(
                            'id_scholl' => $request->id_scholl,
                            'id_user' => $request->id_user[$i],
                            'id_class' => $request->id_class,
                            'text' => $request->deskripsi,
                            'title' => $request->title,
                            'status'      => 1,
                            'tipe'      => $request->tipe,
                            'is_umum' => $is_umum,
                            'created_by' => Auth::guard('admin')->user()->id,
                            'created_at'  => date('Y-m-d H:i:s'),
                            'updated_at'  => date('Y-m-d H:i:s'),
                            );
                            $insert = DB::table('t_notifications')->insertGetId($insertadmin);
                            // kirim ke siswa
                            $siswa = DB::table('students')->where('id',$request->id_user[$i])->where('status',1)->select('id','student_name','email')->get();
                            foreach ($siswa as $k => $v) {
                                $substitute = [
                                    "name" => $v->student_name,
                                    "message" => $messages,
                                    "sekolah" => 'Yayasan IPEKA Kantor Pusat'
                                ];
                                //send email
                                $send_email = parent::SendMailFunction($v->email, $v->student_name,'Notifikasi UKS',$substitute,'d-864064d3888d48dc8e34f002b68125fb');
                            }
                        }
                    } else {
                        if ($request->id_class != null || $request->id_class != '') {
                            $insertadmin = array(
                            'id_scholl' => $request->id_scholl,
                            'id_scholl' => $request->id_class,
                            'text' => $request->deskripsi,
                            'title' => $request->title,
                            'status'      => 1,
                            'tipe'      => $request->tipe,
                            'is_umum' => $is_umum,
                            'created_by' => Auth::guard('admin')->user()->id,
                            'created_at'  => date('Y-m-d H:i:s'),
                            'updated_at'  => date('Y-m-d H:i:s'),
                            );
                            $insert = DB::table('t_notifications')->insertGetId($insertadmin);
                            $in_rel = DB::table('student_class_relations')->where('id_class',$request->id_class)->where('is_active',1)->pluck('id_student')->toArray();
                            // kirim ke siswa
                            $siswa = DB::table('students')->whereIn('id',$in_rel)->where('status',1)->select('id','student_name','email')->get();
                            foreach ($siswa as $k => $v) {
                                $substitute = [
                                    "name" => $v->student_name,
                                    "message" => $messages,
                                    "sekolah" => 'Yayasan IPEKA Kantor Pusat'
                                ];
                                //send email
                                $send_email = parent::SendMailFunction($v->email, $v->student_name,'Notifikasi UKS',$substitute,'d-864064d3888d48dc8e34f002b68125fb');
                            }
                        } else {
                            $insertadmin = array(
                            'id_scholl' => $request->id_scholl,
                            'id_scholl' => $request->id_class,
                            'text' => $request->deskripsi,
                            'title' => $request->title,
                            'status'      => 1,
                            'tipe'      => $request->tipe,
                            'is_umum' => $is_umum,
                            'created_by' => Auth::guard('admin')->user()->id,
                            'created_at'  => date('Y-m-d H:i:s'),
                            'updated_at'  => date('Y-m-d H:i:s'),
                            );
                            $insert = DB::table('t_notifications')->insertGetId($insertadmin);
                            $in_rel = DB::table('student_class_relations as s')->join('table_class as c','c.id','s.id_class')->where('id_scholl',$request->id_scholl)->where('is_active',1)->pluck('id_student')->toArray();
                            // kirim ke siswa
                            $siswa = DB::table('students')->whereIn('id',$in_rel)->where('status',1)->select('id','student_name','email')->get();
                            foreach ($siswa as $k => $v) {
                                $substitute = [
                                    "name" => $v->student_name,
                                    "message" => $messages,
                                    "sekolah" => 'Yayasan IPEKA Kantor Pusat'
                                ];
                                //send email
                                $send_email = parent::SendMailFunction($v->email, $v->student_name,'Notifikasi UKS',$substitute,'d-864064d3888d48dc8e34f002b68125fb');
                            }
                        }
                    }
                    
                } else {
                    if ($request->id_class != null || $request->id_class != '') {
                        $insertadmin = array(
                        'id_scholl' => $request->id_scholl,
                        'id_scholl' => $request->id_class,
                        'text' => $request->deskripsi,
                        'title' => $request->title,
                        'status'      => 1,
                        'tipe'      => $request->tipe,
                        'is_umum' => $is_umum,
                        'created_by' => Auth::guard('admin')->user()->id,
                        'created_at'  => date('Y-m-d H:i:s'),
                        'updated_at'  => date('Y-m-d H:i:s'),
                        );
                        $insert = DB::table('t_notifications')->insertGetId($insertadmin);
                        $in_rel = DB::table('student_class_relations')->where('id_class',$request->id_class)->where('is_active',1)->pluck('id_student')->toArray();
                        // kirim ke siswa
                        $siswa = DB::table('students')->whereIn('id',$in_rel)->where('status',1)->select('id','student_name','email')->get();
                        foreach ($siswa as $k => $v) {
                            $substitute = [
                                "name" => $v->student_name,
                                "message" => $messages,
                                "sekolah" => 'Yayasan IPEKA Kantor Pusat'
                            ];
                            //send email
                            $send_email = parent::SendMailFunction($v->email, $v->student_name,'Notifikasi UKS',$substitute,'d-864064d3888d48dc8e34f002b68125fb');
                        }
                    } else {
                        $insertadmin = array(
                        'id_scholl' => $request->id_scholl,
                        'id_scholl' => $request->id_class,
                        'text' => $request->deskripsi,
                        'title' => $request->title,
                        'status'      => 1,
                        'tipe'      => $request->tipe,
                        'is_umum' => $is_umum,
                        'created_by' => Auth::guard('admin')->user()->id,
                        'created_at'  => date('Y-m-d H:i:s'),
                        'updated_at'  => date('Y-m-d H:i:s'),
                        );
                        $insert = DB::table('t_notifications')->insertGetId($insertadmin);
                        $in_rel = DB::table('student_class_relations as s')->join('table_class as c','c.id','s.id_class')->where('id_scholl',$request->id_scholl)->where('is_active',1)->pluck('id_student')->toArray();
                        // kirim ke siswa
                        $siswa = DB::table('students')->whereIn('id',$in_rel)->where('status',1)->select('id','student_name','email')->get();
                        foreach ($siswa as $k => $v) {
                            $substitute = [
                                "name" => $v->student_name,
                                "message" => $messages,
                                "sekolah" => 'Yayasan IPEKA Kantor Pusat'
                            ];
                            //send email
                            $send_email = parent::SendMailFunction($v->email, $v->student_name,'Notifikasi UKS',$substitute,'d-864064d3888d48dc8e34f002b68125fb');
                        }
                    }
                }
                
            } else {
                //semua siswa
                $insertadmin = array(
                'text' => $request->deskripsi,
                'title' => $request->title,
                'status'      => 1,
                'tipe'      => $request->tipe,
                'is_umum' => $is_umum,
                'created_by' => Auth::guard('admin')->user()->id,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
                );
                $insert = DB::table('t_notifications')->insertGetId($insertadmin);
                $siswa = DB::table('students')->where('status',1)->select('id','student_name','email')->get();
                foreach ($siswa as $k => $v) {
                    $substitute = [
                        "name" => $v->student_name,
                        "message" => $messages,
                        "sekolah" => 'Yayasan IPEKA Kantor Pusat'
                    ];
                    //send email
                    $send_email = parent::SendMailFunction($v->email, $v->student_name,'Notifikasi UKS',$substitute,'d-864064d3888d48dc8e34f002b68125fb');
                }

            }
        } else if($request->tipe == 2) {
            if ($request->id_scholl != null || $request->id_scholl != '') {
                $scholl_name = DB::table('table_scholls')->where('id',$request->id_scholl)->pluck('scholl_name');
                if (count($request->id_user) > 0) {
                    if ($request->id_user[0] != null || $request->id_user[0] != '') {
                        for ($i=0; $i < count($request->id_user); $i++) { 
                            $insertadmin = array(
                            'id_scholl' => $request->id_scholl,
                            'id_teacher' => $request->id_user[$i],
                            'id_class' => $request->id_class,
                            'text' => $request->deskripsi,
                            'title' => $request->title,
                            'status'      => 1,
                            'tipe'      => $request->tipe,
                            'is_umum' => $is_umum,
                            'created_by' => Auth::guard('admin')->user()->id,
                            'created_at'  => date('Y-m-d H:i:s'),
                            'updated_at'  => date('Y-m-d H:i:s'),
                            );
                            $insert = DB::table('t_notifications')->insertGetId($insertadmin);
                            // kirim ke guru
                            $guru = DB::table('teachers')->where('id',$request->id_user[$i])->select('id','teacher_name','email')->get();
                            foreach ($guru as $k => $v) {
                                $substitute = [
                                    "name" => $v->teacher_name,
                                    "message" => $messages,
                                    "sekolah" => $scholl_name[0]
                                ];
                                //send email
                                $send_email = parent::SendMailFunction($v->email, $v->teacher_name,'Notifikasi UKS',$substitute,'d-864064d3888d48dc8e34f002b68125fb');
                            }
                        }
                    } else {
                        $insertadmin = array(
                        'id_scholl' => $request->id_scholl,
                        'id_scholl' => $request->id_class,
                        'text' => $request->deskripsi,
                        'title' => $request->title,
                        'status'      => 1,
                        'tipe'      => $request->tipe,
                        'is_umum' => $is_umum,
                        'created_by' => Auth::guard('admin')->user()->id,
                        'created_at'  => date('Y-m-d H:i:s'),
                        'updated_at'  => date('Y-m-d H:i:s'),
                        );
                        $insert = DB::table('t_notifications')->insertGetId($insertadmin);
                        $in_rel = DB::table('teacher_scholl_relations')->where('id_scholl',$request->id_scholl)->pluck('id_teacher')->toArray();
                        // kirim ke guru
                        $guru = DB::table('teachers')->whereIn('id',$in_rel)->where('status',1)->select('id','teacher_name','email')->get();
                        foreach ($guru as $k => $v) {
                            $substitute = [
                                "name" => $v->teacher_name,
                                "message" => $messages,
                                "sekolah" => $scholl_name
                            ];
                            //send email
                            $send_email = parent::SendMailFunction($v->email, $v->teacher_name,'Notifikasi UKS',$substitute,'d-864064d3888d48dc8e34f002b68125fb');
                        }
                    }
                    
                } else {
                    $insertadmin = array(
                    'id_scholl' => $request->id_scholl,
                    'id_scholl' => $request->id_class,
                    'text' => $request->deskripsi,
                    'title' => $request->title,
                    'status'      => 1,
                    'tipe'      => $request->tipe,
                    'is_umum' => $is_umum,
                    'created_by' => Auth::guard('admin')->user()->id,
                    'created_at'  => date('Y-m-d H:i:s'),
                    'updated_at'  => date('Y-m-d H:i:s'),
                    );
                    $insert = DB::table('t_notifications')->insertGetId($insertadmin);
                    $in_rel = DB::table('teacher_scholl_relations')->where('id_scholl',$request->id_scholl)->pluck('id_teacher')->toArray();
                    // kirim ke guru
                    $guru = DB::table('teachers')->whereIn('id',$in_rel)->where('status',1)->select('id','teacher_name','email')->get();
                    foreach ($guru as $k => $v) {
                        $substitute = [
                            "name" => $v->teacher_name,
                            "message" => $messages,
                            "sekolah" => $scholl_name
                        ];
                        //send email
                        $send_email = parent::SendMailFunction($v->email, $v->teacher_name,'Notifikasi UKS',$substitute,'d-864064d3888d48dc8e34f002b68125fb');
                    }
                }
                
            } else {
                //semua guru
                $insertadmin = array(
                'text' => $request->deskripsi,
                'title' => $request->title,
                'status'      => 1,
                'tipe'      => $request->tipe,
                'is_umum' => $is_umum,
                'created_by' => Auth::guard('admin')->user()->id,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
                );
                $insert = DB::table('t_notifications')->insertGetId($insertadmin);
                // kirim ke guru
                $guru = DB::table('teachers')->where('status',1)->select('id','teacher_name','email')->get();
                foreach ($guru as $k => $v) {
                    $substitute = [
                        "name" => $v->teacher_name,
                        "message" => $messages,
                        "sekolah" => 'Yayasan IPEKA Kantor Pusat'
                    ];
                    //send email
                    $send_email = parent::SendMailFunction($v->email, $v->teacher_name,'Notifikasi UKS',$substitute,'d-864064d3888d48dc8e34f002b68125fb');
                }

            }
        } else if($request->tipe == 3) {
            //ORANG TUA MURID
            if ($request->id_scholl != null || $request->id_scholl != '') {
                $scholl_name = DB::table('table_scholls')->where('id',$request->id_scholl)->pluck('scholl_name');
                if (count($request->id_user) > 0) {
                  
                    if ($request->id_user[0] != null || $request->id_user[0] != '') {
                        for ($i=0; $i < count($request->id_user); $i++) { 
                            $insertadmin = array(
                            'id_scholl' => $request->id_scholl,
                            'id_parent' => $request->id_user[$i],
                            'id_class' => $request->id_class,
                            'text' => $request->deskripsi,
                            'title' => $request->title,
                            'status'      => 1,
                            'tipe'      => $request->tipe,
                            'is_umum' => $is_umum,
                            'created_by' => Auth::guard('admin')->user()->id,
                            'created_at'  => date('Y-m-d H:i:s'),
                            'updated_at'  => date('Y-m-d H:i:s'),
                            );
                            $insert = DB::table('t_notifications')->insertGetId($insertadmin);
                            $ortu = DB::table('student_parents')->where('id',$request->id_user[$i])->where('status',1)->select('id','student_parent_name','email')->get();
                            foreach ($ortu as $c => $d) {
                                $substitute = [
                                    "name" => $d->student_parent_name,
                                    "message" => strip_tags($request->deskripsi),
                                    "sekolah" => 'Yayasan IPEKA Kantor Pusat'
                                ];
                                //send email
                                $send_email = parent::SendMailFunction($d->email, $d->student_parent_name,'Notifikasi UKS',$substitute,'d-864064d3888d48dc8e34f002b68125fb');
                            }
                        }
                    } else {
                        if ($request->id_class != null || $request->id_class != '') {
                            $insertadmin = array(
                            'id_scholl' => $request->id_scholl,
                            'id_scholl' => $request->id_class,
                            'text' => $request->deskripsi,
                            'title' => $request->title,
                            'status'      => 1,
                            'tipe'      => $request->tipe,
                            'is_umum' => $is_umum,
                            'created_by' => Auth::guard('admin')->user()->id,
                            'created_at'  => date('Y-m-d H:i:s'),
                            'updated_at'  => date('Y-m-d H:i:s'),
                            );
                            $insert = DB::table('t_notifications')->insertGetId($insertadmin);
                            $in_rel = DB::table('student_class_relations')->where('id_class',$request->id_class)->where('is_active',1)->pluck('id_student')->toArray();
                            // kirim ke siswa
                            $ortu = DB::table('student_parents')->where('status',1)->select('id','student_parent_name','email')->get();
                            foreach ($ortu as $c => $d) {
                                $substitute = [
                                    "name" => $d->student_parent_name,
                                    "message" => strip_tags($request->deskripsi),
                                    "sekolah" => 'Yayasan IPEKA Kantor Pusat'
                                ];
                                //send email
                                $send_email = parent::SendMailFunction($d->email, $d->student_parent_name,'Notifikasi UKS',$substitute,'d-864064d3888d48dc8e34f002b68125fb');
                            }
                        } else {
                            $insertadmin = array(
                            'id_scholl' => $request->id_scholl,
                            'id_scholl' => $request->id_class,
                            'text' => $request->deskripsi,
                            'title' => $request->title,
                            'status'      => 1,
                            'tipe'      => $request->tipe,
                            'is_umum' => $is_umum,
                            'created_by' => Auth::guard('admin')->user()->id,
                            'created_at'  => date('Y-m-d H:i:s'),
                            'updated_at'  => date('Y-m-d H:i:s'),
                            );
                            $insert = DB::table('t_notifications')->insertGetId($insertadmin);
                            $in_rel = DB::table('student_class_relations as s')->join('table_class as c','c.id','s.id_class')->where('id_scholl',$request->id_scholl)->where('is_active',1)->pluck('id_student')->toArray();
                            // kirim ke siswa
                            $siswa = DB::table('students')->whereIn('id',$in_rel)->where('status',1)->select('id','student_name','email')->get();
                            foreach ($siswa as $k => $v) {
                                $substitute = [
                                    "name" => $v->student_name,
                                    "message" => $messages,
                                    "sekolah" => 'Yayasan IPEKA Kantor Pusat'
                                ];
                                //send email
                                $send_email = parent::SendMailFunction($v->email, $v->student_name,'Notifikasi UKS',$substitute,'d-864064d3888d48dc8e34f002b68125fb');
                            }
                        }
                    }
                    
                } else {
                    if ($request->id_class != null || $request->id_class != '') {
                        $insertadmin = array(
                        'id_scholl' => $request->id_scholl,
                        'id_scholl' => $request->id_class,
                        'text' => $request->deskripsi,
                        'title' => $request->title,
                        'status'      => 1,
                        'tipe'      => $request->tipe,
                        'is_umum' => $is_umum,
                        'created_by' => Auth::guard('admin')->user()->id,
                        'created_at'  => date('Y-m-d H:i:s'),
                        'updated_at'  => date('Y-m-d H:i:s'),
                        );
                        $insert = DB::table('t_notifications')->insertGetId($insertadmin);
                        $in_rel = DB::table('student_class_relations')->where('id_class',$request->id_class)->where('is_active',1)->pluck('id_student')->toArray();
                        // kirim ke siswa
                        $ortu = DB::table('student_parents')->where('status',1)->select('id','student_parent_name','email')->get();
                        foreach ($ortu as $c => $d) {
                            $substitute = [
                                "name" => $d->student_parent_name,
                                "message" => strip_tags($request->deskripsi),
                                "sekolah" => 'Yayasan IPEKA Kantor Pusat'
                            ];
                            //send email
                            $send_email = parent::SendMailFunction($d->email, $d->student_parent_name,'Notifikasi UKS',$substitute,'d-864064d3888d48dc8e34f002b68125fb');
                        }
                    } else {
                        $insertadmin = array(
                        'id_scholl' => $request->id_scholl,
                        'id_scholl' => $request->id_class,
                        'text' => $request->deskripsi,
                        'title' => $request->title,
                        'status'      => 1,
                        'tipe'      => $request->tipe,
                        'is_umum' => $is_umum,
                        'created_by' => Auth::guard('admin')->user()->id,
                        'created_at'  => date('Y-m-d H:i:s'),
                        'updated_at'  => date('Y-m-d H:i:s'),
                        );
                        $insert = DB::table('t_notifications')->insertGetId($insertadmin);
                        $in_rel = DB::table('student_class_relations as s')->join('table_class as c','c.id','s.id_class')->where('id_scholl',$request->id_scholl)->where('is_active',1)->pluck('id_student')->toArray();
                        // kirim ke siswa
                        $siswa = DB::table('students')->whereIn('id',$in_rel)->where('status',1)->select('id','student_name','email')->get();
                        foreach ($siswa as $k => $v) {
                            $substitute = [
                                "name" => $v->student_name,
                                "message" => $messages,
                                "sekolah" => 'Yayasan IPEKA Kantor Pusat'
                            ];
                            //send email
                            $send_email = parent::SendMailFunction($v->email, $v->student_name,'Notifikasi UKS',$substitute,'d-864064d3888d48dc8e34f002b68125fb');
                        }
                    }
                }
                
            } else {
                //semua orang tua
                $insertadmin = array(
                'text' => $request->deskripsi,
                'title' => $request->title,
                'status'      => 1,
                'tipe'      => $request->tipe,
                'is_umum' => $is_umum,
                'created_by' => Auth::guard('admin')->user()->id,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
                );
                $insert = DB::table('t_notifications')->insertGetId($insertadmin);
                $ortu = DB::table('student_parents')->where('status',1)->select('id','student_parent_name','email')->get();
                foreach ($ortu as $c => $d) {
                    $substitute = [
                        "name" => $d->student_parent_name,
                        "message" => strip_tags($request->deskripsi),
                        "sekolah" => 'Yayasan IPEKA Kantor Pusat'
                    ];
                    //send email
                    $send_email = parent::SendMailFunction($d->email, $d->student_parent_name,'Notifikasi UKS',$substitute,'d-864064d3888d48dc8e34f002b68125fb');
                }

            }
        }

        $id_admin    = Auth::guard('admin')->user()->id;
        
        if ($insert) {
            
            $data['code']    = 200;
            $data['message'] = 'Berhasil menambah Data Notifikasi';

            return response()->json($data);
        } else {
            $data['code']    = 500;
            $data['message'] = 'Maaf Ada yang Error ';
            return response()->json($data);
        }
        // return response()->json($request->all());
    }


    public function delete(Request $request)
    {
        $bank             = NotifikasiModel::find($request->id);
        $bank->status     = 0;
        $bank->deleted_at = date('Y-m-d');
        $bank->save();

        if ($bank) {
            $id_admin    = Auth::guard('admin')->user()->id;
            
            $data['code']    = 200;
            $data['message'] = 'Berhasil Menghapus Data Notifikasi';
            $insert_log      = parent::LogAdmin(\Request::ip(),Auth::guard('admin')->user()->id,'Menghapus Notifikasi '.$request->id,'Notifikasi');
            return response()->json($data);
        } else {
            $data['code']    = 500;
            $data['message'] = 'Maaf Ada yang Error ';
            return response()->json($data);
        }
    }

}