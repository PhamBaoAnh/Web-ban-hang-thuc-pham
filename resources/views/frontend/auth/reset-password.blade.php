@extends('frontend.layout.master')

@section('content')

<style>

#login .container #login-row #login-column #login-box {
  max-width: 600px;
  border: 1px solid #d7d7d7;
}
#login .container #login-row #login-column #login-box #login-form {
  padding: 20px;
}
#login .container #login-row #login-column #login-box #login-form #register-link {
  margin-top: -45px;
}
html, body {
  margin: 0;
  padding: 0;
}

#login {
  display: flex;
  justify-content: center;
  align-items: center;
 
  padding-top:50px;  /* Adjust as needed */
  padding-bottom:50px;  /* Adjust as needed */
}
.btn {
        background-color: #7fad39;
        color: white;
        border: none; /* Loại bỏ viền mặc định nếu có */
        padding: 10px 20px; /* Tạo khoảng cách trong nút */
        cursor: pointer; /* Con trỏ chuột khi hover */
        border-radius: 4px; /* Bo tròn các góc của nút */
        font-size: 16px; /* Kích thước chữ */
    }

    .btn:hover {
        background-color: #699e31; /* Màu nền khi hover */
    }

    .btn:active {
        background-color: #567c27; /* Màu nền khi nút được bấm */
    }
</style>

<div id="login" class="m-5">
    <div class="container">
        <div id="login-row" class="row justify-content-center align-items-center">
            <div id="login-column" class="col-md-6">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div id="login-box" class="col-md-12 shadow-none p-3 mb-5 bg-light rounded">
                    <form id="login-form" class="form" action="{{route('password.update')}}" method="post">
                        @csrf
                        <input type="hidden" name="token"  value="{{ $token}}">
                        <h3 class="text-center text-dark mb-4">Đặt lại mật khẩu</h3>
                        <div class="form-group">
                            <input type="text" name="email" placeholder="Email" class="form-control">
                            @error('email')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" placeholder="Mật khẩu mới" class="form-control">
                            @error('password')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="password" name="password_confirmation" placeholder="Xác nhận mật khẩu" class="form-control">
                        </div>
                        <div class="form-group text-center">
                            <button type="submit"class="btn text-white btn-md" style="background: #7fad39">
                                Xác nhận
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection