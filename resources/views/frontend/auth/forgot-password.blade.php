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
</style>

<div id="login" class="m-5">
    <div class="container">
        <div id="login-row" class="row justify-content-center align-items-center">
            <div id="login-column" class="col-md-6">
                <div id="login-box" class="col-md-12 shadow-none p-3 mb-5 bg-light rounded">
                    <form id="login-form" class="form" action="{{route('password.email')}}" method="post">
                        @csrf
                        <h3 class="text-center text-dark">Quên mật khẩu</h3>
                        <p class="text-center mt-2">Một email chứa đường dẫn đặt lại mật khẩu mới sẽ được gửi đến hộp thư của bạn.</p>
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif          
                        <div class="form-group">
                            <input type="text" name="email" id="email" placeholder="email" class="form-control">
                            @error('email')
                                <p class="text-danger">{{$message}}</p>
                            @enderror
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