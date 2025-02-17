  <style>
    .dropdown-menu-cart {
        min-width: 31.25rem;
    }
          .shadow {
        top: 0 !important;
    }
    .div-cart::-webkit-scrollbar {
        width: 8px; /* Đặt chiều rộng của thanh cuộn */
        height: 8px; /* Đặt chiều cao của thanh cuộn (khi cuộn ngang) */
    }

    .search-input {
        width: 0;
        padding-right: 0;
        opacity: 0;
        transition: width 0.3s ease, padding-right 0.3s ease, opacity 0.3s ease;
    }

    .search-input.expanded {
        width: 200px; 
        padding-right: 45px;
        opacity: 1;
    }
        @media (max-width: 576px) { /* Màn hình nhỏ hơn hoặc bằng 576px */
        .dropdown-menu-cart {
            min-width: 0 !important;
        }
        .div-cart {
            max-height: 220px !important;
            overflow: auto !important;
        }
    }
    @media (max-width: 1024px) { /* Màn hình nhỏ hơn hoặc bằng 768px */
        .navbar {
            height: 100%;
            padding-top: 0;
            padding-bottom: 0;
        }
        .div-search {
            margin-left: 0 !important;
        }
        .div-user {
            margin: 0.25rem !important;
        }
        .div-cart {
            max-height: 220px !important;
            overflow: auto !important;
        }
    }
</style>
<!-- Navbar start -->
<div class="fixed-top container-fluid">
  <div class="container px-0">
      <nav class="navbar navbar-light bg-white navbar-expand-xl">
          <a href="{{ route('home') }}" class="navbar-brand">
            <img src="{{ asset('client/assets/img/logo.png') }}" height="100px">
          </a>
          <div class="d-flex div-responsive">
            <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars text-primary"></span>
            </button>
          </div>
          <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                <div class="navbar-nav mx-auto">
                    <a href="{{ route('home') }}"
                       class="nav-item nav-link @if(request()->routeIs('home')) active @endif"><b>Trang chủ</b></a>
                    <a href="{{ route('shop') }}"
                       class="nav-item nav-link @if(request()->is('*thuong-hieu*') || request()->is('*danh-muc*') || request()->is('*san-pham*') || request()->is('*cua-hang*')) active @endif"><b>Cửa hàng</b></a>
                    <a href="{{ route('postclient.index') }}"
                       class="nav-item nav-link @if(request()->is('*bai-viet*')) active @endif"><b>Bài viết</b></a>
                    <a href="{{route('contact.index')}}" class="nav-item nav-link @if(request()->is('*lien-he*')) active @endif"><b>Liên hệ</b></a>
                    <a href="{{route('policy.index')}}" class="nav-item nav-link @if(request()->is('*chinh-sach*')) active @endif"><b>Chính sách</b></a>
                </div>
                <div class="d-flex align-items-center m-3 me-0 div-user">
                    <div class="div-search position-relative mx-auto">
                        <form action="{{ route('shop') }}" method="GET" class="search-form">
                            <input class="form-control border-2 border-secondary rounded-pill search-input" type="text" name="search" placeholder="Tìm kiếm..." style="padding-right: 45px;">
                            <button type="button" class="btn border-2 border-secondary position-absolute rounded-pill text-white h-100 search-button" style="top: 0; right: 0;">
                                <i class="fas fa-search text-primary"></i>
                            </button>
                            <button type="submit" class="d-none submit-btn"></button>
                        </form>
                    </div>                    
                    <div class="dropdown topbar-head-dropdown ms-1 header-item div-cart-responsive">
                        <button type="button"
                                class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle position-relative my-auto cart-button"
                                data-url="{{ route('cart.getCart') }}"
                                style="outline: none; box-shadow: none; color: #81c408;" id="page-header-cart-dropdown"
                                data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true"
                                aria-expanded="false">
                            <i class="fa fa-shopping-bag fa-2x"></i>
                            <span
                                class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1 cart-count"
                                style="top: -5px; left: 30px; height: 20px; min-width: 20px;">{{ session()->exists('cart') ? count(session()->get('cart')) : 0 }}</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end p-0 dropdown-menu-cart"
                              aria-labelledby="page-header-cart-dropdown">
                            @if (session('cart'))
                                <div class="p-3 border-top-0 border-start-0 border-end-0 border-dashed border">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="m-0 fs-16 fw-semibold">Giỏ hàng</h6>
                                        </div>
                                        <div class="col-auto">
                                        </div>
                                    </div>
                                </div>
                                <div data-simplebar style="max-height: 330px;" class="div-cart overflow-auto">
                                    <div class="p-2 cart-items">
                                        @php $total = 0 @endphp
                                        @foreach((array) session('cart') as $id => $item)
                                            @php $total += $item['price'] * $item['quantity'] @endphp
                                        @endforeach
                                        @foreach (session('cart') as $id => $item)
                                            <div class="d-block dropdown-item dropdown-item-cart text-wrap px-3 py-2">
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $item['image'] }}" class="me-3 rounded-circle image"
                                                         style="width: 4.5rem; height: 4.5rem" alt="user-pic">
                                                    <div class="flex-grow-1">
                                                        <h6 class="mt-0 mb-1 fs-14">
                                                            <a class="text-reset name">{{ $item['name'] }}</a>
                                                        </h6>
                                                        <p class="mb-0 fs-12 text-muted">
                                                            Số lượng: <span class="quantity">{{ $item['quantity'] }} x {{number_format($item['price']) }}đ</span>
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <h5 class="m-0 fw-normal total">{{number_format($item['price'] * $item['quantity']) }} 
                                                            <span class="d-inline-block"> VND</span></h5>
                                                    </div>
                                                    <div class="ps-2">
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="p-3 border-bottom-0 border-start-0 border-end-0 border-dashed border"
                                     id="checkout-elem">
                                    <div class="d-flex justify-content-between align-items-center pb-3">
                                        <h5 class="m-0 text-muted">Tổng: </h5>
                                        <div class="px-2">
                                            <h5 class="m-0" id="cart-item-total">{{ number_format($total) }}đ</h5>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <a href="{{ route('cart.index') }}"
                                           class="btn btn-secondary text-center w-100 m-1">Giỏ hàng</a>
                                        <a href="{{ route('checkout') }}" class="btn btn-success text-center w-100 m-1">Checkout</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="dropdown header-item topbar-user">
                        @if (auth()->check())
                            <button type="button" class="btn" style="outline: none; box-shadow: none; color: #81c408;"
                                    id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                <i class="fas fa-user fa-2x"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" style="min-width: 13rem">
                                <!-- item-->
                                <h6 class="dropdown-header">Welcome {{ auth()->user()->name }}!</h6>
                                <a class="dropdown-item" href="{{ route('user.profile') }}">
                                    <i class="bi bi-person me-2"></i>
                                    <span>Thông tin cá nhân</span>
                                </a>
                                <a class="dropdown-item" href="{{ route('order.index') }}">
                                    <i class="bi bi-cart-check"></i>
                                    <span>Đơn hàng</span>
                                </a>
                                <div class="dropdown-divider"></div>
                                {{-- <a class="dropdown-item" href="{{ Auth::logout() }}"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Đăng xuất</span></a> --}}
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Đăng xuất</button>
                                </form>
                            </div>
                        @else
                            <button type="button" class="btn" style="outline: none; box-shadow: none; color: #81c408;"
                                    id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                <i class="fas fa-user fa-2x"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" style="min-width: 13rem">
                                <a class="dropdown-item" href="{{ route('clientlogin') }}"><i
                                        class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span
                                        class="align-middle" data-key="t-logout">Đăng nhập</span></a>
                                <a class="dropdown-item" href="{{ route('register') }}"><i
                                        class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span
                                        class="align-middle" data-key="t-logout">Đăng ký</span></a>
                                @endif
                            </div>
                    </div>
                </div>
        </nav>
    </div>
</div>
<!-- Navbar End -->

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.querySelector('.search-input');
        const searchButton = document.querySelector('.search-button');
        const submitButton = document.querySelector('.submit-btn');
        const searchForm = document.querySelector('.search-form');

        let inputExpanded = false;

        function handleClickOutside(event) {
            if (!searchForm.contains(event.target)) {
                // Nếu nhấp ra ngoài form, thu gọn ô nhập liệu
                searchInput.classList.remove('expanded');
                inputExpanded = false;
            }
        }

        searchButton.addEventListener('click', function () {
            if (!inputExpanded) {
                // Mở rộng ô nhập liệu
                searchInput.classList.add('expanded');
                inputExpanded = true;
            } else {
                // Kiểm tra xem ô nhập liệu có dữ liệu không
                if (searchInput.value.trim() !== '') {
                    // Gửi form nếu có dữ liệu
                    submitButton.click();
                } else {
                    // Ngược lại, thu gọn ô nhập liệu
                    searchInput.classList.remove('expanded');
                    inputExpanded = false;
                }
            }
        });

        // Thêm sự kiện để ẩn ô nhập liệu khi nhấp ra ngoài
        document.addEventListener('click', handleClickOutside);
        const cartDiv = document.querySelector('.div-cart-responsive');
        const targetDiv = document.querySelector('.div-responsive'); // Thẻ div mà bạn muốn di chuyển vào
        const originalParent = cartDiv.parentElement;
        function moveCartDiv() {
            if (window.innerWidth <= 1024) { // Độ rộng màn hình khi responsive
                if (!targetDiv.contains(cartDiv)) {
                    targetDiv.appendChild(cartDiv);
                }
            } else {
                if (cartDiv.parentElement !== originalParent) {
                    originalParent.appendChild(cartDiv); // Di chuyển lại vị trí ban đầu khi không responsive
                }
            }
        }
        // Gọi hàm ngay khi trang được tải và khi thay đổi kích thước cửa sổ
        moveCartDiv();
        
        window.addEventListener('resize', moveCartDiv);
    });
</script>