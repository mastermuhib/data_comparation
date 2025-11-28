@extends('layout.app')
@section('asset')
<link rel="stylesheet" type="text/css" href="{{URL::asset('assets')}}/vendors/css/forms/select/select2.min.css">
@endsection
@section('title', 'Master Payment Category')
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
                                        <label>Nama Orang Tua</label>
                                        <input type="text" class="form-control" name="student_parent_name" required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Status Orang Tua</label>
                                        <select class="select2 form-control" id="parent_type" name="parent_type">
                                        <option value="Bapak">Bapak</option>
                                        <option value="Ibu">Ibu</option>
                                        <option value="Kakek">Kakek</option>
                                        <option value="Nenek">Nenek</option>
                                        <option value="Paman">Paman</option>
                                        <option value="Bibi">Bibi</option>
                                        <option value="Saudara">Saudara</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" class="form-control" name="email" required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>No HP</label>
                                        <input type="text" class="form-control" name="phone" required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Jenis Kelamin</label>
                                        <select class="select2 form-control" id="gender" name="gender">
                                        <option value="1">Laki - Laki</option>
                                        <option value="2">Perempuan</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Tanggal Lahir</label>
                                        <input type="date" class="form-control" name="birthday" required>
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
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Data Siswa </label>
                                        <table class="table table-bordered table_striped table-hover" width="100">
                                            <thead>
                                                <tr>
                                                    @if(Auth::guard('admin')->user()->id_scholl == null)
                                                    <th>Nama Sekolah</th>
                                                    @endif
                                                    <th>Nama Kelas</th>
                                                    <th>Nama Siswa</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="body_siswa">
                                                <tr id="tr_1" class="tr_siswa" data-no="1">
                                                    @if(Auth::guard('admin')->user()->id_scholl == null)
                                                    <td>
                                                        <select class="select2 form-control" id="id_scholl1" onchange="ChangeScholl('1')" required>
                                                            <option value="">--pilih--</option>
                                                            @foreach($data_scholl as $ct)
                                                            <option value="{{$ct->id}}">{{$ct->scholl_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="select2 form-control" id="id_class1" onchange="ChangeClass('1')" required>
                                                            <option value="">-- pilih ---</option>
                                                        </select>
                                                    </td>
                                                    @else
                                                    <td>
                                                        <input type="hidden" id="id_class1" value="{{Auth::guard('admin')->user()->id_scholl}}">
                                                        <select class="select2 form-control" id="id_class1" onchange="ChangeClass('1')" required>
                                                            <option value="">-- pilih ---</option>
                                                            @foreach(DataClass(Auth::guard('admin')->user()->id_scholl) as $ct)
                                                            <option value="{{$ct->id}}">{{$ct->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    @endif
                                                    <td>
                                                        <select class="select2 form-control" id="id_student1" no="1" name="id_student[]" required>
                                                            <option value="">-- pilih ---</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <a href="javascript:void(0)" onclick="DeleteStudent('1')"><i class="fas fa-trash text-danger"></i></a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <button class="mt-3 btn btn-primary btn-sm" type="button" onclick="AddStudent()"><i class="fas fa-plus"></i> Tambah Siwa</button>
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
            url: '/post_parent',
            dataType: 'json',
            data: new FormData($("#form_add")[0]),
            processData: false,
            contentType: false,
            success: function(data) {
                $("#loading_btn").css('display','none');
                $("#save_btn").css('display','');
                show_toast(data.message, 1);
                location.assign('/user/parent');
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

function ChangeScholl(no){
    alert(no);
    id = $("#id_scholl"+no).val();
    $.ajax({
        type: 'GET',
        url: '/get_class/'+id,
        dataType: 'json',
        success: function(data) {
            console.log(data)
            $("#id_class"+no).empty();
            $("#id_class"+no).append("<option value=''>Pilih Kelas</option>");
            for (let i = 0; i < data.length; i++) {
                $("#id_class"+no).append("<option value=" + data[i].id + ">" + data[i].name + "</option>");
            }
            DataTable();
        },
        error: function(data) {
            console.log(data);
        }
    });
}

function ChangeClass(no){
    id = $("#id_class"+no).val();
    $.ajax({
        type: 'GET',
        url: '/get_student/'+id,
        dataType: 'json',
        success: function(data) {
            console.log(data)
            $("#id_student"+no).empty();
            $("#id_student"+no).append("<option value=''>Pilih Siswa</option>");
            for (let i = 0; i < data.length; i++) {
                $("#id_student"+no).append("<option value=" + data[i].id + ">" + data[i].name + "</option>");
            }
            DataTable();
        },
        error: function(data) {
            console.log(data);
        }
    });

}

function AddStudent(){
        var max = 0;
        $('.tr_siswa').each(function() {
          var value = parseInt($(this).data('no'));
          max = (value > max) ? value : max;
        });
       // alert(max);
        var id = parseInt(max)+1;
        //alert(id);

        $.ajax({
            url: '/add_student/'+id,
            type: "GET",
            success: function(response) {
                console.log(response);
                if (response) {
                    $("#body_siswa").append(response);
                }
            }
        });
    }

function DeleteStudent(id){
    $("#tr_"+id).remove();
}
</script>
@endsection
