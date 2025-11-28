@extends('layout.app')
@section('asset')
<link rel="stylesheet" type="text/css" href="{{URL::asset('assets')}}/vendors/css/forms/select/select2.min.css">
@endsection
@section('title', 'Chat Member Notif')
@section('content')

<div class="form_edit_modul" id="show_edit">
</div>
<div class="row" id="show_add" style="display: none;">
    <div class="col-lg-12 col-xxl-4">
        <section class="multiple-validation">
            <div class="card mb-3">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form-horizontal" enctype="multipart/form-data" id="form_add">@csrf
                            <div class="row mb-5">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label>Jenis Notifikasi</label>
                                        <select class="form-control select2" id="id_type" name="tipe" onchange="ChangeTipe()">
                                            <option value="0" selected>Umum </option>
                                            <option value="1">Khusus Siswa</option>
                                            <option value="2">Khusus Guru</option>
                                            <option value="3">Khusus Orang Tua</option>
                                        </select>
                                    </div>
                                </div>
                                @if(Auth::guard('admin')->user()->id_scholl == null)
                                <div class="col-md-3 mb-3">
                                    <label>Sekolah</label>
                                    <select class="select2 form-control" id="id_scholl" name="id_scholl" onchange="ChangeScholl()" required>
                                        <option value="">--pilih--</option>
                                        @foreach($data_scholl as $ct)
                                        <option value="{{$ct->id}}">{{$ct->scholl_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label>Kelas</label>
                                    <select class="select2 form-control" id="id_class" name="id_class" onchange="ChangeClass()" required>
                                        <option value="">-- pilih ---</option>
                                    </select>
                                </div>
                                @else
                                <input type="hidden" name="id_scholl" id="id_scholl" value="{{Auth::guard('admin')->user()->id_scholl}}">
                                <div class="col-md-6 mb-3">
                                    <label>Kelas</label>
                                    <select class="select2 form-control" id="id_class" name="id_class" onchange="ChangeClass()" required>
                                        <option value="">-- pilih ---</option>
                                        @foreach(DataClass(Auth::guard('admin')->user()->id_scholl) as $ct)
                                        <option value="{{$ct->id}}">{{$ct->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                <div class="col-md-6 mb-3" id="div_user" style="display: none;">
                                    <label>User</label>
                                    <select class="select2 form-control" id="id_user" multiple name="id_user[]">
                                        <option value="">Semua User</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Judul</label>
                                        <input type="text" class="form-control required" id="lastName3" name="title" required />
                                    </div>
                                </div> 
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="deskripsi" class="label_input">Notifikasi</label>
                                        <fieldset class="form-label-group mb-0">
                                            <textarea data-length="2000" class="form-control char-textarea active summernote" id="description" rows="3" placeholder="Deskripsi" style="color: rgb(78, 81, 84);" name="address"></textarea>
                                        </fieldset>
                                        <input type="hidden" name="deskripsi" value="" id="isi_deskripsi">
                                    </div>
                                </div>
                                <div class="container">
                                    <div class="col-sm-12 col-xs-12">
                                        <button type="button" disabled class="btn btn-primary float-right" style="display: none" id="is_loading">Loading.....</button>
                                        <button type="submit" class="btn btn-primary float-right" id="is_submit">Submit</button>
                                        <button type="button" class="btn btn-danger mr-2 float-right" id="batalkan">Cancel</button>
                                    </div>
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
                <h5 class="text-dark font-weight-bold ml-3">List Notifikasi</h5>
                <a class="btn btn-primary font-weight-bolder mr-3" id="tambah">Add Notifikasi</a>
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
                                                        <th>Tipe User</th>
                                                        <th>Judul</th>
                                                        <th>User</th>
                                                        <th>Notifikasi</th>
                                                        <th>Tanggal</th>
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
CKEDITOR.replace('description', config);

$('#tambah').on("click", function() {
    // alert('tes')
    $("#hide_add").css('display', 'none');
    $("#show_add").css('display', '');
});
$('#batalkan').on("click", function() {
    $("#hide_add").css('display', '');
    $("#show_add").css('display', 'none');
});

$("#form_add").validate({
    submitHandler: function(form) {
       var description = CKEDITOR.instances.description.getData();
        $("#isi_deskripsi").val(description);
        $("#is_submit").css('display','none');
        $("#is_loading").css('display','');
        $.ajax({ //line 28
            type: 'POST',
            url: '/post_notifikasi',
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
                    location.reload();
                    $("#is_submit").css('display','');
                    $("#is_loading").css('display','none');
                } else {
                    alert("maaf ada yang salah!!!");
                }
                
            }
        });
    }
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

function ChangeScholl(){
    type = $("#id_type").val();
    id = $("#id_scholl").val();
    if (id != '' || id != null) {
        $.ajax({
            type: 'GET',
            url: '/get_class/'+id,
            dataType: 'json',
            success: function(data) {
                console.log(data)
                $("#id_class").empty();
                $("#id_class").append("<option value=''>Semua Kelas</option>");
                $("#id_user").empty();
                $("#id_user").append("<option value=''>Semua User</option>");
                for (let i = 0; i < data.length; i++) {
                    $("#id_class").append("<option value=" + data[i].id + ">" + data[i].name + "</option>");
                }
                
            },
            error: function(data) {
                console.log(data);
            }
        });
        if (type == '2') {

        }
    } else {
        $("#id_class").empty();
        $("#id_class").append("<option value=''>Semua Kelas</option>");
        $("#id_user").empty();
        $("#id_user").append("<option value=''>Semua User</option>");
    }
}

function ChangeClass(){
    type = $("#id_type").val();
    id = $("#id_class").val();
    if (id != '' || id != null) {
        $.ajax({
            type: 'GET',
            url: '/get_student/'+id+'/'+type,
            dataType: 'json',
            success: function(data) {
                $("#id_user").empty();
                $("#id_user").append("<option value=''>Semua User</option>");
                for (let i = 0; i < data.length; i++) {
                    $("#id_user").append("<option value=" + data[i].id + ">" + data[i].name + "</option>");
                }
            },
            error: function(data) {
                console.log(data);
            }
        });
    } else {
        $("#id_student").empty();
        $("#id_student").append("<option value=''>Pilih User</option>");
    }

}

function ChangeTipe(){
    type = $("#id_type").val();
    if (type == '0') {
        $("#div_user").css('display','none');
    } else {
        $("#div_user").css('display','');
    }
}





</script>
@endsection
