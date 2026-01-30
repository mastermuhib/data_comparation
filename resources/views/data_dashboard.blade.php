<style>
	.table td, .table th {
		padding: .75rem;
		vertical-align: middle;
		border-top: 1px solid #dee2e6;
		text-align: center;
	}
</style>
<div class="row">
	<div class="col-sm-4 col-6">
		<!--begin::Stats Widget 13-->
		<a href="#" class="card card-custom bg-danger bg-hover-state-danger card-stretch gutter-b">
			<!--begin::Body-->
			<div class="card-body">
				<span class="svg-icon svg-icon-white svg-icon-3x ml-n1">
					<!--begin::Svg Icon | path:assets/media/svg/icons/Shopping/Cart3.svg-->
					<i class="fas fa-users icon-3x text-white"></i>
					<!--end::Svg Icon-->
				</span>
				<div class="text-inverse-danger font-weight-bolder font-size-h5 mb-0 mt-4">{{number_format($j_dpt)}}</div>
				<div class="font-weight-bold text-inverse-danger font-size-sm">Jumlah DPT</div>
			</div>
			<!--end::Body-->
		</a>
		<!--end::Stats Widget 13-->
	</div>
	
	<div class="col-sm-4 col-6">
		<!--begin::Stats Widget 14-->
		<a href="#" class="card card-custom bg-primary bg-hover-state-primary card-stretch gutter-b">
			<!--begin::Body-->
			<div class="card-body">
				<span class="svg-icon svg-icon-white svg-icon-3x ml-n1">
					<!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
					<i class="fas fa-male icon-3x text-white"></i><span class="text-inverse-primary font-weight-bolder font-size-h6 ml-2">({{ number_format($p_dptl, 2)}} %)</span>
					<!--end::Svg Icon-->
				</span>
				<div class="text-inverse-primary font-weight-bolder font-size-h5 mb-0 mt-4">{{number_format($j_dptl)}} </div>
				<div class="font-weight-bold text-inverse-primary font-size-sm">Jumlah DPT Laki - Laki</div>
			</div>
			<!--end::Body-->
		</a>
		<!--end::Stats Widget 14-->
	</div>
	<div class="col-sm-4 col-6">
		<!--begin::Stats Widget 15-->
		<a href="#" class="card card-custom bg-success bg-hover-state-success card-stretch gutter-b">
			<!--begin::Body-->
			<div class="card-body">
				<span class="svg-icon svg-icon-white svg-icon-3x ml-n1">
					<!--begin::Svg Icon | path:assets/media/svg/icons/Media/Equalizer.svg-->
					<i class="fa fa-female icon-3x text-white"></i><span class="text-inverse-primary font-weight-bolder font-size-h6 ml-2">({{ number_format($p_dptp, 2)}} %)</span>
					<!--end::Svg Icon-->
				</span>
				<div class="text-inverse-success font-weight-bolder font-size-h5 mb-0 mt-4">{{number_format($j_dptp)}} </div>
				<div class="font-weight-bold text-inverse-success font-size-sm">Jumlah DPT Perempuan</div>
			</div>
			<!--end::Body-->
		</a>
		<!--end::Stats Widget 15-->
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<!--begin::Card-->
		<div class="card card-custom gutter-b">
			<div class="text-center">
				<div class="card-title">
					<h3 class="card-label mt-5">Status Pernikahan</h3>
				</div>
			</div>
			<div class="card-body">
				<!--begin::Chart-->
				
				<div id="chart_5" class="d-flex justify-content-center"></div>
				<!--end::Chart-->
			</div>
		</div>
		<!--end::Card-->
	</div>
	<div class="col-md-6">
		<!--begin::Card-->
		<div class="card card-custom gutter-b">
			<div class="text-center">
				<div class="card-title">
					<h3 class="card-label mt-5">Status E-KTP</h3>
				</div>
			</div>
			<div class="card-body">
				<!--begin::Chart-->
				<div id="chart_6" class="d-flex justify-content-center"></div>
				<!--end::Chart-->
			</div>
		</div>
		<!--end::Card-->
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<!--begin::Card-->
		<div  class="card card-custom card-stretch gutter-b">
			<div class="text-center">
				<div class="card-title">
					<h3 class="card-label mt-5">Klasifikasi Usia</h3>
				</div>
			</div>
			<div style="height:280px" class="card-body">
				<!--begin::Chart-->
				<div id="chart_1" class="d-flex justify-content-center"></div>
				<!--end::Chart-->
			</div>
			<div class="card-body mt-3 pb-0">
				<div id="chart_3"></div>
			</div>
			<div class="card-body mt-0">
				<div id="table_klasifikasi">
					<div class="table-responsive">
                        <table class="table zero-configuration" id="yourTable">
                            <thead>
                                <tr>
                                    <th></th>
                                    @for($k=0;$k < count($klasifikasi);$k++)
                                    <th>{{ str_replace("'", "",$klasifikasi[$k]) }}</th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>
                            	@for($a=0;$a < count($data_graph);$a++)
                            	<tr>
                            		<td>{{ $data_graph[$a]['name']}}</td>
                            		@for($b=0;$b < count($data_graph[$a]['data']);$b++)
                                    <td>{{ number_format($data_graph[$a]['data'][$b]) }}</td>
                                    @endfor
                            	</tr>
                            	@endfor
                            	<tr>
                            		<td>
                            			<b>Total</b>
                            		</td>
                            		@for($b=0;$b < count($prosentase_klasifikasi);$b++)
                                    <td>{{ number_format($prosentase_klasifikasi[$b]['total']) }} <b class="ml-1">({{ number_format($prosentase_klasifikasi[$b]['prosentase'],2) }}%)</b></td>
                                    @endfor
                            	</tr>
                            </tbody>
                        </table>
                    </div>
				</div>
			</div>
		</div>
		<!--end::Card-->
	</div>
	<div class="col-md-6">
		<!--begin::Card-->
		<div class="card card-custom card-stretch gutter-b">
			<div class="text-center">
				<div class="card-title">
					<h3 class="card-label mt-5">Grafik Disabilitas</h3>
				</div>
			</div>
			<div class="card-body">
				<!--begin::Chart-->
				<div id="chart_2" class="d-flex justify-content-center"></div>
				<!--end::Chart-->
			</div>
			<div class="card-body mt-3">
				<div id="chart_4"></div>
			</div>
			<div class="card-body mt-0">
				<div id="table_klasifikasi">
					<div class="table-responsive">
                        <table class="table zero-configuration" id="disTable">
                            <thead>
                                <tr>
                                    <th></th>
                                    @for($k=0;$k < count($disabilitas);$k++)
                                    <th>{{ str_replace("'", "",$disabilitas[$k]) }}</th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>
                            	@for($a=0;$a < count($data_graph_dis);$a++)
                            	<tr>
                            		<td>{{ $data_graph_dis[$a]['name']}}</td>
                            		@for($b=0;$b < count($data_graph_dis[$a]['data']);$b++)
                                    <td>{{ number_format($data_graph_dis[$a]['data'][$b]) }}</td>
                                    @endfor
                            	</tr>
                            	@endfor
                            	<tr>
                            		<td>
                            			<b>Total</b>
                            		</td>
                            		@for($b=0;$b < count($prosentase_disabilitas);$b++)
                                    <td>{{ number_format($prosentase_disabilitas[$b]['total']) }} <b class="ml-1">({{ number_format($prosentase_disabilitas[$b]['prosentase'],2) }}%)</b></td>
                                    @endfor
                            	</tr>
                            </tbody>
                        </table>
                    </div>
				</div>
			</div>
		</div>
		<!--end::Card-->
	</div>
</div>
<div class="row" id="isi_table_html">
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="text/javascript">
var KTApexChartsDemo = function () {
    console.log("okay");	
    var _demo1 = function () {
		const apexChart = "#chart_1";
		var options = {
			series: [<?php echo($klasifikasi_series); ?>],
			chart: {
				width: 380,
				type: 'pie',
			},
			labels: [<?php echo($klasifikasi_name); ?>],
			responsive: [{
				breakpoint: 480,
				options: {
					chart: {
						width: 200
					},
					legend: {
						position: 'bottom'
					}
				}
			}],
			colors: [primary, success, warning, danger, info ]
		};

		var chart = new ApexCharts(document.querySelector(apexChart), options);
		chart.render();
	}
	var _demo2 = function () {
		const apexChart = "#chart_2";
		var options = {
			series: [<?php echo($disabilitas_series); ?>],
			chart: {
				width: 380,
				type: 'donut',
			},
			labels: [<?php echo($disabilitas_name); ?>],
			responsive: [{
				breakpoint: 480,
				options: {
					chart: {
						width: 200
					},
					legend: {
						position: 'bottom'
					}
				}
			}],
			colors: [primary, success, warning, danger, info]
		};

		var chart = new ApexCharts(document.querySelector(apexChart), options);
		chart.render();
	}

	var _demo3 = function () {
		const apexChart = "#chart_3";
		var options = {
			series: <?php echo json_encode($data_graph); ?>,
			chart: {
				type: 'bar',
				height: 350
			},
			plotOptions: {
				bar: {
					horizontal: false,
					columnWidth: '55%',
					endingShape: 'rounded'
				},
			},
			dataLabels: {
				enabled: false
			},
			stroke: {
				show: true,
				width: 2,
				colors: ['transparent']
			},
			xaxis: {
				categories: <?php echo json_encode($klasifikasi); ?>,
			},
			yaxis: {
				title: {
					text: '(DPT)'
				}
			},
			fill: {
				opacity: 1
			},
			tooltip: {
				y: {
					formatter: function (val) {
						return val + " Orang"
					}
				}
			},
			colors: [primary, success, warning, danger, info]
		};

			var chart = new ApexCharts(document.querySelector(apexChart), options);
			chart.render();
		}
		var _demo4 = function () {
		const apexChart = "#chart_4";
		var options = {
			series: <?php echo json_encode($data_graph_dis); ?>,
			chart: {
				type: 'bar',
				height: 350
			},
			plotOptions: {
				bar: {
					horizontal: false,
					columnWidth: '55%',
					endingShape: 'rounded'
				},
			},
			dataLabels: {
				enabled: false
			},
			stroke: {
				show: true,
				width: 2,
				colors: ['transparent']
			},
			xaxis: {
				categories: <?php echo json_encode($disabilitas); ?>,
			},
			yaxis: {
				title: {
					text: '(DPT)'
				}
			},
			fill: {
				opacity: 1
			},
			tooltip: {
				y: {
					formatter: function (val) {
						return val + " Orang"
					}
				}
			},
			colors: [primary, success, warning, danger, info]
		};

			var chart = new ApexCharts(document.querySelector(apexChart), options);
			chart.render();
		}

		var _demo6 = function () {
			const apexChart = "#chart_6";
			var options = {
				series: [<?php echo($ektp_series); ?>],
				chart: {
					width: 380,
					type: 'pie',
				},
				labels: [<?php echo($ektp_name); ?>],
				responsive: [{
					breakpoint: 480,
					options: {
						chart: {
							width: 200
						},
						legend: {
							position: 'bottom'
						}
					}
				}],
				colors: [success,danger]
			};

			var chart = new ApexCharts(document.querySelector(apexChart), options);
			chart.render();
		}
		var _demo5 = function () {
			const apexChart = "#chart_5";
			var options = {
				series: [<?php echo($mariage_series); ?>],
				chart: {
					width: 380,
					type: 'donut',
				},
				labels: [<?php echo($mariage_name); ?>],
				responsive: [{
					breakpoint: 480,
					options: {
						chart: {
							width: 200
						},
						legend: {
							position: 'bottom'
						}
					}
				}],
				colors: [success,danger,warning]
			};

			var chart = new ApexCharts(document.querySelector(apexChart), options);
			chart.render();
		}
    return {
		// public functions
		init: function () {
			_demo1();
			_demo2();
			_demo3();
			_demo4();
			_demo5();
			_demo6();
		}
	};
}();

jQuery(document).ready(function () {
	KTApexChartsDemo.init();
});	
</script>