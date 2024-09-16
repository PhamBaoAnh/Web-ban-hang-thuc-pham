@extends('frontend.layout.master')

@section('content')
<link rel="stylesheet" href="/assets/frontend/css/acc.css">

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
       
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <form class="form-change-password" method="POST" action="{{ route('account.update-password') }}">
                    @csrf
                    <div class="signin-container">
                        <br>
                        <br>
                        <div class="form-group">
                            <label for="email" class="text-dark">Mật khẩu cũ</label><br>
                            <div class="col-9 text-start">
                                <input type="password" class="form-control" name="old_password" placeholder="Mật khẩu cũ">
                                @error('old_password')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="text-dark">Mật khẩu mới</label><br>
                            <div class="col-9 text-start">
                                <input type="password" class="form-control" name="password" placeholder="Mật khẩu mới">
                                @error('password')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="phone" class="text-dark">Xác nhận mật khẩu</label><br>
                            <div class="col-9 text-start">
                                <input type="password" class="form-control" name="password_confirmation" placeholder="Xác nhận mật khẩu">
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn text-white mb-5" style="background: #7fad39; color: white;">Cập nhật</button>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="register-in-container">
                    <div class="intro">
                        <h4 class="box-title">New Customer?</h4>
                        <p class="sub-title">Create an account with us and you’ll be able to:</p>
                        <ul class="lis">
                            <li>Check out faster</li>
                            <li>Save multiple shipping addresses</li>
                            <li>Access your order history</li>
                            <li>Track new orders</li>
                            <li>Save items to your Wishlist</li>
                        </ul>
                        <a href="{{ route('register') }}" class="btn btn-bold">Đăng Kí Tài Khoản</a>
                    </div>
                </div>
            </div>
        </div>
          
    </div>
</section>

@endsection
