<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <base href="">
    <meta charset="utf-8" />
    <title>IPEKA UKS | @yield('title')</title>
    @yield('asset')
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
    <link rel="stylesheet" type="text/css" href="{{URL::asset('assets')}}/vendors/css/tables/datatable/datatables.min.css">
    <meta name="description" content="Updates and statistics" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    @if(isset($is_wizard))
    <link href="{{URL::asset('assets')}}/css/pages/wizard/wizard-4.css" rel="stylesheet" type="text/css" />
    @endif
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Page Vendors Styles(used by this page)-->
    <link href="{{URL::asset('assets')}}/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Page Vendors Styles-->
    <!--begin::Global Theme Styles(used by all pages)-->
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
    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
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
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="header-fixed header-mobile-fixed  aside-enabled aside-fixed aside-minimize-hoverable page-loading">
    <!--begin::Main-->
    <!--begin::Header Mobile-->
    <div id="kt_header_mobile" class="header-mobile align-items-center header-mobile-fixed">
        <!--begin::Logo-->
        <a href="javascript:void(0)">
            <h5 class="text-white">CMS Ipeka</h5>
        </a>
        <!--end::Logo-->
        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">
            <!--begin::Aside Mobile Toggle-->
            <button class="btn p-0 burger-icon mr-3 burger-icon-left" id="kt_aside_mobile_toggle">
                <span></span>
            </button>
            <!--end::Aside Mobile Toggle-->
            <!--begin::Header Menu Mobile Toggle-->
            {{-- <button class="btn p-0 burger-icon ml-4" id="kt_header_mobile_toggle">
                <span></span>
            </button> --}}
            <!--end::Header Menu Mobile Toggle-->
            <!--begin::Topbar Mobile Toggle-->
            {{-- temp --}}
            {{-- <div class="topbar-item"> --}}
                <button class="btn btn-hover-text-primary p-0 ml-2" id="kt_header_mobile_topbar_toggle">
                    <span class="svg-icon svg-icon-xl">
                        <!--begin::Svg Icon | path:{{URL::asset('assets')}}/media/svg/icons/General/User.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <polygon points="0 0 24 0 24 24 0 24" />
                                <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                </button>
                {{-- </div> --}}
            <!--end::Topbar Mobile Toggle-->
        </div>
        <!--end::Toolbar-->
    </div>
    <!--end::Header Mobile-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="d-flex flex-row flex-column-fluid page">
            <!--begin::Aside-->
            <div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">
                <!--begin::Brand-->
                <div class="brand flex-column-auto" id="kt_brand" style="background-color: #1E1E2D;">
                    <!--begin::Logo-->
                    <img src="{{URL::asset('assets')}}/images/logo_trans.png" class="max-h-25px" alt="">
                    <!--  <a href="javascript:void(0)" class="brand-logo">
                        <img alt="Logo" src="{{URL::asset('assets')}}/media/logos/logo_tulisan.png" class="max-h-20px"/>
                       <h4 style="color: 'red' ">Metajobs</h4>
                    </a> -->
                    <!--end::Logo-->
                    <!--begin::Toggle-->
                    <button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
                        <span class="svg-icon svg-icon svg-icon-xl">
                            <!--begin::Svg Icon | path:{{URL::asset('assets')}}/media/svg/icons/Navigation/Angle-double-left.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon points="0 0 24 0 24 24 0 24" />
                                    <path d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z" fill="#000000" fill-rule="nonzero" transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999)" />
                                    <path d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999)" />
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>
                    </button>
                    <!--end::Toolbar-->
                </div>
                <!--end::Brand-->
                <!--begin::Aside Menu-->
                <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
                    <!--begin::Menu Container-->
                    <div id="kt_aside_menu" style="background-color: #1E1E2D;" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500">
                        <!--begin::Menu Nav-->
                        <ul class="menu-nav">
                            <li class="menu-item <?php if ('dashboard' == Request::segment(1) ) {echo 'menu-item-active';} ?>" aria-haspopup="true">
                                <a href="/dashboard" class="menu-link">
                                    <span class="svg-icon menu-icon">
                                        <!--begin::Svg Icon | path:{{URL::asset('assets')}}/media/svg/icons/Design/Layers.svg-->
                                        <i class="fas fa-warehouse menu-icon text-white"></i>
                                        <!--end::Svg Icon-->
                                    </span>
                                    <span class="menu-text text-white">Dashboard</span>
                                </a>
                            </li>
                            @include('components/sidebar')
                            @include('components/header')
                            @yield('content')
                            <!--end::Row-->
                            <!--end::Dashboard-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Entry-->
            </div>
            <!--end::Content-->
            <!--begin::Footer-->
            <div class="footer bg-white py-4 d-flex flex-lg-column" id="kt_footer">
                <!--begin::Container-->
                <div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
                    <!--begin::Copyright-->
                    <!-- <div class="text-dark order-2 order-md-1">
                        <span class="text-muted font-weight-bold mr-2">2020©</span>
                        <a href="https://mamaritz.com" target="_blank" class="text-dark-75 text-hover-primary">Metajobs</a>
                    </div> -->
                    @yield('footer')
                    <!--end::Copyright-->
                    <!--begin::Nav-->
                    <div class="nav nav-dark">
                    </div>
                    <!--end::Nav-->
                </div>
                <!--end::Container-->
            </div>
            <!--end::Footer-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Page-->
    </div>
    <div id="kt_quick_user" class="offcanvas offcanvas-right p-10">
        <!--begin::Header-->
        <div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
            <h3 class="font-weight-bold m-0">{{$admin_name}}
                
            <a href="javascript:void(0)" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_user_close">
                <i class="ki ki-close icon-xs text-muted"></i>
            </a>
        </div>
        <!--end::Header-->
        <!--begin::Content-->
        <div class="offcanvas-content pr-5 mr-n5">
            <!--begin::Header-->
            <div class="d-flex align-items-center mt-5">
                <div class="symbol symbol-100 mr-5">
                    <div class="symbol symbol-md bg-light-primary mr-3 flex-shrink-0">
                        <img src="{{$admin_profile}}" alt="">
                    </div>
                </div>
                <div class="d-flex flex-column">
                    <a href="javascript:void(0)" class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary">{{ Auth::user()->name}}</a>
                    <div class="text-muted mt-1">{{ Auth::user()->name }}</div>
                    <div class="navi mt-2">
                        <a href="javascript:void(0)" class="navi-item">
                            <span class="navi-link p-0 pb-2">
                                <span class="navi-icon mr-1">
                                    <span class="svg-icon svg-icon-lg svg-icon-primary">
                                        <!--begin::Svg Icon | path:{{URL::asset('assets')}}/media/svg/icons/Communication/Mail-notification.svg-->
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <path d="M21,12.0829584 C20.6747915,12.0283988 20.3407122,12 20,12 C16.6862915,12 14,14.6862915 14,18 C14,18.3407122 14.0283988,18.6747915 14.0829584,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,8 C3,6.8954305 3.8954305,6 5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,12.0829584 Z M18.1444251,7.83964668 L12,11.1481833 L5.85557487,7.83964668 C5.4908718,7.6432681 5.03602525,7.77972206 4.83964668,8.14442513 C4.6432681,8.5091282 4.77972206,8.96397475 5.14442513,9.16035332 L11.6444251,12.6603533 C11.8664074,12.7798822 12.1335926,12.7798822 12.3555749,12.6603533 L18.8555749,9.16035332 C19.2202779,8.96397475 19.3567319,8.5091282 19.1603533,8.14442513 C18.9639747,7.77972206 18.5091282,7.6432681 18.1444251,7.83964668 Z" fill="#000000" />
                                                <circle fill="#000000" opacity="0.3" cx="19.5" cy="17.5" r="2.5" />
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>
                                </span>
                                <span class="navi-text text-muted text-hover-primary"></span>{{ Auth::user()->email}}
                            </span>
                        </a>
                        <a href="/logout" class="btn btn-sm btn-light-primary font-weight-bolder py-2 px-5">Sign Out</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--begin::Quick Mesasages-->
        <div id="kt_quick_cart" class="offcanvas offcanvas-right p-10">
            <!--begin::Header-->
            <div class="offcanvas-header d-flex align-items-center justify-content-between pb-7">
                <h4 class="font-weight-bold m-0">Pesan</h4>
                <a href="javascript:void(0)" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_cart_close">
                    <i class="ki ki-close icon-xs text-muted"></i>
                </a>
            </div>
            <!--end::Header-->
            <!--begin::Content-->
            <div class="offcanvas-content">
                <!--begin::Wrapper-->
                <div class="offcanvas-wrapper mb-5 scroll-pull" id="header_chat">
                    
                </div>
            </div>
            <!--end::Content-->
        </div>
        <!--end::Quick Cart-->
    <div id="kt_ceck_user" class="offcanvas offcanvas-right p-10">
        <!--begin::Header-->
        <div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
            <h3 class="font-weight-bold m-0">{{$admin_name}}
            <a href="javascript:void(0)" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_ceck_user_close">
                <i class="ki ki-close icon-xs text-muted"></i>
            </a>
        </div>
        <!--end::Header-->
        <!--begin::Content-->
        <div class="offcanvas-content pr-5 mr-n5">
            <!--begin::Header-->
            <div class="d-flex align-items-center mt-5">
                <div class="symbol symbol-100 mr-5">
                    <div class="symbol symbol-md bg-light-primary mr-3 flex-shrink-0">
                        <img src="{{$admin_profile}}" alt="">
                    </div>
                </div>
                <div class="d-flex flex-column">
                    <a href="javascript:void(0)" class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary">{{ Auth::user()->name}}</a>
                    <div class="text-muted mt-1">{{ Auth::user()->name }}</div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade text-left" id="modal_aksi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="title-modal">Warning !!!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-horizontal" id="form_aksi">
                    <div class="modal-body modal_aksi">
                        <input type="hidden" value="" id="id_data" name="id">
                        <input type="hidden" value="" id="id_tujuan" name="tujuan">
                        <input type="hidden" value="" id="id_aksi" name="aksi">
                        <input type="hidden" value="" id="id_tabel" name="tabel">
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" id="aksi_kirim">OK</button>
                </div>
            </div>
        </div>
    </div>
    <!-- -->
    <script src="{{URL::asset('assets')}}/js/core/libraries/jquery.min.js"></script>
    <script src="{{URL::asset('assets')}}/plugins/global/plugins.bundle.js"></script>
    <script src="{{URL::asset('assets')}}/plugins/custom/prismjs/prismjs.bundle.js"></script>
    <script src="{{URL::asset('assets')}}/js/scripts.bundle.js"></script>
    <script src="{{URL::asset('assets')}}/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
    <script src="{{URL::asset('assets')}}/js/pages/widgets.js"></script>
    <script src="{{URL::asset('assets')}}/js/fungsi_nominal.js"></script>
    @if(isset($is_wizard))
    
    @endif
    {{-- <script src="{{URL::asset('assets')}}/js/scripts/pages/bootstrap-toast.js"></script> --}}
    @yield('js')
    <script>
    $(document).ready(function() {

        $("#kt_header_mobile_topbar_toggle").click(function() {
            console.log('fasdfsda');
            $(".horas").show();
        });

    })

    </script>
    <script>
    var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#6993FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1E9FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };

    var HOST_URL = "https://keenthemes.com/metronic/tools/preview";

    $('.select2').on('change', function() { // when the value changes
        // $(this).valid(); // trigger validation on this element
    });

    function show_toast(message, type) {
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
        if (type == 1) {
            toastr.success(message, "Notification");
        } else {
            toastr.error(message, "Error Notification")
        }

    }

    window.setInterval(function(){
      //alert("okey");
      //ReloadDataHeader();
      /// call your function here
    }, 10000);
    function ReloadDataHeader(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/header_chat',
            type: "GET",
            success: function(response) {
                //console.log(response);
                if (response) {
                    $("#jumlah_chat_header").html(response);
                }
            }
        });
        $.ajax({
            url: '/detail_header_chat',
            type: "GET",
            success: function(response) {
                //console.log(response);
                if (response) {
                    $("#header_chat").html(response);
                }
            }
        });  
    }

    function readURL(input) {
        //alert("okey");
        if (input.files && input.files[0]) {
            $("#blah").css('display', '');
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#blah')
                    .attr('src', e.target.result)
                    .css('width', '150px')
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
    $(document).off('click', '.aksi').on('click', '.aksi', function() {
        $("#modal_detail").remove();
        $('#title-modal').html('Warning !!!');
        $('#aksi_kirim').html('Ok');
        var id = $(this).attr('id');
        $("#id_data").val(id);
        var aksi = $(this).attr('aksi');
        $("#id_aksi").val(aksi);
        //alert(aksi);
        var tujuan = $(this).attr('tujuan');
        $("#id_tujuan").val(tujuan);
        var data = $(this).attr('data');
        $("#id_tabel").val(data);
        if (aksi == 'delete') {
            var kata = "Apakah Anda Akan Menghapus Data Ini ??";
        } else if (aksi == 'active') {
            var kata = "Apakah Anda Akan Mengactivekan Data Ini ??";
            if (tujuan == 'master_cabang') {
                var kata = "Apakah Anda Akan Mengactivekan Data Ini, Sehingga muncul di Aplikasi ??";
            }
        } else if (aksi == 'reset_password') {
            var kata = "Apakah Anda Akan Mereset Password Akun ini ??";
        } else if (aksi == 'approve_pembayaran') {
            var kata = "Apakah Anda yakin menerima pembayaran transaksi ini ??";
        } else if (aksi == 'approve_otp') {
            var kata = "Apakah Anda Akan Mengapprove OTP untuk Akun ini ??";
        } else if (aksi == 'batalkan') {
            var kata = "Apakah Anda Menyetujui Pembatalan ini ??";

        } else {
            var kata = "Apakah Anda Akan Menonactivekan Data Ini ??";
            if (tujuan == 'master_cabang') {
                var kata = "Apakah Anda Akan Menonactivekan Data Ini, Sehingga hanya muncul sebagai office ??";
            }
        }

        var app = '<span id="modal_detail" style="color:red;font-weight:bold;font-size:12px;">' + kata + '</span>';
        if (aksi == 'blokir') {
            app = kata;
        }

        $(".modal_aksi").append(app);
        $("#modal_aksi").modal('show');

    });

    $(document).off('click', '#kirim_data').on('click', '#kirim_data', function() {
        id = $("#id_post").val();
        tujuan = $("#tujuan_post").val();
        tabel = $("#tabel_post").val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: '/update/' + tujuan,
            dataType: 'json',
            data: new FormData($("#form_edit")[0]),
            processData: false,
            contentType: false,
            success: function(data) {
                $(".modal-backdrop").remove();
                $(".edit-modal-data").modal('hide');
                if (data.code == 200) {
                    document.getElementById("form_edit").reset();
                    $("#message").remove();
                    show_toast(data.message, 1);

                    var xin_table = $('#myTable').DataTable({
                        "bDestroy": true,
                        "ajax": {
                            url: "/" + tabel,
                            type: 'GET'
                        }
                    });
                }
            }
        });
    });

    $(document).off('click', '#aksi_kirim').on('click', '#aksi_kirim', function() {
        //alert("coba")
        id = $("#id_data").val();
        //alert(id);
        aksi = $("#id_aksi").val();
        tujuan = $("#id_tujuan").val();
        tabel = $("#id_tabel").val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({ //line 28
            type: 'POST',
            url: '/' + aksi + '/' + tujuan,
            dataType: 'json',
            data: new FormData($("#form_aksi")[0]),
            processData: false,
            contentType: false,
            success: function(data) {
                if (data.code == 200) {
                    $(".toast-body").empty();
                    show_toast(data.message, 1);
                    // if ( server_side() != undefined ){
                    //     server_side();
                    // }
                    var xin_table = $('#myTable').DataTable({
                        "bDestroy": true,
                        "ajax": {
                            url: "/" + tabel,
                            type: 'GET'
                        }
                    });

                    $(".modal").modal("hide");
                    
                    data_tabel(tabel)

                    if ($.fn.dataTable.isDataTable("#merchant_table")) {
                        DatatableAll().destroy();
                        DatatableAll();
                    }

                } else {
                    alert("maaf ada yang salah!!!");
                }
            }
        });
    });
    // MODAL KONFIRMASI
    $('#modal_konfirmasi_pembayaran2').on('show.bs.modal', function(e) {

        // var button = $(e.relatedTarget);
        var id = $(e.relatedTarget).data('id');
        $(".confirm").attr('id', id);
        $(".unconfirm").attr('id', id);
        //alert(id);
        $("#detail_konfirmasi").remove();
        //alert(id);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/konfirmasi_pembayaran/' + id,
            type: "GET",
            success: function(response) {
                //alert("dancook");
                // console.log(response);
                if (response) {
                    $(".isi_konfirmasi").html(response);
                }
                $('.select2').select2();
            }
        });
    });

    </script>
</body>
<!--end::Body-->

</html>
