<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <base href="">
    <meta charset="utf-8" />
    <title>Pengelola DPT</title>
    
    <style type="text/css">
    .btn-sm {
        padding: 1px 5px;
        font-size: 10px;
        border-radius: 10px;
    }

    .content {
        background-color: #f0f0f0;
    }
    table {
      border-collapse: separate;
      border-spacing: 0;
    }

    td, th {
      margin: 0;
      white-space: nowrap;
      border-top-width: 0px;
    }

    .div_table {
      max-width: 900px;
      overflow-x: scroll;
      overflow-y: visible;
      padding: 0;
    }

    .headcol {
      position: absolute;
      width: 5em;
      left: 0;
      top: auto;
      border-top-width: 1px;
      /*only relevant for first row*/
      margin-top: -1px;
      /*compensate for top border*/
    }

    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- data table -->
    
    <meta name="description" content="Updates and statistics" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    
    <link href="{{URL::asset('assets')}}/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('assets')}}/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('assets')}}/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <link href="{{URL::asset('assets')}}/css/themes/layout/header/base/light.css" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('assets')}}/css/themes/layout/header/menu/light.css" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('assets')}}/css/themes/layout/brand/dark.css" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('assets')}}/css/themes/layout/aside/light.css" rel="stylesheet" type="text/css" />
    <!--end::Layout Themes-->
    <link rel="shortcut icon" href="{{URL::asset('assets')}}/images/favicon.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/fontawesome.min.css">
    
    <style>
        .menu-nav,.menu-link, .brand{
            background-color: #1E1E2D;
            
        }
        .menu-item>li, .menu-item>a{
            color: #1E1E2D;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/js/fontawesome.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body id="kt_body" class="header-fixed header-mobile-fixed  aside-enabled aside-fixed aside-minimize-hoverable page-loading p-5">
<link rel="stylesheet" type="text/css" href="{{URL::asset('assets')}}/vendors/css/forms/select/select2.min.css">

<div class="accordion accordion-solid accordion-panel accordion-svg-toggle mb-3 mt-3" id="faq">
    <div class="card card-custom gutter-b p-6 col-md-12">
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
                            <select class="select2 select2-lg form-control" onchange="ChangeDashboard()" id="id_kec" name="id_kec">
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


<div id="loading" class="card card-custom gutter-b text-center" style="background: white;">
    <img src="{{URL::asset('assets')}}/images/loading.gif"  class="text-center" style="text-align: center;width: 100%">
</div>
<div id="isi_html" class="tab-content tabcontent-border mt-5">
    
                
</div>

<script src="{{URL::asset('assets')}}/js/core/libraries/jquery.min.js"></script>
<script src="{{URL::asset('assets')}}/plugins/global/plugins.bundle.js"></script>
<script src="{{URL::asset('assets')}}/plugins/custom/prismjs/prismjs.bundle.js"></script>
<script src="{{URL::asset('assets')}}/js/scripts.bundle.js"></script>
<script src="{{URL::asset('assets')}}/js/pages/widgets.js"></script>
<script src="{{URL::asset('assets')}}/vendors/js/forms/select/select2.full.min.js"></script>
<script src="{{URL::asset('assets')}}/js/scripts/forms/select/form-select2.js"></script>
<!-- scipt js -->
<script src="{{URL::asset('assets')}}/plugins/custom/flot/flot.bundle.js"></script>
<script src="{{URL::asset('assets')}}/js/pages/features/charts/apexcharts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>


<script type="text/javascript">
    var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#0BB783", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#D7F9EF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };
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
            ChangeTableDashboard()
        }
    });
}

function ChangeTableDashboard(){
  //if(is_admin != 2) {
    
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
        url     : '/get_table_dashboard',
        data    : { id_kec:id_kec,year:year,triwulan:triwulan,status:status },
        dataType: 'html',
        success: function(data) {
            $("#isi_table_html").html(data);
        }
    });
}
</script>

</body>
</html>