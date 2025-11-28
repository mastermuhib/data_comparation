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
<div class="d-flex flex-row mt-5">
    <!--begin::Aside-->
    <div class="flex-row-auto offcanvas-mobile w-250px w-xxl-350px" id="kt_profile_aside">
        <!--begin::Profile Card-->
        <div class="card card-custom card-stretch">
            <!--begin::Body-->
            <div class="card-body pt-4">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end">
                    <div class="dropdown dropdown-inline">
                        
                    </div>
                </div>
                <div class="d-flex align-items-center mb-5">
                    <div class="symbol symbol-60 symbol-xxl-100 mr-3 align-self-start align-self-xxl-center">
                        <div class="symbol-label" style="background-image:url('{{base_img()}}{{$data->profile}}')"></div>
                        <i class="symbol-badge bg-success"></i>
                    </div>
                    <div>
                        <a href="javascript:void(0)" class="font-weight-bolder font-size-h5 text-dark-75 text-hover-primary">{{$data->user_name}}</a>
                        <div id="div_status"> 
                            @if($data->status == 1)
                            <div class="text-success">active</div>
                            @else
                            <div class="text-danger">Tidak active</div>
                            @endif
                        </div>
                        <div class="mt-2">
                            <a href="javascript:void(0)" class="btn btn-sm btn-primary font-weight-bold mr-2 py-2 px-3 px-xxl-5 my-1 up_status" data-toggle="modal" data-target="#modalStatus" status="{{$data->status}}">Ubah Status</a>
                            <!-- <a href="javascript:void(0)" class="btn btn-sm btn-danger font-weight-bold py-2 px-3 px-xxl-5 my-1" data-toggle="modal" data-target="#modalHapus"><i class="fas fa-trash"></i></a> -->
                        </div>
                    </div>
                </div>
                <!--end::Toolbar-->
                <!--begin::Nav-->
                <div class="navi navi-bold navi-hover navi-active navi-link-rounded">
                    <div class="navi-item mb-2">
                        <a href="javascript:void(0)" class="navi-link py-4 active detail_tab" id="detail_1" no="1">
                            <span class="navi-icon mr-2">
                                <span class="svg-icon">
                                    <i class="fas fa-user"></i>
                                </span>
                            </span>
                            <span class="navi-text font-size-lg">Ubah Profile</span>
                        </a>
                    </div>
                    <div class="navi-item mb-2">
                        <a href="javascript:void(0)" class="navi-link py-4 detail_tab" id="detail_2" no="2" data-toggle="modal" data-target="#modalReset">
                            <span class="navi-icon mr-2">
                                <span class="svg-icon">
                                    <i class="fas fa-key"></i>
                                </span>
                            </span>
                            <span class="navi-text font-size-lg">Reset Password</span>
                        </a>
                    </div>
                    <div class="navi-item mb-2">
                        <a href="javascript:void(0)" class="navi-link py-4 detail_tab" id="detail_3" no="3">
                            <span class="navi-icon mr-2">
                                <span class="svg-icon">
                                    <i class="fas fa-users"></i>
                                </span>
                            </span>
                            <span class="navi-text font-size-lg">Keluarga</span>
                        </a>
                    </div>
                    <div class="navi-item mb-2">
                        <a href="javascript:void(0)" class="navi-link py-4 detail_tab" id="detail_4" no="4">
                            <span class="navi-icon mr-2">
                                <span class="svg-icon">
                                    <i class="fas fa-truck-loading"></i>
                                </span>
                            </span>
                            <span class="navi-text font-size-lg">Riwayat Transaksi</span>
                        </a>
                    </div>
                    <div class="navi-item mb-2">
                        <a href="javascript:void(0)" class="navi-link py-4 detail_tab" id="detail_5" no="5">
                            <span class="navi-icon mr-2">
                                <span class="svg-icon">
                                    <i class="fas fa-file-contract"></i>
                                </span>
                            </span>
                            <span class="navi-text font-size-lg">Hasil Lab</span>
                        </a>
                    </div>
                    <div class="navi-item mb-2">
                        <a href="javascript:void(0)" class="navi-link py-4 detail_tab" id="detail_6" no="6">
                            <span class="navi-icon mr-2">
                                <span class="svg-icon">
                                    <i class="fab fa-weixin"></i>
                                </span>
                            </span>
                            <span class="navi-text font-size-lg">Chat</span>
                        </a>
                    </div>
                    
                </div>
                <!--end::Nav-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Profile Card-->
    </div>
    <!--end::Aside-->
    <!--begin::Content-->
    <div class="flex-row-fluid ml-lg-8">
        <!--begin::Card-->
        <input type="hidden" name="id" value="{{$data->id}}" id="id_user">
        <input type="hidden" value="{{$data->status}}" id="id_status">
        <input type="hidden" value="1" id="id_tab">
        <input type="hidden" name="id_detail" id="id_detail">
        <input type="hidden" name="id_tipe" id="id_tipe">
        <div class="card card-custom p-4" id="div_isi">
            <!--begin::Header-->
            <div class="card-header py-3">
                <div class="card-title align-items-start flex-column">
                    <h3 class="card-label font-weight-bolder text-dark">Ubah Profil User</h3>
                </div>
                <div class="card-toolbar">
                    <button type="button" class="btn btn-success mr-2" id="save_edit">Simpan Perubahan</button>
                </div>
            </div>
            <!--end::Header-->
            <!--begin::Form-->
            <form class="form" id="form_edit">@csrf
                <div class="card-body">
                    <!--begin::Heading-->
                    <div class="row">
                        <label class="col-xl-3"></label>
                        <div class="col-xl-9">
                            <h5 class="font-weight-bold mb-6">Account:</h5>
                        </div>
                    </div>
                    <!--begin::Form Group-->
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">Nama </label>
                        <div class="col-xl-9">
                            <div class="">
                                <input class="form-control form-control-lg form-control-solid" name="user_name" type="text" value="{{$data->user_name}}">
                                <input type="hidden" name="id" value="{{$data->id}}">
                            </div>
                        </div>
                    </div>
                    <!--begin::Form Group-->
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">Nik </label>
                        <div class="col-xl-9">
                            <div class="">
                                <input class="form-control form-control-lg form-control-solid" name="nik" type="number" min="0" value="{{$data->nik}}">
                            </div>
                        </div>
                    </div>
                    <!--begin::Form Group-->
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">Phone </label>
                        <div class="col-xl-9">
                            <div class="">
                                <input class="form-control form-control-lg form-control-solid" name="user_phone"  type="text" value="{{$data->user_phone}}">
                            </div>
                        </div>
                    </div>
                    <!--begin::Form Group-->
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">Email</label>
                        <div class="col-xl-9">
                            <div class="input-group input-group-lg input-group-solid">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="la la-at"></i>
                                    </span>
                                </div>
                                <input type="text" name="user_email" class="form-control form-control-lg form-control-solid" value="{{$data->user_email}}" placeholder="Email">
                            </div>
                        </div>
                    </div>
                    <!--begin::Form Group-->
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">Tanggal Lahir</label>
                        <div class="col-xl-9">
                            <div class="">
                                <input class="form-control form-control-lg form-control-solid" name="birthday"  type="date" value="{{date('Y-m-d',strtotime($data->birthday))}}">
                            </div>
                        </div>
                    </div>
                    <!--begin::Form Group-->
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">Jenis Kelamin</label>
                        <div class="col-xl-9">
                            <select class="form-control form-control-lg form-control-solid" name="gender">
                                <option value="">Pilih Gender</option>
                                <option value="1" <?php if ($data->gender == 1) {
                                    echo "selected";
                                } ?>>Laki - Laki</option>
                                <option value="2" <?php if ($data->gender == 2) {
                                    echo "selected";
                                } ?>>Perempuan</option>
                                
                            </select>
                        </div>
                    </div>
                    <!--begin::Form Group-->
                    <div class="separator separator-dashed my-5"></div>
                    <!--begin::Form Group-->
                    <div class="row">
                        <label class="col-xl-3"></label>
                        <div class="col-xl-9">
                            <h5 class="font-weight-bold mb-6">Alamat:</h5>
                        </div>
                    </div>
                    <!--begin::Form Group-->
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">Negara</label>
                        <div class="col-xl-9">
                            <select class="form-control form-control-lg form-control-solid select2" name="id_country" onchange="country_change()" id="id_country">
                                <option value="">Pilih Negara</option>
                                @foreach($negara as $n)
                                    @if($n->id == $data->id_country)
                                    <option value="{{$n->id}}" selected>{{$n->name}}</option>
                                    @else
                                    <option value="{{$n->id}}">{{$n->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                     <!--begin::Form Group-->
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">Provinsi</label>
                        <div class="col-xl-9">
                            <select class="form-control form-control-lg form-control-solid select2" id="select_province" name="id_province" onchange="province_change()">
                                @if($data->id_province != null)
                                    @foreach(DataProvince($data->id_country) as $pv)
                                        @if($pv->id == $data->id_province)
                                        <option value="{{$pv->id}}" selected="">{{$pv->name}}</option>
                                        @else
                                        <option value="{{$pv->id}}">{{$pv->name}}</option>
                                        @endif
                                    @endforeach
                                @else
                                <option value="">-- Pilih Provinsi --</option>
                                @endif
                            </select>
                        </div>
                    </div>
                     <!--begin::Form Group-->
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">Kota</label>
                        <div class="col-xl-9">
                            <select class="form-control form-control-lg form-control-solid select2" id="select_city" name="id_city" onchange="city_change()">
                                @if($data->id_city != null)
                                    @foreach(DataCity($data->id_province) as $k)
                                        @if($k->id == $data->id_city)
                                        <option value="{{$k->id}}" selected="">{{$k->name}}</option>
                                        @else
                                        <option value="{{$k->id}}">{{$k->name}}</option>
                                        @endif
                                    @endforeach
                                @else
                                <option value="">-- Pilih Kota --</option>
                                @endif
                            </select>
                        </div>
                    </div>
                     <!--begin::Form Group-->
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">Kecamatan</label>
                        <div class="col-xl-9">
                            <select class="form-control form-control-lg form-control-solid select2" id="select_district" name="id_district">
                                @if($data->id_district != null)
                                    @foreach(DataDistrict($data->id_city) as $d)
                                        @if($d->id == $data->id_district)
                                        <option value="{{$d->id}}" selected="">{{$d->name}}</option>
                                        @else
                                        <option value="{{$d->id}}">{{$d->name}}</option>
                                        @endif
                                    @endforeach
                                @else
                                <option value="">-- Pilih Kecamatan --</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <!--begin::Form Group-->
                    <div class="form-group row">
                        <label class="col-xl-3 col-lg-3 col-form-label">Alamat</label>
                        <div class="col-xl-9">
                            <textarea class="form-control form-control-lg" name="address">{{$data->address}}</textarea>
                        </div>
                    </div>
                </div>
            </form>
            <!--end::Form-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Content-->
</div>
<input type="hidden" id="id_user" name="">
<!-- Preview -->
<div class="modal fade modal-cv" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modalReset">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 12px">
            <div class="modal-header">
                <h4 class="modal-title" id="title-modal">Warning !!!</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">
                    <label>Apakah Anda yakin Untuk Me Reset User Tersebut ??</label>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="aksi_reset">OK</button>
                <button type="button" class="btn btn-primary" disabled style="display: none;" id="aksi_reset_loading">Loading ......</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- Preview -->
<!-- Preview -->
<div class="modal fade modal-cv" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modalHapus">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 12px">
            <div class="modal-header">
                <h4 class="modal-title" id="title-modal">Hapus User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">
                    <label>Apakah Anda yakin Untuk Menghapus User Tersebut ??</label>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" id="aksi_hapus">OK</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- Preview -->
<div class="modal fade modal-cv" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modalStatus">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 12px">
            <div class="modal-header">
                <h4 class="modal-title" id="title-modal">Ubah Status</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">
                    <label id="label_status"></label>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" id="aksi_status">OK</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- Preview -->
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
<!-- modal upload hasil -->
<div class="modal fade" id="modalUpload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title a_approve">Upload Hasil Tes disini</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form id="form_upload"> 
                            <div class="col-md-12 text-left mt-5">
                                <label>Upload Hasil :</label>
                                <input type="file" name="file" class="form-control form-control-lg">
                            </div> 
                            <div class="col-md-12 text-left">
                                <label>Catatan Tambahan :</label>
                                <textarea class="form-control" id="text_note" name="note"></textarea>
                                <input type="hidden" name="id" id="id_user_hasil">
                            </div> 
                        </form> 
                    </div>  
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn_upload" class="btn btn-success" data-dismiss="modal"><i class="fas fa-save"></i> Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- modal per Email -->
<div class="modal fade" id="modalSendEmail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Kirim Email Untuk <span id="span_email" class="text-success font-weight-bolder"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
            <div class="text-center" id="txt_email">
                <h5 class="text-dark-90">Apakah Anda Yakin Mengirim Email dengan hasil : <span id="span_hasil"></span> </h5>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success ml-2 mr-2" id="kirim_email">Iya, Kirim Email</button>
        <button type="button" class="btn btn-success ml-2 mr-2" id="loading_kirim_email" disabled style="display: none">Proses Kirim Email....</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- modal kirim email hasil -->
<div class="modal fade" id="modalSendEmailHasil" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Kirim Email Untuk <span id="span_email_hasil" class="text-success font-weight-bolder"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
            <div class="text-center" id="txt_email">
                <h5 class="text-dark-90">Apakah Anda Yakin Mengirim Email hasil Pemeriksaan ini? </h5>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success ml-2 mr-2" id="kirim_email_hasil">Iya, Kirim Email</button>
        <button type="button" class="btn btn-success ml-2 mr-2" id="loading_kirim_email_hasil" disabled style="display: none">Proses Kirim Email....</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modalApprovemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tetapkan Hasil Tes <span id="span_pasien" class="text-success font-weight-bolder"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <a style="background: linear-gradient(99.95deg, #6B83D9 0%, #B283FF 100%);width: 100%;height: 100px" href="javascript:void(0)" onclick="approveThis('1')" class="nav-link btn btn-icon btn-clean btn-lg" data-dismiss="modal">
                    <span class="svg-icon svg-icon-xl">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Media/Equalizer.svg-->
                        <i style="color: white" class="fas fa-user-shield"></i>
                        <p style="color: white;margin-top: 5px;">Negatif</p>
                        <!--end::Svg Icon-->
                    </span>
                </a>
            </div>
            <div class="col-md-6">
                <a style="background: linear-gradient(99.95deg, #d64789 0%, #df46a9 100%);width: 100%;height: 100px;" href="javascript:void(0)" onclick="approveThis('2')" class="nav-link btn btn-icon btn-clean btn-lg" data-dismiss="modal">
                    <span class="svg-icon svg-icon-xl">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Media/Equalizer.svg-->
                        <i style="color: white" class="fas fa-user-injured"></i>
                        <p style="color: white;margin-top: 5px;">Positif</p>
                        <!--end::Svg Icon-->
                    </span>
                </a>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')
@include('components/componen_crud')
<script type="text/javascript">
var column_hasil = [{
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
    { "data": "pasien" },
    { "data": "produk" },
    { "data": "pcr" },
    { "data": "antigen" },
    { "data": "hasil" },
    { "data": "date" }
];

function TableHasil(){

    var search = null;
    var sort = 1;   
    var xin_table = $('#data_tabel').DataTable({
        "processing": true,
        "serverSide": true,
        "orderable": false,
        "targets": 'no-sort',
        "bSort": false,
        "bFilter": false,
        "ajax": {
            "url": '/data_hasil',
            "dataType": "json",
            "type": "POST",
            "data": { _token: "{{csrf_token()}}",search :search,sort:sort,user:user }
        },
        "columns": column_hasil,
        "bDestroy": true
    });
    $("#data_tabel_length").remove();
}

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

$(document).off('click', '#aksi_status').on('click', '#aksi_status', function() {
    user = $("#id_user").val();
    status = $("#id_status").val();
    if (status == '1') {
       link = '/nonactive/user';
       $("#div_status").html('<div class="text-danger">Tidak active</div>');
       $("#id_status").val(0);
    } else {
       link = '/active/user';
       $("#div_status").html('<div class="text-success">active</div>');
       $("#id_status").val(1);
    }
    
    //alert(status);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({ //line 28
        type: 'POST',
        url: link,
        dataType: 'json',
        data: { id:user },
        
        success: function(data) {  
            show_toast(data.message, 1);
            
        }
    });
});
$(document).off('click', '#aksi_hapus').on('click', '#aksi_hapus', function() {
    user = $("#id_user").val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({ //line 28
        type: 'POST',
        url: '/delete/user',
        dataType: 'json',
        data: { id:user},
        
        success: function(data) {  
            show_toast(data.message, 1);
        }
    });
});
$(document).off('click', '#aksi_reset').on('click', '#aksi_reset', function() {
    //alert("wakwau");
    user = $("#id_user").val();
    //alert(user);
    $("#aksi_reset").css('display','none');
    $("#aksi_reset_loading").css('display','');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({ //line 28
        type: 'POST',
        url: '/reset_password_user',
        dataType: 'json',
        data: { id:user},
        
        success: function(data) {  
            show_toast(data.message, 1);
            $("#aksi_reset").css('display','');
            $("#aksi_reset_loading").css('display','none');
            $("#modalReset").modal('hide');
        }

    });
});

$(document).off('click', '.detail_tab').on('click', '.detail_tab', function() {
    no = $(this).attr('no');
    user = $("#id_user").val();
    $("#id_tab").val(no);
    //alert(user)
    for (var i = 0; i < 6; i++) {
        $("#detail_"+i).removeClass('active');
    }
    $("#detail_"+no).addClass('active');
    if (no == '1') {
        location.reload();
    } else if (no == '3') {
        // pasien
        $.ajax({
            url: '/get_keluarga/'+user,
            type: "GET",
            success: function(response) {
                if (response) {
                    $("#div_isi").html(response);
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
                        { "data": "status" },
                        { "data": "date" },
                        { "data": "actions" }
                    ];

                    var search = null;
                    var sort = 1;   
                    var xin_table = $('#data_tabel').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "orderable": false,
                        "targets": 'no-sort',
                        "bSort": false,
                        "bFilter": false,
                        "ajax": {
                            "url": '/data_pasien',
                            "dataType": "json",
                            "type": "POST",
                            "data": { _token: "{{csrf_token()}}",search :search,sort:sort,user:user }
                        },
                        "columns": columns,
                        "bDestroy": true
                    });
                    $("#data_tabel_length").remove();
                        
                }
            }
        });
    } else if (no == '4') {
        // TRANSAKSI
        $.ajax({
            url: '/get_transaksi/'+user,
            type: "GET",
            success: function(response) {
                if (response) {
                    $("#div_isi").html(response);
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
                        { "data": "no_invoice" },
                        { "data": "nominal" },
                        { "data": "status" },
                        { "data": "date" },
                        { "data": "actions" }
                    ];

                    var search = null;
                    var sort = 1;   
                    var xin_table = $('#data_tabel').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "orderable": false,
                        "targets": 'no-sort',
                        "bSort": false,
                        "bFilter": false,
                        "ajax": {
                            "url": '/data_transaksi',
                            "dataType": "json",
                            "type": "POST",
                            "data": { _token: "{{csrf_token()}}",search :search,sort:sort,user:user }
                        },
                        "columns": columns,
                        "bDestroy": true
                    });
                    $("#data_tabel_length").remove();
                        
                }
            }
        });

    } else if (no == '5') {

        // Hasil Tes
        $.ajax({
            url: '/get_hasil/'+user,
            type: "GET",
            success: function(response) {
                if (response) {
                    $("#div_isi").html(response);
                    TableHasil();
                        
                }
                // Action Hasil
                $(document).off('click', '.approve').on('click', '.approve', function(){
                   id = $(this).attr('id');
                   user = $(this).attr('user');
                   name = $(this).attr('name');
                   jenis = $(this).attr('jenis');
                   $("#id_detail").val(id);
                   $("#id_tipe").val(jenis);
                   $("#id_user").val(user);
                   $("#span_pasien").html(name);
                   $("#modalApprovemodal").modal('show'); 
                });

                $(document).off('click', '.send_email').on('click', '.send_email', function(){
                   id = $(this).attr('id');
                   user = $(this).attr('user');
                   hasil = $(this).attr('hasil');
                   name = $(this).attr('name');
                   $("#id_detail").val(id);
                   $("#id_user").val(user);
                   $("#span_email").html(name);
                   $("#span_hasil").html(hasil);
                   $("#modalSendEmail").modal('show'); 
                });

                $(document).off('click', '.send_email_hasil').on('click', '.send_email_hasil', function(){
                   id = $(this).attr('id');
                   user = $(this).attr('user');
                   name = $(this).attr('name');
                   $("#id_detail").val(id);
                   $("#id_user").val(user);
                   $("#span_email_hasil").html(name);
                   $("#modalSendEmailHasil").modal('show'); 
                });

                $(document).off('click', '#kirim_email').on('click', '#kirim_email', function(){
                    id = $("#id_detail").val();
                    user = $("#id_user").val();
                    $("#kirim_email").css('display','none');
                    $("#loading_kirim_email").css('display','');
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url  :'/send_email_hasil',
                        type : "POST",
                        data : { id:id,user:user },
                        success: function (data) {
                            // console.log(response);
                            $("#modalSendEmail").modal('hide'); 
                            show_toast(data.message, 1);
                            DataTable();
                            $("#kirim_email").css('display','');
                            $("#loading_kirim_email").css('display','none');
                        }
                    });
                });

                $(document).off('click', '#kirim_email_hasil').on('click', '#kirim_email_hasil', function(){
                    id = $("#id_detail").val();
                    user = $("#id_user").val();
                    $("#kirim_email_hasil").css('display','none');
                    $("#loading_kirim_email_hasil").css('display','');
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url  :'/send_email_hasil_new',
                        type : "POST",
                        data : { id:id,user:user },
                        success: function (data) {
                            // console.log(response);
                            $("#modalSendEmailHasil").modal('hide'); 
                            show_toast(data.message, 1);
                            DataTable();
                            $("#kirim_email_hasil").css('display','');
                            $("#loading_kirim_email_hasil").css('display','none');
                        }
                    });
                });

                $(document).off('click','.unggah_hasil').on('click','.unggah_hasil', function (){
                    var id = $(this).attr('user');
                    $("#id_user_hasil").val(id);
                    $("#modalUpload").modal('show');
                });

                $(document).off('click','#btn_upload').on('click','#btn_upload', function (){
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({ //line 28
                        type: 'POST',
                        url: '/upload_hasil_tes',
                        dataType: 'json',
                        data: new FormData($("#form_upload")[0]),
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            if (data.code == 200) {
                                show_toast(data.message, 1);
                                DataTable();
                            } else {
                                alert("maaf ada yang salah!!!");
                            }
                        }
                    });
                });

                $(document).off('click','#download_excel').on('click','#download_excel', function(){
                    var serial = $("#form_filter").serialize();
                    window.open("/download_excel/"+serial, '_blank');
                });         
            }
        });

    } else if (no == '6') {
        $.ajax({
            url: '/get_chat/'+user,
            type: "GET",
            success: function(response) {
                if (response) {
                    $("#div_isi").html(response);
                    $(document).scrollTop($(document).height());
                    $('#the_message').scrollTop($('#the_message')[0].scrollHeight);

                    $("#div_isi").append('<div class="card-footer align-items-center" id="footer_send" style=""><form id="form_reply"><input type="hidden" name="id_user" value="'+user+'" id="id_user_reply"><textarea class="form-control border-0 p-0" rows="2" placeholder="Type a message" name="reply" id="txt_reply" onkeydown="pressed(event)"></textarea><div class="d-flex align-items-center justify-content-between mt-5"><div class="mr-3"></div><div><button type="button" class="btn btn-primary btn-md text-uppercase font-weight-bold py-2 px-6" id="reply">Balas</button></div></div></form></div>');
                }
            }
        });

        
    }
});

function pressed(e) {
    //alert("okey");
            // Has the enter key been pressed?
    if ( (window.event ? event.keyCode : e.which) == 13) { 
        // If it has been so, manually submit the <form>
        //alert("enter");
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({ //line 28
            type: 'POST',
            url: '/reply_chat_member',
            dataType: 'json',
            data: new FormData($("#form_reply")[0]),
            processData: false,
            contentType: false,
            success: function(data) {
                if (data.code == 200) {
                    $("#message").remove();
                    show_toast(data.message, 1);
                    $("#the_message").append('<div class="messages"><div class="d-flex flex-column mb-5 align-items-start"><div class="d-flex align-items-center"><div class="symbol symbol-circle symbol-40 mr-3"><img alt="Pic" src="'+data.profile+'"></div><div><a href="javascript:void(0)" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">Admin</a><span class="text-muted font-size-sm">Baru Saja</span></div></div><div class="mt-2 rounded p-5 bg-light-primary text-dark-50 font-weight-bold font-size-lg text-left max-w-400px">'+data.chat+'</div></div></div>');
                    $('#the_message').scrollTop($('#the_message')[0].scrollHeight);
                    $("#txt_reply").val('');
                    
                } else {
                    show_toast(data.message, 0);
                }
                
            }
        });
    }
}
$(document).off('click', '#reply').on('click', '#reply', function() {
//$("#form_reply").submit(function(e) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({ //line 28
        type: 'POST',
        url: '/reply_chat_member',
        dataType: 'json',
        data: new FormData($("#form_reply")[0]),
        processData: false,
        contentType: false,
        success: function(data) {
            if (data.code == 200) {
                $("#message").remove();
                show_toast(data.message, 1);
                $("#the_message").append('<div class="messages"><div class="d-flex flex-column mb-5 align-items-start"><div class="d-flex align-items-center"><div class="symbol symbol-circle symbol-40 mr-3"><img alt="Pic" src="'+data.profile+'"></div><div><a href="javascript:void(0)" class="text-dark-75 text-hover-primary font-weight-bold font-size-h6">Admin</a><span class="text-muted font-size-sm">Baru Saja</span></div></div><div class="mt-2 rounded p-5 bg-light-primary text-dark-50 font-weight-bold font-size-lg text-left max-w-400px">'+data.chat+'</div></div></div>');
                $('#the_message').scrollTop($('#the_message')[0].scrollHeight);
                $("#txt_reply").val('');
                
            } else {
                show_toast(data.message, 0);
            }
            
        }
    });
});

function approveThis(status){
    id = $("#id_detail").val();
    user = $("#id_user").val();
    tipe = $("#id_tipe").val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url  :'/hasil_tes',
        type : "POST",
        data : { id:id,status:status,user:user,tipe:tipe},
        success: function (data) {
            // console.log(response);
            show_toast(data.message, 1);
            TableHasil();
        }
    });
}

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
function country_change() {
    country_id = $("#id_country").val();
    
    $(".class_address").css('display','');
    $.ajax({
        type: 'GET',
        url: '/data_province/' + country_id,
        dataType: 'json',
        success: function(data) {
            console.log(data)
            $("#select_province").empty().append("<option value=''>Pilih Provinsi</option>");
            $("#select_city").empty().append("<option value=''>Pilih Kota</option>");
            $("#select_district").empty().append("<option value=''>Pilih Kecamatan</option>");
            $("#select_village").empty().append("<option value=''>Pilih Desa</option>");
            for (let i = 0; i < data.length; i++) {
                $("#select_province").append("<option value=" + data[i].id + ">" + data[i].name + "</option>");
            }
        },
        error: function(data) {
            console.log(data);
        }
    });
   
    
}

function province_change() {
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

function DataTable(){
    //alert("okey");
    sort = $("#sort").val();
    $("#is_sort").val(sort);

    data_tabel('data_user');
}
function FilterBy(){
    alert("cak");
}

$(document).off('click','.d_detail').on('click','.d_detail', function (){
    var id = $(this).attr('id');
    tab = $("#id_tab").val();
    if (tab == '3') {
       url = '/detail_pasien/'+id;
    } else if(tab == '4'){
       url = '/detail_transaksi/'+id;
    } else if(tab == '5'){
       url = '';
    }
    
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
        url :url,
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

$(document).off('click', '.up_status').on('click', '.up_status', function(){
    status = $(this).attr('status');
    if (status == '1') {
       $("#label_status").html('Apakah Anda Yakin Untuk Menon activekan User Ini ???');
    } else {
       $("#label_status").html('Apakah Anda Yakin Untuk Meng activekan User Ini ???');
    }
});

</script>
@endsection
