@extends('layout.app')
@section('asset')
<link rel="stylesheet" type="text/css" href="{{URL::asset('assets')}}/vendors/css/forms/select/select2.min.css">
@endsection
@section('title', 'Master District')
@section('content')
<div class="form_edit_modul" id="show_edit">
</div>
<div class="row" id="show_add" style="display: none;">
    <div class="col-lg-12 col-xxl-4">
        <section class="multiple-validation">
            <div class="card mb-3">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form-horizontal"  id="form_add">@csrf
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama Sekolah</label>
                                        <input type="text" class="form-control form-control-lg required" id="lastName3" name="scholl_name" required />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email Sekolah</label>
                                        <input type="text" class="form-control form-control-lg required" id="lastName3" name="email" required/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>No Telp Sekolah</label>
                                        <input type="text" class="form-control form-control-lg required" id="lastName3" name="phone" required/>
                                    </div>
                                </div>
                                <div class="col-md-6" id="provinsi">
                                    <div class="form-group">
                                        <label class="control-label">Provinsi</label>
                                        <select class="select2 form-control province" required name="id_province">
                                            <option value="">pilih provinsi</option>
                                            @foreach($data_province as $v)
                                            <option value="{{$v->id}}">{{$v->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Kota</label>
                                        <select class="select2 form-control cities" required name="id_city">
                                            <option value=''>pilih kota</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Kecamatan</label>
                                        <select class="select2 form-control districts" name="id_district" id="id_district">  
                                        <option value=''>pilih kecamatan</option>  
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Kode Pos</label>
                                        <input type="text" class="form-control form-control-lg required" id="lastName3" name="pos_code" required/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <textarea class="form-control" id="searchLock" name="address" required placeholder="Jl." runat="server"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Latitude</label>
                                        <input type="text" readonly class="form-control form-control-lg" id="latitude" name="latitude"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Longitude</label>
                                        <input type="text" readonly class="form-control form-control-lg" id="longitude" name="longitude"/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                </div>
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-header text-center">
                                            Foto Profile
                                        </div>
                                        <div class="card-body text-center">
                                            
                                            <img id="profile_admin" src="https://souq-cms.trendcas.com/assets/imgs/theme/upload.svg" alt="your image" style="max-width: 200px;max-height: 200px;" />
                                            <label class="btn btn-white btn-sm mb-0 w-100 align-self-center">
                                                Upload File <input type="file" name="image" style="display: none;" onchange="gantiProfile_admin(this);">
                                            </label>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <button type="submit" class="btn btn-primary float-right" id="save_add">Submit</button>
                                    <button type="button" disabled class="btn btn-primary float-right" id="loading_add" style="display: none;">Loading....</button>
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
<div class="row">
    <div class="col-lg-12 col-xxl-4">
        <!--begin::List Widget 9-->
        <div class="card card-custom card-stretch gutter-b">
            <!--begin::Header-->
            <div class="card-header align-items-center border-0 mt-2">
                <h5 class="text-dark font-weight-bold ml-3">List Sekolah</h5>
                @if($akses->is_add == 1)
                <a class="btn btn-primary font-weight-bolder mr-3" id="tambah">Add Sekolah</a>
                @endif
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
                                            <table class="table zero-configuration" id="yourTable">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Name</th>
                                                        <th>City</th>
                                                        <th>Province</th>
                                                        <th>Status</th>
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
    </div>
</div>
@endsection
@section('js')
@include('components/componen_crud')
<!-- end -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAvTkPKa1jErT_Kh9ZPTIP2az48f8y0WGo&libraries=places"></script>
<script>
function initialize() {
    $("#searchLock").attr("placeholder","");
    var input = document.getElementById('searchLock');
    var autocomplete = new google.maps.places.Autocomplete(input);
    google.maps.event.addListener(autocomplete, 'place_changed',
        function() {
            var place = autocomplete.getPlace();
            var lat = place.geometry.location.lat();
            var lng = place.geometry.location.lng();
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;

        }
    );
}
google.maps.event.addDomListener(window, 'load', initialize);
var column = [
        { "data": "no" },
        { "data": "name" },
        { "data": "city" },
        { "data": "province" },
        { "data": "status" },
        { "data": "action" },
    ];

    function indexTable() {
        var is_edit  = $("#is_edit").val();
        var is_delete  = $("#is_delete").val();
        var nantable = $('#yourTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "/data_master_sekolah",
                "dataType": "json",
                "type": "POST",
                "data": { _token: "{{csrf_token()}}",is_edit:is_edit,is_delete:is_delete }
            },
            "columns": column,
            "bDestroy": true
        });
        return nantable;
    }
 $(function() {
    //$('#yourTable').DataTable();
    $(".select2-container--default").css('width', '100%');
    indexTable()
});

$(".province").on("change", function() {
    var prov_id = this.value;
    province_change(prov_id)
});

$(".cities").on("change", function() {
    var city_id = this.value;
    city_change(city_id)
});

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

function city_change(city_id) {
    // alert(country_id)
    $.ajax({
        type: 'GET',
        url: '/districts/' + city_id,
        dataType: 'json',
        success: function(data) {
            console.log(data)
            $(".districts").empty();
            $(".districts").append("<option value=''>Select District</option>");
            for (let i = 0; i < data.length; i++) {
                $(".districts").append("<option value=" + data[i].id + ">" + data[i].name + "</option>");
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
            url: '/post_master_sekolah',
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
                    indexTable()
                } else {
                    show_toast(data.message, 0);
                }
                $("#save_add").css('display','');
                $("#loading_add").css('display','none');
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
// batalkan edit
$(document).off('click', '#batalkan3').on('click', '#batalkan3', function() {

    $("#titel_head").remove();
    $("#head_modul").append('<span id="titel_head">Tambah Data District</span>');
    $("#hide_add").css('display', '');
    $("#show_edit").css('display', 'none');
});

</script>
@endsection
