@extends('layout.app')
@section('asset')
<link rel="stylesheet" type="text/css" href="{{URL::asset('assets')}}/vendors/css/forms/select/select2.min.css">
<link rel="stylesheet" type="text/css" href="{{URL::asset('assets')}}/jqvmap.css">

@endsection
@section('title', 'Dashboard')
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
                        <div class="col-md-3">
                            <label>Kecamatan</label>
                            <select class="select2 form-control" onchange="ChangeDashboard()" id="id_kec" name="id_kec">
                                <option value="">Semua</option>
                                @foreach($data_kec as $ct)
                                <option value="{{$ct->id}}">{{$ct->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Triwulan</label>
                            <select class="select2 form-control" onchange="ChangeTriwulan()" id="id_triwulan" name="id_triwulan">
                                @foreach($triwulan as $ct)
                                <option value="{{$ct->id}}">{{$ct->name}}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="triwulan" value="{{ $triwulan[0]->triwulan }}" id="triwulan">
                            <input type="hidden" name="year" value="{{ $triwulan[0]->year }}" id="year">
                        </div>
                        
                        <div class="col-md-6">
                            <label>Status </label>
                            <select class="select2 form-control" id="status" name="status[]" multiple onchange="ChangeDashboard()">
                                <option value="baru" selected>Baru</option>
                                <option value="ubah" selected>Ubah</option>
                                <option value="aktif" selected>Aktif</option>
                                <option value="tms">TMS</option>
                                <option value="hapus">Hapus</option>
                            </select>
                        </div>
                        <input type="hidden" id="start" name="start" value="0">
                    </div>
                </form>
            </div>
        </div>
        <!--end::Body-->
    </div>
</div>


<div id="loading" class="card card-body text-center" style="background: white;">
    <img src="{{URL::asset('assets')}}/images/loading.gif"  class="text-center" style="text-align: center;width: 100%">
</div>
<div id="isi_html" class="tab-content tabcontent-border mt-5">
    
                
</div>

@endsection
@section('js')
@include('components/componen_crud')
<!-- scipt js -->
<script src="{{URL::asset('assets')}}/plugins/custom/flot/flot.bundle.js"></script>
<script src="{{URL::asset('assets')}}/js/pages/features/charts/apexcharts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
<!-- vmaps -->
<script src="{{URL::asset('assets')}}/jquery.vmap.js"></script>
<script src="{{URL::asset('assets')}}/maps/jquery.vmap.indonesia.js"></script>
<script type="text/javascript" src="{{URL::asset('assets')}}/maps/jquery.vmap.electioncolors.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script type="text/javascript">
$(function() {
    //$('#myTable').ChangeDashboard();
    $(".select2-container--default").css('width', '100%');
    ChangeDashboard();
});


$(document).off('click', '#FilterDash').on('click', '#FilterDash', function() {
    ChangeDashboard();
});

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
                ChangeDashboard();
            },
            error: function(data) {
                console.log(data);
            }
        });
    } else {
        ChangeDashboard();
    }
    
}


function ChangeDashboard(){
  //if(is_admin != 2) {
    $("#old").remove()
    $('#loading').css('display','');
    $('#isi_html').css('display','none');
    var id_kec     = $("#id_kec").val();
    var triwulan     = $("#triwulan").val();
    var year     = $("#year").val();
    var status = $("#status").val();
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({ //line 28
        type    : 'POST',
        url     : '/get_dashboard',
        data    : { id_kec:id_kec,year:year,triwulan:triwulan,status:status },
        dataType: 'html',
        success: function(data) {
            //alert("cuuk");

            $('#isi_html').css('display','');
            $("#isi_html").html(data);
            $('#loading').css('display','none');
        }
    });
  //}
}
</script>
@endsection