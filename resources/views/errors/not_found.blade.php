@extends('layout.app')
@section('asset')
<link rel="stylesheet" type="text/css" href="{{URL::asset('assets')}}/vendors/css/forms/select/select2.min.css">
@endsection
@section('title', 'ID Tidak ditemukan')
@section('content')
<div class="text-center mt-10">
    <img src="{{image_blank()}}" style="width: 200px;">
    <br>
    <h1><span class="font-weight-bolder text-dark">ID Tidak ditemukan</span></h1>
    <p>Periksa kembali ID nya</p>
</div>
@endsection
