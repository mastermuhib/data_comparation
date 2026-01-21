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
					<i class="fas fa-male icon-3x text-white"></i>
					<!--end::Svg Icon-->
				</span>
				<div class="text-inverse-primary font-weight-bolder font-size-h5 mb-0 mt-4">{{number_format($j_dptl)}}</div>
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
					<i class="fa fa-female icon-3x text-white"></i>
					<!--end::Svg Icon-->
				</span>
				<div class="text-inverse-success font-weight-bolder font-size-h5 mb-0 mt-4">{{number_format($j_dptp)}}</div>
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
		<div  class="card card-custom gutter-b">
			<div class="text-center">
				<div class="card-title">
					<h3 class="card-label mt-5">Klasifikasi Usia</h3>
				</div>
			</div>
			<div style="height:415px" class="card-body">
				<!--begin::Chart-->
				<div id="chart_1" class="d-flex justify-content-center"></div>
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
					<h3 class="card-label mt-5">Grafik Disabilitas</h3>
				</div>
			</div>
			<div class="card-body">
				<!--begin::Chart-->
				<div id="chart_2" class="d-flex justify-content-center"></div>
				<!--end::Chart-->
			</div>
		</div>
		<!--end::Card-->
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<!--begin::Card-->
		<div class="card card-custom gutter-b">
			<div class="text-center">
				<div class="card-title">
					<h3 class="card-label mt-5">Klasifikasi Status Pernikahan</h3>
				</div>
			</div>
			<div class="card-body">
				<!--begin::Chart-->
				<canvas id="chart_3"></canvas>
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
					<h3 class="card-label mt-5">Klasifikasi E-KTP</h3>
				</div>
			</div>
			<div class="card-body">
				<!--begin::Chart-->
				<canvas id="chart_4"></canvas>
				<!--end::Chart-->
			</div>
		</div>
		<!--end::Card-->
	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="text/javascript">
var KTApexChartsDemo = function () {
    console.log("okay");	
    var _demo1 = function () {
		const apexChart = "#chart_1";
		var options = {
			series: [44, 55, 13, 43, 22],
			chart: {
				width: 380,
				type: 'pie',
			},
			labels: ['Team A', 'Team B', 'Team C', 'Team D', 'Team E'],
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
			series: [44, 55, 41, 17, 15],
			chart: {
				width: 380,
				type: 'donut',
			},
			labels: ['Team A', 'Team B', 'Team C', 'Team D', 'Team E'],
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
    return {
		// public functions
		init: function () {
			_demo1();
			_demo2();
	
		}
	};
}();

jQuery(document).ready(function () {
	KTApexChartsDemo.init();
});	
</script>