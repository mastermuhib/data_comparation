@extends('layout.app')
@section('asset')
<link rel="stylesheet" type="text/css" href="{{URL::asset('assets')}}/vendors/css/forms/select/select2.min.css">
@endsection
@section('title', 'Master City')
@section('content')

<div class="row">
    <div class="col-lg-12 col-xxl-4">
        <!--begin::List Widget 9-->
        <div class="card card-custom card-stretch gutter-b">
            <!--begin::Header-->
            <div class="card-header align-items-center border-0 mt-2">
                <h5 class="text-dark font-weight-bold ml-3">List Obat</h5>
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
                                                        <th>Nama Obat</th>
                                                        <th>Terpakai</th>
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
var column = [
        { "data": "no" },
        { "data": "medicine" },
        { "data": "used" },
        { "data": "status" },
        { "data": "action" },
    ];

    function data_tabel(tabel) {
        if (tabel == 'data_medicine') {
            var nantable = $('#yourTable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "/"+tabel,
                    "dataType": "json",
                    "type": "POST",
                    "data": { _token: "{{csrf_token()}}" }
                },
                "columns": column,
                "bDestroy": true
            });
            return nantable;
        }
    }
 $(function() {
    //$('#yourTable').DataTable();
    $(".select2-container--default").css('width', '100%');
    data_tabel('data_medicine')
});


$(function(){ /* DOM ready */
    $(".country").on("change", function() {
        var country_id = this.value;
        country_change(country_id);
    });
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

$('#tambah').on("click", function() {
    // alert('tes')
    $("#hide_add").css('display', 'none');
    $("#show_add").css('display', '');
});
$('#batalkan').on("click", function() {
    $("#hide_add").css('display', '');
    $("#show_add").css('display', 'none');
});
// batalkan edit
$(document).off('click', '#batalkan3').on('click', '#batalkan3', function() {

    $("#titel_head").remove();
    $("#head_modul").append('<span id="titel_head">Tambah Data City</span>');
    $("#hide_add").css('display', '');
    $("#show_edit").css('display', 'none');
});

</script>
@endsection
