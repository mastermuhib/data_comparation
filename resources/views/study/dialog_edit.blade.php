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
                                        <label class="control-label">Nama Pelajaran</label>
                                        <input type="text" name="study_name" class="form-control form-control-lg" placeholder="Name" required value="{{$data->study_name}}">
                                        <input type="hidden" name="id" value="{{$data->id}}">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Description</label>
                                        <fieldset class="form-label-group mb-0">
                                            <textarea data-length="2000" class="form-control char-textarea active summernote" id="description" rows="3" placeholder="Deskripsi" style="color: rgb(78, 81, 84);">{{$data->description}}</textarea>
                                        </fieldset>
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
<script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
<script type="text/javascript">
ClassicEditor.create( document.querySelector( '#description' ) )
            .then( editor => {
                console.log( editor );
            } ).catch( error => { console.error( error ); } );
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
        $.ajax({ //line 28
            type: 'POST',
            url: '/update_pelajaran',
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
