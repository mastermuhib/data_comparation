@extends('layout.app')
@section('asset')
<link rel="stylesheet" type="text/css" href="{{URL::asset('assets')}}/vendors/css/forms/select/select2.min.css">
@endsection
@section('title', 'Rekapitulasi Desa')
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
                            <label>Kecamatan</label>
                            <select class="select2 select2-lg form-control" onchange="DataTable()" id="id_kec" name="id_kec">
                                <option value="">Semua</option>
                                @foreach($data_kec as $ct)
                                <option value="{{$ct->id}}">{{$ct->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Triwulan</label>
                            <select class="select2 form-control" onchange="ChangeTriwulan()" id="id_triwulan" name="id_triwulan">
                                @foreach($triwulan as $ct)
                                <option value="{{$ct->id}}">{{$ct->name}}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="triwulan" value="{{ $triwulan[0]->triwulan }}" id="triwulan">
                            <input type="hidden" name="year" value="{{ $triwulan[0]->year }}" id="year">
                        </div>
                        <div class="col-md-2">
                            <label>Klasifikasi</label>
                            <select class="select2 form-control" onchange="DataTable()" id="klasifikasi" name="klasifikasi">
                                <option value="">Semua</option>
                                @foreach($data_klasifikasi as $k)
                                <option value="{{$k->id}}">{{$k->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Status </label>
                            <select class="select2 form-control" id="status" name="status[]" multiple onchange="DataTable()">
                                <option value="baru" selected>Baru</option>
                                <option value="ubah" selected>Ubah</option>
                                <option value="aktif" selected>Aktif</option>
                                <option value="tms">TMS</option>
                                <option value="hapus">Hapus</option>
                            </select>
                        </div>
                        <div class="col-md-2 pt-5">
                            <button class="btn btn-block btn-primary" type="button" onclick="Calculate()">Hitung Rekap</button>
                        </div>
                        <div class="col-md-2 pt-5">
                            <button class="btn btn-block btn-success" type="button" onclick="Download('excel')">Download Excel</button>
                        </div>
                        <div class="col-md-2 pt-5">
                            <button class="btn btn-block btn-danger" type="button" onclick="Download('pdf')">Download PDF</button>
                        </div>
                        <input type="hidden" id="start" name="start" value="0">
                        
                    </div>
                </form>
            </div>
        </div>
        <!--end::Body-->
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <!--begin::List Widget 9-->
        <div class="card card-custom card-stretch gutter-b">
            <!--begin::Header-->
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
                                                        <th>Kecamatan</th>
                                                        <th>Klasifikasi</th>
                                                        <th>Laki - Laki</th>
                                                        <th>Perempuan</th>
                                                        <th>Total</th>
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
<!-- Modal Delete-->
    <div class="modal fade text-left" id="modalCalculate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content modal-lg">
                <div class="modal-header">
                    <h4 class="modal-title" id="title-modal">Menghitung Ulang</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal p-3" novalidate id="form_calcuclate">@csrf
                    <div class="row">
                        <div class="col-4 pt-2">
                            <label>Pilih Triwulan</label>
                            <select class="select2 form-control" name="triwulan">
                                <option value="1">Triwulan I</option>
                                <option value="2">Triwulan II</option>
                                <option value="3">Triwulan III</option>
                                <option value="4">Triwulan IV</option>
                            </select>
                        </div>
                        <div class="col-4 pt-2">
                            <label>Pilih Tahun</label>
                            <select class="select2 form-control" name="year">
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                            </select>
                        </div>
                        <div class="col-4 pt-5">
                            <button class="btn btn-block btn-success" id="save_btn">Hitung Rekap</button>
                            <button class="btn btn-block btn-success" style="display:none;" disabled id="loading_btn">Loading.........</button>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" >Tutup</button>
                </div>
            </div>
        </div>
    </div>
<!-- End Modal -->
@endsection
@section('js')
@include('components/componen_crud')
<script type="text/javascript">
var column = [
        { "data": "no" },
        { "data": "kec" },
        { "data": "klasifikasi" },
        { "data": "male" },
        { "data": "female" },
        { "data": "total" },
        { "data": "actions" },
    ];

function data_tabel(table) {
    var id_kec      = $("#id_kec").val();
    var triwulan    = $("#triwulan").val();
    var year        = $("#year").val();
    var status      = $("#status").val();
    var klasifikasi = $("#klasifikasi").val();
    var nantable    = $('#yourTable').DataTable({
        "processing": true,
        "serverSide": true,
        "searching": false,
        "ajax": {
            "url": table,
            "dataType": "json",
            "type": "POST",
            "data": { _token: "{{csrf_token()}}",id_kec:id_kec,year:year,triwulan:triwulan,klasifikasi:klasifikasi,status:status }
        },
        "columns": column,
        "bDestroy": true
    });
    return nantable;
}
$(function() {
    //$('#myTable').DataTable();
    $(".select2-container--default").css('width', '100%');
    data_tabel('/rekapitulasi/data_klasifikasi')
});
$("#s_search").keyup(function(){
   data_tabel('/rekapitulasi/data_klasifikasi')
});


$('.select2').on('change', function() { // when the value changes
    $(this).valid(); // trigger validation on this element
});

function Calculate(){
    $("#modalCalculate").modal('show');
}

function Reset(){
    location.reload();
}

function DataTable(){
    data_tabel('/rekapitulasi/data_klasifikasi')
}

function DownloadExcel(){
    var serial = $("#form_filter").serialize();
    window.open("/export_excel/dpt_report/"+serial, '_blank');
}

function ChangeTriwulan(){

    id = $("#id_triwulan").val();
    if (id != '' || id != null) {
        $.ajax({
            type: 'GET',
            url: '/get_triwulan/'+id,
            dataType: 'json',
            success: function(data) {
                console.log(data)
                $("#triwulan").val(data.triwulan);
                $("#year").val(data.year);
                DataTable();
            },
            error: function(data) {
                console.log(data);
            }
        });
    } else {
        DataTable();
    }
    
}

function ResetAll(){
    location.reload();
}

$("#form_calcuclate").validate({
    submitHandler: function(form) {
        $("#loading_btn").css('display','');
        $("#save_btn").css('display','none');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({ //line 28
            type: 'POST',
            url: '/rekapitulasi/klasifikasi/calculate',
            dataType: 'json',
            data: new FormData($("#form_calcuclate")[0]),
            processData: false,
            contentType: false,
            success: function(data) {
                $("#loading_btn").css('display','none');
                $("#save_btn").css('display','');
                if (data.code == 200) {
                    show_toast(data.message, 1);
                    location.reload();
                } else {
                    show_toast(data.message, 0);
                }
            }, error : function(data) {
                $("#loading_btn").css('display','none');
                $("#save_btn").css('display','');
            }
        });
    }
});

function Download(type){
    var serial = $("#form_filter").serialize();
    window.open("/download_rekapitulasi_klasifikasi/"+type+"/"+serial, '_blank');
}
</script>
@endsection