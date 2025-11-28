@extends('layout.app')
@section('asset')
<link rel="stylesheet" type="text/css" href="{{URL::asset('assets')}}/vendors/css/forms/select/select2.min.css">
@endsection
@section('title', 'Master District')
@section('content')
<!-- Pop Up Edit -->
<section class="multiple-validation" id="detail_edit">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form-horizontal" novalidate id="form_edit">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>District Name</label>
                                        <input type="text" class="form-control form-control-lg required" id="lastName3" name="name" value="{{$data->name}}">
                                        <input type="hidden" name="id" value="{{$data->id}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Country</label>
                                        <select class="select2 form-control country" required data-validation-required-message="Role Wajib diisi" name="country">
                                            <option value="">Select Country</option>
                                            @foreach($countries as $v)
                                            <option value="{{$v->id}}" <?php if ($v->id == $data->country_id) { echo "selected";} ?> >{{$v->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6" id="province_edit">
                                    <div class="form-group">
                                        <label class="control-label">Province</label>
                                        <select class="select2 form-control province" required data-validation-required-message="Role Wajib diisi" name="province">
                                            <option value=''>Select Province</option>
                                            @foreach($provinces as $v)
                                            <option value="{{$v->id}}" <?php if ($v->id == $data->province_id) { echo "selected";} ?> >{{$v->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">City</label>
                                        <select class="select2 form-control cities" required data-validation-required-message="Role Wajib diisi" name="city_id">
                                            <option value=''>Select City</option>
                                            @foreach($cities as $v)
                                            <option value="{{$v->id}}" <?php if ($v->id == $data->regency_id) { echo "selected";} ?> >{{$v->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <button type="button" class="btn btn-primary mr-2 float-right" id="kirim_edit">Submit</button>
                                    <button type="button" class="btn btn-danger float-right" id="batalkan3" style="margin-right: 10px">Cancel</button>
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
<!-- end -->
<script type="text/javascript">
$(function() {
    //$('#yourTable').DataTable();
    $(".select2-container--default").css('width', '100%');
});

$(".country").on("change", function() {
    var country_id = this.value;
    country_change(country_id)
});
$(".province").on("change", function() {
    var prov_id = this.value;
    province_change(prov_id)
});

function country_change(country_id) {
    // alert(country_id)
    $.ajax({
        type: 'GET',
        url: '/data_province/' + country_id,
        dataType: 'json',
        success: function(data) {
            console.log(data)
            $(".province").empty();
            $(".cities").empty().append("<option value=''>Select City</option>");
            $(".province").append("<option value=''>Select Province</option>");
            for (let i = 0; i < data.length; i++) {
                $(".province").append("<option value=" + data[i].id + ">" + data[i].name + "</option>");
            }
        },
        error: function(data) {
            console.log(data);
        }
    });
}

function province_change(prov_id) {
    // alert(country_id)
    $.ajax({
        type: 'GET',
        url: '/cities/' + prov_id,
        dataType: 'json',
        success: function(data) {
            console.log(data)
            $(".cities").empty();
            $(".cities").append("<option value=''>Select City</option>");
            for (let i = 0; i < data.length; i++) {
                $(".cities").append("<option value=" + data[i].id + ">" + data[i].name + "</option>");
            }
        },
        error: function(data) {
            console.log(data);
        }
    });
}

$('#tambah').on("click", function() {
    // alert('tes')
    $("#hide_add").css('display', 'none');
    $("#show_add").css('display', '');
});
$('#batalkan').on("click", function() {
    $("#hide_add").css('display', '');
    $("#show_add").css('display', 'none');
});

function select2_reset() {
    $.ajax({
        type: 'GET',
        url: '/countries',
        dataType: 'json',
        success: function(data) {
            console.log(data)
            $(".country").empty();
            $(".country").append("<option value=''>Select Country</option>");
            for (let i = 0; i < data.length; i++) {
                $(".country").append("<option value=" + data[i].id + ">" + data[i].name + "</option>");
            }
        }
    });
    $('.province').empty().append("<option value=''>Select Province</option>");
    $('.cities').empty().append("<option value=''>Select City</option>");
}

$(document).off('click', '#kirim_edit').on('click', '#kirim_edit', function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // var description = CKEDITOR.instances.edit_description.getData();
    // $("#isi_deskripsi2").val(description);
    $.ajax({ //line 28
        type: 'POST',
        url: '/update/master_district',
        dataType: 'json',
        data: new FormData($("#form_edit")[0]),
        processData: false,
        contentType: false,
        success: function(data) {
            //$("#modal_loading").modal('hide');
            //$(".modal-backdrop").remove();
            console.log(data)
            $(".edit-modal-data").modal('hide');
            if (data.code == 200) {
                
                show_toast(data.message, 1);
            }
        }
    });
});

$(document).off('click', '.edit_data').on('click', '.edit_data', function() {
    var id = $(this).attr('id');

    $("#detail_edit").remove();
    //alert("sini kan")
    $("#hide_add").css('display', 'none');
    $("#show_add").css('display', 'none');
    $("#titel_head").remove();
    $("#head_modul").append('<span id="titel_head">Edit Data District</span>');
    $.ajax({
        url: '/detail/master_district/' + id,
        type: "GET",
        success: function(response) {
            console.log(response);
            $(window).scrollTop(0);

            if (response) {
                $("#show_edit").html(response);
                $("#show_edit").css('display', '');
            }
            $('.select2').select2();
            $(".select2-container--default").css('width', '100%');
        }
    });
});
// batalkan edit
$(document).off('click', '#batalkan3').on('click', '#batalkan3', function() {

    $("#titel_head").remove();
    $("#head_modul").append('<span id="titel_head">Tambah Data District</span>');
    $("#hide_add").css('display', '');
    $("#show_edit").css('display', 'none');
});

</script>
@endsection