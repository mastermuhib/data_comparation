<!--begin::Card-->
<div class="card card-custom gutter-b card-stretch">
	<!--begin::Body-->
	<div class="card-body pt-4">
		<!--begin::Toolbar-->
		<div class="d-flex justify-content-end">
			
		</div>
		<!--end::Toolbar-->
		<!--begin::User-->
		<div class="d-flex align-items-end mb-7">
			<!--begin::Pic-->
			<div class="d-flex align-items-center">
				<!--begin::Pic-->
				<div class="flex-shrink-0 mr-4 mt-lg-0 mt-3">
					<div class="symbol symbol-circle symbol-lg-75">
						@if($data->image != null)
						<img src="{{env('BASE_IMG')}}{{$data->image}}" alt="image">
						@else
                            <span class="symbol-label font-size-h4 font-weight-bold">{{substr($data->student_name, 0, 1)}}</span>
						@endif
					</div>
					<div class="symbol symbol-lg-75 symbol-circle symbol-primary d-none">
						<span class="font-size-h3 font-weight-boldest">JM</span>
					</div>
				</div>
				<!--end::Pic-->
				<!--begin::Title-->
				<div class="d-flex flex-column">
					<a href="#" class="text-dark font-weight-bold text-hover-primary font-size-h4 mb-0">{{$data->student_name}}</a>
					<span class="text-muted font-weight-bold">nisn# {{$data->nisn}}</span>
				</div>
				<!--end::Title-->
			</div>
			<!--end::Title-->
		</div>
		<!--end::User-->
		<!--begin::Desc-->
		<p class="mb-7">
		</p>
		<!--end::Desc-->
		<!--begin::Info-->
		<div class="mb-7">
			<div class="d-flex justify-content-between align-items-center">
				<span class="text-dark-75 font-weight-bolder mr-2">Email:</span>
				<a href="#" class="text-muted text-hover-primary">
					@if (Auth::guard('admin')->user()->id_scholl != null)
                    {{ substr($data->email, 0, 3)."**********"}}
                    @else
					{{$data->email}}
					@endif
				</a>
			</div>
			<div class="d-flex justify-content-between align-items-cente my-1">
				<span class="text-dark-75 font-weight-bolder mr-2">Phone:</span>
				<a href="#" class="text-muted text-hover-primary">
					@if (Auth::guard('admin')->user()->id_scholl != null)
                    {{ substr($data->phone, 0, 3)."**********"}}
                    @else
					{{$data->phone}}
					@endif
				</a>
			</div>
			<div class="d-flex justify-content-between align-items-center">
				<span class="text-dark-75 font-weight-bolder mr-2">Domisili:</span>
				<span class="text-muted text-hover-primary">{{$data->name}}</span>
			</div>
		</div>
		<!--end::Info-->
	</div>
	<!--end::Body-->
</div>
<!--end::Card-->