<div class="tab-content tabcontent-border mt-5">

     <div class="tab-pane active" id="member" role="tabpanel">
        <h4 class="mb-3 font-weight-bold">Total</h4>
        
        <div class="row mb-3">
            <div class="col-xl-2 col-sm-6 col-xs-6">
                <!--begin::Stats Widget 30-->
                <div class="card card-custom bg-info card-stretch gutter-b" style="background-color: #3F99F7 !important;">
                    <!--begin::Body-->
                    <div class="card-body">
                        <a href="#" class="card-title font-weight-bolder text-white-red font-size-h6 mb-4 text-hover-state-dark d-block">Download</a>
                        <span class="card-title font-weight-bolder text-white-red font-size-h2 mb-0 mt-6 d-block">{{number_format($jumlah_download)}}</span>
                        
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Stats Widget 30-->
    
            </div>
            
            <div class="col-xl-2 col-sm-6 col-xs-6">
                <!--begin::Stats Widget 29-->
                <div class="card card-custom bgi-no-repeat card-stretch gutter-b" style="background-color: #3F99F7 !important">
                    <!--begin::Body-->
                    <div class="card-body">
                        <a href="#" class="card-title font-weight-bolder text-white-red font-size-h6 mb-4 text-hover-state-dark d-block">Member</a>
                        <span class="card-title font-weight-bolder text-white-red font-size-h2 mb-0 mt-6 d-block">{{number_format($member_all_new)}}</span>
                        <span class="text-white-red font-size-sm">Konversi</span>
                        <p class="text-white-red font-weight-bold">{{$persen_member_all}}</p>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Stats Widget 29-->
            </div>
            <div class="col-xl-2 col-sm-6 col-xs-6">
                <!--begin::Stats Widget 30-->
                <div class="card card-custom bg-info card-stretch gutter-b" style="background-color: #3F99F7 !important;">
                    <!--begin::Body-->
                    <div class="card-body">
                        <a href="#" class="card-title font-weight-bolder text-white-red font-size-h6 mb-4 text-hover-state-dark d-block">active</a>
                        <span class="card-title font-weight-bolder text-white-red font-size-h2 mb-0 mt-6 d-block">{{number_format($member_active)}}</span>
                        <span class="text-white-red font-size-sm">Konversi</span>
                        <p class="text-white-red font-weight-bold">{{$persen_member_active}}</p>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Stats Widget 30-->
            </div>
            <div class="col-xl-2 col-sm-6 col-xs-6">
                <!--begin::Stats Widget 30-->
                <div class="card card-custom bg-info card-stretch gutter-b" style="background-color: #3F99F7 !important;">
                    <!--begin::Body-->
                    <div class="card-body">
                        <a href="#" class="card-title font-weight-bolder text-white-red font-size-h6 mb-4 text-hover-state-dark d-block">Free Member</a>
                        <span class="card-title font-weight-bolder text-white-red font-size-h2 mb-0 mt-6 d-block">{{number_format($member_free)}}</span>
                        <span class="text-white-red font-size-sm">Konversi</span>
                        <p class="text-white-red font-weight-bold">{{$persen_member_free}}</p>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Stats Widget 30-->
            </div>
            <div class="col-xl-2 col-sm-6 col-xs-6">
                <!--begin::Stats Widget 31-->
                <div class="card card-custom bg-danger card-stretch gutter-b" style="background-color: #3F99F7 !important;">
                    <!--begin::Body-->
                    <div class="card-body">
                        <a href="#" class="card-title font-weight-bolder text-white-red font-size-h6 mb-4 text-hover-state-dark d-block">Lengkap</a>
                        <span class="card-title font-weight-bolder text-white-red font-size-h2 mb-0 mt-6 d-block">{{number_format($profle_lengkap)}}</span>
                        <span class="text-white-red font-size-sm">Konversi</span>
                        <p class="text-white-red font-weight-bold">{{$persen_profle_lengkap}}</p>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Stats Widget 31-->
            </div>
            <div class="col-xl-2 col-sm-6 col-xs-6">
                <!--begin::Stats Widget 32-->
                <div class="card card-custom bg-dark card-stretch gutter-b" style="background-color: #3F99F7 !important">
                    <!--begin::Body-->
                    <div class="card-body">
                        <a href="#" class="card-title font-weight-bolder text-white-red font-size-h6 mb-4 text-hover-state-dark d-block">Verified</a>
                        <span class="card-title font-weight-bolder text-white-red font-size-h2 mb-0 mt-6 text-hover-primary d-block">{{number_format($verifikasi_member)}}</span>
                        <span class="text-white-red font-size-sm">Konversi</span>
                        <p class="text-white-red font-weight-bold">{{$persen_verifikasi_member}}</p>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Stats Widget 32-->
            </div>
            <!-- pembatas -->
        
            <!-- kolom4 samping -->
        </div>
        <!-- tabel2 bawah -->
        <h4 class="mb-3 font-weight-bold">Bulan Ini</h4>

        <div class="row">
            <div class="col-xl-2 col-sm-6 col-xs-6">
                <!--begin::Stats Widget 30-->
                <div class="card card-custom bg-info card-stretch gutter-b" style="background-color: #60A7F1 !important;">
                    <!--begin::Body-->
                    <div class="card-body">
                        <a href="#" class="card-title font-weight-bolder text-white-red font-size-h6 mb-4 text-hover-state-dark d-block">Download</a>
                        <span class="card-title font-weight-bolder text-white-red font-size-h2 mb-0 mt-6 d-block">{{number_format($jumlah_download_bulan)}}</span>
                        
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Stats Widget 30-->
    
            </div>
            
            <div class="col-xl-2 col-sm-6 col-xs-6">
                <!--begin::Stats Widget 29-->
                <div class="card card-custom bgi-no-repeat card-stretch gutter-b" style="background-color: #60A7F1 !important">
                    <!--begin::Body-->
                    <div class="card-body">
                        <a href="#" class="card-title font-weight-bolder text-white-red font-size-h6 mb-4 text-hover-state-dark d-block">Member</a>
                        <span class="card-title font-weight-bolder text-white-red font-size-h2 mb-0 mt-6 d-block">{{number_format($member_all_new_bulan)}}</span>
                        <span class="text-white-red font-size-sm">Konversi</span>
                        <p class="text-white-red font-weight-bold">{{$persen_member_all_bulan}}</p>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Stats Widget 29-->
            </div>
            <div class="col-xl-2 col-sm-6 col-xs-6">
                <!--begin::Stats Widget 30-->
                <div class="card card-custom bg-info card-stretch gutter-b" style="background-color: #60A7F1 !important;">
                    <!--begin::Body-->
                    <div class="card-body">
                        <a href="#" class="card-title font-weight-bolder text-white-red font-size-h6 mb-4 text-hover-state-dark d-block">active</a>
                        <span class="card-title font-weight-bolder text-white-red font-size-h2 mb-0 mt-6 d-block">{{number_format($member_active_bulan)}}</span>
                        <span class="text-white-red font-size-sm">Konversi</span>
                        <p class="text-white-red font-weight-bold">{{$persen_member_active_bulan}}</p>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Stats Widget 30-->
            </div>
            <div class="col-xl-2 col-sm-6 col-xs-6">
                <!--begin::Stats Widget 30-->
                <div class="card card-custom bg-info card-stretch gutter-b" style="background-color: #60A7F1 !important;">
                    <!--begin::Body-->
                    <div class="card-body">
                        <a href="#" class="card-title font-weight-bolder text-white-red font-size-h6 mb-4 text-hover-state-dark d-block">Free Member</a>
                        <span class="card-title font-weight-bolder text-white-red font-size-h2 mb-0 mt-6 d-block">{{number_format($member_free_bulan)}}</span>
                        <span class="text-white-red font-size-sm">Konversi</span>
                        <p class="text-white-red font-weight-bold">{{$persen_member_free_bulan}}</p>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Stats Widget 30-->
            </div>
            <div class="col-xl-2 col-sm-6 col-xs-6">
                <!--begin::Stats Widget 31-->
                <div class="card card-custom bg-danger card-stretch gutter-b" style="background-color: #60A7F1 !important;">
                    <!--begin::Body-->
                    <div class="card-body">
                        <a href="#" class="card-title font-weight-bolder text-white-red font-size-h6 mb-4 text-hover-state-dark d-block">Lengkap</a>
                        <span class="card-title font-weight-bolder text-white-red font-size-h2 mb-0 mt-6 d-block">{{number_format($profle_lengkap_bulan)}}</span>
                        <span class="text-white-red font-size-sm">Konversi</span>
                        <p class="text-white-red font-weight-bold">{{$persen_profle_lengkap_bulan}}</p>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Stats Widget 31-->
            </div>
            <div class="col-xl-2 col-sm-6 col-xs-6">
                <!--begin::Stats Widget 32-->
                <div class="card card-custom bg-dark card-stretch gutter-b" style="background-color: #60A7F1 !important">
                    <!--begin::Body-->
                    <div class="card-body">
                        <a href="#" class="card-title font-weight-bolder text-white-red font-size-h6 mb-4 text-hover-state-dark d-block">Verified</a>
                        <span class="card-title font-weight-bolder text-white-red font-size-h2 mb-0 mt-6 text-hover-primary d-block">{{number_format($verifikasi_member_bulan)}}</span>
                        <span class="text-white-red font-size-sm">Konversi</span>
                        <p class="text-white-red font-weight-bold">{{$persen_verifikasi_member_bulan}}</p>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Stats Widget 32-->
            </div> 
        </div>

        <!-- Kolom3 bawah -->

        <h4 class="mb-3 font-weight-bold">Hari Ini</h4>

        <div class="row">
            <div class="col-xl-2 col-sm-6 col-xs-6">
                <!--begin::Stats Widget 30-->
                <div class="card card-custom bg-info card-stretch gutter-b" style="background-color: #76B5F8 !important;">
                    <!--begin::Body-->
                    <div class="card-body">
                        <a href="#" class="card-title font-weight-bolder text-white-red font-size-h6 mb-4 text-hover-state-dark d-block">Download</a>
                        <span class="card-title font-weight-bolder text-white-red font-size-h2 mb-0 mt-6 d-block">{{number_format($jumlah_download_hari)}}</span>
                        
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Stats Widget 30-->
    
            </div>
            
            <div class="col-xl-2 col-sm-6 col-xs-6">
                <!--begin::Stats Widget 29-->
                <div class="card card-custom bgi-no-repeat card-stretch gutter-b" style="background-color: #76B5F8 !important">
                    <!--begin::Body-->
                    <div class="card-body">
                        <a href="#" class="card-title font-weight-bolder text-white-red font-size-h6 mb-4 text-hover-state-dark d-block">Member</a>
                        <span class="card-title font-weight-bolder text-white-red font-size-h2 mb-0 mt-6 d-block">{{number_format($member_all_new_hari)}}</span>
                        <span class="text-white-red font-size-sm">Konversi</span>
                        <p class="text-white-red font-weight-bold">{{$persen_member_all_hari}}</p>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Stats Widget 29-->
            </div>
            <div class="col-xl-2 col-sm-6 col-xs-6">
                <!--begin::Stats Widget 30-->
                <div class="card card-custom bg-info card-stretch gutter-b" style="background-color: #76B5F8 !important;">
                    <!--begin::Body-->
                    <div class="card-body">
                        <a href="#" class="card-title font-weight-bolder text-white-red font-size-h6 mb-4 text-hover-state-dark d-block">active</a>
                        <span class="card-title font-weight-bolder text-white-red font-size-h2 mb-0 mt-6 d-block">{{number_format($member_active_hari)}}</span>
                        <span class="text-white-red font-size-sm">Konversi</span>
                        <p class="text-white-red font-weight-bold">{{$persen_member_active_hari}}</p>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Stats Widget 30-->
            </div>
            <div class="col-xl-2 col-sm-6 col-xs-6">
                <!--begin::Stats Widget 30-->
                <div class="card card-custom bg-info card-stretch gutter-b" style="background-color: #76B5F8 !important;">
                    <!--begin::Body-->
                    <div class="card-body">
                        <a href="#" class="card-title font-weight-bolder text-white-red font-size-h6 mb-4 text-hover-state-dark d-block">Free Member</a>
                        <span class="card-title font-weight-bolder text-white-red font-size-h2 mb-0 mt-6 d-block">{{number_format($member_free_hari)}}</span>
                        <span class="text-white-red font-size-sm">Konversi</span>
                        <p class="text-white-red font-weight-bold">{{$persen_member_free_hari}}</p>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Stats Widget 30-->
            </div>
            <div class="col-xl-2 col-sm-6 col-xs-6">
                <!--begin::Stats Widget 31-->
                <div class="card card-custom bg-danger card-stretch gutter-b" style="background-color: #76B5F8 !important;">
                    <!--begin::Body-->
                    <div class="card-body">
                        <a href="#" class="card-title font-weight-bolder text-white-red font-size-h6 mb-4 text-hover-state-dark d-block">Lengkap</a>
                        <span class="card-title font-weight-bolder text-white-red font-size-h2 mb-0 mt-6 d-block">{{number_format($profle_lengkap_hari)}}</span>
                        <span class="text-white-red font-size-sm">Konversi</span>
                        <p class="text-white-red font-weight-bold">{{$persen_profle_lengkap_hari}}</p>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Stats Widget 31-->
            </div>
            <div class="col-xl-2 col-sm-6 col-xs-6">
                <!--begin::Stats Widget 32-->
                <div class="card card-custom bg-dark card-stretch gutter-b" style="background-color: #76B5F8 !important">
                    <!--begin::Body-->
                    <div class="card-body">
                        <a href="#" class="card-title font-weight-bolder text-white-red font-size-h6 mb-4 text-hover-state-dark d-block">Verified</a>
                        <span class="card-title font-weight-bolder text-white-red font-size-h2 mb-0 mt-6 text-hover-primary d-block">{{number_format($verifikasi_member_hari)}}</span>
                        <span class="text-white-red font-size-sm">Konversi</span>
                        <p class="text-white-red font-weight-bold">{{$persen_verifikasi_member_hari}}</p>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Stats Widget 32-->
            </div> 
        </div>
        <!--end::Card-->
        <div class="row">
            <div class="col-md-12">
                <label>Grafik Member Bulanan</label>
                <figure class="highcharts-figure">
                    <div id="container_m"></div>
                </figure>
            </div>
        </div>  
        <div class="row">
            <div class="col-lg-12">
                <!--begin::Mixed Widget 1-->
                <div class="card card-custom bg-gray-100 card-stretch gutter-b">
                    <!--begin::Header-->
                    <div class="card-header border-0 bg-danger py-2" style="background-color: #3F99F7 !important;">
                        <h3 class="card-title font-weight-bolder text-white-red">Tabel Member Bulanan</h3>
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
                                @for($d = 0;$d < count($data_graph_prod1);$d++)
                                    <?php $no = $no + 1; ?>
                                    <tr>
                                        <th scope="col">{{$data_graph_prod1[$d]['name']}}</th>
                                        @for($k = 0;$k < count($data_graph_prod1[$d]['data']);$k++)
                                        <td scope="row" style="font-size: 12px;">{{number_format($data_graph_prod1[$d]['data'][$k])}}</td>
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
    </div>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script type="text/javascript">

    // highcart
    Highcharts.chart('container_m', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Grafik Member Bulanan'
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

</script>
