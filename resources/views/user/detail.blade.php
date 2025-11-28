<div class="card" style="border:none">
  <div class="modal-header" style="background: linear-gradient(270.95deg, #aedef5 49.19%, #005685 100%);">
      <div class="col-md-12 text-center">
          <div class="symbol-lg-100 mb-2 mt-2">
              <img src="{{URL::asset('assets')}}/images/ipeka.png" alt="image" style="width: 20%;">
          </div>
      </div>
      
  </div>
  <div class="modal-body" style="padding-top: 0px">
      <div class="card p-3" style="border: none;">
          <div class="card p-3 mb-1" style="background:#F1F1F2;">
              <div class="row">
                <div class="col-6">
                    <h5><i class="fas fa-user"></i> Data User</h5>
                </div>
                <div class="col-6">
                </div>
              </div>
              <form method="POST" class="form-horizontal p-3" id="form_edit">@csrf
                <table class="table bg-light p-3" width="100%">
                    <tr>
                      <td width="30%" class="labele">Nama User</td>
                      <td width="3%">:</td>
                      <td width="67%">
                        <input type="text" class="form-control form-control-lg" name="user_name" value="{{$data->user_name}}">
                        <input type="hidden" name="id" value="{{$data->id}}">
                      </td> 
                    </tr>
                    <tr>
                        <td width="30%" class="labele">No NIK</td>
                        <td width="3%">:</td>
                        <td width="67%">
                          <input type="text" class="form-control form-control-lg" name="nik" value="{{$data->nik}}">
                      </td>
                    </tr>
                    <tr>
                      <td width="30%" class="labele">Email</td>
                      <td width="3%">:</td>
                      <td width="67%">
                        <input type="text" class="form-control form-control-lg" name="user_email" value="{{$data->user_email}}">
                      </td> 
                    </tr>
                    <tr>
                        <td width="30%" class="labele">Phone</td>
                        <td width="3%">:</td>
                        <td width="67%">
                          <input type="text" class="form-control form-control-lg" name="user_phone" value="{{$data->user_phone}}">
                      </td> 
                    </tr>
                    <tr>
                      <td width="30%" class="labele">Jenis kelamin</td>
                      <td width="3%">:</td>
                      <td width="67%">
                          <select class="form-control form-control-lg" name="gender">
                              <option value="">Pilih Jenis Kelamin</option>
                              <option value="1" <?php if ($data->gender == 1) {
                                echo "selected";
                              } ?>>Laki - Laki</option>
                              <option value="2" <?php if ($data->gender == 2) {
                                echo "selected";
                              } ?>>Perempuan</option>
                          </select>
                      </td> 
                    </tr>
                    <tr>
                        <td width="30%" class="labele">Alamat</td>
                        <td width="3%">:</td>
                        <td width="67%">
                          <textarea class="form-control form-control-lg" name="address">{{$data->address}}</textarea>
                      </td> 
                    </tr> 
                </table>
              </form> 
          </div>
      </div>
    </div>
    <div class="" style="background: linear-gradient(270.95deg, #aedef5 49.19%, #005685 100%);border-bottom-right-radius: 7px;
    border-bottom-left-radius: 7px;
    padding: 20px;">
        <div class="row">
            <div class="col-md-6">
                <button type="button" class="btn btn-block btn-success mt-3" id="save_edit" style="border-radius: 125px;"><span><i class="fas fa-save"></i>Simpan</span></button>
            </div>
            <div class="col-md-6">
                <button type="button" class="btn btn-block btn-primary mt-3" data-dismiss="modal" style="border-radius: 125px;"><span>Tutup</span></button>
            </div>
        </div>                
    </div>
  </div>