@extends('frontend.layout.master')

@section('content')

<div id="main-content" class="main-content">
    <div class="container">
        <div class="row">

            <!-- Form Sign In -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="signin-container">
                <form id="login-form" class="form" action="{{route('registerPost')}}" method="post">
                        @csrf
                        <h2 class="text-center text-dark">Đăng ký</h2>
                        <div class="form-group">
                            <label for="name" class="text-dark">Họ tên:</label><br>
                            <input type="text" name="name" id="name" class="form-control">
                            @error('name')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email" class="text-dark">Email:</label><br>
                            <input type="text" name="email" id="email" class="form-control">
                            @error('email')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password" class="text-dark">Mật khẩu:</label><br>
                            <input type="password" name="password" id="password" class="form-control">
                            @error('password')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation" class="text-dark">Xác nhận mật khẩu:</label><br>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                            @error('password_confirmation')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit"class="btn btn-md text-white" style="background: #7fad39; color: white;">
                                Đăng ký
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- New Customer Section -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
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
                        <a href="{{route('login')}}" class="btn btn-bold">Đăng Nhập Tài Khoản</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection