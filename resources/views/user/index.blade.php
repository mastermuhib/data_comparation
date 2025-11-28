@extends('layout.app')
@section('asset')
<link rel="stylesheet" type="text/css" href="{{URL::asset('assets')}}/vendors/css/forms/select/select2.min.css">
<style type="text/css">
    table.dataTable thead .sorting, 
table.dataTable thead .sorting_asc, 
table.dataTable thead .sorting_desc {
    background : none;
}
</style>
@endsection
@section('title', 'Product')
@section('content')
<div id="show_edit">
</div>
<div id="edit_password">
</div>
<div class="row" id="show_add" style="display: none;">
    <div class="col-lg-12 col-xxl-4">
        <section class="multiple-validation">
            <div class="card mb-3">
                <div class="card-content">
                    <div class="card-body">
                        <form method="POST" class="form-horizontal p-3" id="form_add">@csrf
                            <div class="row mb-5">
                                <div class="col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Nama Produk</label>
                                        <input type="text" name="name" class="form-control form-control-lg" placeholder="Nama Produk" required>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Email</label>
                                        <input type="email" name="email" class="form-control form-control-lg" placeholder="Email" required>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Phone</label>
                                        <input type="text" name="phone" class="form-control form-control-lg" placeholder="Phone" required>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Perusahaan</label>
                                        <input type="text" name="company" class="form-control form-control-lg" placeholder="Perusahaan" required>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Jabatan</label>
                                        <input type="text" name="position" class="form-control form-control-lg" placeholder="Jabatan" required>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Password</label>
                                        <input type="password" name="password" id="password" class="form-control form-control-lg" placeholder="Your Password" minlength="6" required>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Confirm Password</label>
                                        <input type="password" name="confirm_password" id="confirm_password" class="form-control form-control-lg" placeholder="Confirm Password" minlength="6" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-header text-center">
                                            Foto Profile
                                        </div>
                                        <div class="card-body text-center">
                                            
                                            <img id="profile_admin" src="" alt="your image" style="max-width: 200px;max-height: 200px;" />
                                            <label class="btn btn-white btn-sm mb-0 w-100 align-self-center">
                                                Upload File <input type="file" name="profile" style="display: none;" onchange="gantiProfile_admin(this);">
                                            </label>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <button type="submit" class="btn btn-primary float-right">Submit</button>
                                    <button type="button" class="btn btn-danger mr-2 float-right" id="batalkan">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<div class="accordion accordion-solid accordion-panel accordion-svg-toggle mb-3 mt-3" id="faq">
    <div class="card p-6 col-md-12">
        <div class="card-header" id="faqHeading2">
            <div class="card-title font-size-h4 text-dark collapsed" data-toggle="collapse" data-target="#faq2" aria-expanded="false" aria-controls="faq2" role="button">
                <div class="card-label">Filter User <i class="fas fa-filter"></i></div>
                <span class="svg-icon svg-icon-primary">
                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Angle-double-right.svg-->
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                            <path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero"></path>
                            <path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999)"></path>
                        </g>
                    </svg>
                    <!--end::Svg Icon-->
                </span>
            </div>
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div id="faq2" class="collapse" aria-labelledby="faqHeading2" data-parent="#faq" style="">
            <div class="card-body pt-3 font-size-h6 font-weight-normal text-dark-50">
                <form id="form_filter">
                    <div class="row" data-select2-id="4">
                        <div class="col-md-3">
                            <label>Status </label>
                            <select class="select2 form-control" id="s_status" name="status" onchange="DataTable()">
                                <option value="">Semua</option>
                                <option value="1">active</option>
                                <option value="0">Tidak active</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Dari Tanggal</label>
                            <input type="date" name="tgl_start" class="form-control form-control-lg" onchange="DataTable()" id="start">
                        </div>
                        <div class="col-md-3">
                            <label>Sampai Tanggal</label>
                            <input type="date" name="tgl_end" class="form-control form-control-lg" onchange="DataTable()" id="end">
                        </div>
                        <input type="hidden" name="sort" value="" id="is_sort">
                    </div>
                </form>
            </div>
        </div>
        <!--end::Body-->
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-xxl-4">
        <!--begin::List Widget 9-->
        <div class="card card-custom card-stretch gutter-b">
            <!--begin::Header-->
            <div class="card-header align-items-center border-0 row">
                <div class="col-md-2">
                    <h5 class="text-dark font-weight-bold ml-3"><spaan>List User</spaan></h5> 
                </div>
                <div class="col-md-2 pl-0">
                    <h2 class="text-dark font-weight-bolder" id="jumlah_produk"><u>0</u></h2>
                   
                </div>
                <div class="col-md-6">
                    
                </div>
                
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body" style="margin-top: -25px;">
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <!-- <div class="card-header">
                                    <h4 class="card-title">List Admin</h4>
                                </div> -->
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="row">
                                            <div class="col-md-2 col-xs-12">
                                                <div class="form-group">
                                                    <button class="btn btn-block btn-lg btn-danger" onclick="ResetAll()" type="button"><i class="fas fa-sync"></i> Refresh</button>
                                                </div>
                                            </div> 
                                            <div class="col-md-4 col-xs-12">
                                                <div class="form-group">
                                                    <select class="form-control form-control-lg" onchange="DataTable()" id="sort" style="height: 45px;">
                                                        <option value="0" selected>Urutkan By Nama (A - Z)</option>
                                                        <option value="1">Urutkan By Nama (Z - A)</option>
                                                        <option value="2">Urutkan By Tanggal (Terbaru)</option>
                                                        <option value="3">Urutkan By Tanggal (Terlama)</option>
                                                    </select>
                                                </div>
                                            </div> 
                                            <div class="col-md-6">
                                                <div class="input-group rounded bg-light">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <span class="svg-icon svg-icon-lg">
                                                                <!--begin::Svg Icon | path:assets/media/svg/icons/General/Search.svg-->
                                                                <i class="fas fa-search"></i>
                                                                <!--end::Svg Icon-->
                                                            </span>
                                                        </span>
                                                    </div>
                                                    <input type="text" id="s_search" class="form-control h-45px" placeholder="Cari by Nama/NIK/Email/Phone">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table zero-configuration" id="data_tabel">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama</th>
                                                        <th>NIK</th>
                                                        <th>No HP</th>
                                                        <th>Email</th>
                                                        <th>Status</th>
                                                        <th>Tanggal Daftar</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <!--end: Card Body-->
        </div>
        <!--end: Card-->
        <!--end: List Widget 9-->
        <!-- </div> -->
    </div>
</div>
<input type="hidden" id="id_user" name="">
<!-- Preview -->
<div class="modal fade modal-cv" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal_prev">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" style="border-radius: 12px" id="isi_preview">
            
        </div>
        <div class="text-center" id="proses_loading">
            <img alt="Pic" src="{{URL::asset('assets')}}/media/loading.gif" style="width: 30%">
        </div>
    </div>
</div>
<!-- Preview -->
@endsection
@section('js')
@include('components/componen_crud')
<script type="text/javascript">
var columns = [{
        "data": null,
        "sortable": false,
        "orderable": false,
        "bFilter": false,
        "targets": 'no-sort',
        "bSort": false,
        render: function(data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
        }
    },
    { "data": "name" },
    { "data": "nik" },
    { "data": "phone" },
    { "data": "email" },
    { "data": "status" },
    { "data": "date" },
    { "data": "actions" }
];

function data_tabel(tabel) {
    var tgl_start = $("#start").val();
    var tgl_end = $("#end").val();
    var status = $("#s_status").val();
    var search = $("#s_search").val();
    var sort = $("#sort").val();
    
    if (tabel == 'data_user') {
        var xin_table = $('#data_tabel').DataTable({
            "processing": true,
            "serverSide": true,
            "orderable": false,
            "targets": 'no-sort',
            "bSort": false,
            "bFilter": false,
            "ajax": {
                "url": '/data_user',
                "dataType": "json",
                "type": "POST",
                "data": { _token: "{{csrf_token()}}",tgl_start : tgl_start,tgl_end : tgl_end,status : status,search :search,sort:sort }
            },
            "columns": columns,
            "bDestroy": true
        });
        $("#data_tabel_length").remove();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({ //line 28
            type: 'POST',
            url: '/get_data_user',
            dataType: 'json',
            data: { tgl_start : tgl_start,tgl_end : tgl_end,status : status,search :search,sort:sort},
            success: function(data) {
                $("#jumlah_produk").html('<u>'+data+'</u>');
            }
        });
    }
    
}
$(function() {
    //$('#myTable').DataTable();
    $(".select2-container--default").css('width', '100%');
    data_tabel('data_user')
});
$("#s_search").keyup(function(){
   data_tabel('data_user');
});


$('.select2').on('change', function() { // when the value changes
    $(this).valid(); // trigger validation on this element
});

$('#tambah').on("click", function() {
    // alert('tes')
    $(window).scrollTop(0);
    $("#show_add").css('display', '');
});
$('#batalkan').on("click", function() {
    $("#show_add").css('display', 'none');
});

$("#form_add").validate({
    rules: {
        password: {
            minlength: 6
        },
        confirm_password: {
            equalTo: "#password"
        }
    },
    messages: {
        password: {
            minlength: "password minimal 6 character"
        },
        confirm_password: {
            equalTo: "password not match"
        }
    },
    submitHandler: function(form) {
        $.ajax({ //line 28
            type: 'POST',
            url: '/post_participant',
            dataType: 'json',
            data: new FormData($("#form_add")[0]),
            processData: false,
            contentType: false,
            success: function(data) {
                if (data.code == 200) {
                    document.getElementById("form_add").reset();
                    $("#hide_add").css('display', '');
                    $("#show_add").css('display', 'none');
                    $("#message").remove();
                    show_toast(data.message, 1);

                    data_tabel('data_user')
                } else {
                    show_toast(data.message, 0);
                }
            }
        });
    }
});

$(document).off('click', '#batalkan_password').on('click', '#batalkan_password', function() {
    $("#edit_password").hide().empty();
});

$(document).off('change', '#reg_by').on('change', '#reg_by', function() {
    //alert("juancook");
    reg_by = $("#reg_by").val();
    if (reg_by == 0) {
       $("#existing").css('display','');
       $("#by_aplikasi").css('display','none');
    } else if(reg_by == 1){
       $("#by_aplikasi").css('display','');
       $("#existing").css('display','none');
    } else {
       $("#existing").css('display','none');
       $("#by_aplikasi").css('display','none');
    }

    DataTable();
});

$(document).off('click', '#batalkan3').on('click', '#batalkan3', function() {

    $("#titel_head").remove();
    $("#head_modul").append('<span id="titel_head">Tambah Data Admin</span>');
    $("#hide_add").css('display', '');
    $("#show_edit").css('display', 'none').empty();
});

$(document).off('click', '#save_edit').on('click', '#save_edit', function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({ //line 28
        type: 'POST',
        url: '/update/user',
        dataType: 'json',
        data: new FormData($("#form_edit")[0]),
        processData: false,
        contentType: false,
        success: function(data) {
            //$("#modal_loading").modal('hide');
            //$(".modal-backdrop").remove();
            $(".edit-modal-data").modal('hide');
            if (data.code == 200) {
                
                show_toast(data.message, 1);
                data_tabel('data_user')
            }
        }
    });
});
// is admin cabang
$(document).off('click', '#is_cabang').on('click', '#is_cabang', function() {
    if ($("#is_cabang").prop('checked') == true) {
        $("#div_cabang").css('display', '');

    } else {
        $("#div_cabang").css('display', 'none');
    }

});
$(document).off('change', '#select_role').on('change', '#select_role', function() {
    
    id = $(this).val();
    $(".get_role").remove();
    $.ajax({
        url: '/select_role/'+id+'/company',
        type: "GET",
        success: function(response) {
            //console.log(response);
            if (response) {
                $("#div_company").html(response);
            }
            $('.select2').select2();
            $(".select2-container--default").css('width', '100%');
        }
    });
    //kode ao
    $.ajax({
        url: '/select_role/'+id+'/kode',
        type: "GET",
        success: function(response) {
            //console.log(response);
            if (response) {
                $("#div_kode").html(response);
            }
        }
    });
});
// apabila pilih role
function country_change(country_id) {
    // alert(country_id)
    country_id = $("#select_country").val();
    $.ajax({
        type: 'GET',
        url: '/data_province/' + country_id,
        dataType: 'json',
        success: function(data) {
            console.log(data)
            $("#select_province").empty();
            $("#select_city").empty().append("<option value=''>Pilih Kota</option>");
            $("#select_district").empty().append("<option value=''>Pilih Kecamatan</option>");
            $("#select_village").empty().append("<option value=''>Pilih Desa</option>");
            $(".province").append("<option value=''>Pilih Provinsi</option>");
            for (let i = 0; i < data.length; i++) {
                $(".province").append("<option value=" + data[i].id + ">" + data[i].name + "</option>");
            }
        },
        error: function(data) {
            console.log(data);
        }
    });
}

function province_change(prov_id) {
    // alert(country_id)
    prov_id = $("#select_province").val();
    $.ajax({
        type: 'GET',
        url: '/cities/' + prov_id,
        dataType: 'json',
        success: function(data) {
            console.log(data)
            $("#select_city").empty();
            $("#select_district").empty().append("<option value=''>Pilih Kecamatan</option>");
            $("#select_village").empty().append("<option value=''>Pilih Desa</option>");
            $("#select_city").append("<option value=''>Pilih Kota</option>");
            for (let i = 0; i < data.length; i++) {
                $("#select_city").append("<option value=" + data[i].id + ">" + data[i].name + "</option>");
            }
        },
        error: function(data) {
            console.log(data);
        }
    });
}

function city_change() {
    // alert(country_id)
    city_id = $("#select_city").val();
    $.ajax({
        type: 'GET',
        url: '/districts/' + city_id,
        dataType: 'json',
        success: function(data) {
            console.log(data)
            $("#select_district").empty();
            $("#select_village").empty().append("<option value=''>Pilih Desa</option>");
            $("#select_district").append("<option value=''>Pilih Kecamatan</option>");
            for (let i = 0; i < data.length; i++) {
                $("#select_district").append("<option value=" + data[i].id + ">" + data[i].name + "</option>");
            }
        },
        error: function(data) {
            console.log(data);
        }
    });
}

function district_change() {
    // alert(country_id)
    dis_id = $("#select_district").val();
    $.ajax({
        type: 'GET',
        url: '/villages/' + dis_id,
        dataType: 'json',
        success: function(data) {
            console.log(data)
            $("#select_village").empty();
            $("#select_village").append("<option value=''>Pilih Desa</option>");
            for (let i = 0; i < data.length; i++) {
                $("#select_village").append("<option value=" + data[i].id + ">" + data[i].name + "</option>");
            }
        },
        error: function(data) {
            console.log(data);
        }
    });
}

function deptchange1() {
    // alert(country_id)
    id = $("#s_dept1").val();
    $.ajax({
        type: 'GET',
        url: '/jurusan/'+id,
        dataType: 'json',
        success: function(data) {
            console.log(data)
            $("#s_jur1").empty();
            $("#s_jur1").append("<option value=''>--- Jurusan ---</option>");
            for (let i = 0; i < data.length; i++) {
                $("#s_jur1").append("<option value=" + data[i].id + ">" + data[i].name + "</option>");
            }
        },
        error: function(data) {
            console.log(data);
        }
    });
}

function deptchange2() {
    // alert(country_id)
    id = $("#s_dept2").val();
    $.ajax({
        type: 'GET',
        url: '/jurusan/'+id,
        dataType: 'json',
        success: function(data) {
            console.log(data)
            $("#s_jur2").empty();
            $("#s_jur2").append("<option value=''>--- Jurusan ---</option>");
            for (let i = 0; i < data.length; i++) {
                $("#s_jur2").append("<option value=" + data[i].id + ">" + data[i].name + "</option>");
            }
        },
        error: function(data) {
            console.log(data);
        }
    });
}

function deptchange3() {
    // alert(country_id)
    id = $("#s_dept3").val();
    $.ajax({
        type: 'GET',
        url: '/jurusan/'+id,
        dataType: 'json',
        success: function(data) {
            console.log(data)
            $("#s_jur3").empty();
            $("#s_jur3").append("<option value=''>--- Jurusan ---</option>");
            for (let i = 0; i < data.length; i++) {
                $("#s_jur3").append("<option value=" + data[i].id + ">" + data[i].name + "</option>");
            }
        },
        error: function(data) {
            console.log(data);
        }
    });
}

function deptchange4() {
    // alert(country_id)
    id = $("#dept_pend").val();
    $.ajax({
        type: 'GET',
        url: '/jurusan/'+id,
        dataType: 'json',
        success: function(data) {
            console.log(data)
            $("#jur_pend").empty();
            $("#jur_pend").append("<option value=''>Semua Jurusan</option>");
            for (let i = 0; i < data.length; i++) {
                $("#jur_pend").append("<option value=" + data[i].id + ">" + data[i].name + "</option>");
            }
            DataTable();

        },
        error: function(data) {
            console.log(data);
        }
    });
}

function DataTable(){
    //alert("okey");
    sort = $("#sort").val();
    $("#is_sort").val(sort);

    data_tabel('data_user');
}
function FilterBy(){
    alert("cak");
}

$(document).off('click', '.selected_cb').on('click', '.selected_cb', function(){
    id = $(this).attr('id');
    jur = $(this).attr('jur');
    ting = $(this).attr('ting');
    //user = $(this).val(O);
    if($(this).is(":checked")){
     //$("#user_pilih"+user).prop('checked',true);
     jum = $("#user_tercentang").val();
     jumlah = parseInt(jum) + 1;
     $("#user_tercentang").val(jumlah);
     $("#span_approve").html('Aprove ('+jumlah+')')
     $("#span_tolak").html('Tolak ('+jumlah+')')
     InputDB(id,'add',jur,ting);
     
    } else {
      //$("#user_pilih"+user).prop('checked',false);
      jum = $("#user_tercentang").val()
      jumlah = parseInt(jum) - 1;
      $("#user_tercentang").val(jumlah);
      $("#span_approve").html('Aprove ('+jumlah+')')
      $("#span_tolak").html('Tolak ('+jumlah+')')
      InputDB(id,'delete',jur,ting);
    }
    $(".participant").html(jumlah);
   //var jumlah = $(".selected_cb:checked").length;
});

function InputDB(id,action,jur,ting) {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({ //line 28
        type: 'POST',
        url: '/cache/participant',
        dataType: 'json',
        data: { id : id,action : action ,jur :jur,ting:ting},
        success: function(data) {
            
        }
    });

}

function approve(action) {
    var alasan = $('textarea#text_tolak').val();
    //id_user = $("#id_user").val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({ //line 28
        type: 'POST',
        url: '/approve/participant',
        dataType: 'json',
        data: { action : action , alasan : alasan},
        success: function(data) {
            location.reload();
        }
    });

}

function approveThis(app,jenis) {
    if (jenis != null) {
       alasan = $("textarea#text_tolak").val();
    } else {
       alasan = $("textarea#text_pembatalan").val();
    }
    id  = $("#id_user").val();
    $.ajax({
        type: 'post',
        url: '/participant_approve',
        dataType: 'json',
        data : { id : id,status : app,alasan:alasan},
        success: function(data) {
            show_toast(data.message, 1);
            //location.reload();
        },
        error: function(data) {
            console.log(data);
        }
    });

}

$(document).off('click','.d_detail').on('click','.d_detail', function (){
    var id = $(this).attr('id');
    $("#button_id").attr('tabel',id);
    //$("#id_user").val(id);
    //alert(status);
    $("#modal_prev").modal('show'); 
    $("#proses_loading").css('display','');
    //$("#footer_cv").css('display','none');
    //alert(status);
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
    $.ajax({
        url :'/detail_user/'+id,
        type: "GET",
        success: function (response) {
            // console.log(response);
            if(response) {
                $("#isi_preview").html(response);
                $("#proses_loading").css('display','none');
                //$("#footer_cv").css('display','');
            }
        }
    });      
});

$(document).off('click', '.approve').on('click', '.approve', function(){
   id = $(this).attr('id');
   $("#id_user").val(id);
   $("#modalApprovemodal").modal('show'); 
});

$(document).off('click', '.batalkan').on('click', '.batalkan', function(){
   id = $(this).attr('id');
   status = $(this).attr('status');
   //alert(status);
   $(".span_batal").html(status);
   $("#id_user").val(id);
   $("#batalKan").modal('show'); 
});
function ImportEX() {
    $("#loading_import").css('display','');
    $("#btn_import").css('display','none');
    $.ajax({ //line 28
        type: 'POST',
        url: '/import_participant',
        //url: '/import_update_participant',
        dataType: 'json',
        data: new FormData($("#form_import")[0]),
        processData: false,
        contentType: false,
        success: function(data) {
            if (data.code == 200) {
                document.getElementById("form_import").reset();
                $("#message").remove();
                show_toast(data.message, 1);
                $("#loading_import").css('display','none');
                $("#btn_import").css('display','');

                data_tabel('data_user')
            } else {
                show_toast(data.message, 0);
                $("#loading_import").css('display','none');
                $("#btn_import").css('display','');
            }
        }
    });
}

$(document).off('click','#download_excel').on('click','#download_excel', function(){
    var serial = $("#form_filter").serialize();
    window.open("/download_excel/"+serial, '_blank');
});

function ResetAll(){
    location.reload();
}
$("#text_tolak").keyup(function(){
    var text = $('textarea#text_tolak').val();
    if (text.length > 2) {
        $("#btn_tolak").css('display','');
    } else {
        $("#btn_tolak").css('display','none');
    }
   
});

$("#text_pembatalan").keyup(function(){
    var text = $('textarea#text_pembatalan').val();
    if (text.length > 2) {
        $("#btn_pembatalan").css('display','');
    } else {
        $("#btn_pembatalan").css('display','none');
    }
   
});

$('#modalTolak').on('hidden.bs.modal', function () {
    $("#id_user").val('');
})
$("#text_tolak2").keyup(function(){
    var text = $('textarea#text_tolak2').val();
    if (text.length > 2) {
        $("#btn_tolak2").css('display','');
    } else {
        $("#btn_tolak2").css('display','none');
    }
   
});
$('#modalTolakSeseorang').on('hidden.bs.modal', function () {
    $("#id_user").val('');
})

</script>
@endsection
