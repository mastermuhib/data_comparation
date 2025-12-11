<div class="card" style="border:none">
  <div class="modal-header" style="background: linear-gradient(270.95deg, #aedef5 49.19%, #005685 100%);">
      <div class="col-md-12 text-center">
          <!-- <div class="symbol symbol-circle symbol-lg-100 mb-2 mt-2">
              <img src="{{base_img()}}{{$data[0]->profile}}" alt="image">
          </div> -->
          <label class="text-dark font-weight-bolder">Detail Peserta</label>
      </div>
      
  </div>
  <div class="modal-body" style="padding-top: 0px">
      <div class="card p-3" style="border: none;">
        <div class="text-center mt-0">
          <h2>{{$data[0]->participant_name}}</h2>
        </div>
          <div class="card p-3 mb-1" style="background:#F1F1F2;">
              <h5><i class="fas fa-user-shield"></i> Informasi Pribadi</h5>
              <table class="table bg-light p-3">
                  <tr id="">
                    <td width="30%" class="labele">Email</td>
                    <td width="3%">:</td>
                    <td width="67%">{{$data[0]->participant_email}}</td> 
                  </tr>
                  <tr>
                    <td width="30%" class="labele">No. Hp</td>
                    <td width="3%">:</td>
                    <td width="67%">{{$data[0]->participant_phone}}</td> 
                  </tr> 
                  <tr>
                    <td width="30%" class="labele">Tanggal Pendaftan</td>
                    <td width="3%">:</td>
                    <td width="67%">{{date('d F Y H:i',strtotime($data[0]->created_at))}}</td> 
                  </tr> 
                  <tr>
                    <td width="30%" class="labele">Perusahaan</td>
                    <td width="3%">:</td>
                    <td width="67%">{{$data[0]->company}}</td> 
                  </tr> 
                  <tr>
                    <td width="30%" class="labele">Posisi</td>
                    <td width="3%">:</td>
                    <td width="67%">{{$data[0]->position}}</td> 
                  </tr>  
              </table>
          </div>
          @if($tingkatan == 'undefined' || $tingkatan == 5 || $tingkatan == 1)
          <div class="card p-3 mb-1" style="background:#F1F1F2;">
              <div class="row">
                <div class="col-6">
                    <h5><i class="fas fa-graduation-cap"></i> Tingkat Pendidikan S1</h5>
                </div>
                <div class="col-6">
                  @if($tingkatan != 5 || $tingkatan == 'undefined')
                    @if($data[0]->is_approved == 0)
                    <button type="button" class="btn btn-block btn-primary btn-sm mb-3 approve" data-dismiss="modal" id="{{$data[0]->id}}1" style="border-radius: 125px;"><i class="flaticon-rotate"></i><span>Menunggu Approval</span></button>
                    @elseif($data[0]->is_approved == 1)
                    <button type="button" class="btn btn-block btn-danger btn-sm mb-3 batalkan" data-dismiss="modal" id="{{$data[0]->id}}1" status="Approve" style="border-radius: 125px;"><i class="fas fa-sync-alt"></i><span>Batalkan Approve</span></button>
                    @else
                    <button type="button" class="btn btn-block btn-danger btn-sm mb-3 batalkan" data-dismiss="modal" id="{{$data[0]->id}}1" status="Penolakan" style="border-radius: 125px;"><i class="fas fa-sync-alt"></i><span>Batalkan Penolakan</span></button>
                    @endif 
                  @endif
                </div>
              </div>
                <table class="table bg-light p-3" width="100%">
                    <tr>
                      <td width="30%" class="labele">NPM</td>
                      <td width="3%">:</td>
                      <td width="67%">{{$data[0]->nik}}</td> 
                    </tr>
                    <tr>
                      <td width="30%" class="labele">Tahun Masuk</td>
                      <td width="3%">:</td>
                      <td width="67%">{{$data[0]->entry_year}}</td> 
                    </tr>
                    <tr>
                      <td width="30%" class="labele">Tahun Lulus</td>
                      <td width="3%">:</td>
                      <td width="67%">{{$data[0]->graduated_year}}</td> 
                    </tr>
                    <tr>
                      <td width="30%" class="labele">Departement</td>
                      <td width="3%">:</td>
                      <td width="67%">{{DepartName($data[0]->id_departement)}}</td> 
                    </tr>
                    <tr>
                      <td width="30%" class="labele">Program Study</td>
                      <td width="3%">:</td>
                      <td width="67%">{{JurName($data[0]->id_majority)}}</td> 
                    </tr>
                </table>
          </div>
          @endif
          @if($data[0]->id_majority2 != null)
          @if($tingkatan == 'undefined' || $tingkatan == 5 || $tingkatan == 2)
          <div class="card p-3 mb-1" style="background:#F1F1F2;">
              <div class="row">
                <div class="col-6">
                    <h5><i class="fas fa-graduation-cap"></i> Tingkat Pendidikan S2</h5>
                </div>
                <div class="col-6">
                  @if($tingkatan != 5 || $tingkatan == 'undefined')
                    @if($data[0]->is_approved2 == 0)
                    <button type="button" class="btn btn-block btn-primary btn-sm mb-3 approve" data-dismiss="modal" id="{{$data[0]->id}}2" style="border-radius: 125px;"><i class="flaticon-rotate"></i><span>Menunggu Approval</span></button>
                    @elseif($data[0]->is_approved2 == 1)
                    <button type="button" class="btn btn-block btn-danger btn-sm mb-3 batalkan" data-dismiss="modal" id="{{$data[0]->id}}2" status="Approve" style="border-radius: 125px;"><i class="fas fa-sync-alt"></i><span>Batalkan Approve</span></button>
                    @else
                    <button type="button" class="btn btn-block btn-danger btn-sm mb-3 batalkan" data-dismiss="modal" id="{{$data[0]->id}}2" status="Penolakan" style="border-radius: 125px;"><i class="fas fa-sync-alt"></i><span>Batalkan Penolakan</span></button>
                    @endif 
                  @endif
                </div>
              </div>
                <table class="table bg-light p-3" width="100%">
                    <tr>
                      <td width="30%" class="labele">NPM</td>
                      <td width="3%">:</td>
                      <td width="67%">{{$data[0]->nik2}}</td> 
                    </tr>
                    <tr>
                      <td width="30%" class="labele">Tahun Masuk</td>
                      <td width="3%">:</td>
                      <td width="67%">{{$data[0]->entry_year2}}</td> 
                    </tr>
                    <tr>
                      <td width="30%" class="labele">Tahun Lulus</td>
                      <td width="3%">:</td>
                      <td width="67%">{{$data[0]->graduated_year2}}</td> 
                    </tr>
                    <tr>
                      <td width="30%" class="labele">Departement</td>
                      <td width="3%">:</td>
                      <td width="67%">{{DepartName($data[0]->id_departement2)}}</td> 
                    </tr>
                    <tr>
                      <td width="30%" class="labele">Program Study</td>
                      <td width="3%">:</td>
                      <td width="67%">{{JurName($data[0]->id_majority2)}}</td> 
                    </tr>
                </table>
          </div>
          @endif
          @endif
          @if($data[0]->id_majority3 != null)
          @if($tingkatan == 'undefined' || $tingkatan == 5 || $tingkatan == 3)
          <div class="card p-3 mb-1" style="background:#F1F1F2;">
              <div class="row">
                <div class="col-6">
                    <h5><i class="fas fa-graduation-cap"></i> Tingkat Pendidikan S3</h5>
                </div>
                <div class="col-6">
                  @if($tingkatan != 5 || $tingkatan == 'undefined')
                    @if($data[0]->is_approved3 == 0)
                    <button type="button" class="btn btn-block btn-primary btn-sm mb-3 approve" data-dismiss="modal" id="{{$data[0]->id}}3" style="border-radius: 125px;"><i class="flaticon-rotate"></i><span>Menunggu Approval</span></button>
                    @elseif($data[0]->is_approved3 == 1)
                    <button type="button" class="btn btn-block btn-danger btn-sm mb-3 batalkan" data-dismiss="modal" id="{{$data[0]->id}}3" status="Approve" style="border-radius: 125px;"><i class="fas fa-sync-alt"></i><span>Batalkan Approve</span></button>
                    @else
                    <button type="button" class="btn btn-block btn-danger btn-sm mb-3 batalkan" data-dismiss="modal" id="{{$data[0]->id}}3" status="Penolakan" style="border-radius: 125px;"><i class="fas fa-sync-alt"></i><span>Batalkan Penolakan</span></button>
                    @endif
                  @endif 
                </div>
              </div>
                <table class="table bg-light p-3" width="100%">
                    <tr>
                      <td width="30%" class="labele">NPM</td>
                      <td width="3%">:</td>
                      <td width="67%">{{$data[0]->nik3}}</td> 
                    </tr>
                    <tr>
                      <td width="30%" class="labele">Tahun Masuk</td>
                      <td width="3%">:</td>
                      <td width="67%">{{$data[0]->entry_year3}}</td> 
                    </tr>
                    <tr>
                      <td width="30%" class="labele">Tahun Lulus</td>
                      <td width="3%">:</td>
                      <td width="67%">{{$data[0]->graduated_year3}}</td> 
                    </tr>
                    <tr>
                      <td width="30%" class="labele">Departement</td>
                      <td width="3%">:</td>
                      <td width="67%">{{DepartName($data[0]->id_departement3)}}</td> 
                    </tr>
                    <tr>
                      <td width="30%" class="labele">Program Study</td>
                      <td width="3%">:</td>
                      <td width="67%">{{JurName($data[0]->id_majority3)}}</td> 
                    </tr>
                </table>
          </div>
          @endif
          @endif
          <div class="card p-3 mb-1" style="background:#F1F1F2;">
              <h5><i class="fab fa-instagram-square"></i> Alamat</h5>
              <table class="table bg-light p-3" width="100%">
                  <tr>
                    <td width="30%" class="labele">Negara</td>
                    <td width="3%">:</td>
                    <td width="67%">{{$data[0]->negara}}</td> 
                  </tr>  
                  @if($data[0]->id_country == 1)
                  <tr>
                    <td width="30%" class="labele">Provinsi</td>
                    <td width="3%">:</td>
                    <td width="67%">{{$data[0]->provinsi}}</td> 
                  </tr>
                  <tr>
                    <td width="30%" class="labele">Kota / Kabupaten</td>
                    <td width="3%">:</td>
                    <td width="67%">{{$data[0]->kota}}</td> 
                  </tr>
                  <tr>
                    <td width="30%" class="labele">Kecamatan</td>
                    <td width="3%">:</td>
                    <td width="67%">{{$data[0]->district}}</td> 
                  </tr>
                  @endif
                  <tr>
                    <td width="30%" class="labele">Kode Pos</td>
                    <td width="3%">:</td>
                    <td width="67%">{{$data[0]->pos_code}}</td> 
                  </tr>
                  <tr>
                    <td width="30%" class="labele">Alamat</td>
                    <td width="3%">:</td>
                    <td width="67%">{{$data[0]->address}}</td> 
                  </tr>
              </table>
          </div>
      </div>
    </div>
    <div class="" style="background: linear-gradient(270.95deg, #aedef5 49.19%, #005685 100%);border-bottom-right-radius: 7px;
    border-bottom-left-radius: 7px;
    padding: 20px;">
        <div class="row">
          @if($tingkatan != 5)
            <div class="col-md-12">
                <button type="button" class="btn btn-block btn-primary btn-sm mt-3" data-dismiss="modal" style="border-radius: 125px;"><span>Tutup</span></button>
            </div>
          @else
            <div class="col-md-6">
               <button id="{{$data[0]->id}}" class="btn btn-success btn-block aksi mt-3" type="button" data="data_participant" aksi="approve_otp" tujuan="participant" data-dismiss="modal" style="border-radius: 125px;"><span class="navi-icon"><i class="fas fa-hand-point-right"></i></span><span class="navi-text">Approve OTP</span></button>
            </div>
            <div class="col-md-6">
                <button type="button" class="btn btn-block btn-primary mt-3" data-dismiss="modal" style="border-radius: 125px;"><span>Tutup</span></button>
            </div>
          @endif
        </div>                
    </div>
  </div>
