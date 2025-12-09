@extends('layout.app')
@section('asset')
<link rel="stylesheet" type="text/css" href="{{URL::asset('assets')}}/vendors/css/forms/select/select2.min.css">
@endsection
@section('title', '')
@section('content')
<div class="row" id="show_add">
    <div class="col-lg-12 col-xxl-4">
        <section class="multiple-validation">
            <div class="card mb-3">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form-horizontal p-3" novalidate id="form_add">@csrf
                            <div class="row mb-5">
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Nama Siswa</label>
                                        <input type="text" class="form-control" name="student_name" required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>NISN</label>
                                        <input type="text" class="form-control" name="nisn" required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" class="form-control" name="email" required>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>No HP</label>
                                        <input type="text" class="form-control" name="phone" required>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <div class="form-group">
                                        <label>Jenis Kelamin</label>
                                        <select class="select2 form-control" id="gender" name="gender">
                                        <option value="1">Laki - Laki</option>
                                        <option value="2">Perempuan</option>
                                    </select>
                                    </div>
                                </div>
                                @if(Auth::guard('admin')->user()->id_scholl == null)
                                <div class="col-md-6 mb-3">
                                    <label>Sekolah</label>
                                    <select class="select2 form-control" id="id_scholl" name="id_scholl" onchange="ChangeScholl()" required>
                                        <option value="">--pilih--</option>
                                        @foreach($data_scholl as $ct)
                                        <option value="{{$ct->id}}">{{$ct->scholl_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label>Kelas</label>
                                    <select class="select2 form-control" id="id_class" name="id_class" required>
                                        <option value="">-- pilih ---</option>
                                    </select>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <div class="form-group">
                                        <label>Tanggal Masuk</label>
                                        <input type="date" class="form-control" name="tgl_masuk">
                                    </div>
                                </div>
                                @else
                                <div class="col-md-6 mb-3">
                                    <label>Kelas</label>
                                    <input type="hidden" name="id_scholl" id="id_scholl" value="{{Auth::guard('admin')->user()->id_scholl}}">
                                    <select class="select2 form-control" id="id_class" name="id_class" required>
                                        <option value="">-- pilih ---</option>
                                        @foreach(DataClass(Auth::guard('admin')->user()->id_scholl) as $ct)
                                        <option value="{{$ct->id}}">{{$ct->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Tanggal Masuk</label>
                                        <input type="date" class="form-control" name="tgl_masuk">
                                    </div>
                                </div>
                                @endif
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Tanggal Lahir</label>
                                        <input type="date" class="form-control" name="birthday" required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Golongan Darah</label>
                                        <input type="text" class="form-control" name="blood_group">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Kota Domisili</label>
                                    <select class="select2 form-control" id="id_city" name="id_city">
                                        <option value="">--pilih--</option>
                                        @foreach($data_city as $c)
                                        <option value="{{$c->id}}">{{$c->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Alamat Domisili</label>
                                        <textarea name="address" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Tinggi Badan (cm)</label>
                                        <input type="number" min="0" class="form-control" name="heigth" placeholder="140">
                                    </div>
                                </div> 
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Berat Badan (Kg)</label>
                                        <input type="number" min="0" class="form-control" name="weigth" placeholder="50">
                                    </div>
                                </div> 
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-header text-center">
                                            Foto
                                        </div>
                                        <div class="card-body text-center">
                                            
                                            <img id="profile_admin" src="https://souq-cms.trendcas.com/assets/imgs/theme/upload.svg" alt="your image" style="max-width: 200px;max-height: 200px;" />
                                            <label class="btn btn-white btn-sm mb-0 w-100 align-self-center">
                                                Upload File <input type="file" name="image" style="display: none;" onchange="gantiProfile_admin(this);">
                                            </label>
                                            
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <button type="submit" id="save_btn" class="btn btn-primary float-right">Submit</button>
                                    <button type="button" id="loading_btn" class="btn btn-primary float-right" style="display: none;" disabled>Loading.....</button>
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
@endsection
@section('js')
<!-- scipt js -->
@include('components/componen_crud')
<style>
    label.error {
        color: red;
    }
    </style>
<script type="text/javascript">
$(function() {
    //$('#myTable').DataTable();
    $(".select2-container--default").css('width', '100%');
});

$(".toggle-password").click(function() {
  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});

$("#form_add").validate({
    submitHandler: function(form) {
        $("#loading_btn").css('display','');
        $("#save_btn").css('display','none');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({ //line 28
            type: 'POST',
            url: '/post_siswa',
            dataType: 'json',
            data: new FormData($("#form_add")[0]),
            processData: false,
            contentType: false,
            success: function(data) {
                $("#loading_btn").css('display','none');
                $("#save_btn").css('display','');
                show_toast(data.message, 1);
                location.assign('/user/siswa');
            }, error : function(data) {
                $("#loading_btn").css('display','none');
                $("#save_btn").css('display','');
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

function ChangeScholl(){

    id = $("#id_scholl").val();
    $.ajax({
        type: 'GET',
        url: '/get_class/'+id,
        dataType: 'json',
        success: function(data) {
            console.log(data)
            $("#id_class").empty();
            $("#id_class").append("<option value=''>Pilih Kelas</option>");
            for (let i = 0; i < data.length; i++) {
                $("#id_class").append("<option value=" + data[i].id + ">" + data[i].name + "</option>");
            }
            DataTable();
        },
        error: function(data) {
            console.log(data);
        }
    });
}
</script>
@endsection
