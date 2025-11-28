@extends('layout.app')
@section('asset')
<link rel="stylesheet" type="text/css" href="{{URL::asset('assets')}}/vendors/css/forms/select/select2.min.css">
@endsection
@section('title', '')
@section('content')
<div class="row" id="show_add">
    <div class="col-lg-12 col-xxl-4">
        <section class="multiple-validation">
            <form class="form-horizontal p-3" novalidate id="form_add">@csrf
                <div class="row mb-5">
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        @if(Auth::guard('admin')->user()->id_scholl == null)
                                        <div class="col-md-12 mb-3">
                                            <label>Sekolah</label>
                                            <select class="select2 form-control" id="id_scholl" name="id_scholl" onchange="ChangeScholl()" required>
                                                <option value="">--pilih--</option>
                                                @foreach($data_scholl as $ct)
                                                <option value="{{$ct->id}}">{{$ct->scholl_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label>Kelas</label>
                                            <select class="select2 form-control" id="id_class" name="id_class" onchange="ChangeClass()" required>
                                                <option value="">-- pilih ---</option>
                                            </select>
                                        </div>
                                        @else
                                        <input type="hidden" name="id_scholl" id="id_scholl" value="{{Auth::guard('admin')->user()->id_scholl}}">
                                        <div class="col-md-12 mb-3">
                                            <label>Kelas</label>
                                            <select class="select2 form-control" id="id_class" name="id_class" onchange="ChangeClass()" required>
                                                <option value="">-- pilih ---</option>
                                                @foreach(DataClass(Auth::guard('admin')->user()->id_scholl) as $ct)
                                                <option value="{{$ct->id}}">{{$ct->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @endif
                                        <div class="col-md-12 mb-3">
                                            <label>Siswa</label>
                                            <select class="select2 form-control" id="id_student" name="id_student" onchange="ChangeStudent()" required>
                                                <option value="">-- pilih ---</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12 mb-3" id="div_student">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>Tanggal</label>
                                                <input type="datetime-local" class="form-control" name="record_date" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>Kategori</label>
                                                <select class="select2 form-control" name="id_category" required>
                                                    <option value="">-- pilih ---</option>
                                                    @foreach($data_category as $c)
                                                    <option value="{{$c->id}}">{{$c->category_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>Keluhan</label>
                                                <textarea name="problem" class="form-control" required></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label>Tindakan</label>
                                                <textarea name="solving" class="form-control" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-content">
                                <div class="card-body" id="div_medicine">
                                    <div class="row div_medicine" data-no="1" id="div_medicine1">
                                        <div class="col-md-3 col-sm-12 mb-2">
                                            <div class="form-group">
                                                <label>Obat</label>
                                                <select class="select2 form-control" name="id_medicine[]" required>
                                                    @foreach($medicines as $c)
                                                        <option value="{{$c->id}}">{{$c->medicine}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12 mb-2">
                                            <div class="form-group">
                                                <label>Dosis</label>
                                                <input type="number" min="0" class="form-control" name="dosis[]" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12 mb-2">
                                            <div class="form-group">
                                                <label>Notes</label>
                                                <textarea name="notes[]" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-1 mt-5">
                                            <a href="javascript:void(0)" onclick="DelMed('1')"><i class="fas fa-trash"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center mb-3">
                                    <button class="btn btn-default btn-sm" onclick="AddMed()" type="button"><i class="fas fa-plus"></i> Tambah Obat</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <button type="submit" id="save_btn" class="btn btn-primary float-right"><i class="fas fa-save"></i> Simpan Medical record</button>
                                <button type="button" id="loading_btn" class="btn btn-primary float-right" style="display: none;" disabled>Loading.....</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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
            url: '/post_medical',
            dataType: 'json',
            data: new FormData($("#form_add")[0]),
            processData: false,
            contentType: false,
            success: function(data) {
                $("#loading_btn").css('display','none');
                $("#save_btn").css('display','');
                if (data.code == 200) {
                    show_toast(data.message, 1);
                    location.assign('/medical-record/list/');
                } else {
                    show_toast(data.message, 0);
                }
            }, error : function(data) {
                $("#loading_btn").css('display','none');
                $("#save_btn").css('display','');
            }
        });
    }
});

function ChangeScholl(){

    id = $("#id_scholl").val();
    $("#div_student").html('');
    if (id != '' || id != null) {
        $.ajax({
            type: 'GET',
            url: '/get_class/'+id,
            dataType: 'json',
            success: function(data) {
                console.log(data)
                $("#id_class").empty();
                $("#id_class").append("<option value=''>Pilih Kelas</option>");
                $("#id_student").empty();
                $("#id_student").append("<option value=''>Pilih Siswa</option>");
                for (let i = 0; i < data.length; i++) {
                    $("#id_class").append("<option value=" + data[i].id + ">" + data[i].name + "</option>");
                }
                DataTable();
            },
            error: function(data) {
                console.log(data);
            }
        });
    } else {
        $("#id_class").empty();
        $("#id_class").append("<option value=''>Pilih Kelas</option>");
        $("#id_student").empty();
        $("#id_student").append("<option value=''>Pilih Siswa</option>");
    }
}

function ChangeClass(){
    id = $("#id_class").val();
    $("#div_student").html('');
    if (id != '' || id != null) {
        $.ajax({
            type: 'GET',
            url: '/get_student/'+id,
            dataType: 'json',
            success: function(data) {
                console.log(data)
                $("#id_student").empty();
                $("#id_student").append("<option value=''>Pilih Siswa</option>");
                for (let i = 0; i < data.length; i++) {
                    $("#id_student").append("<option value=" + data[i].id + ">" + data[i].name + "</option>");
                }
            },
            error: function(data) {
                console.log(data);
            }
        });
    } else {
        $("#id_student").empty();
        $("#id_student").append("<option value=''>Pilih Siswa</option>");
    }

}

function ChangeStudent(){

    id = $("#id_student").val();
    if (id != '' || id != null) {
        $.ajax({
            type: 'GET',
            url: '/get_student_data/'+id,
            dataType: 'html',
            success: function(data) {
                $("#div_student").html(data)
            },
            error: function(data) {
                console.log(data);
            }
        });
    } else {
        $("#div_student").html('');
    }

}

function AddMed(){
        var max = 0;
        $('.div_medicine').each(function() {
          var value = parseInt($(this).data('no'));
          max = (value > max) ? value : max;
        });
       // alert(max);
        var id = parseInt(max)+1;
        //alert(id);

        $.ajax({
            url: '/add_medicine/'+id,
            type: "GET",
            success: function(response) {
                console.log(response);
                if (response) {
                    $("#div_medicine").append(response);
                    $('.select2').select2();
                    $(".select2-container--default").css('width', '100%');
                }
            }
        });
    }

function DelMed(id){
    $("#div_medicine"+id).remove();
}
</script>
@endsection
