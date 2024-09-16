@extends('frontend.layout.master')
<link rel="stylesheet" href="/assets/frontend/css/acc.css">
@section('content')

<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="{{ asset('assets/frontend/img/breadcrumb.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2></h2>
                    <div class="breadcrumb__option">
                        <a href="/"></a>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<section class="breadcrumb-section set-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <nav>
                    <div class="nav nav-tabs nav-fill">
                        <a href="{{ route('account') }}" class="nav-item nav-link {{ request()->segment(1) == 'tai-khoan' ? 'active' : '' }}">Tài khoản</a>
                        <a href="{{ route('account.orderHistory') }}" class="nav-item nav-link {{ request()->segment(1) == 'lich-su-don-hang' ? 'active' : '' }}">Lịch sử đơn hàng</a>
                        <a href="{{ route('account.change-password') }}" class="nav-item nav-link {{ request()->segment(1) == 'doi-mat-khau' ? 'active' : '' }}">Đổi mật khẩu</a>
                    </div>
                </nav>
            </div>
        </div>
        <form id="login-form" class="form" action="{{route('account.update')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <!--Form Sign In-->
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="signin-container">
                        <br>
                        <br>
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="email" class="text-dark">Email</label><br>
                            <div class="col-9 text-start">
                                <input class="form-control" type="email" name="email" id="email" value="{{ Auth::guard('web')->user()->email }}" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="text-dark">Họ Tên</label><br>
                            <div class="col-9 text-start">
                                <input class="form-control" type="text" name="name" id="name" value="{{ Auth::guard('web')->user()->name }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phone" class="text-dark">Số điện thoại</label><br>
                            <div class="col-9 text-start">
                                <input class="form-control" type="text" name="phone" id="phone" value="{{ Auth::guard('web')->user()->phone }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address" class="text-dark">Địa chỉ</label><br>
                            <div class="col-9 text-start">
                                <input class="form-control" type="text" name="address" id="address" value="{{ Auth::guard('web')->user()->address }}">
                            </div>
                        </div>
                    </div>
                </div>
              
                <!-- Avatar Upload and Submit Button -->
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="register-in-container">
                        <br>
                        <div class="col-12 d-flex align-items-center justify-content-center">
                            <div class="user-avatar">
                                <div class="user-avatar-img">
                                    <img src="{{ Auth::guard('web')->user()->avatar ?? '/assets/frontend/img/no-avatar.png' }}" id="user-avatar" alt="user-avatar">
                                </div>
                                <div class="user-avatar-btn text-primary">
                                    <label for="avatar" style="color: #7fad39 ">Upload ảnh
                                        <input accept="image/png, image/jpg, image/jpeg" hidden onchange="previewImg(this,'user-avatar')" type="file" name="avatar" id="avatar">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <button type="submit" class="btn btn-md" style="background-color: #7fad39; color: white;">
                                Cập Nhật
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>    
    </div>
</section>


@endsection



