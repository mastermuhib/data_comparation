@extends('layout.app')
@section('asset')
<link rel="stylesheet" type="text/css" href="{{URL::asset('assets')}}/vendors/css/forms/select/select2.min.css">
@endsection
@section('title', 'Log Admin')
@section('content')
<div class="card-body py-15 py-lg-20">
                
    <!--begin::Title-->
    <h1 class="fw-bolder fs-2qx text-gray-900 mb-4">
        System Error
    </h1>
    <!--end::Title--> 
    
    <!--begin::Text-->
    <div class="fw-semibold fs-6 text-gray-500 mb-7">
        Sistem sedang dalam perbaikan! Silahkan dicoba lagi dalam beberapa saat.
    </div>
    <!--end::Text--> 

    <!--begin::Illustration-->
    <div class="mb-11">
        <img src="{{URL::asset('assets')}}/media/auth/500-error.png" class="mw-100 mh-300px theme-light-show" alt="">
        <img src="{{URL::asset('assets')}}/media/auth/500-error-dark.png" class="mw-100 mh-300px theme-dark-show" alt="">
    </div>
    <!--end::Illustration-->
    
    <!--begin::Link-->
    <div class="mb-0">
        <a href="/welcome" class="btn btn-sm btn-primary">Return Home</a>
    </div>    
    <!--end::Link-->

</div>
@endsection
