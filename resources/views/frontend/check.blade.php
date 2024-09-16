@extends('frontend.layout.master')

@section('content')

<link rel="stylesheet" href="{{ asset('assets/frontend/css/custom.css') }}">
<p>&nbsp;</p>
<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="{{asset('assets/frontend/img/breadcrumb.jpg')}}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Kiểm Tra Đơn Hàng</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<div id="tabs" class="project-tab">
    <div class="container shadow-sm bg-body rounded">
        <div class="row">
            <div class="col-md-12">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{session('success')}}
                    </div>
                @endif
                
                <div class="tab-content" >
                    <div class="tab-pane active show mt-5">
                        <div class="text-center mb-3">
                            <button type="button" class="btn btn-outline-primary mr-2" onclick="showForm('phone')">Số điện thoại</button>
                            <button type="button" class="btn btn-outline-primary mr-2" onclick="showForm('email')">Email</button>
                            <button type="button" class="btn btn-outline-primary" onclick="showForm('phone_email')">Số điện thoại và Email</button>
                        </div>
                        <form id="form-phone" class="form text-center" action="{{ route('order.check.result') }}" method="POST" style="display: none;">
                            @csrf
                            <h3 class="text-center text-dark"></h3>  
               <!--             <h3 class="text-center text-dark">Kiểm tra đơn hàng theo Số điện thoại</h3>  -->
                            <div class="form-group mt-3">
                                <input type="text" name="phone" id="phone" placeholder="Số điện thoại" class="form-control mx-auto" style="max-width: 300px; font-size: 1.2em;">
                                @error('phone')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group text-center mt-3">
                            <button type="submit" class="btn btn-lg" style="background: #7faf51; color: white;">Xác nhận</button>

                            </div>
                        </form>

                        <!-- Form kiểm tra theo Email -->
                        <form id="form-email" class="form text-center" action="{{ route('order.check.result') }}" method="POST" style="display: none;">
                            @csrf
                            <h3 class="text-center text-dark"></h3>
                            <div class="form-group mt-3">
                                <input type="email" name="email" id="email" placeholder="Email" class="form-control mx-auto" style="max-width: 300px; font-size: 1.2em;">
                                @error('email')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group text-center mt-3">
                            <button type="submit" class="btn btn-lg" style="background: #7faf51; color: white;">Xác nhận</button>


                            </div>
                        </form>

                        <!-- Form kiểm tra theo Số điện thoại và Email -->
                        <form id="form-phone-email" class="form text-center" action="{{ route('order.check.result') }}" method="POST" style="display: none;">
                            @csrf
                            <h3 class="text-center text-dark"></h3>
                            <div class="form-group mt-3">
                                <input type="text" name="phone" id="phone" placeholder="Số điện thoại" class="form-control mx-auto" style="max-width: 300px; font-size: 1.2em;">
                                @error('phone')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group mt-3">
                                <input type="email" name="email" id="email" placeholder="Email" class="form-control mx-auto" style="max-width: 300px; font-size: 1.2em;">
                                @error('email')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group text-center mt-3">
                            <button type="submit" class="btn btn-lg" style="background: #7faf51; color: white;">Kiểm Tra</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showForm(formType) {
        document.getElementById('form-phone').style.display = 'none';
        document.getElementById('form-email').style.display = 'none';
        document.getElementById('form-phone-email').style.display = 'none';

        if (formType === 'phone') {
            document.getElementById('form-phone').style.display = 'block';
        } else if (formType === 'email') {
            document.getElementById('form-email').style.display = 'block';
        } else if (formType === 'phone_email') {
            document.getElementById('form-phone-email').style.display = 'block';
        }
    }
</script>

@endsection
