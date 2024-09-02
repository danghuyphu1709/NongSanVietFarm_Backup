@extends('admin.layout.master')
@section('title', 'Thêm mới khách hàng')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/datatable/index.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/select2/index.min.css') }}"/>
@endsection
<style>
    #lfm {
        display: none;
    }
</style>
@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
    <form action="{{ route('user.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <section class="section">
            <div class="row">
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body text-center" style="display: flex;flex-direction: column;justify-content: center;">
                            <!-- Avatar Upload -->
                            <a id="lfm" class="icon camera" title="Chọn Hình" data-input="thumbnail" data-preview="avatar-img" data-base64="inputBase64">
                                <i class="fa fa-camera"></i>
                            </a>
                            <input id="thumbnail" class="form-control" type="hidden" name="avatar">
                            <input type="hidden" id="inputBase64" name="base64">
                            <div style="width: 100%">
                                <img id="avatar-img"
                                    class="rounded-circle mb-3"
                                    src="{{ old('avatar') ? asset(old('avatar')) : asset('client/assets/img/avatar.jpg') }}"
                                    style="width: 150px; height: 150px; object-fit: cover; cursor: pointer; text-align: center; margin: 20px;">
                            </div>
                            {!! ShowError($errors, 'avatar') !!}
                            <label for="avatar" class="form-label">Ảnh đại diện <span class="text-danger">*</span></label>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Thêm Mới Thành Viên</h5>
                            @csrf
                            <div class="row mb-3">
                                <!-- Name Field -->
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Tên khách hàng <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name"
                                           value="{{ old('name') }}">
                                    {!! ShowError($errors, 'name') !!}
                                </div>

                                <!-- Email Field -->
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email"
                                           value="{{ old('email') }}">
                                    {!! ShowError($errors, 'email') !!}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <!-- Phone Field -->
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                           value="{{ old('phone') }}">
                                    {!! ShowError($errors, 'phone') !!}
                                </div>

                                <!-- Password Field -->
                                <div class="col-md-6">
                                    <label for="password" class="form-label">Mật khẩu <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="password" name="password">
                                    {!! ShowError($errors, 'password') !!}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <!-- Provinces, Districts, and Wards -->
                                <div class="col-md-4">
                                    <label for="province_id" class="form-label">Tỉnh / Thành phố <span class="text-danger">*</span></label>
                                    <select id="province_id" name="province_id" class="form-control select2">
                                        <option value="">Chọn Tỉnh / Thành phố</option>
                                    </select>
                                    {!! ShowError($errors, 'province_id') !!}
                                </div>

                                <div class="col-md-4">
                                    <label for="district_id" class="form-label">Quận / Huyện <span class="text-danger">*</span></label>
                                    <select id="district_id" name="district_id" class="form-control select2">
                                        <option value="">Chọn Quận / Huyện</option>
                                    </select>
                                    {!! ShowError($errors, 'district_id') !!}
                                </div>

                                <div class="col-md-4">
                                    <label for="ward_id" class="form-label">Xã / Phường <span class="text-danger">*</span></label>
                                    <select id="ward_id" name="ward_id" class="form-control select2">
                                        <option value="">Chọn Xã / Phường</option>
                                    </select>
                                    {!! ShowError($errors, 'ward_id') !!}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <!-- Address Field -->
                                <div class="col-md-12">
                                    <label for="address" class="form-label">Địa chỉ <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="address"
                                              name="address">{{ old('address') }}</textarea>
                                    {!! ShowError($errors, 'address') !!}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <!-- Status Switch -->
                                <div class="col-md-3">
                                    <label for="status" class="form-label">Trạng Thái</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="statusSwitch" name="status"
                                               >
                                        <label class="form-check-label" for="statusSwitch">
                                            Đang hoạt động
                                        </label>
                                    </div>
                                </div>
                                <!-- Active Switch -->
                                <div class="col-md-3">
                                    <label for="active" class="form-label">Kích Hoạt</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="activeSwitch" name="active"
                                               >
                                        <label class="form-check-label" for="activeSwitch">
                                            Kích hoạt
                                        </label>
                                    </div>
                                </div>
                            </div>
                           {{-- <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Vai Trò:</h4>
                                <div class="flex-shrink-0">

                                </div>
                            </div><!-- end card header -->
                            <div class="card-body">
                                <p class="text-muted">Danh vai trò:</p>
                                @error('roles')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                                <div class="live-preview">
                                    <div class="row">
                                        @foreach($roles as $key => $item)
                                            <div class="col-md-4">
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input permission-checkbox" type="checkbox" id="gridCheck1" name="roles[]" value="{{ $item->id }}" {{ $item->checked ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="gridCheck1">{{ \App\Enums\Roles::from($item->id)->label() }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <!--end row-->
                                </div>
                            </div>
                            <!--end card-body-->
                        </div> --}}
                            <div class="row mb-3">
                                <!-- Submit and Cancel Buttons -->
                                <div class="col-md-12 text-end">
                                    <a href="{{ route('user.index') }}" class="btn btn-info me-2">Quay Lại</a>
                                    <button type="submit" class="btn btn-primary">Tạo mới</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
@endsection
@section('js')
    <script src="{{ asset('admin.js.app') }}"></script>
    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/select2/index.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/product/addProduct.js') }}"></script>
    <script src="/path-to-your-tinymce/tinymce.min.js"></script>
    <script>
        $(document).ready(function () {
            var oldProvinceId = "{{ old('province_id') }}";
            var oldDistrictId = "{{ old('district_id') }}";
            var oldWardId = "{{ old('ward_id') }}";

            // Load provinces
            $.ajax({
                url: '/api/provinces',
                method: 'GET',
                success: function (data) {
                    var options = '<option value="">Chọn Tỉnh / Thành phố</option>';
                    $.each(data, function (key, value) {
                        options += '<option value="' + value.ProvinceID + '"' + (oldProvinceId == value.ProvinceID ? ' selected' : '') + '>' + value.ProvinceName + '</option>';
                    });
                    $('#province_id').html(options);

                    // Trigger change event if oldProvinceId is set
                    if (oldProvinceId) {
                        $('#province_id').trigger('change');
                    }
                }
            });

            // Load districts when province changes
            $('#province_id').change(function () {
                var provinceId = $(this).val();
                if (provinceId) {
                    $.ajax({
                        url: '/api/districts/' + provinceId,
                        method: 'GET',
                        success: function (data) {
                            var options = '<option value="">Chọn Quận / Huyện</option>';
                            $.each(data, function (key, value) {
                                options += '<option value="' + value.DistrictID + '"' + (oldDistrictId == value.DistrictID ? ' selected' : '') + '>' + value.DistrictName + '</option>';
                            });
                            $('#district_id').html(options);

                            // Trigger change event if oldDistrictId is set
                            if (oldDistrictId) {
                                $('#district_id').trigger('change');
                            }
                        }
                    });
                } else {
                    $('#district_id').html('<option value="">Chọn Quận / Huyện</option>');
                    $('#ward_id').html('<option value="">Chọn Xã / Phường</option>');
                }
            });

            // Load wards when district changes
            $('#district_id').change(function () {
                var districtId = $(this).val();
                if (districtId) {
                    $.ajax({
                        url: '/api/wards/' + districtId,
                        method: 'GET',
                        success: function (data) {
                            var options = '<option value="">Chọn Xã / Phường</option>';
                            $.each(data, function (key, value) {
                                options += '<option value="' + value.id + '"' + (oldWardId == value.id ? ' selected' : '') + '>' + value.WardName + '</option>';
                            });
                            $('#ward_id').html(options);
                        }
                    });
                } else {
                    $('#ward_id').html('<option value="">Chọn Xã / Phường</option>');
                }
            });

            // File Manager for Avatar
            var route_prefix = "{{ url('laravel-filemanager') }}";
            $('#lfm').filemanager('image', {prefix: route_prefix});
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#lfm').filemanager('image');
            $('#avatar-img').on('click', function () {
                $('#lfm').trigger('click');
            });
            window.setFileField = function (fileUrl) {
                $('#thumbnail').val(fileUrl);
                $('#avatar-img').attr('src', fileUrl);
            };
        });
    </script>
@endsection
