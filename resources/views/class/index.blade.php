@extends('layout.app')
@section('asset')
<link rel="stylesheet" type="text/css" href="{{URL::asset('assets')}}/vendors/css/forms/select/select2.min.css">
<style type="text/css">
    table.dataTable thead .sorting, 
table.dataTable thead .sorting_asc, 
table.dataTable thead .sorting_desc {
    background : none;
}
</style>
@endsection
@section('title', 'Tipe Produk')
@section('content')
<div id="show_edit">
</div>
<div id="edit_password">
</div>
<div class="row" id="show_add" style="display: none;">
    <div class="col-lg-12 col-xxl-12">
        <section class="multiple-validation">
            <div class="card mb-3">
                <div class="card-content">
                    <div class="card-body">
                        <form method="POST" class="form-horizontal p-3" id="form_add">@csrf
                            <div class="row mb-5">
                                <div class="col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Nama Kelas</label>
                                        <input type="text" name="class_name" class="form-control form-control-lg" placeholder="Name" required>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Sekolah</label>
                                        <select class="select2 form-control" id="select_cabang" name="id_scholl" required>
                                            <option value="">Pilih Sekolah</option>
                                            @foreach($data_scholl as $c)
                                            <option value="{{$c->id}}">{{$c->scholl_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Kapasitas Kelas</label>
                                        <input type="number" min="0" name="capacity" class="form-control form-control-lg" placeholder="20" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-header text-center">
                                            Foto Kelas
                                        </div>
                                        <div class="card-body text-center">
                                            
                                            <img id="profile_admin" src="https://souq-cms.trendcas.com/assets/imgs/theme/upload.svg" alt="your image" style="max-width: 200px;max-height: 200px;" />
                                            <label class="btn btn-white btn-sm mb-0 w-100 align-self-center">
                                                Upload Foto <input type="file" name="image" style="display: none;" onchange="gantiProfile_admin(this);">
                                            </label>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Description</label>
                                        <fieldset class="form-label-group mb-0">
                                            <textarea data-length="2000" class="form-control char-textarea active summernote" id="description" rows="3" placeholder="Deskripsi" style="color: rgb(78, 81, 84);"></textarea>
                                        </fieldset>
                                        <input type="hidden" name="description" value="" id="isi_text">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <button type="submit" class="btn btn-primary float-right" id="save_add">Submit</button>
                                    <button type="button" class="btn btn-primary float-right" style="display: none;" id="loading_add" disabled>Loading...</button>
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
                <h5 class="text-dark font-weight-bold ml-3">List Kelas</h5>
                @if($akses->is_add == 1)
                <a class="btn btn-primary font-weight-bolder mr-3" id="tambah">Add Kelas</a>
                @endif
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
                                                        <th>Sekolah</th>
                                                        <th>Tanggal</th>
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
<input type="hidden" id="id_user" name="">
<!-- modal batal approve -->

<!-- Preview -->
<div class="modal fade modal-cv" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal_prev">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" style="border-radius: 12px" id="isi_preview">
            
        </div>
        <div class="text-center" id="proses_loading">
            <img alt="Pic" src="{{URL::asset('assets')}}/media/loading.gif" style="width: 30%">
        </div>
    </div>
</div>
<!-- Preview -->
@endsection
@section('js')
@include('components/componen_crud')
<script src="//cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
<script type="text/javascript">
var config = {};
config.placeholder = 'some value';
CKEDITOR.replace('description', config);

</script>
<script type="text/javascript">
var column = [
        { "data": "no" },
        { "data": "class" },
        { "data": "scholl" },
        { "data": "date" },
        { "data": "status" },
        { "data": "actions" },
    ];


function data_tabel(table) {
    var is_edit  = $("#is_edit").val();
    var is_delete  = $("#is_delete").val();
    id_scholl = $("#scholl_id").val();
    var nantable = $('#yourTable').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/data_kelas",
            "dataType": "json",
            "type": "POST",
            "data": { _token: "{{csrf_token()}}",is_edit:is_edit,is_delete:is_delete,id_scholl:id_scholl }
        },
        "columns": column,
        "bDestroy": true
    });
    return nantable;
}
$(function() {
    //$('#myTable').DataTable();
    $(".select2-container--default").css('width', '100%');
    data_tabel('data_kelas')
});
$("#s_search").keyup(function(){
   data_tabel('data_kelas');
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
        var text = CKEDITOR.instances.description.getData();
        $("#isi_text").val(text);
        $.ajax({ //line 28
            type: 'POST',
            url: '/post_kelas',
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

                    data_tabel('data_kelas')
                } else {
                    show_toast(data.message, 0);
                }
                $("#save_add").css('display','');
                $("#loading_add").css('display','none');
            }
        });
    }
});

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

function ResetAll(){
    location.reload();
}
</script>
@endsection
