@extends('admin.layout.master')
@section('title', 'Thư viện hình ảnh')
@section('css')
<link rel="stylesheet" href="{{ asset('admin/assets/vendor/datatable/index.min.css') }}" />
@endsection
@section('content')
<div class="pagetitle">
    <div class="d-flex" style="justify-content: space-between">
      <h1>Dashboard</h1>
    </div>
    <nav >
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Home</a></li>
        <li class="breadcrumb-item">Media</li>
      </ol>
    </nav>
  </div>
  <div class="container-fluid">
    <iframe src="/filemanager?editor=photos&type=Images" style="width: 100%; height: 100vh; overflow: hidden; border: none;"></iframe>
  </div>

  @section('js')
  <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
  <script src="{{ asset('admin/assets/vendor/select2/index.min.js')}}"></script> 
  <script src="{{ asset('admin/assets/js/product/addProduct.js')}}"></script>
  <script src="/path-to-your-tinymce/tinymce.min.js"></script>
  @endsection
@endsection