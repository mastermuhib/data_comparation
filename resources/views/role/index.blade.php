@extends('layout.app')
@section('asset')
<link rel="stylesheet" type="text/css" href="{{URL::asset('assets')}}/vendors/css/forms/select/select2.min.css">
@endsection
@section('title', 'Role')
@section('content')

<div class="form_edit_modul" id="show_edit">
</div>
<div class="row" id="show_add" style="display: none;">
    <div class="col-lg-12 col-xxl-4">
        <section class="multiple-validation">
            <div class="card mb-3">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form-horizontal" id="form_add">@csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label for="nomor" class="label_input">Nama role</label>
                                            <input type="text" name="name" class="form-control form-control-lg" placeholder="Name" required data-validation-required-message="Name Wajib diisi">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-md-12">
                                    <label class="control-label">Pilih Menu </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <table class="table-striped table-bordered table-hover" width="100%" border="1">
                                            <thead>
                                                <th>Menu</th>
                                                <th>Sub Menu</th>
                                            </thead>
                                            @foreach($menu_choose as $k => $v)
                                            <tr>
                                                <td style="padding: 5px;">
                                                    <label class="custom-control custom-checkbox m-b-0 col-md-12">
                                                        <input type="checkbox" class="custom-control-input check_menu" tabel="{{$v->menu_id}}" value="{{$v->id}}" name="menu[]" id="menu{{$v->menu_id}}">
                                                        <span class="custom-control-label">{{$v->name}}</span>
                                                    </label>
                                                </td>
                                                <td style="padding: 5px;">
                                                    @foreach($submenu_choose as $f => $s)
                                                    <?php if ($v->menu_id == $s->parent_menu_id) { ?>
                                                    <label class="custom-control custom-checkbox m-b-0"><input type="checkbox" value="{{$s->id}}" name="submenu[]" id="submenu{{$s->parent_menu_id}}" class="custom-control-input sub{{$v->menu_id}}" disabled><span class="custom-control-label">{{$s->name}}</span></label>
                                                    <?php }?>
                                                    @endforeach
                                                </td>
                                            </tr>
                                            @endforeach
                                        </table>
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
                <h5 class="text-dark font-weight-bold ml-3">List Role</h5>
                <a class="btn btn-primary font-weight-bolder mr-3" id="tambah">Add Role</a>
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
                                            <table class="table zero-configuration" id="myTable">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Name</th>
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

$(function() {
    //$('#myTable').DataTable();
    $(".select2-container--default").css('width', '100%');
    var xin_table = $('#myTable').DataTable({
        "bDestroy": true,
        "ajax": {
            url: "/data_role",
            type: 'GET'
        }
    });
});

$(document).off('click', '.check_menu').on('click', '.check_menu', function() {
    var tabel = $(this).attr('tabel');
    if ($(this).is(':checked')) {
        $(".sub" + tabel).attr('disabled', false);

    } else {

        $(".sub" + tabel).attr('disabled', 'disabled');
    }
});

$('#tambah').on("click", function() {
    // alert('tes')
    $("#hide_add").css('display', 'none');
    $("#show_add").css('display', '');
});
$('#batalkan').on("click", function() {
    $("#hide_add").css('display', '');
    $("#show_add").css('display', 'none');
});
$("#form_add").submit(function(e) {
    e.preventDefault();
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({ //line 28
            type: 'POST',
            url: '/post_role',
            dataType: 'json',
            data: new FormData($("#form_add")[0]),
            processData: false,
            contentType: false,
            success: function(data) {  
                if (data.code == 200) {
                document.getElementById("form_add").reset();
                $("#hide_add").css('display', '');
                $("#show_add").css('display', 'none');
                $("#message").remove();
                show_toast(data.message, 1);

                var xin_table = $('#myTable').dataTable({
                    "bDestroy": true,
                    "ajax": {
                        url: "/data_role",
                        type: 'GET'
                    }
                });
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
        url: '/update/role',
        dataType: 'json',
        data: new FormData($("#form_edit")[0]),
        processData: false,
        contentType: false,
        success: function(data) {
            //$("#modal_loading").modal('hide');
            //$(".modal-backdrop").remove();
            $(".edit-modal-data").modal('hide');
            if (data.code == 200) {
                document.getElementById("form_edit").reset();
                $("#message").remove();
                show_toast(data.message, 1);

                $("#titel_head").remove();
                $("#head_modul").append('<span id="titel_head">Add City</span>');
                $("#hide_add").css('display', '');
                $("#show_edit").css('display', 'none');
                //alert("okey");

                var nantable = $('#yourTable').DataTable({
                        "processing": true,
                        "serverSide": true,
                        "ajax": {
                            "url": "/data_company",
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
    $("#head_modul").append('<span id="titel_head">Edit Data City</span>');
    $.ajax({
        url: '/detail/role/' + id,
        type: "GET",
        success: function(response) {
            // console.log(response);
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
    $("#head_modul").append('<span id="titel_head">Tambah Data City</span>');
    $("#hide_add").css('display', '');
    $("#show_edit").css('display', 'none');
});

function deptchange1() {
    // alert(country_id)
    id = $("#s_dept1").val();
    $.ajax({
        type: 'GET',
        url: '/jurusan/'+id,
        dataType: 'json',
        success: function(data) {
            console.log(data)
            $("#s_jur1").empty();
            $("#s_jur1").append("<option value=''>--- Jurusan ---</option>");
            for (let i = 0; i < data.length; i++) {
                $("#s_jur1").append("<option value=" + data[i].id + ">" + data[i].name + "</option>");
            }
        },
        error: function(data) {
            console.log(data);
        }
    });
}

function deptchange2() {
    // alert(country_id)
    id = $("#s_dept2").val();
    $.ajax({
        type: 'GET',
        url: '/jurusan/'+id,
        dataType: 'json',
        success: function(data) {
            console.log(data)
            $("#s_jur2").empty();
            $("#s_jur2").append("<option value=''>--- Jurusan ---</option>");
            for (let i = 0; i < data.length; i++) {
                $("#s_jur2").append("<option value=" + data[i].id + ">" + data[i].name + "</option>");
            }
        },
        error: function(data) {
            console.log(data);
        }
    });
}

</script>
@endsection
