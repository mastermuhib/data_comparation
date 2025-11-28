@if ($data_pendidikan->slug == 'sd' || $data_pendidikan->slug == 'smp')
<input type="hidden" name="id_jurusan[]" value="0">
@else
<select name="id_jurusan[]" class="select2 select_jurusan" id="jur{{$no}}" no="{{$no}}" style="width: 100%" multiple>
   <option value="0" selected>Semua Jurusan</option>
   @foreach($data_jurusan as $p)
      <option value="{{$p->id}}">{{$p->name}}</option>
   @endforeach       
</select> 
@endif