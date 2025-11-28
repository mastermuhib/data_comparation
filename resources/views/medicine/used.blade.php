@extends('layout.app')
@section('asset')
<link rel="stylesheet" type="text/css" href="{{URL::asset('assets')}}/vendors/css/forms/select/select2.min.css">
@endsection
@section('title', 'Master City')
@section('content')

<div class="card card-custom gutter-b">
    <div class="card-body">
        <!--begin::Details-->
        <div class="d-flex mb-2">
            <!--begin: Pic-->
            <div class="flex-shrink-0 mr-7 mt-lg-0 mt-3">
                @if($data->icon != null)
                <div class="symbol symbol-50 symbol-lg-120">
                    <img src="{{env('BASE_IMG')}}{{$data->icon}}" alt="image">
                </div>
                @else
                <div class="d-flex align-items-center"><div class="symbol symbol-50 symbol-lg-120 symbol-light-warning flex-shrink-0"><span class="symbol-label font-size-h3 font-weight-bold">{{substr($data->medicine, 0, 1)}}</span></div></div>
                @endif
                <input type="hidden" name="id_medicine" id="id_medicine" value="{{$data->id}}">
            </div>
            <!--end::Pic-->
            <!--begin::Info-->
            <div class="flex-grow-1">
                <!--begin::Title-->
                <div class="d-flex justify-content-between flex-wrap mt-1">
                    <div class="d-flex mr-3">
                        <a href="#" class="text-dark-75 text-hover-primary font-size-h5 font-weight-bold mr-3">{{$data->medicine}}</a>
                        <a href="#">
                            <i class="flaticon2-correct text-success font-size-h5"></i>
                        </a>
                    </div>
                    <div class="my-lg-0 my-3">
                        <a href="/master/medicine/used/print/{{$id}}" class="btn btn-sm btn-light-success font-weight-bolder text-uppercase mr-3">Download</a>
                    </div>
                </div>
                <!--end::Title-->
                <!--begin::Content-->
                <div class="d-flex flex-wrap justify-content-between mt-1">
                    <div class="d-flex flex-column flex-grow-1 pr-8">
                        
                        <span class="font-weight-bold text-dark-50">{{$data->notes}}</span>
                    </div>
                    
                </div>
                <!--end::Content-->
            </div>
            <!--end::Info-->
        </div>
        <!--end::Details-->
        <!--begin::Items-->
        
        <!--begin::Items-->
    </div>
</div>
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
                        <div class="col-md-2">
                            <label>Kelas</label>
                            <select class="select2 form-control" onchange="DataTable()" id="id_class" name="id_class">
                                <option value="">Semua Kelas</option>
                                
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
                        <div class="col-md-3">
                            <label>Kelas</label>
                            <select class="select2 form-control" onchange="DataTable()" id="id_class" name="id_class">
                                <option value="">Semua Kelas</option>
                                @foreach(DataClass(Auth::guard('admin')->user()->id_scholl) as $ct)
                                <option value="{{$ct->id}}">{{$ct->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5">
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
    <div class="col-lg-12 col-xxl-4">
        <!--begin::List Widget 9-->
        <div class="card card-custom card-stretch gutter-b">
            <!--begin::Header-->
            <div class="card-header align-items-center border-0 mt-2">
                <h5 class="text-dark font-weight-bold ml-3">List Penggunaan Obat</h5>
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
                                            <table class="table table-hover" id="yourTable">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Siswa</th>
                                                        <th>Sakit</th>
                                                        <th>Tanggal</th>
                                                        <th>Dosis</th>
                                                        <th>Dokter</th>
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
@endsection
@section('js')
<script src="{{URL::asset('assets')}}/vendors/js/tables/datatable/datatables.min.js"></script>
<script src="{{URL::asset('assets')}}/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
<script src="{{URL::asset('assets')}}/vendors/js/tables/datatable/buttons.print.min.js"></script>
<script src="{{URL::asset('assets')}}/vendors/js/tables/datatable/buttons.bootstrap.min.js"></script>
<script src="{{URL::asset('assets')}}/vendors/js/tables/datatable/datatables.bootstrap4.min.js"></script>
<script src="{{URL::asset('assets')}}/js/scripts/datatables/datatable.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="{{URL::asset('assets')}}/js/anypicker.min.js"></script>
<script src="{{URL::asset('assets')}}/vendors/js/forms/select/select2.full.min.js"></script>
<script src="{{URL::asset('assets')}}/js/scripts/forms/select/form-select2.js"></script>
<script src="//cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
<script src="{{URL::asset('assets')}}/js/scripts/pages/bootstrap-toast.js"></script>
<!-- end -->
<script type="text/javascript">
var column = [
        { "data": "no" },
        { "data": "student" },
        { "data": "category" },
        { "data": "date" },
        { "data": "dosis" },
        { "data": "doctor" },
    ];

    function data_tabel(tabel) {
        id = $("#id_medicine").val();
        if (tabel == 'data_used_medicine') {
            var nantable = $('#yourTable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "/"+tabel,
                    "dataType": "json",
                    "type": "POST",
                    "data": { _token: "{{csrf_token()}}",id:id }
                },
                "columns": column,
                "bDestroy": true
            });
            return nantable;
        }
    }
 $(function() {
    //$('#yourTable').DataTable();
    $(".select2-container--default").css('width', '100%');
    data_tabel('data_used_medicine')
});
</script>
@endsection
