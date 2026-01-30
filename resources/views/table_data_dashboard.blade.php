<style>
	.table td, .table th {
		padding: .75rem;
		vertical-align: middle;
		border-top: 1px solid #dee2e6;
		text-align: center;
	}
</style>
<div class="col-md-6">
	<!--begin::Card-->
	<div class="card card-custom card-stretch gutter-b">
		<div class="text-center">
			<div class="card-title">
				<h3 class="card-label mt-5">Data Klasifikasi Usia Per Kecamatan</h3>
			</div>
		</div>
		<div class="card-body">
			<!--begin::Chart-->
			<div id="table_klasifikasi_kec">
				<div class="table-responsive">
                    <table class="table zero-configuration" id="klasifikasi_kec">
                        <thead>
                            <tr>
                                <th colspan="2"></th>
                                @for($k=0;$k < count($klasifikasi);$k++)
                                <th>{{ $klasifikasi[$k] }}</th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                        	@for($a=0;$a < count($data_klasifikasi);$a++)
                        	<tr>
                        		<td rowspan="4">{{ $data_klasifikasi[$a]['name']}}</td>
                        	</tr>
                        	<tr>
                        		<td>Laki - Laki</td>
                        		@for($b=0;$b < count($data_klasifikasi[$a]['lk']);$b++)
                                <td>{{ number_format($data_klasifikasi[$a]['lk'][$b]) }}</td>
                                @endfor
                        	</tr>
                        	<tr>
                        		<td>Perempuan</td>
                        		@for($b=0;$b < count($data_klasifikasi[$a]['pr']);$b++)
                                <td>{{ number_format($data_klasifikasi[$a]['pr'][$b]) }}</td>
                                @endfor
                        	</tr>
                        	<tr>
                        		<td><b>Total</b></td>
                        		@for($b=0;$b < count($data_klasifikasi[$a]['total']);$b++)
                                <td><b>{{ number_format($data_klasifikasi[$a]['total'][$b]) }}</b></td>
                                @endfor
                        	</tr>
                        	@endfor
                        </tbody>
                    </table>
                </div>
			</div>
			<!--end::Chart-->
		</div>
	</div>
</div>
<div class="col-md-6">
	<!--begin::Card-->
	<div class="card card-custom card-stretch gutter-b">
		<div class="text-center">
			<div class="card-title">
				<h3 class="card-label mt-5">Data Disabilitas Per Kecamatan</h3>
			</div>
		</div>
		<div class="card-body">
			<div id="table_disabilitas_kec">
				<div class="table-responsive">
                    <table class="table zero-configuration" id="disabilitas_kec">
                        <thead>
                            <tr>
                                <th colspan="2"></th>
                                @for($k=0;$k < count($disabilitas);$k++)
                                <th>{{ $disabilitas[$k] }}</th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                        	@for($a=0;$a < count($data_disabilitas);$a++)
                        	<tr>
                        		<td rowspan="4">{{ $data_disabilitas[$a]['name']}}</td>
                        	</tr>
                        	<tr>
                        		<td>Laki - Laki</td>
                        		@for($b=0;$b < count($data_disabilitas[$a]['lk']);$b++)
                                <td>{{ number_format($data_disabilitas[$a]['lk'][$b]) }}</td>
                                @endfor
                        	</tr>
                        	<tr>
                        		<td>Perempuan</td>
                        		@for($b=0;$b < count($data_disabilitas[$a]['pr']);$b++)
                                <td>{{ number_format($data_disabilitas[$a]['pr'][$b]) }}</td>
                                @endfor
                        	</tr>
                        	<tr>
                        		<td><b>Total</b></td>
                        		@for($b=0;$b < count($data_disabilitas[$a]['total']);$b++)
                                <td><b>{{ number_format($data_disabilitas[$a]['total'][$b]) }}</b></td>
                                @endfor
                        	</tr>
                        	@endfor
                        </tbody>
                    </table>
                </div>
			</div>
		</div>
	</div>
</div>