@extends('layout.app')
@section('asset')
<link rel="stylesheet" type="text/css" href="{{URL::asset('assets')}}/vendors/css/forms/select/select2.min.css">
@endsection
@section('title', 'Administrator')
@section('content')
<div id="show_edit">
</div>
<div id="edit_password">
</div>
<div class="row" id="show_add" style="display: none;">
    <div class="col-lg-12 col-xxl-4">
        <section class="multiple-validation">
            <div class="card mb-3">
                <div class="card-content">
                    <div class="card-body">
                        <form method="POST" class="form-horizontal p-3" id="form_add">@csrf
                            <div class="row mb-5">
                                <div class="col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Name</label>
                                        <input type="text" name="name" class="form-control form-control-lg" placeholder="Name" required>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Email</label>
                                        <input type="email" name="email" class="form-control form-control-lg" placeholder="Email" required>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Phone</label>
                                        <input type="text" name="phone" class="form-control form-control-lg" placeholder="Phone" required>
                                    </div>
                                </div>
                                <div class="col-sm-2 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Role</label>
                                        <select class="select2 form-control" id="select_role" name="role_id" required>
                                            <option value="">Select Role</option>
                                            @foreach($data_role as $v)
                                            <option value="{{$v->id}}">{{$v->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Cabang Sekolah (Jika Admin Cabang)</label>
                                        <select class="select2 form-control" id="select_cabang" name="id_scholl">
                                            <option value="">Pilih Sekolah</option>
                                            @foreach($data_scholl as $c)
                                            <option value="{{$c->id}}">{{$c->scholl_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Address</label>
                                        <input type="text" name="address" class="form-control form-control-lg" required>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Password</label>
                                        <input type="password" name="password" id="password" class="form-control form-control-lg" placeholder="Your Password" minlength="6" required>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Confirm Password</label>
                                        <input type="password" name="confirm_password" id="confirm_password" class="form-control form-control-lg" placeholder="Confirm Password" minlength="6" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-header text-center">
                                            Foto Profile
                                        </div>
                                        <div class="card-body text-center">
                                            
                                            <img id="profile_admin" src="https://souq-cms.trendcas.com/assets/imgs/theme/upload.svg" alt="your image" style="max-width: 200px;max-height: 200px;" />
                                            <label class="btn btn-white btn-sm mb-0 w-100 align-self-center">
                                                Upload File <input type="file" name="profile" style="display: none;" onchange="gantiProfile_admin(this);">
                                            </label>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <button type="submit" class="btn btn-primary float-right" id="save_add">Submit</button>
                                    <button type="button" class="btn btn-primary float-right" style="display: none;" id="loading_add" disabled>Submit</button>
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
            <div class="card-header align-items-center border-0">
                <h5 class="text-dark font-weight-bold ml-3">List Administrator</h5>
                <a class="btn btn-primary font-weight-bolder mr-3" id="tambah">Add Admin</a>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body" style="margin-top: -25px;">
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
                                            <table class="table zero-configuration" id="data_tabel">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Name</th>
                                                        <th>Role</th>
                                                        <th>Email</th>
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
        <!-- </div> -->
    </div>
</div>
@endsection
@section('js')
@include('components/componen_crud')
<script type="text/javascript">
var columns = [{
        "data": null,
        "sortable": false,
        render: function(data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
        }
    },
    { "data": "name" },
    { "data": "role_name" },
    { "data": "email" },
    { "data": "status" },
    { "data": "actions" }
];

function data_tabel(tabel) {
    if (tabel == 'data_admin') {
        var xin_table = $('#data_tabel').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": '/data_admin',
                "dataType": "json",
                "type": "POST",
                "data": { _token: "{{csrf_token()}}" }
            },
            "columns": columns,
            "bDestroy": true
        });
    }
}
$(function() {
    //$('#myTable').DataTable();
    $(".select2-container--default").css('width', '100%');
    data_tabel('data_admin')
});

$('.select2').on('change', function() { // when the value changes
    $(this).valid(); // trigger validation on this element
});

$('#tambah').on("click", function() {
    // alert('tes')
    $(window).scrollTop(0);
    $("#show_add").css('display', '');
});
$('#batalkan').on("click", function() {
    $("#show_add").css('display', 'none');
});

$("#form_add").validate({
    rules: {
        password: {
            minlength: 6
        },
        confirm_password: {
            equalTo: "#password"
        }
    },
    messages: {
        password: {
            minlength: "password minimal 6 character"
        },
        confirm_password: {
            equalTo: "password not match"
        }
    },
    submitHandler: function(form) {
        $("#save_add").css('display','none');
        $("#loading_add").css('display','');
        $.ajax({ //line 28
            type: 'POST',
            url: '/postadmin',
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

                    data_tabel('data_admin')
                } else {
                    alert("maaf ada yang salah!!!");
                }
                $("#save_add").css('display','');
                $("#loading_add").css('display','none');
            }
        });
    }
});



$(document).off('click', '.edit_data').on('click', '.edit_data', function() {
    var id = $(this).attr('id');
    $("#show_add").css('display', 'none');
    $.ajax({
        url: '/detail/Administrator/' + id,
        type: "GET",
        success: function(response) {
            console.log(response);
            $(window).scrollTop(0);

            if (response) {
                $("#show_edit").html(response);
                $("#show_edit").css('display', '');
            }
            //$('.select2').select2();
            $(".select2-container--default").css('width', '100%');
        }
    });
});

$(document).off('change', '#select_cabang').on('change', '#select_cabang', function() {
    var id = $(this).val();
    //alert(id);
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
    $.ajax({
        url :'/number_of_cashier/1/'+id,
        type: "GET",
        success: function (response) {
            // console.log(response);
            $("#select_meja").html(response);
        }
    });
});

$(document).off('click', '.edit_password').on('click', '.edit_password', function() {
    var id = $(this).attr('id');

    $.ajax({
        url: '/ubah-password/' + id,
        type: "GET",
        success: function(response) {
            console.log(response);
            if (response) {
                $("#edit_password").html(response);
                $("#edit_password").show()
                $(window).scrollTop(0);
            }
        }
    });
});

$(document).off('click', '#batalkan_password').on('click', '#batalkan_password', function() {
    $("#edit_password").hide().empty();
});

$(document).off('click', '#batalkan3').on('click', '#batalkan3', function() {

    $("#titel_head").remove();
    $("#head_modul").append('<span id="titel_head">Tambah Data Admin</span>');
    $("#hide_add").css('display', '');
    $("#show_edit").css('display', 'none').empty();
});
function gantiProfile(input) {
    //alert("okey");
    if (input.files && input.files[0]) {
        $("#profile").css('display', '');
        var reader = new FileReader();

        reader.onload = function(e) {
            $('#profile')
                .attr('src', e.target.result)
                .css('width', '150px')
        };

        reader.readAsDataURL(input.files[0]);
    }
}

function gantiProfile_admin(input) {
    //alert("okey");
    if (input.files && input.files[0]) {
        $("#profile_admin").css('display', '');
        var reader = new FileReader();

        reader.onload = function(e) {
            $('#profile_admin')
                .attr('src', e.target.result)
                .css('width', '150px')
        };

        reader.readAsDataURL(input.files[0]);
    }
}


$(document).off('click', '#kirim_edit').on('click', '#kirim_edit', function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({ //line 28
        type: 'POST',
        url: '/update/Administrator',
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

                $("#show_edit").css('display', 'none').empty();
                //alert("okey");
                data_tabel('data_admin')
            }
        }
    });
});
// is admin cabang
$(document).off('click', '#is_cabang').on('click', '#is_cabang', function() {
    if ($("#is_cabang").prop('checked') == true) {
        $("#div_cabang").css('display', '');

    } else {
        $("#div_cabang").css('display', 'none');
    }

});
$(document).off('change', '#select_role').on('change', '#select_role', function() {
    
    id = $(this).val();
    $(".get_role").remove();
    $.ajax({
        url: '/select_role/'+id+'/company',
        type: "GET",
        success: function(response) {
            //console.log(response);
            if (response) {
                $("#div_company").html(response);
            }
            $('.select2').select2();
            $(".select2-container--default").css('width', '100%');
        }
    });
    //kode ao
    $.ajax({
        url: '/select_role/'+id+'/kode',
        type: "GET",
        success: function(response) {
            //console.log(response);
            if (response) {
                $("#div_kode").html(response);
            }
        }
    });
});
// apabila pilih role

</script>
@endsection
