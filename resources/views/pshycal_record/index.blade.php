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
@section('title', 'Tipe Produk')
@section('content')
<div class="accordion accordion-solid accordion-panel accordion-svg-toggle mb-3 mt-3" id="faq">
    <div class="card p-6 col-md-12">
        <div class="card-header" id="faqHeading2">
            <div class="card-title font-size-h4 text-dark" data-toggle="collapse" data-target="#faq2" aria-expanded="false" aria-controls="faq2" role="button">
                <div class="card-label">Filter<i class="fas fa-filter"></i></div>
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
        <div id="faq2" class="collapse show" aria-labelledby="faqHeading2" data-parent="#faq" style="">
            <div class="card-body pt-3 font-size-h6 font-weight-normal text-dark-50">
                <form id="form_filter">
                    <div class="row" data-select2-id="4">
                        <div class="col-md-2">
                            <label>Gender </label>
                            <select class="select2 form-control" id="gender" name="gender" onchange="data_tabel('/data_pemeriksaan')">
                                <option value="">Semua</option>
                                <option value="1">Laki - Laki</option>
                                <option value="2">Perempuan</option>
                            </select>
                        </div>
                        @if(Auth::guard('admin')->user()->id_scholl == null)
                        <div class="col-md-3">
                            <label>Sekolah IPEKA</label>
                            <select class="select2 form-control" onchange="ChangeScholl()" id="id_scholl" name="id_scholl">
                                <option value="">Semua</option>
                                @foreach($data_scholl as $ct)
                                <option value="{{$ct->id}}">{{$ct->scholl_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Kelas</label>
                            <select class="select2 form-control" onchange="data_tabel('/data_pemeriksaan')" id="id_class" name="id_class">
                                <option value="">Semua Kelas</option>
                                
                            </select>
                        </div>
                        
                        @else
                        <input type="hidden" name="id_scholl" id="id_scholl" value="{{Auth::guard('admin')->user()->id_scholl}}">
                        <div class="col-md-5">
                            <label>Kelas</label>
                            <select class="select2 form-control" onchange="data_tabel('/data_pemeriksaan')" id="id_class" name="id_class">
                                <option value="">Semua Kelas</option>
                                @foreach(DataClass(Auth::guard('admin')->user()->id_scholl) as $ct)
                                <option value="{{$ct->id}}">{{$ct->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        <div class="col-md-2">
                            <div class="form-group">
                                <label></label>
                                <select class="form-control form-control-lg" name="sort" onchange="data_tabel('/data_pemeriksaan')" id="sort" style="height: 45px;">
                                    <option value="1">Terakhir dibuat</option>
                                    <option value="2">By Nama (A - Z)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label></label>
                                <button type="button" onclick="DownloadExcel()" class="btn btn-lg btn-success btn-block">Download Excel</button>
                            </div>
                        </div>
                        <div class="col-md-2 col-6 mt-3">
                            <label>Dari </label>
                            <input class="form-control" value="{{$start}}" type="date" id="start_date" name="start_date" onchange="data_tabel('/data_pemeriksaan')">
                        </div>
                        <div class="col-md-2 col-6 mt-3">
                            <label>Sampai </label>
                            <input class="form-control" value="{{$end}}" type="date" id="end_date" name="end_date" onchange="data_tabel('/data_pemeriksaan')">
                        </div>
                        <div class="col-md-5 col-8 mt-3">
                            <label></label>
                            <div class="input-group rounded bg-light mt-1">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <span class="svg-icon svg-icon-lg">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/General/Search.svg-->
                                            <i class="fas fa-search"></i>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </span>
                                </div>
                                <input type="text" id="s_search" name="search" class="form-control h-45px" onkeyup="data_tabel('/data_pemeriksaan')" placeholder="Cari">
                            </div>
                        </div>
                        <div class="col-md-2 col-4 mt-3">
                            <div class="form-group">
                                <label></label>
                                <button type="button" onclick="Reset()" class="btn btn-lg btn-danger btn-block">Reset</button>
                            </div>
                        </div>
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
            <div class="card-header align-items-center border-0 mt-2">
                <h5 class="text-dark font-weight-bold ml-3">List Pemeriksaan Tahunan</h5>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body pt-2">
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <!-- <div class="card-header">
                                    <h4 class="card-title">List Admin</h4>
                                </div> -->
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table zero-configuration" id="yourTable">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Kelas</th>
                                                        <th>Siswa</th>
                                                        <th>Dokter Pemeriksa</th>
                                                        <th>Tanggal</th>
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
    </div>
</div>
<input type="hidden" id="id_user" name="">
<!-- modal batal approve -->

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
var column = [
        { "data": "no" },
        { "data": "scholl" },
        { "data": "student" },
        { "data": "admin" },
        { "data": "date" },
        { "data": "actions" },
    ];

function data_tabel(table) {
    var search     = $("#s_search").val();
    var sort       = $("#sort").val();
    var id_scholl  = $("#id_scholl").val();
    var gender     = $("#gender").val();
    var start_date = $("#start_date").val();
    var end_date   = $("#end_date").val();
    var id_class   = $("#id_class").val();
    var is_edit    = $("#is_edit").val();
    var is_delete  = $("#is_delete").val();
    var nantable   = $('#yourTable').DataTable({
        "processing": true,
        "serverSide": true,
        "searching": false,
        "ajax": {
            "url": table,
            "dataType": "json",
            "type": "POST",
            "data": { _token: "{{csrf_token()}}",search:search,sort:sort,id_class:id_class,start_date:start_date,end_date:end_date,gender:gender,id_scholl:id_scholl,is_edit:is_edit,is_delete:is_delete }
        },
        "columns": column,
        "bDestroy": true
    });
    return nantable;
}
$(function() {
    //$('#myTable').DataTable();
    $(".select2-container--default").css('width', '100%');
    data_tabel('/data_pemeriksaan')
});
$("#s_search").keyup(function(){
   data_tabel('/data_pemeriksaan')
});


$('.select2').on('change', function() { // when the value changes
    $(this).valid(); // trigger validation on this element
});

function ChangeScholl(){

    id = $("#id_scholl").val();
    if (id != '' || id != null) {
        $.ajax({
            type: 'GET',
            url: '/get_class/'+id,
            dataType: 'json',
            success: function(data) {
                console.log(data)
                $("#id_class").empty();
                $("#id_class").append("<option value=''>Semua Kelas</option>");
                for (let i = 0; i < data.length; i++) {
                    $("#id_class").append("<option value=" + data[i].id + ">" + data[i].name + "</option>");
                }
                data_tabel('/data_pemeriksaan');
            },
            error: function(data) {
                console.log(data);
            }
        });
    } else {
        data_tabel('/data_pemeriksaan');
    }
}

function ResetAll(){
    location.reload();
}

function Reset(){
    location.reload();
}

function DownloadExcel(){
    var serial = $("#form_filter").serialize();
    window.open("/export_excel/pshycal_record/"+serial, '_blank');
}
</script>
@endsection
