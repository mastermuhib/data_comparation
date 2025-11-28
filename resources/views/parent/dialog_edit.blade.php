@extends('layout.app')
@section('asset')
<link rel="stylesheet" type="text/css" href="{{URL::asset('assets')}}/vendors/css/forms/select/select2.min.css">
@endsection
@section('title', '')
@section('content')
<section class="multiple-validation" id="detail_edit">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form-horizontal p-3" novalidate id="form_add">@csrf
                            <div class="row mb-5">
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Nama Orang</label>
                                        <input type="text" class="form-control" name="student_parent_name" value="{{$data->student_parent_name}}" required>
                                        <input type="hidden" name="id" value="{{$data->id}}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Status Orang Tua</label>
                                        <select class="select2 form-control" id="parent_type" name="parent_type">
                                        <option value="Bapak" <?php if ($data->parent_type == 'Bapak') {
                                            echo "selected";
                                        } ?>>Bapak</option>
                                        <option value="Ibu" <?php if ($data->parent_type == 'Ibu') {
                                            echo "selected";
                                        } ?>>Ibu</option>
                                        <option value="Kakek" <?php if ($data->parent_type == 'Kakek') {
                                            echo "selected";
                                        } ?>>Kakek</option>
                                        <option value="Nenek" <?php if ($data->parent_type == 'Nenek') {
                                            echo "selected";
                                        } ?>>Nenek</option>
                                        <option value="Paman" <?php if ($data->parent_type == 'Paman') {
                                            echo "selected";
                                        } ?>>Paman</option>
                                        <option value="Bibi" <?php if ($data->parent_type == 'Bibi') {
                                            echo "selected";
                                        } ?>>Bibi</option>
                                        <option value="Saudara" <?php if ($data->parent_type == 'Saudara') {
                                            echo "selected";
                                        } ?>>Saudara</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" class="form-control" value="{{$data->email}}" name="email" required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>No HP</label>
                                        <input type="text" class="form-control" value="{{$data->phone}}" name="phone" required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Jenis Kelamin</label>
                                        <select class="select2 form-control" id="gender" name="gender">
                                        <option value="1" <?php if ($data->gender == 1) {
                                            echo "selected";
                                        } ?>>Laki - Laki</option>
                                        <option value="2" <?php if ($data->gender == 2) {
                                            echo "selected";
                                        } ?>>Perempuan</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Tanggal Lahir</label>
                                        <input type="date" class="form-control" value="{{$data->birthday}}" name="birthday" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Kota Domisili</label>
                                    <select class="select2 form-control" id="id_city" name="id_city">
                                        <option value="">--pilih--</option>
                                        @foreach($data_city as $c)
                                            @if($c->id == $data->id_city)
                                                <option value="{{$c->id}}" selected>{{$c->name}}</option>
                                            @else
                                                <option value="{{$c->id}}">{{$c->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Alamat Domisili</label>
                                        <textarea name="address" class="form-control">{{$data->address}}</textarea>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Data Siswa </label>
                                        <table class="table table-bordered table_striped table-hover" width="100">
                                            <thead>
                                                <tr>
                                                    <th>Nama Sekolah</th>
                                                    <th>Nama Kelas</th>
                                                    <th>Nama Siswa</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="body_siswa">
                                                <?php $no = 0; ?>
                                                @foreach($student as $s)
                                                <?php $no = $no + 1; ?>
                                                <tr id="tr_{{$no}}" class="tr_siswa" data-no="{{$no}}">
                                                    <td colspan="3">
                                                        <input type="hidden" name="id_student[]" value="{{$s->id_student}}">
                                                        <label>{!! DataSiswa($s->id_student) !!}</label>
                                                    </td>
                                                    <td>
                                                        <a href="javascript:void(0)" onclick="DeleteStudent('{{$no}}')"><i class="fas fa-trash text-danger"></i></a>
                                                    </td>
                                                </tr>
                                                @endforeach
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
                                            @if($data->image != null)
                                            <img id="profile_admin" src="{{env('BASE_IMG')}}{{$data->image}}" alt="your image" style="max-width: 200px;max-height: 200px;" />
                                            @else
                                            <img id="profile_admin" src="https://souq-cms.trendcas.com/assets/imgs/theme/upload.svg" alt="your image" style="max-width: 200px;max-height: 200px;" />
                                            @endif
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
        </div>
    </div>
</section>
@endsection
@section('js')
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
            url: '/update_parent',
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