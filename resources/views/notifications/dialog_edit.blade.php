@extends('layout.app')
@section('asset')
<link rel="stylesheet" type="text/css" href="{{URL::asset('assets')}}/vendors/css/forms/select/select2.min.css">
@endsection
@section('title', 'Chat Member Notif')
@section('content')
<!-- Pop Up Edit -->
<section class="multiple-validation" id="detail_edit">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form-horizontal p-3" novalidate id="form_edit">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Judul</label>
                                        <input type="text" name="title" class="form-control" id="name" placeholder="Name" required data-validation-required-message="Nama Wajib diisi" value="{{$data->title}}">
                                        <input type="hidden" name="id" value="{{$data->id}}">
                                        <input type="hidden" name="is_umum" value="{{$data->is_umum}}">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="firstName3">
                                           Nama Member
                                        </label>
                                        <select class="form-control select2" required data-validation-required-message="Subjek Wajib diisi" name="subjek">
                                            @if($data->is_umum == 1)
                                            <option value="" selected="">Semua Member </option>
                                            @else
                                            @foreach($member as $m)
                                            <option  value="{{$m->id}}" <?php if ($data->id_user == $m->id) {
                                                echo "selected";
                                                } ?> >{{$m->user_name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div> 
                               
                               <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="deskripsi" class="label_input">Deskripsi </label>
                                        <fieldset class="form-label-group mb-0">
                                            <textarea data-length="2000" class="form-control char-textarea active summernote" id="edit_description" rows="3" placeholder="Deskripsi" style="color: rgb(78, 81, 84);" name="desc">{{$data->text}}</textarea>
                                        </fieldset>
                                        <input type="hidden" name="text" value="" id="isi_deskripsi">
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Image</label>
                                        <input type="file" class="form-control-file mb-2" name="image" id="inputfoto" onchange="readURL(this);">
                                        @if($data->file == null)
                                        <img id="blah" src="" alt="your image" style="max-width: 200px;max-height: 200px;" />
                                        @else
                                        <img id="blah" src="{{base_img()}}{{$data->file}}" alt="your image" style="max-width: 200px;max-height: 200px;" />
                                        @endif
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<!-- end -->
<script type="text/javascript">
$(function() {
    //$('#myTable').DataTable();
    $(".select2-container--default").css('width', '100%');
    var xin_table = $('#myTable').DataTable({
        "bDestroy": true,
        "ajax": {
            url: "/data_notifikasi",
            type: 'GET'
        }
    });
});

var config = {};
config.placeholder = 'some value';
CKEDITOR.replace('edit_description', config);

$(document).off('click', '#kirim_edit').on('click', '#kirim_edit', function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var description = CKEDITOR.instances.edit_description.getData();
    $("#isi_deskripsi").val(description);
    $.ajax({ //line 28
        type: 'POST',
        url: '/update/notifikasi',
        dataType: 'json',
        data: new FormData($("#form_edit")[0]),
        processData: false,
        contentType: false,
        success: function(data) {
            console.log(data)
        if (data.code == 200) {
                document.getElementById("form_edit").reset();
                $("#message").remove();
                show_toast(data.message, 1);
                $("#titel_head").remove();
                $("#head_modul").append('<span id="titel_head">Add Notifikasi</span>');
                $("#hide_add").css('display', '');
                $("#show_edit").css('display', 'none');
                //alert("okey");
                var xin_table = $('#myTable').DataTable({
                    "bDestroy": true,
                    "ajax": {
                        url: "/data_notifikasi",
                        type: 'GET'
                    }
                });
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
        url: '/detail/notifikasi/' + id,
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

$(document).off('change', '#jenis_notifikasi').on('change', '#jenis_notifikasi', function() {
    id = $(this).val();
    if (id == 2) {
       $("#member_khusus").css('display','');
       $("#member_terpilih").css('display','');
    } else {
       $("#member_khusus").css('display','none');
       $("#member_terpilih").css('display','none');
    }
});

$(document).off('click', '.hapus-row').on('click', '.hapus-row', function() {
    $(this).closest('.row').remove();

    row_number = $(this).attr('row-number');
    number_of_row(row_number);
});

$("#searching_user").keyup(function(){
   text = $("#searching_user").val();
    if ( text.length > 2 ){
        $("#loading_searching").css('display','');
        $.ajax({
            url: '/search_user/'+text,
            type: "GET",
            success: function(response) {
                console.log(response);
                if (response) {
                    $("#data_member").html(response);
                    $("#loading_searching").css('display','none');
                }
            }
        });
    }
});

$(document).off('click', '.pilih_user').on('click', '.pilih_user', function() { 
    no = $(this).attr('no');
    nama = $(this).attr('nama');
    $("#div_pilih_user"+no).remove();
    $("#user_terpilih").append('<div class="checkbox-inline col-md-3 pb-5"><label class="checkbox checkbox-square checkbox-primary"><input type="checkbox" class="pilih_user" name="subjek[]" value="'+no+'" checked>'+nama+'<span></span></label></div>');
});

</script>
@endsection