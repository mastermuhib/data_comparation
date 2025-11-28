<tr class="pendidikan" data-id="{{$no}}" id="tr_pendidikan{{$no}}">
    <td width="10%">{{$no}} <input type="hidden" name="jumlah_jurusan[]" id="jumlah_jurusan{{$no}}" value="1"></td>
    <td width="40%">
       <select name="id_pendidikan[]" class="select-pendidikan select2" id="pend{{$no}}" no="{{$no}}" style="width: 100%"> 
           <option value="">Pilih Pendidikan</option>
           @foreach($data_pendidikan as $p)
              <option value="{{$p->id}}">{{$p->name}}</option>
           @endforeach
       </select>
    </td>
    <td width="45%" id="td_jur{{$no}}">
        <select name="id_jurusan[]" class="select2 select_jurusan" id="jur{{$no}}" no="{{$no}}" style="width: 100%" multiple>
            <option value="0" selected>Semua Jurusan</option>
        </select>  
    </td>
    
    <!-- <td width="30%" id="td_nilai{{$no}}">
        
    </td> -->
    <td width="10%" style="vertical-align: middle;">
         <a href="javascript:void(0)" class="hapus_pend" no="{{$no}}"><i class="fa fa-trash"></i></a> 
    </td>
</tr>