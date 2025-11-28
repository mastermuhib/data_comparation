<tr id="tr_{{$no}}" class="tr_siswa" data-no="{{$no}}">
    @if(Auth::guard('admin')->user()->id_scholl == null)
    <td>
        <select class="select2 form-control" id="id_scholl{{$no}}" no="{{$no}}" onchange="ChangeScholl('{{$no}}')" required>
            <option value="">--pilih--</option>
            @foreach($data_scholl as $ct)
            <option value="{{$ct->id}}">{{$ct->scholl_name}}</option>
            @endforeach
        </select>
    </td>
    <td>
        <select class="select2 form-control" id="id_class{{$no}}" no="{{$no}}" onchange="ChangeClass('{{$no}}')" required>
            <option value="">-- pilih ---</option>
        </select>
    </td>
    @else
    <td>
        <input type="hidden" id="id_class{{$no}}" value="{{Auth::guard('admin')->user()->id_scholl}}" no="{{$no}}">
        <select class="select2 form-control" id="id_class{{$no}}" onchange="ChangeClass('{{$no}}')" no="{{$no}}" required>
            <option value="">-- pilih ---</option>
            @foreach(DataClass(Auth::guard('admin')->user()->id_scholl) as $ct)
            <option value="{{$ct->id}}">{{$ct->name}}</option>
            @endforeach
        </select>
    </td>
    @endif
    <td>
        <select class="select2 form-control" id="id_student{{$no}}" no="{{$no}}" name="id_student[]" required>
            <option value="">-- pilih ---</option>
        </select>
    </td>
    <td>
        <a href="javascript:void(0)" onclick="DeleteStudent('{{$no}}')"><i class="fas fa-trash text-danger"></i></a>
    </td>
</tr>
<script src="{{URL::asset('assets')}}/vendors/js/forms/select/select2.full.min.js"></script>
<script src="{{URL::asset('assets')}}/js/scripts/forms/select/form-select2.js"></script>
<script type="text/javascript">
$(function() {
    //$('#myTable').DataTable();
    $(".select2-container--default").css('width', '100%');
});
</script>