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
                        <form class="form-horizontal" novalidate id="form_add">@csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama Sekolah</label>
                                        <input type="text" class="form-control form-control-lg required" id="lastName3" name="scholl_name" required value="{{$data->scholl_name}}" />
                                        <input type="hidden" name="id" value="{{$data->id}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email Sekolah</label>
                                        <input type="text" class="form-control form-control-lg required" id="lastName3" name="email" required value="{{$data->email}}"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>No Telp Sekolah</label>
                                        <input type="text" class="form-control form-control-lg required" id="lastName3" name="phone" required value="{{$data->phone}}"/>
                                    </div>
                                </div>
                                <div class="col-md-6" id="provinsi">
                                    <div class="form-group">
                                        <label class="control-label">Provinsi</label>
                                        <select class="select2 form-control province" required name="id_province">
                                            <option value="">pilih provinsi</option>
                                            @foreach($data_province as $v)
                                                @if($v->id == $data->id_province)
                                                    <option value="{{$v->id}}" selected>{{$v->name}}</option>
                                                @else
                                                    <option value="{{$v->id}}">{{$v->name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Kota</label>
                                        <select class="select2 form-control cities" required name="id_city">
                                            @if($data->id_city != 'null')
                                                @foreach(DataCity($data->id_province) as $k)
                                                    @if($k->id == $data->id_city)
                                                    <option value="{{$k->id}}" selected="">{{$k->name}}</option>
                                                    @else
                                                    <option value="{{$k->id}}">{{$k->name}}</option>
                                                    @endif
                                                @endforeach
                                            @else
                                            <option value="">-- Pilih Kota --</option>
                                            @endif   
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Kecamatan</label>
                                        <select class="select2 form-control districts" name="id_district" id="id_district">  
                                            @if($data->id_district != 'null')
                                                @foreach(DataDistrict($data->id_city) as $d)
                                                    @if($d->id == $data->id_district)
                                                    <option value="{{$d->id}}" selected="">{{$d->name}}</option>
                                                    @else
                                                    <option value="{{$d->id}}">{{$d->name}}</option>
                                                    @endif
                                                @endforeach
                                            @else
                                            <option value="">-- Pilih Kecamatan --</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Kode Pos</label>
                                        <input type="text" class="form-control form-control-lg required" id="lastName3" name="pos_code" required value="{{$data->pos_code}}" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <textarea class="form-control" id="searchLock" name="address" required placeholder="Jl." runat="server">{{$data->address}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Latitude</label>
                                        <input type="text" class="form-control form-control-lg" readonly id="latitude" name="latitude" value="{{$data->latitude}}" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Longitude</label>
                                        <input type="text" class="form-control form-control-lg" readonly id="longitude" name="longitude" value="{{$data->longitude}}" />
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
                                <div class="col-md-3">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <button type="submit" class="btn btn-primary mr-2 float-right">Submit</button>
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
$(function() {
    //$('#yourTable').DataTable();
    $(".select2-container--default").css('width', '100%');
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
        $.ajax({ //line 28
            type: 'POST',
            url: '/update_master_sekolah',
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

</script>
@endsection