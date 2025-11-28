@extends('layout.app')
@section('asset')
<link rel="stylesheet" type="text/css" href="{{URL::asset('assets')}}/vendors/css/forms/select/select2.min.css">
@endsection
@section('title', 'Detail Peserta')
@section('content')
<div id="show_edit">
</div>
<div id="edit_password">
</div>
<div class="row" id="show_add">
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
                                        <input type="text" name="class_name" class="form-control form-control-lg" placeholder="Name" required value="{{$data->class_name}}">
                                        <input type="hidden" name="id" value="{{$data->id}}">
                                    </div>
                                </div>
                                <div class="col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Sekolah</label>
                                        <select class="select2 form-control" id="select_cabang" name="id_scholl" required>
                                            <option value="">Pilih Sekolah</option>
                                            @foreach($data_scholl as $c)
                                                @if($c->id == $data->id_scholl)
                                                <option value="{{$c->id}}" selected>{{$c->scholl_name}}</option>
                                                @else
                                                <option value="{{$c->id}}">{{$c->scholl_name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Kapasitas Kelas</label>
                                        <input type="number" min="0" name="capacity" class="form-control form-control-lg" placeholder="20" required value="{{$data->capacity}}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-header text-center">
                                            Foto Kelas
                                        </div>
                                        <div class="card-body text-center">
                                            @if($data->image == null)
                                            <img id="profile_admin" src="https://souq-cms.trendcas.com/assets/imgs/theme/upload.svg" alt="your image" style="max-width: 200px;max-height: 200px;" />
                                            @else
                                            <img id="profile_admin" src="{{env('BASE_IMG')}}{{$data->image}}" alt="your image" style="max-width: 200px;max-height: 200px;" />
                                            @endif
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
                                            <textarea data-length="2000" class="form-control char-textarea active summernote" id="description" rows="3" placeholder="Deskripsi" style="color: rgb(78, 81, 84);">{{$data->description}}</textarea>
                                        </fieldset>
                                        <input type="hidden" name="description" value="" id="isi_text">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <button type="submit" class="btn btn-primary float-right" id="save_add">Submit</button>
                                    <button type="button" class="btn btn-primary float-right" style="display: none;" id="loading_add" disabled>Loading....</button>
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
@include('components/componen_crud')
<script src="//cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
<script type="text/javascript">
var config = {};
config.placeholder = 'some value';
CKEDITOR.replace('description', config);
</script>
<script type="text/javascript">

$(function() {
    //$('#myTable').DataTable();
    $(".select2-container--default").css('width', '100%');
    //data_tabel('data_admin')
});

$('.select2').on('change', function() { // when the value changes
    $(this).valid(); // trigger validation on this element
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
            url: '/update_kelas',
            dataType: 'json',
            data: new FormData($("#form_add")[0]),
            processData: false,
            contentType: false,
            success: function(data) {
                if (data.code == 200) {
                    
                    show_toast(data.message, 1);
                } else {
                    show_toast(data.message, 0);
                }
                $("#save_add").css('display','');
                $("#loading_add").css('display','none');
            }
        });
    }
});
// apabila pilih role

</script>
@endsection
