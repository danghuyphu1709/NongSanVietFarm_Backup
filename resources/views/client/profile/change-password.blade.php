@extends('client.layouts.master')
@section('title', 'Thông tin tài khoản')
@section('content')
    @php
        $updated = session('update');
        $error = session('error');
    @endphp
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Thông tin tài khoản</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
            <li class="breadcrumb-item active text-white">Tài khoản</li>
        </ol>
    </div>
    <div class="container mt-5">
        @php
            $update = session('update');
        @endphp
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <img src="{{ auth()->user()->avatar ?? asset('client/assets/img/avatar.jpg') }}" alt="{{ auth()->user()->name }}"
                             class="rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover;">
                        <h4>{{ auth()->user()->name }}</h4>
                        <p class="text-muted">{{ auth()->user()->email }}</p>
                        <a href="{{ route('user.profile') }}" class="btn btn-primary btn-sm mt-3 text-white">
                            <i class="bi bi-info-circle-fill me-2"></i>Thông tin chính
                        </a>
                        <a href="{{ route('user.showChangePasswordForm') }}"
                           class="btn btn-primary btn-sm mt-3 text-white">
                            <i class="bi bi-shield-lock-fill me-2"></i>Đổi mật khẩu
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card mt-3">
                    <div class="card-header">
                        <h5>Đổi Mật Khẩu</h5>
                    </div>
                    <div class="card-body">
                        @if (auth()->user()->social_id)
                            <div class="alert alert-danger">
                                Bạn không thể đổi mật khẩu khi đăng nhập bằng Google.
                            </div>
                        @else
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <form action="{{ route('user.profile.change_password') }}" method="POST">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="new_password">Mật Khẩu Mới <span class="text-danger">*</span></label>
                                    <input type="password" name="new_password" id="new_password" class="form-control">
                                    {!! ShowError($errors,'new_password') !!}
                                </div>
                                <div class="form-group mb-3">
                                    <label for="new_password_confirmation">Xác Nhận Mật Khẩu Mới <span class="text-danger">*</span></label>
                                    <input type="password" name="new_password_confirmation"
                                           id="new_password_confirmation"
                                           class="form-control">

                                </div>
                                <button type="submit" class="btn btn-primary">Đổi Mật Khẩu</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin/assets/js/showMessage/message.js') }}"></script>
    <script>
        $(document).ready(function () {
            let status = @json($updated);
            if (status) {
                let title = 'Cập nhật thành công';
                let message = 'Hồ sơ của bạn đã được cập nhật thành công!';
                let icon = 'success';
                showMessage(title, message, icon);
            }
            @if (session('error'))
            Swal.fire({
                title: 'Lỗi',
                text: '{{ session('error') }}',
                icon: 'error',
                showConfirmButton: false,
                timer: 1500
            });
            @endif
        });
    </script>
@endsection
