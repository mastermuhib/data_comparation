<div class="tab-pane active" id="overview" role="tabpanel">
        <!-- hari ini -->
        <h4 class="mb-3 font-weight-bold">Member</h4>
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
                        <p class="font-weight-bold text-white-red">{{$persen_member_active}}</p>
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
        <!-- Kolom2 Bawah -->
        <input id="laki" type="hidden" value="{{$jk_laki}}">
        <input id="perempuan" type="hidden" value="{{$jk_perempuan}}">

        <h4 class="mb-3 font-weight-bold">Bisnis</h4>
        <div class="row">
            <div class="col-lg-6">
                <!--begin::Mixed Widget 1-->
                <div class="card card-custom bg-gray-100 card-stretch gutter-b">
                    <!--begin::Header-->
                    <div class="border-0 bg-danger py-0 text-center pt-4" style="background-color: #3F99F7 !important;">
                        <h3 class="card-title font-weight-bolder text-white-red">{{$jumlah_bisnis}} Bisnis</h3>
                        <div class="card-toolbar">
                            <div class="dropdown dropdown-inline">
                                
                                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right" style="">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body p-0 position-relative overflow-hidden" style="background-color:#E5E5E5;">
                        
                        <!--begin::Stats-->
                        <div class="card-spacer mt-2">
                            <!--begin::Row-->
                            <div class="row m-0">
                                <div class="col bg-white px-6 py-8 rounded-xl mr-7 mb-7 text-center">
                                    
                                    <a href="#" class="text-dark font-weight-bold font-size-h6 mt-2">{{number_format($bisnis_active)}}</a>
                                    <br>
                                    <span class="font-weight-bold text-dark font-size-sm">Bisnis active</span>
                                </div>
                                <div class="col bg-white px-6 py-8 rounded-xl mb-7 text-center">
                                   
                                    <a href="#" class="text-dark font-weight-bold font-size-h6 mt-2">{{number_format($bisnis_verifikasi)}}</a>
                                    <br>
                                    <span class="font-weight-bold text-dark font-size-sm">Bisnis Terverifikasi</span>
                                    
                                </div>
                            </div>
                            <!--end::Row-->
                            <!--begin::Row-->
                            <div class="row m-0">
                                <div class="col bg-white px-6 py-8 rounded-xl mr-7 mb-7 text-center">
                                    
                                    <a href="#" class="text-dark font-weight-bold font-size-h6 mt-2">{{number_format($jumlah_lowongan)}}</a>
                                    <br>
                                    <span class="font-weight-bold text-dark font-size-sm">Jumlah Lowongan</span>
                                </div>
                                <div class="col bg-white px-6 py-8 rounded-xl mb-7 text-center">
                                   
                                    <a href="#" class="text-dark font-weight-bold font-size-h6 mt-2">{{number_format($posisi_lowongan)}}</a>
                                    <br>
                                    <span class="font-weight-bold text-dark font-size-sm">Posisi Pekerjaan</span>
                                    
                                </div>
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Stats-->
                    <div class="resize-triggers"><div class="expand-trigger"><div style="width: 359px; height: 515px;"></div></div><div class="contract-trigger"></div></div></div>
                    <!--end::Body-->
                </div>
                <!--end::Mixed Widget 1-->
            </div>
            <!-- Lowongan -->
            <div class="col-lg-6">
                <!--begin::Mixed Widget 1-->
                <div class="card card-custom bg-gray-100 card-stretch gutter-b">
                    <!--begin::Header-->
                    <div class="border-0 bg-danger py-0 text-center pt-4" style="background-color: #3F99F7 !important;">
                        <h3 class="card-title font-weight-bolder text-white-red">{{number_format($jumlah_lowongan)}} Lowongan</h3>
                        <div class="card-toolbar">
                            <div class="dropdown dropdown-inline">
                                
                                <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right" style="">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body p-0 position-relative overflow-hidden" style="background-color:#E5E5E5;">
                        
                        <!--begin::Stats-->
                        <div class="card-spacer mt-2">
                            <!--begin::Row-->
                            <div class="row m-0">
                                <div class="col bg-white px-6 py-8 rounded-xl mr-7 mb-7 text-center">
                                    
                                    <a href="#" class="text-dark font-weight-bold font-size-h6 mt-2">{{number_format($seleksi_lowongan)}}</a>
                                    <br>
                                    <span class="font-weight-bold text-dark font-size-sm">Terseleksi</span>
                                </div>
                                <div class="col bg-white px-6 py-8 rounded-xl mb-7 text-center">
                                   
                                    <a href="#" class="text-dark font-weight-bold font-size-h6 mt-2">{{number_format($lowongan_terkirim)}}</a>
                                    <br>
                                    <span class="font-weight-bold text-dark font-size-sm">Terkirim</span>
                                    
                                </div>
                            </div>
                            <!--end::Row-->
                            <!--begin::Row-->
                            <div class="row m-0">
                                <div class="col bg-white px-6 py-8 rounded-xl mr-7 mb-7 text-center">
                                    
                                    <a href="#" class="text-dark font-weight-bold font-size-h6 mt-2">{{number_format($panggilan)}}</a>
                                    <br>
                                    <span class="font-weight-bold text-dark font-size-sm">Panggilan</span>
                                </div>
                                <div class="col bg-white px-6 py-8 rounded-xl mb-7 text-center">
                                   
                                    <a href="#" class="text-dark font-weight-bold font-size-h6 mt-2">{{number_format($diterima_kerja)}}</a>
                                    <br>
                                    <span class="font-weight-bold text-dark font-size-sm">Penerimaan</span>
                                    
                                </div>
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Stats-->
                    <div class="resize-triggers"><div class="expand-trigger"><div style="width: 359px; height: 515px;"></div></div><div class="contract-trigger"></div></div></div>
                    <!--end::Body-->
                </div>
                <!--end::Mixed Widget 1-->
            </div>
                       
            <!-- kolom4 samping -->
            <div class="text-center" style=" width: 20%; padding: 10px;">
            </div>
        </div>
        <!-- Kolom2 Bawah -->
        <!-- Tampilan Garfik1-->
        <!--end::Card-->
        <h4>STATISTIC</h4>
        <div class="row">
            <div class="col-md-6">
                <div id="piechart"></div>
            </div>
            <div class="col-md-6">
                <div id="piechart_pendidikan"></div>
            </div>
            <div class="col-md-12 mt-4">
                <div id="top_x_div"></div>
            </div>
            <div class="col-md-12">
                <div id="vmap" style="width: 100%; height: 500px;margin-top: 50px;"></div>
            </div>
        </div>
                
    </div>
</div>
<script src="{{URL::asset('assets')}}/plugins/custom/flot/flot.bundle.js"></script>
<script src="{{URL::asset('assets')}}/js/pages/features/charts/apexcharts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
<!-- vmaps -->
<script src="{{URL::asset('assets')}}/jquery.vmap.js"></script>
<script src="{{URL::asset('assets')}}/maps/jquery.vmap.indonesia.js"></script>
<script type="text/javascript" src="{{URL::asset('assets')}}/maps/jquery.vmap.electioncolors.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    jQuery(document).ready(function () {
        jQuery('#vmap').vectorMap({
          map: 'indonesia_id',
          enableZoom: true,
          showTooltip: true,
          selectedColor: null,
          colors: electionColors,
          onRegionClick: function(event, code, region){
            // event.preventDefault();
            console.log(code,event);
          }
        });
    });
    $('.count').each(function () {
        $(this).prop('Counter',0).animate({
            Counter: $(this).text()
        }, {
            duration: 4000,
            easing: 'swing',
            step: function (now) {
                $(this).text(Math.ceil(now));
            }
        });
    });

    google.charts.load('current', { 'packages': ['corechart'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var laki = document.getElementById("laki").value;
        var perempuan = document.getElementById("perempuan").value;

        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Laki-laki', <?php echo $jk_laki ?>],
            ['Perempuan', <?php echo $jk_perempuan ?>],
        ]);

        var options = {
            title: 'JENIS KELAMIN',

        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);

        // chat pendidikan user

        var data_p = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['SD', <?php echo $sekolah_sd ?>],
            ['SMP', <?php echo $sekolah_smp ?>],
            ['SMA', <?php echo $sekolah_sma ?>],
            ['SMK', <?php echo $sekolah_smk ?>],
            ['D1', <?php echo $sekolah_d1 ?>],
            ['D2', <?php echo $sekolah_d2 ?>],
            ['D3', <?php echo $sekolah_d3 ?>],
            ['D4', <?php echo $sekolah_d4 ?>],
            ['S1', <?php echo $sekolah_s1 ?>],
            ['S2', <?php echo $sekolah_s2 ?>],
        ]);

        var options_p = {
            title: 'Pendidikan',

        };

        var chart_p = new google.visualization.PieChart(document.getElementById('piechart_pendidikan'));

        chart_p.draw(data_p, options_p);
    }

    google.charts.load('current', { 'packages': ['bar'] });
    google.charts.setOnLoadCallback(drawStuff);

    function drawStuff() {
        var data = new google.visualization.arrayToDataTable([
            ['Usia Member', 'Jumlah'],
            ["dibawah 17 Thn", <?php echo $dibawah_17 ?>],
            ["17 - 24 Thn", <?php echo $dibawah_24 ?>],
            ["24 - 35 Thn", <?php echo $dibawah_35 ?>],
            ["35 - 41 Thn", <?php echo $dibawah_41 ?>],
            ['diatas 41 Thn', <?php echo $diatas_41 ?>]
        ]);

        var options = {
            title: '',
            width: '100%',
            legend: { position: 'none' },
            chart: {
                title: '',
                subtitle: ''
            },
            bars: 'horizontal', // Required for Material Bar Charts.
            axes: {
                x: {
                    0: { side: 'top', label: 'Jumlah' } // Top x-axis.
                }
            },
            bar: { groupWidth: "100%" }
        };

        var chart = new google.charts.Bar(document.getElementById('top_x_div'));
        chart.draw(data, options);
    };
</script>