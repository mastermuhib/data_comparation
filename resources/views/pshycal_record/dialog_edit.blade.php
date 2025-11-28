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
                    <div class="col-md-12">
                        <div class="card mb-3">
                            <div class="card-content">
                                <div class="card-body">
                                    <h4>Data Siswa</h4>
                                    <br>
                                    <div class="row mb-3">
                                    <input type="hidden" name="id" value="{{$data->id}}">
                                    @if($akses->is_add == 1)
                                        @if(Auth::guard('admin')->user()->id_scholl == null)
                                        <div class="col-md-3 col-6 mb-3">
                                            <label>Sekolah</label>
                                            <select class="select2 form-control" id="id_scholl" name="id_scholl" onchange="ChangeScholl()" required>
                                                <option value="">--pilih--</option>
                                                @foreach($data_scholl as $ct)
                                                    @if($ct->id == $data->id_scholl)
                                                    <option value="{{$ct->id}}" selected>{{$ct->scholl_name}}</option>
                                                    @else
                                                    <option value="{{$ct->id}}">{{$ct->scholl_name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 col-6 mb-3">
                                            <label>Kelas</label>
                                            <select class="select2 form-control" id="id_class" name="id_class" onchange="ChangeClass()" required>
                                                @if($data->id_scholl != null)
                                                    @foreach(DataClass($data->id_scholl) as $ct)
                                                    @if($ct->id == $data->id_class)
                                                        <option value="{{$ct->id}}" selected>{{$ct->name}}</option>
                                                    @else
                                                        <option value="{{$ct->id}}">{{$ct->name}}</option>
                                                    @endif
                                                @endforeach
                                                @else
                                                <option value="">-- pilih ---</option>
                                                @endif
                                            </select>
                                        </div>
                                        @else
                                        <input type="hidden" name="id_scholl" id="id_scholl" value="{{Auth::guard('admin')->user()->id_scholl}}">
                                        <div class="col-md-3 col-6 mb-3">
                                            <label>Kelas</label>
                                            <select class="select2 form-control" id="id_class" name="id_class" onchange="ChangeClass()" required>
                                                <option value="">-- pilih ---</option>
                                                @foreach(DataClass(Auth::guard('admin')->user()->id_scholl) as $ct)
                                                    @if($ct->id == $data->id_class)
                                                        <option value="{{$ct->id}}" selected>{{$ct->name}}</option>
                                                    @else
                                                        <option value="{{$ct->id}}">{{$ct->name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        @endif
                                        <div class="col-md-3 col-6 mb-3">
                                            <label>Siswa</label>
                                            <select class="select2 form-control" id="id_student" name="id_student" onchange="ChangeStudent()" required>
                                                @if($data->id_class != null)
                                                    <option value="">-- pilih ---</option>
                                                    @foreach(DataStudent($data->id_class) as $ct)
                                                        
                                                        @if($ct->id == $data->id_student)
                                                            <option value="{{$ct->id}}" selected>{{$ct->name}}</option>
                                                        @else
                                                            <option value="{{$ct->id}}">{{$ct->name}}</option>
                                                        @endif
                                                    @endforeach
                                                @else
                                                <option value="">-- pilih ---</option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-3 col-6 mb-3">
                                            <label>Orang Tua Siswa</label>
                                            <select class="select2 form-control" id="id_parent" name="id_parent">
                                                @if($data->id_class != null)
                                                    <option value="">-- pilih ---</option>
                                                    @foreach(DataParent($data->id_student) as $ct)
                                                        @if($ct->id == $data->id_parent)
                                                            <option value="{{$ct->id}}" selected>{{$ct->name}}</option>
                                                        @else
                                                            <option value="{{$ct->id}}">{{$ct->name}}</option>
                                                        @endif
                                                    @endforeach
                                                @else
                                                <option value="">-- pilih ---</option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-3 mb-3">
                                            <a class="btn btn-sm btn-success btn-block" target="_blank" href="/medical-record/pemeriksaan-tahunan/print/{{base64_encode($data->id)}}"><i class="fas fa-print"></i> Cetak PDF</a>
                                        </div>
                                    </div>
                                    @else
                                    <div class="col-4 mb-3">
                                        <label>Siswa</label>
                                        <select class="select2 form-control" id="id_student" name="id_student" disabled>
                                            @if($data->id_class != null)
                                                <option value="">-- pilih ---</option>
                                                @foreach(DataStudent($data->id_class) as $ct)
                                                    
                                                    @if($ct->id == $data->id_student)
                                                        <option value="{{$ct->id}}" selected>{{$ct->name}}</option>
                                                    @endif
                                                @endforeach
                                            @else
                                            <option value="">-- pilih ---</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-4 mb-3">
                                            <label>Kelas</label>
                                            <select class="select2 form-control" id="id_class" name="id_class" disabled>
                                                <option value="">-- pilih ---</option>
                                                @foreach(DataClass(Auth::guard('admin')->user()->id_scholl) as $ct)
                                                    @if($ct->id == $data->id_class)
                                                        <option value="{{$ct->id}}" selected>{{$ct->name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4 mb-3">
                                        <a class="btn btn-sm btn-success btn-block" target="_blank" href="/medical-record/pemeriksaan-tahunan/print/{{base64_encode($data->id)}}"><i class="fas fa-print"></i> Cetak PDF</a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-content">
                                <div class="card-body">
                                    <h4>Pemeriksaan Fisik</h4>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <label>Tanggal Pemeriksaan</label>
                                                <input type="datetime-local" value="{{ date('Y-m-d',strtotime($data->date))}}T{{ date('H:i',strtotime($data->date))}}" class="form-control" name="date" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12">
                                            <table class="table table-hover" style="width: 100%" border="0">
                                                <tr>
                                                    <td colspan="3">
                                                        <h5>Keadaan Umum</h5>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Warna Conjunctiva
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="conjunctiva" value="{{$data->conjunctiva}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Tinggi Badan (cm)
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="number" min="0" class="form-control" name="height" value="{{$data->height}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Berat Badan (kg)
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="number" min="0" class="form-control" name="weight" value="{{$data->weight}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Tekanan Darah (mm Hg)
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="blood_pressure" value="{{$data->blood_pressure}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Denyut Nadi ( / menit)
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="pulse" value="{{$data->pulse}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">
                                                        <h5>Kepala</h5>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Kesehatan Rambut
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="hair_healthy" value="{{$data->hair_healthy}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">
                                                        <h5>Penglihatan</h5>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Tanpa Kacamata
                                                    </td>
                                                    <td>
                                                        <label class="control-label">Kanan</label>
                                                        <input type="text" class="form-control" name="without_glasses_right" value="{{$data->without_glasses_right}}">
                                                    </td>
                                                    <td>
                                                        <label class="control-label">Kiri</label>
                                                        <input type="text" class="form-control" name="without_glasses_left" value="{{$data->without_glasses_left}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Dengan Kacamata
                                                    </td>
                                                    <td>
                                                        <label class="control-label">Kanan</label>
                                                        <input type="text" class="form-control" name="with_glasses_right" value="{{$data->with_glasses_right}}">
                                                    </td>
                                                    <td>
                                                        <label class="control-label">Kiri</label>
                                                        <input type="text" class="form-control" name="with_glasses_left" value="{{$data->with_glasses_left}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Mata Juling
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="cockeye" value="{{$data->cockeye}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Radang Mata
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="eye_inflammation" value="{{$data->eye_inflammation}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Buta Warna
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="color_blind" value="{{$data->color_blind}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">
                                                        <h5>Telingga/Hidung/Tenggorokan</h5>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Daya Pendengaran
                                                    </td>
                                                    <td>
                                                        <label class="control-label">Kanan</label>
                                                        <input type="text" class="form-control" name="hearing_power_right" value="{{$data->hearing_power_right}}">
                                                    </td>
                                                    <td>
                                                        <label class="control-label">Kiri</label>
                                                        <input type="text" class="form-control" name="hearing_power_left" value="{{$data->hearing_power_left}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Cerumen Telinga
                                                    </td>
                                                    <td>
                                                        <label class="control-label">Kanan</label>
                                                        <input type="text" class="form-control" name="ear_wax_right" value="{{$data->ear_wax_right}}">
                                                    </td>
                                                    <td>
                                                        <label class="control-label">Kiri</label>
                                                        <input type="text" class="form-control" name="ear_wax_left" value="{{$data->ear_wax_left}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Kelainan Hidung
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="nasal_abnormalities" value="{{$data->nasal_abnormalities}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Tenggorokan / tonsil
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="throat" value="{{$data->throat}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Gigi Mulut
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="mouth_teeth" value="{{$data->mouth_teeth}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">
                                                        <h5>Dada</h5>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Batuk Dada
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="chest_cough" value="{{$data->chest_cough}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Jantung
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="heart" value="{{$data->heart}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Paru - paru
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="lungs" value="{{$data->lungs}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">
                                                        <h5>Perut</h5>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Hati
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="liver" value="{{$data->liver}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Limpa
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="spleen" value="{{$data->spleen}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Nyeri Tekan
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="tenderness" value="{{$data->tenderness}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Anggota Gerak
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="motion_members" value="{{$data->motion_members}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Kulit
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="text" class="form-control" name="skin" value="{{$data->skin}}">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Kesimpulan
                                                    </td>
                                                    <td colspan="2">
                                                        <textarea name="conclusion" class="form-control" required>{{$data->conclusion}}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Diagnosa
                                                    </td>
                                                    <td colspan="2">
                                                        <textarea name="diagnose" class="form-control" required>{{$data->diagnose}}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Dokter Pemeriksa
                                                    </td>
                                                    <td colspan="2">
                                                        <select class="select2 form-control" id="id_doctor" name="id_doctor" required>
                                                            <option value="">--pilih--</option>
                                                            @foreach($data_doctor as $ct)
                                                            @if($ct->id == $data->id_doctor)
                                                            <option value="{{$ct->id}}" selected>{{$ct->name}}</option>
                                                            @else
                                                            <option value="{{$ct->id}}">{{$ct->name}}</option>
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-content">
                                <div class="card-body">
                                    <h4>Kesimpulan Perkembangan Jasmani & Kesehatan Anak</h4>
                                    <br>
                                    <div class="row">
                                        <table class="table table-hover" style="width: 100%" border="0">
                                            <tr>
                                                <th>
                                                    No
                                                </th>
                                                <th>
                                                    Pemeriksaan
                                                </th>
                                                <th>
                                                    Kesimpulan
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    1
                                                </td>
                                                <td>
                                                    Berat Badan
                                                </td>
                                                <td colspan="2">
                                                    <textarea name="weight_result" placeholder="Kesimpulan Berat Badan" class="form-control" required>{{$data->weight_result}}</textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    2
                                                </td>
                                                <td>
                                                    Tinggi Badan
                                                </td>
                                                <td colspan="2">
                                                    <textarea name="height_result" placeholder="Kesimpulan Tinggi Badan" class="form-control" required>{{$data->height_result}}</textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    3
                                                </td>
                                                <td>
                                                    Gizi (lebih baik/baik/kurang)
                                                </td>
                                                <td colspan="2">
                                                    <textarea name="nutrition_result" placeholder="Kesimpulan Gizi" class="form-control" required>{{$data->nutrition_result}}</textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    4
                                                </td>
                                                <td>
                                                    Mata / Penglihatan
                                                </td>
                                                <td colspan="2">
                                                    <textarea name="eye_result" placeholder="Kesimpulan Mata" class="form-control" required>{{$data->eye_result}}</textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    5
                                                </td>
                                                <td>
                                                    Hidung / Penciuman
                                                </td>
                                                <td colspan="2">
                                                    <textarea name="nasal_result" placeholder="Kesimpulan Hidung" class="form-control" required>{{$data->nasal_result}}</textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    6
                                                </td>
                                                <td>
                                                    Telinga / Pendengaran
                                                </td>
                                                <td colspan="2">
                                                    <textarea name="ear_result" placeholder="Kesimpulan Telinga" class="form-control" required>{{$data->ear_result}}</textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    7
                                                </td>
                                                <td>
                                                    Mulut (Tanpa halitosis)
                                                </td>
                                                <td colspan="2">
                                                    <textarea name="mouth_result" placeholder="Kesimpulan Mulut" class="form-control" required>{{$data->mouth_result}}</textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    8
                                                </td>
                                                <td>
                                                    Gigi Geligi
                                                </td>
                                                <td colspan="2">
                                                    <textarea name="teeth_result" placeholder="Kesimpulan gigi" class="form-control" required>{{$data->teeth_result}}</textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    9
                                                </td>
                                                <td>
                                                    Anggota Badan
                                                </td>
                                                <td colspan="2">
                                                    <textarea name="body_result" placeholder="Kesimpulan Anggota Badan" class="form-control" required>{{$data->body_result}}</textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    10
                                                </td>
                                                <td>
                                                    Kulit
                                                </td>
                                                <td colspan="2">
                                                    <textarea name="skin_result" placeholder="Kesimpulan Kulit" class="form-control" required>{{$data->skin_result}}</textarea>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @if($akses->is_add == 1)
                            <div class="col-sm-12 col-xs-12">
                                <button type="submit" id="save_btn" class="btn btn-primary float-right"><i class="fas fa-save"></i> Simpan Pemeriksaan</button>
                                <button type="button" id="loading_btn" class="btn btn-primary float-right" style="display: none;" disabled>Loading.....</button>
                            </div>
                            @endif
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
            url: '/update/pemeriksaan',
            dataType: 'json',
            data: new FormData($("#form_add")[0]),
            processData: false,
            contentType: false,
            success: function(data) {
                $("#loading_btn").css('display','none');
                $("#save_btn").css('display','');
                show_toast(data.message, 1);
                DataTable();
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
            url: '/get_student_parent/'+id,
            dataType: 'json',
            success: function(data) {
                console.log(data)
                $("#id_parent").empty();
                $("#id_parent").append("<option value=''>-- Pilih --</option>");
                for (let i = 0; i < data.length; i++) {
                    $("#id_parent").append("<option value=" + data[i].id + ">" + data[i].name + "</option>");
                }
            },
            error: function(data) {
                console.log(data);
            }
        });
    } else {
        $("#id_parent").empty();
        $("#id_parent").append("<option value=''>-- Pilih --</option>");
    }

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
