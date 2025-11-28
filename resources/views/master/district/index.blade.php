@extends('layout.app')
@section('asset')
<link rel="stylesheet" type="text/css" href="{{URL::asset('assets')}}/vendors/css/forms/select/select2.min.css">
@endsection
@section('title', 'Master District')
@section('content')
<div class="form_edit_modul" id="show_edit">
</div>
<div class="row" id="show_add" style="display: none;">
    <div class="col-lg-12 col-xxl-4">
        <section class="multiple-validation">
            <div class="card mb-3">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form-horizontal"  id="form_add">@csrf
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control form-control-lg required" id="lastName3" name="name" data-validation-required-message="Name Required"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Country</label>
                                        <select class="select2 form-control country" required data-validation-required-message="Role Wajib diisi" name="country" id="country">
                                            <option value="">Select Country</option>
                                            @foreach($data_country as $v)
                                            <option value="{{$v->id}}">{{$v->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6" id="provinsi">
                                    <div class="form-group">
                                        <label class="control-label">Province</label>
                                        <select class="select2 form-control province" required data-validation-required-message="Role Wajib diisi" name="province">
                                            <option value=''>Select Province</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">City</label>
                                        <select class="select2 form-control cities" required data-validation-required-message="Role Wajib diisi" name="city_id">
                                            <option value=''>Select City</option>
                                        </select>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <button type="submit" class="btn btn-primary float-right">Submit</button>
                                    <button type="button" class="btn btn-danger mr-2 float-right" id="batalkan">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-xxl-4">
        <!--begin::List Widget 9-->
        <div class="card card-custom card-stretch gutter-b">
            <!--begin::Header-->
            <div class="card-header align-items-center border-0 mt-2">
                <h5 class="text-dark font-weight-bold ml-3">List District</h5>
                <a class="btn btn-primary font-weight-bolder mr-3" id="tambah">Add District</a>
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
                                                        <th>Name</th>
                                                        <th>City</th>
                                                        <th>Province</th>
                                                        <th>Status</th>
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
        { "data": "name" },
        { "data": "city" },
        { "data": "province" },
        { "data": "status" },
        { "data": "action" },
    ];

    function indexTable() {
        var nantable = $('#yourTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "/data_master_district",
                "dataType": "json",
                "type": "POST",
                "data": { _token: "{{csrf_token()}}" }
            },
            "columns": column,
            "bDestroy": true
        });
        return nantable;
    }
 $(function() {
    //$('#yourTable').DataTable();
    $(".select2-container--default").css('width', '100%');
    indexTable()
});

$(".country").on("change", function() {
    var country_id = this.value;
    country_change(country_id)
});
$(".province").on("change", function() {
    var prov_id = this.value;
    province_change(prov_id)
});

function country_change(country_id) {
    // alert(country_id)
    $.ajax({
        type: 'GET',
        url: '/data_province/' + country_id,
        dataType: 'json',
        success: function(data) {
            console.log(data)
            $(".province").empty();
            $(".cities").empty().append("<option value=''>Select City</option>");
            $(".province").append("<option value=''>Select Province</option>");
            for (let i = 0; i < data.length; i++) {
                $(".province").append("<option value=" + data[i].id + ">" + data[i].name + "</option>");
            }
        },
        error: function(data) {
            console.log(data);
        }
    });
}

function province_change(prov_id) {
    // alert(country_id)
    $.ajax({
        type: 'GET',
        url: '/cities/' + prov_id,
        dataType: 'json',
        success: function(data) {
            console.log(data)
            $(".cities").empty();
            $(".cities").append("<option value=''>Select City</option>");
            for (let i = 0; i < data.length; i++) {
                $(".cities").append("<option value=" + data[i].id + ">" + data[i].name + "</option>");
            }
        },
        error: function(data) {
            console.log(data);
        }
    });
}

$('#tambah').on("click", function() {
    // alert('tes')
    $("#hide_add").css('display', 'none');
    $("#show_add").css('display', '');
});
$('#batalkan').on("click", function() {
    $("#hide_add").css('display', '');
    $("#show_add").css('display', 'none');
});

function select2_reset() {
    $.ajax({
        type: 'GET',
        url: '/countries',
        dataType: 'json',
        success: function(data) {
            console.log(data)
            $(".country").empty();
            $(".country").append("<option value=''>Select Country</option>");
            for (let i = 0; i < data.length; i++) {
                $(".country").append("<option value=" + data[i].id + ">" + data[i].name + "</option>");
            }
        }
    });
    $('.province').empty().append("<option value=''>Select Province</option>");
    $('.cities').empty().append("<option value=''>Select City</option>");
}

$("#form_add").submit(function(e) {
    e.preventDefault();
    //var description = CKEDITOR.instances.description.getData();
    // var id_country = $("#country").val();
    var id_province = $("#province").val();

    //$("#isi_deskripsi").val(description);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({ //line 28
        type: 'POST',
        url: '/post_master_district',
        dataType: 'json',
        data: new FormData($("#form_add")[0]),
        processData: false,
        contentType: false,
        success: function(data) {
            
            if (data.code == 200) {
                document.getElementById("form_add").reset();
                select2_reset()
                $("#hide_add").css('display', '');
                $("#show_add").css('display', 'none');
                $(".toast-body").empty();
                show_toast(data.message, 1);

                var nantable = $('#yourTable').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": {
                        "url": "/data_master_district",
                        "dataType": "json",
                        "type": "POST",
                        "data": { _token: "{{csrf_token()}}" }
                    },
                    "columns": column,
                    "bDestroy": true
                });
                nantable.ajax.reload();
            } else {
                alert("maaf ada yang salah!!!");
            }
        }
    });
});

$(document).off('click', '#kirim_edit').on('click', '#kirim_edit', function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // var description = CKEDITOR.instances.edit_description.getData();
    // $("#isi_deskripsi2").val(description);
    $.ajax({ //line 28
        type: 'POST',
        url: '/update/master_district',
        dataType: 'json',
        data: new FormData($("#form_edit")[0]),
        processData: false,
        contentType: false,
        success: function(data) {
            //$("#modal_loading").modal('hide');
            //$(".modal-backdrop").remove();
            console.log(data)
            $(".edit-modal-data").modal('hide');
            if (data.code == 200) {
                document.getElementById("form_edit").reset();
                $("#message").remove();
                show_toast(data.message, 1);

                $("#titel_head").remove();
                $("#head_modul").append('<span id="titel_head">Add Distict</span>');
                $("#hide_add").css('display', '');
                $("#show_edit").css('display', 'none');
                //alert("okey");
                 var nantable = $('#yourTable').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "ajax": {
                            "url": "/data_master_district",
                            "dataType": "json",
                            "type": "POST",
                            "data": { _token: "{{csrf_token()}}" }
                        },
                        "columns": column,
                        "bDestroy": true
                    });
                    nantable.ajax.reload();
            }
        }
    });
});

$(document).off('click', '.edit_data').on('click', '.edit_data', function() {
    var id = $(this).attr('id');

    $("#detail_edit").remove();
    //alert("sini kan")
    $("#hide_add").css('display', 'none');
    $("#show_add").css('display', 'none');
    $("#titel_head").remove();
    $("#head_modul").append('<span id="titel_head">Edit Data District</span>');
    $.ajax({
        url: '/detail/master_district/' + id,
        type: "GET",
        success: function(response) {
            console.log(response);
            $(window).scrollTop(0);

            if (response) {
                $("#show_edit").html(response);
                $("#show_edit").css('display', '');
            }
            $('.select2').select2();
            $(".select2-container--default").css('width', '100%');
        }
    });
});
// batalkan edit
$(document).off('click', '#batalkan3').on('click', '#batalkan3', function() {

    $("#titel_head").remove();
    $("#head_modul").append('<span id="titel_head">Tambah Data District</span>');
    $("#hide_add").css('display', '');
    $("#show_edit").css('display', 'none');
});

</script>
@endsection
