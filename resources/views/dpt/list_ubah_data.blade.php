@extends('layout.app')
@section('asset')
<link rel="stylesheet" type="text/css" href="{{URL::asset('assets')}}/vendors/css/forms/select/select2.min.css">
@endsection
@section('title', 'Riwayat Ubah Data')
@section('content')
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
                                <div class="card-header">
                                    <h4 class="card-title">Perubahan <u>{{ $data->type }}</u> pada Triwulan {{ $data->triwulan }} Tahun {{ $data->year }} Pada Tanggal {{ date("d F Y H:i", strtotime($data->created_at)) }}</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body card-dashboard">
                                        <div class="row">
                                            <div class="input-group rounded bg-light m-3 p-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <span class="svg-icon svg-icon-lg">
                                                            <!--begin::Svg Icon | path:assets/media/svg/icons/General/Search.svg-->
                                                            <i class="fas fa-search"></i>
                                                            <!--end::Svg Icon-->
                                                        </span>
                                                    </span>
                                                </div>
                                                <input type="text" id="s_search" name="search" class="form-control h-45px" onkeyup="DataTable()" placeholder="Cari">
                                                <input type="hidden" name="code" id="code" value="{{ $data->code }}">
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table zero-configuration" id="yourTable">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nik</th>
                                                        <th>Data Lama</th>
                                                        <th>Data Update</th>
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
@endsection
@section('js')
@include('components/componen_crud')
<script type="text/javascript">
var column = [
        { "data": "no" },
        { "data": "nik" },
        { "data": "old" },
        { "data": "new" },
 
    ];

function data_tabel(table) {
    var search     = $("#s_search").val();
    var code     = $("#code").val();
    var nantable   = $('#yourTable').DataTable({
        "processing": true,
        "serverSide": true,
        "searching": false,
        "ajax": {
            "url": '/data_detail_ubah',
            "dataType": "json",
            "type": "POST",
            "data": { _token: "{{csrf_token()}}",search:search,code:code }
        },
        "columns": column,
        "bDestroy": true
    });
    return nantable;
}


$(function() {
    //$('#myTable').DataTable();
    $(".select2-container--default").css('width', '100%');
    data_tabel('/data_ubah')
    
});


$("#s_search").keyup(function(){
   data_tabel('/data_ubah')
});


$('.select2').on('change', function() { // when the value changes
    $(this).valid(); // trigger validation on this element
});

function Reset(){
    location.reload();
}

function DataTable(){
    data_tabel('/data_ubah')
}

</script>
@endsection