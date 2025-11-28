<div class="row">
	@foreach($data as $k=>$v)
    <div class="checkbox-inline col-md-3 pb-5" id="div_pilih_user{{$v->id}}">
        <label class="checkbox checkbox-square checkbox-primary">
        <input type="checkbox" class="pilih_user" no="{{$v->id}}" nama="{{$v->user_name}}">{{$v->user_name}} - ({{$v->nik}})
        <span></span></label>
    </div>
    @endforeach
</div>