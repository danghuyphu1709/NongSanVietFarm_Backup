@extends('admin.layout.master')
@section('title', 'Thêm mới nhãn')
@section('content')
    <div class="pagetitle">
      <h1>Thêm mới nhãn</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a></li>
          <li class="breadcrumb-item"><a href="{{ route('tags.index') }}">Nhãn</a></li>
          <li class="breadcrumb-item"><a href="{{ route('tags.create') }}" class="active">Thêm mới</a></li>
        </ol>
      </nav>
    </div>
    <!-- End Page Title -->
    <section class="section">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-body">
                <!-- Form -->
                <form action="{{ route('tags.store') }}" method="POST" data-toggle="validator" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3 mt-4">
                        <label for="name" class="col-sm-2 col-form-label">Tên nhãn</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="name" name="name">
                          @error('name')
                            <div style="color: red">{{ $message }}</div>
                          @enderror
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                        <button type="reset" class="btn btn-secondary">Hoàn tác</button>
                    </div>
                </form>
                <!-- End Horizontal Form -->
              </div>
            </div>
          </div>
        </div>
      </section>
@endsection
