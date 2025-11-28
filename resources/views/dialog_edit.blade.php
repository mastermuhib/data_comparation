@extends('layout.app')
@section('asset')
<link rel="stylesheet" type="text/css" href="{{URL::asset('assets')}}/vendors/css/forms/select/select2.min.css">
@endsection
@section('title', 'Administrator')
@section('content')
<section class="multiple-validation" id="detail_edit">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form-horizontal p-3" novalidate id="form_edit">
                            <div class="row">
                                <div class="col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Name</label>
                                        <input type="text" name="admin_name" class="form-control form-control-lg" id="admin_name" placeholder="Name" required data-validation-required-message="Nama Wajib diisi" value="{{$data->admin_name}}">
                                        <input type="hidden" name="id" value="{{$data->id}}">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Nama Pengirim</label>
                                        <input type="text" name="sender" class="form-control form-control-lg" value="{{$data->sender}}" placeholder="Name" required>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Email</label>
                                        <input type="email" name="email" class="form-control form-control-lg" id="email" placeholder="Email" required data-validation-required-message="Email Wajib diisi" value="{{$data->email}}">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Phone</label>
                                        <input type="text" name="phone" class="form-control form-control-lg" placeholder="Phone" required data-validation-required-message="Phone Wajib diisi" value="{{$data->phone}}">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Role</label>
                                        <select class="form-control" required data-validation-required-message="Role Wajib diisi" name="id_role" id="role">
                                            <option value="">Select Role</option>
                                            @foreach($data_role as $v)
                                            <option value="{{$v->id}}" <?php if ($data->id_role == $v->id) {
                                                echo "selected";
                                                } ?> >{{$v->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Cabang</label>
                                        <select class="form-control" id="select_edit_cabang" name="branch_id" required>
                                            <option value="">Pilih Cabang</option>
                                            @foreach($data_cabang as $c)
                                            @if($c->id == $data->branch_id)
                                            <option value="{{$c->id}}" selected>{{$c->branch_name}}</option>
                                            @else
                                            <option value="{{$c->id}}">{{$c->branch_name}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Address</label>
                                        <input value="{{$data->address}}" type="text" name="address" class="form-control form-control-lg" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card h-100">
                                        <div class="card-header text-center">
                                            Foto Profile
                                        </div>
                                        <div class="card-body text-center">
                                            
                                            <img id="profile" src="{{base_img()}}{{$data->profile}}" alt="your image" style="max-width: 200px;max-height: 200px;" />
                                            <label class="btn btn-white btn-sm mb-0 w-100 align-self-center">
                                                Change File <input type="file" name="profile" style="display: none;" onchange="gantiProfile(this);">
                                            </label>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <button type="button" class="btn btn-primary mr-2 float-right" id="kirim_edit">Submit</button>
                                    <button type="button" class="btn btn-danger float-right" id="batalkan3" style="margin-right: 10px">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('js')
@include('components/componen_crud')
<script type="text/javascript">
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
