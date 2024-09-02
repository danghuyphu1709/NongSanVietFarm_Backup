@extends('admin.layout.master')
@section('content')
    <style>
        #lfm {
            display: none;
        }
    </style>
    @php
        $update = session('update');
    @endphp
    <div class="container mt-5">
        <form action="{{ route('admin.profile.update', \Auth::guard('admin')->user()->id) }}" method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <a id="lfm" data-input="thumbnail" data-preview="avatar-img" data-base64="inputBase64" class="btn btn-primary text-white">
                                <i class="fa fa-picture-o"></i> Hình ảnh
                            </a>
                            <input id="thumbnail" class="form-control" type="hidden" name="avatar" value="{{ old('avatar', \Auth::guard('admin')->user()->avatar) }}">
                            <input type="hidden" id="inputBase64" name="base64">
                            <img id="avatar-img"
                                 src="{{ old('avatar', \Auth::guard('admin')->user()->avatar) ? old('avatar', \Auth::guard('admin')->user()->avatar) : asset('client/assets/img/avatar.jpg') }}"
                                 alt="{{ \Auth::guard('admin')->user()->name }}"
                                 class="rounded-circle mb-3"
                                 style="width: 100px; height: 100px; object-fit: cover; cursor: pointer; text-align: center;margin: 20px">
                            @if ($errors->has('avatar'))
                                <span class="text-danger">{{ $errors->first('avatar') }}</span>
                            @endif

                            <h4>{{ \Auth::guard('admin')->user()->name }}</h4>
                            <p class="text-muted">{{ \Auth::guard('admin')->user()->email }}</p>
                            <a href="{{route('admin.profile')}}" class="btn btn-primary btn-sm mt-3 text-white">
                                <i class="bi bi-info-circle-fill me-2"></i>Thông tin chính
                            </a>
                            <a href="{{route('admin.showChangePasswordForm')}}"
                               class="btn btn-primary btn-sm mt-3 text-white">
                                <i class="bi bi-shield-lock-fill me-2"></i>Đổi mật khẩu
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5>Thông Tin Hồ Sơ</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="name" class="form-label">Tên <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name" class="form-control"
                                               value="{{ \Auth::guard('admin')->user()->name }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input disabled type="email" name="email" id="email" class="form-control"
                                               value="{{ \Auth::guard('admin')->user()->email }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Số điện thoại <span class="text-danger">*</span></label>
                                        <input type="text" name="phone" id="phone" class="form-control"
                                               value="{{ \Auth::guard('admin')->user()->phone }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <!-- Dropdown cho địa chỉ -->
                                <div class="col-md-4">
                                    <label for="province_id" class="form-label">Tỉnh / Thành phố <span class="text-danger">*</span></label>
                                    <select id="province_id" name="province_id" class="form-control" required>
                                        <option value="1">Chọn Tỉnh / Thành phố</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="district_id" class="form-label">Quận / Huyện <span class="text-danger">*</span></label>
                                    <select id="district_id" name="district_id" class="form-control">
                                        <option value="1">Chọn Quận / Huyện</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="ward_id" class="form-label">Xã / Phường <span class="text-danger">*</span></label>
                                    <select id="ward_id" name="ward_id" class="form-control">
                                        <option value="1">Chọn Xã / Phường</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="address" class="form-label">Địa chỉ <span class="text-danger">*</span></label>
                                        <textarea name="address" id="address"
                                                  class="form-control">{{ \Auth::guard('admin')->user()->address }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary text-white">Cập Nhật Hồ Sơ</button>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    <script src="{{ asset('admin/assets/js/product/addProduct.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin/assets/js/showMessage/message.js') }}"></script>
    <script src="{{ asset('admin/assets/js/check-out/address_shipping.js') }}"></script>
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
    <script>
        $(document).ready(function () {
            // Hiển thị thông báo thành công nếu có
            let status = @json($update);
            let title = 'Bạn đã';
            let message = status;
            let icon = 'success';
            if (status) {
                showMessage(title, message, icon);
            }
        });
    </script>
    <script>
        $(document).ready(function () {
            var oldProvinceId = "{{ old('province_id', \Auth::guard('admin')->user()->province_id) }}";
            var oldDistrictId = "{{ old('district_id',  \Auth::guard('admin')->user()->district_id) }}";
            var oldWardId = "{{ old('ward_id',  \Auth::guard('admin')->user()->ward_id) }}";

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

            $('#lfm').filemanager('image');
        });
    </script>
@endsection
