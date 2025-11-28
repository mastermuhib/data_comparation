<!-- Pop Up Edit -->
@extends('layout.app')
@section('asset')
<link rel="stylesheet" type="text/css" href="{{URL::asset('assets')}}/vendors/css/forms/select/select2.min.css">
@endsection
@section('title', 'Role')
@section('content')
<section class="multiple-validation" id="detail_edit">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form-horizontal" novalidate id="form_edit">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="controls">
                                            <label for="nomor" class="label_input">Nama role</label>
                                            <input type="text" name="name" class="form-control form-control-lg" placeholder="Name" required data-validation-required-message="Name Wajib diisi" value="{{$data->name}}">
                                            <input type="hidden" name="id" value="{{$data->id}}">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <table class="table-striped table-bordered table-hover" width="100%" border="1">
                                            <thead>
                                                <th>Menu</th>
                                                <th>Sub Menu</th>
                                            </thead>
                                            <?php for ($i=0; $i < count($mymenu) ; $i++) { ?>
                                            <tr>
                                                <td style="padding: 5px;">
                                                    <?php if ($mymenu[$i]->menu_id == rcheck($mymenu[$i]->menu_id,$data->id)) { ?>
                                                    <label class="custom-control custom-checkbox m-b-0 col-md-12"><input type="checkbox" value="{{$mymenu[$i]->id}}" name="menu[]" id="menu{{$mymenu[$i]->menu_id}}" class="custom-control-input check_menu" tabel="{{$mymenu[$i]->menu_id}}" checked><span class="custom-control-label">{{$mymenu[$i]->name}}</span></label>
                                                    <?php } else { ?>
                                                    <label class="custom-control custom-checkbox m-b-0 col-md-12"><input type="checkbox" value="{{$mymenu[$i]->id}}" name="menu[]" id="menu{{$mymenu[$i]->menu_id}}" class="custom-control-input check_menu" tabel="{{$mymenu[$i]->menu_id}}"><span class="custom-control-label">{{$mymenu[$i]->name}}</span></label>
                                                    <?php } ?>
                                                </td>
                                                <td style="padding: 5px;">
                                                    <?php for ($a=0; $a < count($mysubmenu) ; $a++) { ?>
                                                    <?php if ($mymenu[$i]->menu_id == $mysubmenu[$a]->parent_menu_id) { 

                                            if ($mysubmenu[$a]->parent_menu_id == rcheck2($mysubmenu[$a]->id,$data->id,$mysubmenu[$a]->parent_menu_id)) { ?>
                                                    <div class="col-md-12"><label class="custom-control custom-checkbox m-b-0"><input type="checkbox" value="{{$mysubmenu[$a]->id}}" name="submenu[]" id="submenu{{$mysubmenu[$a]->parent_menu_id}}" class="custom-control-input sub{{$mymenu[$i]->menu_id}}" checked><span class="custom-control-label">{{$mysubmenu[$a]->name}}</span></label></div>
                                                    <?php } else { ?>
                                                    <div class="col-md-12"><label class="custom-control custom-checkbox m-b-0"><input type="checkbox" value="{{$mysubmenu[$a]->id}}" name="submenu[]" id="submenu{{$mysubmenu[$a]->parent_menu_id}}" class="custom-control-input sub{{$mymenu[$i]->menu_id}}" disabled><span class="custom-control-label">{{$mysubmenu[$a]->name}}</span></label></div>
                                                    <?php } ?>
                                                    <?php }?>
                                                    <?php }?>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-xs-12">
                                    <button type="button" class="btn btn-primary mr-2 float-right" id="kirim_edit">Submit</button>
                                    <button type="button" class="btn btn-danger float-right" id="batalkan3" style="margin-right: 10px">Cancel</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Pop Up Edit -->
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
                
                $("#hide_add").css('display', '');
                $("#show_add").css('display', 'none');
                $("#message").remove();
                show_toast(data.message, 1);

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
                show_toast(data.message, 1);

                $("#titel_head").remove();
                $("#head_modul").append('<span id="titel_head">Add City</span>');
                $("#hide_add").css('display', '');
                $("#show_edit").css('display', 'none');
                //alert("okey");
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
