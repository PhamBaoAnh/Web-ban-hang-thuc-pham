@extends('frontend.layout.master')
<style>
    .horizontal-radio {
    display: inline-block;
    margin-right: 20px; /* Adjust as needed */
}

.horizontal-radio label {
    display: inline-flex;
    align-items: center;
}

.horizontal-radio input[type="radio"] {
    display: none; /* Hide the actual radio button */
}

.horizontal-radio .checkmark {
    display: inline-block;
    width: 20px; /* Adjust as needed */
    height: 20px; /* Adjust as needed */
    border: 1px solid #ccc; /* Example border style */
    border-radius: 50%; /* Ensures it's circular */
    margin-right: 10px; /* Adjust as needed */
    position: relative;
}

.horizontal-radio input[type="radio"]:checked + .checkmark::after {
    content: "";
    display: block;
    width: 10px; /* Size of the inner circle */
    height: 10px; /* Size of the inner circle */
    background-color: #2196F3; /* Color when checked */
    border-radius: 50%; /* Ensures it's circular */
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}
.payment-methods-container {
    display: flex;
    justify-content: center; /* căn giữa theo chiều ngang */
    align-items: center; /* căn giữa theo chiều dọc */
}

.payment-methods-container .checkout__input__radio {
    margin-right: 20px; /* Khoảng cách giữa các phương thức thanh toán */
}
.text-center {
    text-align: center; /* Căn giữa nội dung theo chiều ngang */
}

.wrap-btn {
    margin-top: 20px; /* Khoảng cách từ nút lên trên */
    margin-bottom: 20px; /* Khoảng cách từ nút xuống dưới */
}

.btn-submit {
    padding: 12px 50px; /* Điều chỉnh padding để nút lớn hơn */
    font-size: 18px; /* Kích thước chữ */
    border-radius: 8px; /* Bo tròn góc */
    background-color: #007bff; /* Màu nền */
    color: #ffffff; /* Màu chữ */
    border: none; /* Bỏ viền */
    cursor: pointer; /* Đổi con trỏ chuột khi di chuyển qua nút */
}

.btn-submit:hover {
    background-color: #0056b3; /* Màu nền khi hover */
}


</style>
@section('content')
   <!-- Hero Section -->
   <div class="hero-section hero-background">
        <h1 class="page-title">Organic Fruits</h1>
    </div>

    <!-- Navigation section -->
    <div class="container">
        <nav class="biolife-nav">
            <ul>
                <li class="nav-item"><a href="index-2.html" class="permal-link">Trang chủ</a></li>
                <li class="nav-item"><span class="current-page">Đặt hàng</span></li>
            </ul>
        </nav>
    </div>

    <div class="page-contain checkout">
        <form action="{{ route('checkoutPost') }}" method="POST" class="form-now">
            @csrf
            <!-- Main content -->
            <div id="main-content" class="main-content">
                <div class="container sm-margin-top-10px">
                    <div class="row">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="signin-container">
                                <div class="form-row">
                                    <label for="name">Họ Tên <span>*</span></label>
                                    <input type="text" id="name" name="name" value="{{ old('name', Auth::check() ? Auth::guard('web')->user()->name : '') }}" class="txt-input" required>
                                    @error('name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-row">
                                    <label for="email">Email<span>*</span></label>
                                    <input type="email" id="email" name="email" value="{{ old('email', Auth::check() ? Auth::guard('web')->user()->email : '') }}" class="txt-input" required>
                                    @error('email')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-row">
                                    <label for="phone">Số điện thoại:<span class="requite">*</span></label>
                                    <input type="text" id="phone" name="phone" value="{{ old('phone', Auth::check() ? Auth::guard('web')->user()->phone : '') }}" class="txt-input" required>
                                    @error('phone')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-row">
                                    <label for="address">Địa chỉ nhận hàng:<span class="requite">*</span></label>
                                    <input type="text" id="address" name="address" value="{{ old('address', Auth::check() ? Auth::guard('web')->user()->address : '') }}" class="txt-input" required>
                                    @error('address')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="form-row">
                                    <label for="note">Ghi chú:</label>
                                    <input type="text" id="note" name="note" value="{{ old('note') }}" class="txt-input">
                                    @error('note')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Order Summary -->
                        <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12 sm-padding-top-48px sm-margin-bottom-0 xs-margin-bottom-15px">
                            <div class="order-summary sm-margin-bottom-80px">
                                <div class="title-block">
                                    <h3 class="title">Thông Tin Chi Tiết</h3>
                                    <a href="#" class="link-forward">Chỉnh giỏ hàng</a>
                                </div>
                                <div class="cart-list-box short-type">
                                    <ul class="cart-list">
                                        @foreach (session('cart') as $item)
                                        <li class="cart-elem">
                                            <div class="cart-item">
                                                <div class="product-thumb">
                                                    <a class="prd-thumb" href="#">
                                                        <figure><img src="{{ $item['image'] }}" width="100" height="100" alt="shop-cart"></figure>
                                                    </a>
                                                </div>
                                                <div class="info">
                                                    <span class="txt-quantity">x{{ $item['quantity'] }}</span>
                                                    <a href="#" class="pr-name">{{ $item['name'] }}</a>
                                                </div>
                                                <div class="price price-contain">
                                                    <ins><span class="price-amount"><span class="currencySymbol"></span>{{ convertPrice($item['price'] * $item['quantity']) }}</span></ins>
                                                </div>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                    <ul class="subtotal">
                                        <li>
                                            <div class="subtotal-line">
                                                <b class="stt-name">Tổng Tiền</b>
                                                <span class="stt-price">{{ convertPrice(session('total_price')) }}</span>
                                            </div>
                                        </li>
                                       
                                        <li>
                                            <div class="subtotal-line">
                                                <b class="stt-name">Ưu đãi</b>
                                                <span class="stt-price">
                                                    -{{ convertPrice(session('diss', 0)) }} ( {{  session('coupon')->discount_amount ?? 0 }}%)
                                                </span>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="subtotal-line">
                                                <b class="stt-name">Thanh Toán</b>
                                                @if(session()->has('total_price_coupon'))
                                                    <span class="stt-price">{{ convertPrice(session('total_price_coupon')) }}</span><br>
                                                @else
                                                    <span class="stt-price">{{ convertPrice(session('total_price')) }}</span>
                                                @endif
                                            </div>
                                        </li>
                                        <li>
                                        <div class="subtotal-line">
                                            <div class="checkout__input__radio horizontal-radio">
                                                <label for="vnpay">
                                                    <input type="radio" name="payment" id="vnpay" value="1">
                                                    <span class="checkmark"></span>
                                                    Thanh toán VNPay
                                                </label>
                                            </div>
                                            <div class="checkout__input__radio horizontal-radio">
                                                <label for="cod">
                                                    <input type="radio" name="payment" id="cod" value="2">
                                                    <span class="checkmark"></span>
                                                    Thanh toán khi nhận hàng
                                                </label>
                                            </div>
                                        </div>

                                        </li>
                                    </ul>
                                    <div class="form-row wrap-btn text-center">
                                        <button class="btn btn-submit btn-bold" type="submit">Thanh Toán</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
