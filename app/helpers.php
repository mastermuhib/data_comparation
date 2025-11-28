<?php
function rcheck($menu_id,$id) {

    $menu = DB::select("select b.id as id,b.name as name,b.menu_id as menu_id from menus b join role_menus r on b.id = r.menu_id where r.role_id = '$id' and b.parent_menu_id = '0' and b.menu_id = $menu_id;"); 
    if (!empty($menu)) {
        $return = $menu[0]->menu_id;
    } else {
       $return = 500;
    }
    return $return;
}


function rcheck2($menu_id,$id,$parent_menu_id) {
    
    $cek_dulu = DB::table('role_menus')->where('role_id',$id)->where('menu_id',$menu_id)->get();
    if ($cek_dulu->isNotEmpty()) {
        $menu = DB::select("select b.id as id,b.name as name,b.parent_menu_id as parent_menu_id,b.slug as slug,b.menu_id as menu_id from menus b join role_menus r on b.id = r.menu_id where r.role_id = '$id' and b.menu_id = '0' and b.parent_menu_id = '$parent_menu_id';");
        $return = $menu[0]->parent_menu_id;
        
    } else {
       $return = 500;
    }
    return $return;
}

function NamaTes($nomor){
    //jumlah panggil
    $jumlah_p = DB::table('interview_member')->where('nomor',$nomor)->pluck('name');
    return $jumlah_p[0];       
}

function nama_pend($id){
    $nama = DB::table('tb_form_pendidikan')->select('name')->where('id',$id)->pluck('name');
    return $nama[0];
}

function DataSiswa($id){
    $return = " - ";
    $data = DB::table('student_class_relations as r')->join('students as s','s.id','r.id_student')->join('table_class as c','c.id','r.id_class')->join('table_scholls as t','t.id','c.id_scholl')->where('r.id_student',$id)->where('r.is_active',1)->select('student_name','class_name','scholl_name')->get();
    if ($data->isNotEmpty()) {
        $return = $data[0]->student_name.' <span class="text-info"> - </span>'.$data[0]->scholl_name.' <span class="text-info"> - </span>'.$data[0]->class_name;
    }
    return $return;

}


function TipePerusahaan($id) {
    $data = DB::table('master_tipe_perusahaan')->where('id',$id)->pluck('tipe');
    if ($data->isNotEmpty()) {
        if ($data[0] == 'Perorangan' || $data[0] == 'PERORANGAN') {
            $return = 1;
        } else {
            $return = 0;
        }
    } else {
        $return = 0;
    }
}

function cekDiskon($id,$type)
{
    if ($type == 1) {
        $cek_produk = DB::table('products')
                        ->where('id',$id)
                        ->select('price','discount')
                        ->get()
                        ->first();
        if ($cek_produk != null) {
            if ($cek_produk->discount == null) {
                $return = $cek_produk->price;
            } else {
                $potongan = ($cek_produk->discount/100)*$cek_produk->price;
                $return  = $cek_produk->price - $potongan;
            }
        } else {
            $return = 0;
        }
    } else {
        $cek_packege = DB::table('packages')
                        ->where('id',$id)
                        ->select('discount','price')
                        ->get()
                        ->first();
        if ($cek_packege != null) {
            if ($cek_packege->discount == null) {
                $return = $cek_packege->price;
            } else {
                $potongan  = ($cek_packege->discount/100)*$cek_packege->price;
                $return = $cek_packege->price - $potongan;
            }
        } else {
            $return = 0;
        }
    }
    return $return;
}

function image_blank() {
    $img = "https://e-brochure.s3-id-jkt-1.kilatstorage.id/dfb9gm4oFdQBwy32dUaBOUkfMoWL01Hx3KC0aF67.svg";
    return $img;
}


function base_img(){
    $url = "https://kandidat.s3-id-jkt-1.kilatstorage.id/";
    return $url;
}

function base_img_local(){
    $url = URL::to('/').'/assets/file_hasil/';
    return $url;
}


function getUmur($tgl) {
    if ($tgl != null) {
        $date1 = $tgl;
        $date2 = date('Y-m-d');
        $diff = abs(strtotime($date2) - strtotime($date1));
        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

        $data_umur = $years.' thn  '.$months.' bln  '.$days.' hr';
         //exit();
    } else {
        $data_umur = '(Belum diisi)';
    }
    
    $return = $data_umur;

    return $return;

}

function getUmurThn($tgl) {
    if ($tgl != null) {
        $date1 = $tgl;
        $date2 = date('Y-m-d');
        $diff = abs(strtotime($date2) - strtotime($date1));
        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

        $data_umur = $years.' th';
         //exit();
    } else {
        $data_umur = ' - ';
    }
    
    $return = $data_umur;

    return $return;

}


function DataProvince($id){
    $data = DB::table('provinces')->where('country_id',$id)->get();
    
    return $data;
}

function DataCity($id){
    $data = DB::table('cities')->where('province_id',$id)->get();
    return $data;
}

function DataClass($id){
    $data = DB::table('table_class')->where('id_scholl',$id)->select('id','class_name as name')->get();
    return $data;
}

function DataStudent($id){
    $in_array = DB::table('student_class_relations')->where('is_active',1)->where('id_class',$id)->pluck('id_student');
    $data = DB::table('students')->whereIn('id',$in_array)->select('id','student_name as name')->get();
    return $data;
}

function DataParent($id){
    $in_array = DB::table('student_parent_relations')->where('id_student',$id)->pluck('id_parent');
    $data = DB::table('student_parents')->whereIn('id',$in_array)->select('id','student_parent_name as name')->get();
    return $data;
}


function DataDistrict($id){
    $data = DB::table('districts')->where('regency_id',$id)->get();
    return $data;
}

function DataVillage($id){
    $data = DB::table('villages')->where('district_id',$id)->get();
    return $data;
}

function DataJurusan($id){
    $data = DB::table('major')->where('id_departement',$id)->get();
    return $data;
}

function CheckAdm($id,$type){
    if ($type == 'jurusan') {
        $return = DB::table('roles')->where('id',$id)->pluck('id_jurusan');
    } else {
        $return = DB::table('roles')->where('id',$id)->pluck('id_departement');
    }
    
    return $return[0];
}

function timeConverter($day)
    {
        date_default_timezone_set("Asia/Jakarta");
        $time = new DateTime($day);
        $diff = $time->diff(new DateTime());
        $minutes = ($diff->days * 24 * 60) +
                   ($diff->h * 60) + $diff->i;
        if ($minutes < 1440){
          if ($minutes > 60){
             $jam = $minutes/60;
             $lebih = $minutes%60;

             $return = (int)$jam." Jam yang lalu";
          } else {
             $return = $minutes." Menit yang lalu";
          }
          
        } else {
           $return = date("d F Y", strtotime($day));
        }
        return $return;
    }


?>