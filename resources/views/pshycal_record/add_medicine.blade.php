<div class="row div_medicine" data-no="{{$no}}" id="div_medicine{{$no}}">
    <div class="col-md-3 col-sm-12 mb-2">
        <div class="form-group">
            <label>Obat</label>
            <select class="select2 form-control" name="id_medicine[]" required>
                @foreach($medicines as $c)
                    <option value="{{$c->id}}">{{$c->medicine}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4 col-sm-12 mb-2">
        <div class="form-group">
            <label>Dosis</label>
            <input type="number" min="1" class="form-control" name="dosis[]" required>
        </div>
    </div>
    <div class="col-md-4 col-sm-12 mb-2">
        <div class="form-group">
            <label>Notes</label>
            <textarea name="notes[]" class="form-control"></textarea>
        </div>
    </div>
    <div class="col-md-1 mt-5">
        <a href="javascript:void(0)" onclick="DelMed('{{$no}}')"><i class="fas fa-trash"></i></a>
    </div>
</div>