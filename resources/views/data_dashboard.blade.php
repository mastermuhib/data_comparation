<div class="row">
	<div class="col-sm-4 col-6">
		<!--begin::Stats Widget 13-->
		<a href="#" class="card card-custom bg-danger bg-hover-state-danger card-stretch gutter-b">
			<!--begin::Body-->
			<div class="card-body">
				<span class="svg-icon svg-icon-white svg-icon-3x ml-n1">
					<!--begin::Svg Icon | path:assets/media/svg/icons/Shopping/Cart3.svg-->
					<i class="fas fa-user-graduate icon-3x text-white"></i>
					<!--end::Svg Icon-->
				</span>
				<div class="text-inverse-danger font-weight-bolder font-size-h5 mb-0 mt-4">{{number_format($j_student)}}</div>
				<div class="font-weight-bold text-inverse-danger font-size-sm">Jumlah Siswa</div>
			</div>
			<!--end::Body-->
		</a>
		<!--end::Stats Widget 13-->
	</div>
	<!-- <div class="col-sm-3 col-6">
		<a href="#" class="card card-custom bg-dark bg-hover-state-dark card-stretch gutter-b">
			<div class="card-body">
				<span class="svg-icon svg-icon-white svg-icon-3x ml-n1">
					<i class="fas fa-user-tie icon-3x text-white"></i>
				</span>
				<div class="text-inverse-dark font-weight-bolder font-size-h5 mb-0 mt-4">{{number_format($j_teacher)}}</div>
				<div class="font-weight-bold text-inverse-dark font-size-sm">Jumlah Guru</div>
			</div>
		</a>
	</div> -->
	<div class="col-sm-4 col-6">
		<!--begin::Stats Widget 14-->
		<a href="#" class="card card-custom bg-primary bg-hover-state-primary card-stretch gutter-b">
			<!--begin::Body-->
			<div class="card-body">
				<span class="svg-icon svg-icon-white svg-icon-3x ml-n1">
					<!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
					<i class="fas fa-users icon-3x text-white"></i>
					<!--end::Svg Icon-->
				</span>
				<div class="text-inverse-primary font-weight-bolder font-size-h5 mb-0 mt-4">{{number_format($j_parent)}}</div>
				<div class="font-weight-bold text-inverse-primary font-size-sm">Jumlah Wali Murid</div>
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
					<i class="fa fa-american-sign-language-interpreting icon-3x text-white"></i>
					<!--end::Svg Icon-->
				</span>
				<div class="text-inverse-success font-weight-bolder font-size-h5 mb-0 mt-4">{{number_format($j_mr)}}</div>
				<div class="font-weight-bold text-inverse-success font-size-sm">Jumlah MR</div>
			</div>
			<!--end::Body-->
		</a>
		<!--end::Stats Widget 15-->
	</div>
</div>
<div class="row">
	<div class="col-lg-4">
		<!--begin::Card-->
		<div  class="card card-custom gutter-b">
			<div class="text-center">
				<div class="card-title">
					<h3 class="card-label mt-5">Kategori MR</h3>
				</div>
			</div>
			<div style="height:415px" class="card-body">
				<!--begin::Chart-->
				<div id="chart_11" class="d-flex justify-content-center"></div>
				<!--end::Chart-->
			</div>
		</div>
		<!--end::Card-->
	</div>
	<div class="col-lg-8">
		<!--begin::Card-->
		<div class="card card-custom gutter-b">
			<div class="text-center">
				<div class="card-title">
					<h3 class="card-label mt-5">Grafik MR</h3>
				</div>
			</div>
			<div class="card-body">
				<!--begin::Chart-->
				<div id="chart_3"></div>
				<!--end::Chart-->
			</div>
		</div>
		<!--end::Card-->
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<!--begin::Card-->
		<div class="card card-custom gutter-b">
			<div class="text-center">
				<div class="card-title">
					<h3 class="card-label mt-5">MR Sekolah</h3>
				</div>
			</div>
			<div class="card-body">
				<!--begin::Chart-->
				<div id="chart_4"></div>
				<!--end::Chart-->
			</div>
		</div>
		<!--end::Card-->
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<!--begin::Card-->
		<div class="card card-custom gutter-b">
			<div class="text-center">
				<div class="card-title">
					<h3 class="card-label mt-5">Data Obat Terpakai</h3>
				</div>
			</div>
			<div class="card-body">
				<!--begin::Chart-->
				<div id="chart_5"></div>
				<!--end::Chart-->
			</div>
		</div>
		<!--end::Card-->
	</div>
</div>
<script type="text/javascript">

	var KTApexChartsDemo = function () {
	// Private functions
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
				categories: <?php echo json_encode($time); ?>,
			},
			yaxis: {
				title: {
					text: '(Kejadian)'
				}
			},
			fill: {
				opacity: 1
			},
			tooltip: {
				y: {
					formatter: function (val) {
						return val + " kejadian"
					}
				}
			},
			colors: [<?php echo($category_medical_color); ?>]
		};

			var chart = new ApexCharts(document.querySelector(apexChart), options);
			chart.render();
		}


		var _demo4 = function () {
		const apexChart = "#chart_4";
		var options = {
			series: <?php echo json_encode($data_graph_scholl); ?>,
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
				categories: <?php echo json_encode($time); ?>,
			},
			yaxis: {
				title: {
					text: '(Kejadian)'
				}
			},
			fill: {
				opacity: 1
			},
			tooltip: {
				y: {
					formatter: function (val) {
						return val + " kejadian"
					}
				}
			},
			colors: [<?php echo($category_medical_color); ?>]
		};

			var chart = new ApexCharts(document.querySelector(apexChart), options);
			chart.render();
		}


		var _demo5 = function () {
		const apexChart = "#chart_5";
		var options = {
			series: <?php echo json_encode($data_graph_obat); ?>,
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
				categories: <?php echo json_encode($time); ?>,
			},
			yaxis: {
				title: {
					text: '(Terpakai)'
				}
			},
			fill: {
				opacity: 1
			},
			tooltip: {
				y: {
					formatter: function (val) {
						return val + " Terpakai"
					}
				}
			},
			colors: [<?php echo($category_medical_color); ?>]
		};

			var chart = new ApexCharts(document.querySelector(apexChart), options);
			chart.render();
		}

		var _demo11 = function () {
			const apexChart = "#chart_11";
			var options = {
				series: [<?php echo($category_medical_count); ?>],
				labels: [<?php echo($category_medical_name); ?>],
				chart: {
					width: 380,
					type: 'donut',
				},
				responsive: [{
					breakpoint: 480,
					options: {
						chart: {
							width: 200
						},
						legend: {
							position: 'top'
						}
					}
				}],
				colors: [<?php echo($category_medical_color); ?>]
				
			};

			var chart = new ApexCharts(document.querySelector(apexChart), options);
			chart.render();
		}
	return {
		// public functions
		init: function () {
			_demo3();
			_demo4();
			_demo11();
			_demo5();
		}
	};
}();
jQuery(document).ready(function () {
	KTApexChartsDemo.init();
});
</script>