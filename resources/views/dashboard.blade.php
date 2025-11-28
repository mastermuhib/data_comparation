@extends('layout.app')
@section('asset')
<link rel="stylesheet" type="text/css" href="{{URL::asset('assets')}}/vendors/css/forms/select/select2.min.css">
<link rel="stylesheet" type="text/css" href="{{URL::asset('assets')}}/jqvmap.css">

@endsection
@section('title', 'Dashboard')
@section('content')
<!-- <div class="">
	<div class="card card-body" class="">
		<div class="row">
			<div class="col-md-5">
				<label class="label-control">
					Dari tanggal
				</label>
				<input type="hidden" name="start" id="tanggal_mulai" class="form-control form-control-lg" value="{{$start}}">
			</div>
			<div class="col-md-5">
				<label class="label-control">
					Sampai tanggal
				</label>
				<input type="hidden" name="end" id="tanggal_akhir" class="form-control form-control-lg" value="{{$end}}">
			</div>
            <div class="col-md-2">
                <button style="padding: 12px;margin-top: 25px;" type="button" id="FilterDash" class="btn btn-success btn-block"><i class="fas fa-filter"></i> FILTER</button>
            </div>
		</div>
	</div>
</div> -->

<input type="hidden" name="start" id="tanggal_mulai" class="form-control form-control-lg" value="{{$start}}">
<input type="hidden" name="end" id="tanggal_akhir" class="form-control form-control-lg" value="{{$end}}">


<div id="loading" class="card card-body text-center" style="background: white;">
    <img src="{{URL::asset('assets')}}/images/loading.gif"  class="text-center" style="text-align: center;width: 100%">
</div>
<div id="isi_html" class="tab-content tabcontent-border mt-5">
    
                
</div>

@endsection
@section('js')
@include('components/componen_crud')
<!-- scipt js -->
<script src="{{URL::asset('assets')}}/plugins/custom/flot/flot.bundle.js"></script>
<script src="{{URL::asset('assets')}}/js/pages/features/charts/apexcharts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
<!-- vmaps -->
<script src="{{URL::asset('assets')}}/jquery.vmap.js"></script>
<script src="{{URL::asset('assets')}}/maps/jquery.vmap.indonesia.js"></script>
<script type="text/javascript" src="{{URL::asset('assets')}}/maps/jquery.vmap.electioncolors.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script type="text/javascript">
$(function() {
    //$('#myTable').DataTable();
    $(".select2-container--default").css('width', '100%');
    ChangeDashboard();
});


$(document).off('click', '#FilterDash').on('click', '#FilterDash', function() {
    ChangeDashboard();
});




function ChangeDashboard(){
  //if(is_admin != 2) {
    $("#old").remove()
    $('#loading').css('display','');
    $('#isi_html').css('display','none');
    periode = $("#bdaymonth").val();
    id_scholl = $('select[name=id_scholl]').val();
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({ //line 28
        type    : 'POST',
        url     : '/get_dashboard',
        data    : { periode:periode, id_scholl:id_scholl },
        dataType: 'html',
        success: function(data) {
            //alert("cuuk");

            $('#isi_html').css('display','');
            $("#isi_html").html(data);
            $('#loading').css('display','none');
        }
    });
  //}
}
</script>
@endsection