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
                                        <div class="col-md-12 mb-3" id="div_student">
                                            <input type="hidden" name="id_student" value="{{$user->id}}" id="id_user">
                                            <input type="hidden" name="id_class" value="{{$user->id_class}}">
                                            <div class="card card-custom gutter-b card-stretch">
                                                <!--begin::Body-->
                                                <div class="card-body pt-4">
                                                    <!--begin::Toolbar-->
                                                    <div class="d-flex justify-content-end">
                                                        
                                                    </div>
                                                    <!--end::Toolbar-->
                                                    <!--begin::User-->
                                                    <div class="d-flex align-items-end mb-7">
                                                        <!--begin::Pic-->
                                                        <div class="d-flex align-items-center">
                                                            <!--begin::Pic-->
                                                            <div class="flex-shrink-0 mr-4 mt-lg-0 mt-3">
                                                                <div class="symbol symbol-circle symbol-lg-75">
                                                                    <img src="{{env('BASE_IMG')}}{{$user->image}}" alt="image">
                                                                </div>
                                                                <div class="symbol symbol-lg-75 symbol-circle symbol-primary d-none">
                                                                    <span class="font-size-h3 font-weight-boldest">JM</span>
                                                                </div>
                                                            </div>
                                                            <!--end::Pic-->
                                                            <!--begin::Title-->
                                                            <div class="d-flex flex-column">
                                                                <a href="#" class="text-dark font-weight-bold text-hover-primary font-size-h4 mb-0">{{$user->student_name}}</a>
                                                                <span class="text-muted font-weight-bold">nisn# {{$user->nisn}}</span>
                                                            </div>
                                                            <!--end::Title-->
                                                        </div>
                                                        <!--end::Title-->
                                                    </div>
                                                    <!--end::User-->
                                                    <!--begin::Desc-->
                                                    <p class="mb-7">
                                                    </p>
                                                    <!--end::Desc-->
                                                    <!--begin::Info-->
                                                    <div class="mb-7">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <span class="text-dark-75 font-weight-bolder mr-2">Email:</span>
                                                            <a href="#" class="text-muted text-hover-primary">
                                                                @if (Auth::guard('admin')->user()->id_scholl != null)
                                                                {{ substr($user->email, 0, 3)."**********"}}
                                                                @else
                                                                {{$user->email}}
                                                                @endif
                                                            </a>
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-cente my-1">
                                                            <span class="text-dark-75 font-weight-bolder mr-2">Phone:</span>
                                                            <a href="#" class="text-muted text-hover-primary">
                                                                @if (Auth::guard('admin')->user()->id_scholl != null)
                                                                {{ substr($user->phone, 0, 3)."**********"}}
                                                                @else
                                                                {{$user->phone}}
                                                                @endif
                                                            </a>
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <span class="text-dark-75 font-weight-bolder mr-2">Domisili:</span>
                                                            <span class="text-muted text-hover-primary">{{$user->name}}</span>
                                                        </div>
                                                    </div>
                                                    <!--end::Info-->
                                                </div>
                                                <!--end::Body-->
                                            </div>
                                            <!--end::Card-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        @if($type == '1')
                        <div id="div_add" style="display: none">
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
                                                    <input type="text" class="form-control" name="medicine[]" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12 mb-2">
                                                <div class="form-group">
                                                    <label>Dosis</label>
                                                    <input type="text" class="form-control" name="dosis[]" required>
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
                                    <button type="button" class="btn btn-danger mr-2 ml-2 float-right" onclick="cancel()">Batalkan</button>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3" id="div_table">
                            <div class="card-header">
                                @if($akses->is_add == 1)
                                <button type="button" class="btn btn-sm btn-success float-right" onclick="Addnew()">Tambah medical record</button>
                                @endif
                                <a class="btn btn-sm btn-success float-right mr-4" target="_blank" href="/medical-record/list/print/{{base64_encode($id)}}/1"><i class="fas fa-print"></i> Cetak PDF</a>
                                <!-- <a class="btn btn-sm btn-success float-right mr-4" href="/medical-record/list/excel/{{base64_encode($id)}}/1">Download Excel</a> -->
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table zero-configuration" id="yourTable">
                                        <thead>
                                            <tr>
                                                <th style="width: 2%;">No</th>
                                                <th style="width: 23%;">Keluhan</th>
                                                <th style="width: 40%;">Tindakan</th>
                                                <th style="width: 15%;">Tanggal</th>
                                                <th style="width: 5%;">Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @else
                        <div id="div_add">
                            <div class="card mb-3">
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="row">
                                            <input type="hidden" name="id" value="{{$data->id}}" id="id_record">
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label>Tanggal</label>
                                                    <input type="datetime-local" class="form-control" value="{{$data->record_date}}" name="record_date" required>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label>Kategori</label>
                                                    <select class="select2 form-control" name="id_category" required>
                                                        <option value="">-- pilih ---</option>
                                                        @foreach($data_category as $c)
                                                            @if($c->id == $data->id_category)
                                                            <option value="{{$c->id}}" selected>{{$c->category_name}}</option>
                                                            @else
                                                            <option value="{{$c->id}}">{{$c->category_name}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label>Keluhan</label>
                                                    <textarea name="problem" class="form-control" required>{{$data->problem}}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label>Tindakan</label>
                                                    <textarea name="solving" class="form-control" required>{{$data->solving}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-content">
                                    <div class="card-body" id="div_medicine">
                                        <?php $no = 0; ?>
                                        @foreach($data_medicine as $m)
                                        <?php $no = $no + 1; ?>
                                        <div class="row div_medicine" data-no="{{$no}}" id="div_medicine{{$no}}">
                                            <div class="col-md-3 col-sm-12 mb-2">
                                                <div class="form-group">
                                                    <label>Obat</label>
                                                    <select class="select2 form-control" name="id_medicine[]" required>
                                                        @foreach($medicines as $c)
                                                            @if($c->id == $m->id_medicine)
                                                            <option value="{{$c->id}}" selected>{{$c->medicine}}</option>
                                                            @else
                                                            <option value="{{$c->id}}">{{$c->medicine}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12 mb-2">
                                                <div class="form-group">
                                                    <label>Dosis</label>
                                                    <input type="number" min="1" class="form-control" value="{{$m->dosis}}" name="dosis[]" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12 mb-2">
                                                <div class="form-group">
                                                    <label>Notes</label>
                                                    <textarea name="notes[]" class="form-control">{{$m->notes}}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-1 mt-5">
                                                <a href="javascript:void(0)" onclick="DelMed('{{$no}}')"><i class="fas fa-trash"></i></a>
                                            </div>
                                        </div>
                                        @endforeach
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
                                    <button type="button" class="btn btn-danger mr-2 ml-2 float-right" onclick="cancel()">Batalkan</button>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3" id="div_table" style="display: none;">
                            <div class="card-header">
                                <button type="button" class="btn btn-sm btn-success float-right" onclick="Addnew()">Tambah medical record</button>
                                <a class="btn btn-sm btn-success float-right mr-4" href="/medical-record/list/print/{{base64_encode($id)}}/1">Download PDF</a>
                                <!-- <a class="btn btn-sm btn-success float-right mr-4" href="">Download Excel</a> -->
                                <!-- <button type="button" onclick="Addnew()">Tambah medical record</button> -->
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table zero-configuration" id="yourTable">
                                        <thead>
                                            <tr>
                                                <th style="width: 2%;">No</th>
                                                <th style="width: 23%;">Keluhan</th>
                                                <th style="width: 40%;">Tindakan</th>
                                                <th style="width: 15%;">Tanggal</th>
                                                <th style="width: 5%;">Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endif
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
var column = [
        { "data": "no" },
        { "data": "problem" },
        { "data": "solving" },
        { "data": "date" },
        { "data": "actions" },
    ];

function DataTable() {
    var id_student = $("#id_user").val();
    var search = "";
    var nantable = $('#yourTable').DataTable({
        "processing": true,
        "serverSide": true,
        "searching": false,
        "ajax": {
            "url": "/data_medical",
            "dataType": "json",
            "type": "POST",
            "data": { _token: "{{csrf_token()}}",id_student:id_student,search:search }
        },
        "columns": column,
        "bDestroy": true
    });
    return nantable;
}
$(function() {
    //$('#myTable').DataTable();
    $(".select2-container--default").css('width', '100%');
    DataTable();
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
            url: '/update_medical',
            dataType: 'json',
            data: new FormData($("#form_add")[0]),
            processData: false,
            contentType: false,
            success: function(data) {
                $("#loading_btn").css('display','none');
                $("#save_btn").css('display','');
                show_toast(data.message, 1);
                DataTable();
                $("#div_add").css('display','none');
                $("#div_table").css('display','');
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
function Addnew(){
    $("#div_add").css('display','');
    $("#div_table").css('display','none');
}

function cancel(){
    $("#id_record").remove();
    $("#div_add").css('display','none');
    $("#div_table").css('display','');
}
</script>
@endsection
