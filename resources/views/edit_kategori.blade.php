<!-- Pop Up Edit -->
<section class="multiple-validation" id="detail_edit">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-5">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form-horizontal p-3" novalidate id="form_edit">
                            <div class="row">
                            <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label">Name</label>
                                        <input value="{{$data->id}}" type="hidden" name="id">
                                        <input value="{{$data->name}}" type="text" name="name" class="form-control form-control-lg" placeholder="Name" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Photo</label>
                                        <input type="file" class="form-control form-control-lg mb-4" name="foto" id="inputfoto" onchange="readURL(this);">
                                        @if($data->icon == null)
                                        <img id="blah" src="{{base_img()}}3jVwF5DKCHPE50f5sNCMQNarnVT6WRxrYUy1lAJr.png" alt="your image" style="max-width: 200px;max-height: 200px;" />
                                        @else
                                        <img id="blah" src="{{base_img()}}{{$data->icon}}" alt="your image" style="max-width: 200px;max-height: 200px;" />
                                        @endif
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
<!-- End Pop Up Edit -->
