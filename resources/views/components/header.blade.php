<!--begin::Wrapper-->
<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
    <!--begin::Header-->
    <div id="kt_header" class="header header-fixed">
        <!--begin::Container-->
        <div class="container-fluid d-flex align-items-stretch justify-content-between">
            <!--begin::Header Menu Wrapper-->
            <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
                <!--begin::Header Menu-->
                <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                    <!--begin::Header Nav-->
                    <input type="hidden" name="is_edit" id="is_edit" value="{{ $akses->is_edit }}">
                    <input type="hidden" name="is_delete" id="is_delete" value="{{ $akses->is_delete }}">
                    <div>
                        
                    </div>
                    @if(Request::is('dashboard'))
                    <div style="margin-left: 150px; margin-top: 10px;">
                    <select class="select2 form-control" onchange="ChangeDashboard()" id="id_scholl" name="id_scholl"  required>
                        <option value=""></option>
                        
                    </select>
                    </div>
                    @endif
                    <!--end::Header Nav-->
                </div>
                <!--end::Header Menu-->
            </div>
            <!--end::Header Menu Wrapper-->
            <ul class="navbar-nav mr-auto">
                <!-- This is  -->
                <li class="nav-item"> <a class="nav-link nav-toggler d-block d-md-none waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a></li>
                <li class="nav-item"> <a class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark" href="javascript:void(0)"><i class="icon-menu"></i></a> </li>
                <li class="nav-item">
                   
                </li>
                <!-- ============================================================== -->
                <!-- Search -->
                <!-- ============================================================== -->
                <li class="nav-item">
                    <form class="app-search" style="display :none;">
                        <input type="text" class="form-control form-control-lg" placeholder="Search & enter">
                    </form>
                </li>
            </ul>

            <!--begin::Topbar-->
            <div class="topbar d-none">
                <a href="javascript:void(0)" class="btn btn-icon btn-clean btn-lg mb-1 position-relative" id="kt_quick_cart_toggle" data-toggle="tooltip" data-placement="right" data-container="body" data-boundary="window" title="" data-original-title="Pesan" style="margin-right: 3px;margin-top: 5px">
                    <span class="svg-icon svg-icon-xl">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                        <i class="flaticon2-mail text-warning"></i>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="label label-sm label-light-danger label-rounded font-weight-bolder position-absolute top-0 right-0 mt-1 mr-1" id="jumlah_chat_header"></span>
                </a>
            </div>
            <div class="topbar">
                <!--begin::User-->
                <div class="topbar-item" style="z-index: 4">
                    <div class="btn btn-icon w-auto btn-clean d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
                        <div>
                        <img src="{{$admin_profile}}" alt="" style="height: 30px;width: 30px;border-radius: 100px;margin-right: 10px;">
                        </div>
                    </div>
                </div>
                <!-- kt_ceck_user -->
                <!--end::User-->
            </div>
            <!--end::Topbar-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Header-->
    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid pt-1" id="kt_content">
        <!-- sub Header -->
        <!--end::Subheader-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="col-md-12">
                <!--begin::Dashboard-->
                <!--begin::Row-->
