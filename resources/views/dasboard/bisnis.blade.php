
<div class="tab-content tabcontent-border mt-5">
<div class="tab-pane active" id="coorporate" role="tabpanel">
        <!-- hari ini -->
       <div style="margin-top: 5px"></div>
        <h4>Total</h4>
        <div class="row">
            <div class="col-lg-3">
                <div style="margin-bottom: 30px">

                    <div class="bg-white text-center rounded-xl">
                        <div class="p-3">
                            <h3 class="font-weight-bold">{{ number_format($bisnis_active) }}</h3>
                            <a href="#" class="text-dark-75 font-weight-bold font-size-h6">Pendaftar</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="row">
                <!-- tabel1 samping -->
                    <div style="margin-bottom: 30px" class="col-lg-3">

                        <div class="bg-white text-center rounded-xl">
                            <div class="p-3">
                                <h3 class="font-weight-bold">{{ number_format($bisnis_verifikasi) }}</h3>
                                <a href="#" class="text-dark-75 font-weight-bold font-size-h6">Verified</a>
                            </div>
                        </div>
                    </div>
                    <!-- tabel2 samping -->
                    <div style="margin-bottom: 30px" class="col-lg-3">
                        <div class="bg-white text-center rounded-xl">
                            <div class="p-3">
                                <h3 class="font-weight-bold">{{ number_format($jumlah_lowongan) }}</h3>
                                <a href="#" class="text-dark-75 font-weight-bold font-size-h6">Lowongan</a>
                            </div>
                        </div>
                    
                    </div>
                    <!-- Tabel3 samping -->
                    <div style="margin-bottom: 30px" class="col-lg-3">

                        <div class="bg-white text-center rounded-xl">
                            <div class="p-3">
                                <h3 class="font-weight-bold">{{ number_format($posisi_lowongan) }}</h3>
                                <a href="#" class="text-dark-75 font-weight-bold font-size-h6">Posisi</a>
                            </div>
                        </div>

                    </div>
                    <!-- Tabel4 samping -->
                    <div style="margin-bottom: 30px" class="col-lg-3">

                        <div class="bg-white text-center rounded-xl">
                            <div class="p-3">
                                <h3 class="font-weight-bold">{{ number_format($seleksi_lowongan) }}</h3>
                                <a href="#" class="text-dark-75 font-weight-bold font-size-h6">Terseleksi</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>   
        </div>
        <!-- baris2 bawah -->
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card card-custom bg-white card-stretch gutter-b">
                    <!--begin::Body-->
                    <div class="card-body my-4">
                        <a href="#" class="card-title font-weight-bolder text-dark-75 font-size-h6 mb-4 text-hover-state-dark d-block">Lamaran Terkirim</a>
                        <div class="font-weight-bold text-muted font-size-sm">
                        <span class="text-dark-75 font-weight-bolder font-size-h2 mr-2">{{number_format($lowongan_terkirim)}}</span>{{$persen_lamaran_terkirim}} % Konversi</div>
                        <div class="progress progress-xs mt-7 bg-primary-o-60">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $persen_lamaran_terkirim.'%'?>;" aria-valuenow="{{$persen_lamaran_terkirim}}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <!--end::Body-->
                </div>
            </div>
            <!-- kolom2 samping -->
            <div class="col-lg-4 mb-4">
                <div class="card card-custom bg-white card-stretch gutter-b">
                    <!--begin::Body-->
                    <div class="card-body my-4">
                        <a href="#" class="card-title font-weight-bolder text-dark-75 font-size-h6 mb-4 text-hover-state-dark d-block">Panggilan</a>
                        <div class="font-weight-bold text-muted font-size-sm">
                        <span class="text-dark-75 font-weight-bolder font-size-h2 mr-2">{{ number_format($panggilan) }}</span>{{$persen_panggilan}} % Konversi</div>
                        <div class="progress progress-xs mt-7 bg-success-o-60">
                            <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $persen_panggilan.'%'?>;" aria-valuenow="{{$persen_panggilan}}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <!--end::Body-->
                </div>
            </div>
            <!-- kolom4 samping -->
            <div  class="col-lg-4 mb-4">
                <div class="card card-custom bg-white card-stretch gutter-b">
                    <!--begin::Body-->
                    <div class="card-body my-4">
                        <a href="#" class="card-title font-weight-bolder text-dark-75 font-size-h6 mb-4 text-hover-state-dark d-block">Penerimaan</a>
                        <div class="font-weight-bold text-dark-75 font-size-sm">
                        <span class="font-size-h2 mr-2">{{number_format($diterima_kerja)}}</span>{{$persen_diterima}} % Konversi</div>
                        <div class="progress progress-xs mt-7 bg-warning-o-90">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $persen_diterima.'%'?>;" aria-valuenow="{{$persen_diterima}}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <!--end::Body-->
                </div>
            </div>
        </div>
        <!-- ===================================================== -->
        <div style="margin-top: 5px"></div>
        <h4>Bulan ini</h4>

        <div class="row">
            <div class="col-lg-3">
                <div style="margin-bottom: 30px">

                    <div class="bg-white text-center rounded-xl">
                        <div class="p-3">
                            <h3 class="font-weight-bold">{{ number_format($bisnis_active_bulan) }}</h3>
                            <a href="#" class="text-dark-75 font-weight-bold font-size-h6">Pendaftar</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="row">
                <!-- tabel1 samping -->
                    <div style="margin-bottom: 30px" class="col-lg-3">

                        <div class="bg-white text-center rounded-xl">
                            <div class="p-3">
                                <h3 class="font-weight-bold">{{ number_format($bisnis_verifikasi_bulan) }}</h3>
                                <a href="#" class="text-dark-75 font-weight-bold font-size-h6">Verified</a>
                            </div>
                        </div>
                    </div>
                    <!-- tabel2 samping -->
                    <div style="margin-bottom: 30px" class="col-lg-3">
                        <div class="bg-white text-center rounded-xl">
                            <div class="p-3">
                                <h3 class="font-weight-bold">{{ number_format($jumlah_lowongan_bulan) }}</h3>
                                <a href="#" class="text-dark-75 font-weight-bold font-size-h6">Lowongan</a>
                            </div>
                        </div>
                    
                    </div>
                    <!-- Tabel3 samping -->
                    <div style="margin-bottom: 30px" class="col-lg-3">

                        <div class="bg-white text-center rounded-xl">
                            <div class="p-3">
                                <h3 class="font-weight-bold">{{ number_format($posisi_lowongan_bulan) }}</h3>
                                <a href="#" class="text-dark-75 font-weight-bold font-size-h6">Posisi</a>
                            </div>
                        </div>

                    </div>
                    <!-- Tabel4 samping -->
                    <div style="margin-bottom: 30px" class="col-lg-3">

                        <div class="bg-white text-center rounded-xl">
                            <div class="p-3">
                                <h3 class="font-weight-bold">{{ number_format($seleksi_lowongan_bulan) }}</h3>
                                <a href="#" class="text-dark-75 font-weight-bold font-size-h6">Terseleksi</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>   
            <!-- BULAN -->
        </div>
        <!-- baris2 bawah -->
        <div class="row">
            <div style="margin-bottom: 30px" class="col-lg-4">

                <div class="card card-custom bg-white card-stretch gutter-b">
                    <!--begin::Body-->
                    <div class="card-body my-4">
                        <a href="#" class="card-title font-weight-bolder text-dark-75 font-size-h6 mb-4 text-hover-state-dark d-block">Lamaran Terkirim</a>
                        <div class="font-weight-bold text-muted font-size-sm">
                        <span class="text-dark-75 font-weight-bolder font-size-h2 mr-2">{{number_format($seleksi_lowongan_bulan)}}</span>{{$persen_lamaran_terkirim_bulan}} % Konversi</div>
                        <div class="progress progress-xs mt-7 bg-primary-o-60">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $persen_lamaran_terkirim_bulan.'%'?>;" aria-valuenow="{{$persen_lamaran_terkirim_bulan}}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <!--end::Body-->
                </div>

            </div>
            <!-- kolom2 samping -->
            <div style="margin-bottom: 30px" class="col-lg-4">

                <div class="card card-custom bg-white card-stretch gutter-b">
                    <!--begin::Body-->
                    <div class="card-body my-4">
                        <a href="#" class="card-title font-weight-bolder text-dark-75 font-size-h6 mb-4 text-hover-state-dark d-block">Panggilan</a>
                        <div class="font-weight-bold text-muted font-size-sm">
                        <span class="text-dark-75 font-weight-bolder font-size-h2 mr-2">{{ number_format($panggilan_bulan) }}</span>{{$persen_panggilan_bulan}} Konversi</div>
                        <div class="progress progress-xs mt-7 bg-success-o-60">
                            <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $persen_panggilan_bulan.'%'?>;" aria-valuenow="{{$persen_panggilan_bulan}}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <!--end::Body-->
                </div>
            </div>
            <!-- kolom4 samping -->
            <div style="margin-bottom: 30px" class="col-lg-4">


                <div class="card card-custom bg-white card-stretch gutter-b">
                    <!--begin::Body-->
                    <div class="card-body my-4">
                        <a href="#" class="card-title font-weight-bolder text-dark-75 font-size-h6 mb-4 text-hover-state-dark d-block">Penerimaan</a>
                        <div class="font-weight-bold text-dark-75 font-size-sm">
                        <span class="font-size-h2 mr-2">{{number_format($diterima_kerja_bulan)}}</span>{{$persen_diterima_bulan}} Konversi</div>
                        <div class="progress progress-xs mt-7 bg-warning-o-90">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $persen_diterima_bulan.'%'?>;" aria-valuenow="{{$persen_diterima_bulan}}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <!--end::Body-->
                </div>

            </div>
        </div>

        <!--========================================= -->
        <div style="margin-top: 5px"></div>
        <h4>Hari</h4>

         <div class="row">
            <div class="col-lg-3">
                <div style="margin-bottom: 30px">

                    <div class="bg-white text-center rounded-xl">
                        <div class="p-3">
                            <h3 class="font-weight-bold">{{ number_format($bisnis_active_hari) }}</h3>
                            <a href="#" class="text-dark-75 font-weight-bold font-size-h6">Pendaftar</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="row">
                <!-- tabel1 samping -->
                    <div style="margin-bottom: 30px" class="col-lg-3">

                        <div class="bg-white text-center rounded-xl">
                            <div class="p-3">
                                <h3 class="font-weight-bold">{{ number_format($bisnis_verifikasi_hari) }}</h3>
                                <a href="#" class="text-dark-75 font-weight-bold font-size-h6">Verified</a>
                            </div>
                        </div>
                    </div>
                    <!-- tabel2 samping -->
                    <div style="margin-bottom: 30px" class="col-lg-3">
                        <div class="bg-white text-center rounded-xl">
                            <div class="p-3">
                                <h3 class="font-weight-bold">{{ number_format($jumlah_lowongan_hari) }}</h3>
                                <a href="#" class="text-dark-75 font-weight-bold font-size-h6">Lowongan</a>
                            </div>
                        </div>
                    
                    </div>
                    <!-- Tabel3 samping -->
                    <div style="margin-bottom: 30px" class="col-lg-3">

                        <div class="bg-white text-center rounded-xl">
                            <div class="p-3">
                                <h3 class="font-weight-bold">{{ number_format($posisi_lowongan_hari) }}</h3>
                                <a href="#" class="text-dark-75 font-weight-bold font-size-h6">Posisi</a>
                            </div>
                        </div>

                    </div>
                    <!-- Tabel4 samping -->
                    <div style="margin-bottom: 30px" class="col-lg-3">

                        <div class="bg-white text-center rounded-xl">
                            <div class="p-3">
                                <h3 class="font-weight-bold">{{ number_format($seleksi_lowongan_hari) }}</h3>
                                <a href="#" class="text-dark-75 font-weight-bold font-size-h6">Terseleksi</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>   
            <!-- BULAN -->
        </div>
        <!-- baris2 bawah -->
        <div class="row">
            <div style="margin-bottom: 30px" class="col-lg-4">

                <div class="card card-custom bg-white card-stretch gutter-b">
                    <!--begin::Body-->
                    <div class="card-body my-4">
                        <a href="#" class="card-title font-weight-bolder text-dark-75 font-size-h6 mb-4 text-hover-state-dark d-block">Lamaran Terkirim</a>
                        <div class="font-weight-bold text-muted font-size-sm">
                        <span class="text-dark-75 font-weight-bolder font-size-h2 mr-2">{{number_format($seleksi_lowongan_hari)}}</span>{{$persen_lamaran_terkirim_hari}} Konversi</div>
                        <div class="progress progress-xs mt-7 bg-primary-o-60">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $persen_lamaran_terkirim_hari.'%'?>;" aria-valuenow="{{$persen_lamaran_terkirim_hari}}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <!--end::Body-->
                </div>

            </div>
            <!-- kolom2 samping -->
            <div style="margin-bottom: 30px" class="col-lg-4">

                <div class="card card-custom bg-white card-stretch gutter-b">
                    <!--begin::Body-->
                    <div class="card-body my-4">
                        <a href="#" class="card-title font-weight-bolder text-dark-75 font-size-h6 mb-4 text-hover-state-dark d-block">Panggilan</a>
                        <div class="font-weight-bold text-muted font-size-sm">
                        <span class="text-dark-75 font-weight-bolder font-size-h2 mr-2">{{ number_format($panggilan_hari) }}</span>{{$persen_panggilan_hari}} Konversi</div>
                        <div class="progress progress-xs mt-7 bg-success-o-60">
                            <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $persen_panggilan_hari.'%'?>;" aria-valuenow="{{$persen_panggilan_hari}}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <!--end::Body-->
                </div>
            </div>
            <!-- kolom4 samping -->
            <div style="margin-bottom: 30px" class="col-lg-4">


                <div class="card card-custom bg-white card-stretch gutter-b">
                    <!--begin::Body-->
                    <div class="card-body my-4">
                        <a href="#" class="card-title font-weight-bolder text-dark-75 font-size-h6 mb-4 text-hover-state-dark d-block">Penerimaan</a>
                        <div class="font-weight-bold text-dark-75 font-size-sm">
                        <span class="font-size-h2 mr-2">{{number_format($diterima_kerja_hari)}}</span>{{$persen_diterima_hari}} Konversi</div>
                        <div class="progress progress-xs mt-7 bg-warning-o-90">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $persen_diterima_hari.'%'?>;" aria-valuenow="{{$persen_diterima_hari}}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <!--end::Body-->
                </div>

            </div>
        </div>


         
        <!-- Tampilan Garfik1-->
        <!--end::Card-->
        
        <div class="row">
            <div class="col-md-12">
                <label>Grafik Bisnis Bulanan</label>
                <figure class="highcharts-figure">
                    <div id="container"></div>
                </figure>
            </div>
        </div>  
        <div class="row">
            <div class="col-md-12">
                <label>Grafik Lowongan Bulanan</label>
                <figure class="highcharts-figure">
                    <div id="container2"></div>
                </figure>
            </div>
        </div>  
        <div class="row">
            <div class="col-lg-12">
                <!--begin::Mixed Widget 1-->
                <div class="card card-custom bg-gray-100 card-stretch gutter-b">
                    <!--begin::Header-->
                    <div class="card-header border-0 bg-danger py-2" style="background-color: #3F99F7 !important;">
                        <h3 class="card-title font-weight-bolder text-white-red">Tabel Lowongan Bulanan</h3>
                        <div class="card-toolbar">
                            <div class="dropdown dropdown-inline">
                                
                                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right" style="">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body p-0 position-relative overflow-hidden table-responsive">
                        <table class="table" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    @for($i = 0;$i < count($time);$i++)
                                    <th scope="col">{{$time[$i]}}</th>
                                    @endfor
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 0; ?>
                                @for($d = 0;$d < count($data_graph_prod2);$d++)
                                    <?php $no = $no + 1; ?>
                                    <tr>
                                        <th scope="col">{{$data_graph_prod2[$d]['name']}}</th>
                                        @for($k = 0;$k < count($data_graph_prod2[$d]['data']);$k++)
                                        <td scope="row" style="font-size: 12px;">{{number_format($data_graph_prod2[$d]['data'][$k])}}</td>
                                        @endfor
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    <div class="resize-triggers"><div class="expand-trigger"><div style="width: 359px; height: 515px;"></div></div><div class="contract-trigger"></div></div></div>
                    <!--end::Body-->
                </div>
                <!--end::Mixed Widget 1-->
            </div>
        </div>  
        <div class="row mt-5">
            <!-- top Lowongan -->
            <div class="col-lg-4">
                <!--begin::Mixed Widget 1-->
                <div class="card card-custom bg-gray-100 card-stretch gutter-b">
                    <!--begin::Header-->
                    <div class="card-header border-0 bg-danger py-2" style="background-color: #3F99F7 !important;">
                        <h3 class="card-title font-weight-bolder text-white-red">Top 10 Lowongan</h3>
                        <div class="card-toolbar">
                            <div class="dropdown dropdown-inline">
                                
                                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right" style="">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body p-0 position-relative overflow-hidden">
                        <table class="table" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama Bisnis</th>
                                    <th scope="col">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 0; ?>
                                @foreach($top_lowongan as $t=>$v)
                                    <?php $no = $no + 1; ?>
                                    <tr>
                                        <td scope="row" style="font-size: 12px;">{{$no}}</td>
                                        <td scope="col" style="font-size: 12px;">{{$v->name}}</td>
                                        <td scope="col" style="font-size: 12px;text-align: center;">{{$v->total}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    <div class="resize-triggers"><div class="expand-trigger"><div style="width: 359px; height: 515px;"></div></div><div class="contract-trigger"></div></div></div>
                    <!--end::Body-->
                </div>
                <!--end::Mixed Widget 1-->
            </div>
            <!-- top posisi -->
            <div class="col-lg-4">
                <!--begin::Mixed Widget 1-->
                <div class="card card-custom bg-gray-100 card-stretch gutter-b">
                    <!--begin::Header-->
                    <div class="card-header border-0 bg-danger py-2" style="background-color: #3F99F7 !important;">
                        <h3 class="card-title font-weight-bolder text-white-red">Top 10 Posisi</h3>
                        <div class="card-toolbar">
                            <div class="dropdown dropdown-inline">
                                
                                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right" style="">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body p-0 position-relative overflow-hidden">
                        <table class="table" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama Bisnis</th>
                                    <th scope="col">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 0; ?>
                                @foreach($top_posisi as $t=>$v)
                                    <?php $no = $no + 1; ?>
                                    <tr>
                                        <td scope="row" style="font-size: 12px;">{{$no}}</td>
                                        <td scope="col" style="font-size: 12px;">{{$v->name}}</td>
                                        <td scope="col" style="font-size: 12px;text-align: center;">{{$v->total}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    <div class="resize-triggers"><div class="expand-trigger"><div style="width: 359px; height: 515px;"></div></div><div class="contract-trigger"></div></div></div>
                    <!--end::Body-->
                </div>
                <!--end::Mixed Widget 1-->
            </div>
            <!-- top penerimaan -->
            <div class="col-lg-4">
                <!--begin::Mixed Widget 1-->
                <div class="card card-custom bg-gray-100 card-stretch gutter-b">
                    <!--begin::Header-->
                    <div class="card-header border-0 bg-danger py-2" style="background-color: #3F99F7 !important;">
                        <h3 class="card-title font-weight-bolder text-white-red">Top 10 Penerimaan</h3>
                        <div class="card-toolbar">
                            <div class="dropdown dropdown-inline">
                                
                                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right" style="">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body p-0 position-relative overflow-hidden table-responsive">
                        <table class="table" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama Bisnis</th>
                                    <th scope="col">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 0; ?>
                                @foreach($top_penerimaan as $t=>$v)
                                    <?php $no = $no + 1; ?>
                                    <tr>
                                        <td scope="row" style="font-size: 12px;">{{$no}}</td>
                                        <td scope="col" style="font-size: 12px;">{{$v->name}}</td>
                                        <td scope="col" style="font-size: 12px;text-align: center;">{{$v->total}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    <div class="resize-triggers"><div class="expand-trigger"><div style="width: 359px; height: 515px;"></div></div><div class="contract-trigger"></div></div></div>
                    <!--end::Body-->
                </div>
                <!--end::Mixed Widget 1-->
            </div>
        </div>        
</div>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script type="text/javascript">

    // highcart
    Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Grafik Bisnis Bulanan'
    },
    subtitle: {
        text: 'kandidat'
    },
    xAxis: {
        categories: <?php echo json_encode($time); ?>,
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'jumlah (piece)'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: <?php echo json_encode($data_graph_prod1); ?>
    });

    // lowongan

    Highcharts.chart('container2', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Grafik Lowongan Bulanan'
    },
    subtitle: {
        text: 'kandidat'
    },
    xAxis: {
        categories: <?php echo json_encode($time); ?>,
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'jumlah (piece)'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: <?php echo json_encode($data_graph_prod2); ?>
});

</script>
