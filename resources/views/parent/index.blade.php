@extends('layout.app')
@section('asset')
<link rel="stylesheet" type="text/css" href="{{URL::asset('assets')}}/vendors/css/forms/select/select2.min.css">
@endsection
@section('title', 'Master Payment Category')
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
                            <select class="select2 form-control" id="gender" name="gender" onchange="DataTable()">
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
                        <div class="col-md-3">
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
                                <input type="text" id="s_search" class="form-control h-45px" onkeyup="DataTable()" placeholder="Cari">
                            </div>
                        </div>
                        @else
                        <input type="hidden" name="id_scholl" id="id_scholl" value="{{Auth::guard('admin')->user()->id_scholl}}">
                        <div class="col-md-6">
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
                                <input type="text" id="s_search" class="form-control h-45px" onkeyup="DataTable()" placeholder="Cari">
                            </div>
                        </div>
                        @endif
                        <div class="col-md-2">
                            <label>Domisili</label>
                            <select class="select2 form-control" onchange="DataTable()" id="id_city" name="id_city">
                                <option value="">Semua Kota</option>
                                @foreach($data_city as $c)
                                <option value="{{$c->id}}">{{$c->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label></label>
                                <select class="form-control form-control-lg" onchange="DataTable()" id="sort" style="height: 45px;">
                                    <option value="1">Terakhir dibuat</option>
                                    <option value="2">By Nama (A - Z)</option>
                                </select>
                            </div>
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
    <div class="col-lg-12">
        <!--begin::List Widget 9-->
        <div class="card card-custom card-stretch gutter-b">
            <!--begin::Header-->
            <div class="card-body pt-2" id="div_body">
                
            </div>
            <!--end: Card Body-->
        </div>
        <!--end: Card-->
        <!--end: List Widget 9-->
        <!-- </div> -->
    </div>
</div>
<!-- Modal -->
    <div class="modal fade text-left" id="modal_aksi_status" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="title-modal">Warning !!!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" id="form_aksi_status">
                    <div class="modal-body">
                        <input type="hidden" value="" id="id_data_status" name="id">
                        <input type="hidden" value="" id="id_tujuan_status" name="tujuan">
                        <input type="hidden" value="" id="id_aksi_status" name="aksi">
                        <input type="hidden" value="" id="id_tabel_status" name="tabel">
                        <div class="modal_aksi_status"></div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="aksi_kirim_status">OK</button>
                </div>
            </div>
        </div>
    </div>
<!-- End Modal -->
<!-- Modal Delete-->
    <div class="modal fade text-left" id="modal_delete_data" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="title-modal">Warning !!!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                    <div class=""><h5>Apakah Anda yakin untuk menghapus orang tua ini?</h5></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="aksi_delete">OK</button>
                </div>
            </div>
        </div>
    </div>
<!-- End Modal -->
@endsection
@section('js')
<!-- scipt js -->
@include('components/componen_crud')

<style>
    label.error {
        color: red;
    }
    </style>
<script type="text/javascript">
$(function() {
    //$('#myTable').DataTable();
    $(".select2-container--default").css('width', '100%');
    DataTable();
    
});

$("#s_search").keyup(function(){
   DataTable();
});

function DataTable() {
    $("#start").val(0);
    var search = $("#search").val();
    var sort   = $("#sort").val();
    var id_scholl = $("#id_scholl").val();
    var gender = $("#gender").val();
    var start  = $("#start").val();
    var id_city = $("#id_city").val();

    //send data
    $("#div_body").html('<div class="col-md-12"><div class="text-center mt-20 mb-20"><span class="text-success">Loading............</span></div></div>');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({ //line 28
        type: 'POST',
        url: '/get_data_parent',
        dataType: 'html',
        data: { search:search,sort:sort,id_city:id_city,start:start,gender:gender,id_scholl:id_scholl },
        success: function(data) {  
            $("#div_body").html(data);
        }
    });   
}

function Next(){
    now = $("#start").val();
    start = parseInt(now) + 8;
    var search = $("#search").val();
    var sort   = $("#sort").val();
    var id_scholl = $("#id_scholl").val();
    var gender = $("#gender").val();
    var id_city = $("#id_city").val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({ //line 28
        type: 'POST',
        url: '/get_data_parent',
        dataType: 'html',
        data: { search:search,sort:sort,id_city:id_city,start:start,gender:gender,id_scholl:id_scholl },
        success: function(data) {  
            $("#div_body").append(data);
            $("#start").val(start);
        }
    });   
}

</script>
@endsection
