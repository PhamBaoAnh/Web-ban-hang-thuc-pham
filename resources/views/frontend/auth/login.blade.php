@extends('frontend.layout.master')

@section('content')
<div class="page-contain login-page">
<!-- Main content -->
<div id="main-content" class="main-content">
    <div class="container">
        <div class="row">

            <!--Form Sign In-->
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="signin-container">
                <form id="login-form" class="form" action="{{route('loginPost')}}" method="post">
                        @csrf
                        <br>
                        <h2 class="text-center text-dark">Đăng nhập</h2>
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @error('status')
                            <p class="text-danger">{{$message}}</p>
                        @enderror
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
                        <div class="form-group" >
                            <a href="{{route('password.request')}}" style="color: #7fad39;">Quên mật khẩu?</a>
                        </div>
                        <div class="form-group">
                        <button type="submit" class="btn btn-md" style="background-color: #7fad39; color: white;">
                            Đăng nhập
                        </button>

                        </div>

                    </form>
                </div>
            </div>

            <!--Go to Register form-->
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="register-in-container">
                    <div class="intro">
                        <h4 class="box-title">New Customer?</h4>
                        <p class="sub-title">Create an account with us and you’ll be able to:</p>
                        <ul class="lis">
                            <li>Check out faster</li>
                            <li>Save multiple shipping anddesses</li>
                            <li>Access your order history</li>
                            <li>Track new orders</li>
                            <li>Save items to your Wishlist</li>
                        </ul>
                        <a href="{{route('register')}}" class="btn btn-bold">Đăng Kí Tài Khoản</a>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

</div>


@endsection
