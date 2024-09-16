@extends('frontend.layout.master')

@section('content')
<style>
.custom-select {
    display: block;
    width: 100%;
    max-width: 200px; /* Điều chỉnh chiều rộng tối đa của select box */
    font-size: 15px; /* Font size to lớn hơn, ví dụ 1.2rem */
    font-weight: 400;
    line-height: 1.5;
    color: #ffffff; /* Màu chữ là màu trắng */
    background-color: #7faf51; /* Màu nền xanh */
    background-clip: padding-box;
    border: 80px; /* Xóa viền */
    border-radius: 10rem;
    appearance: none; /* Xóa kiểu giao diện mặc định của select */
    -webkit-appearance: none;
    -moz-appearance: none;
    transition: background-color 0.15s ease-in-out, color 0.15s ease-in-out;
    position: relative;
}




/* Style cho mũi tên dropdown */
.custom-select:after {
    position: absolute;
    top: 50%;
    right: 1rem;
    transform: translateY(-50%);
    pointer-events: none;
    content: '\25BC'; /* Mũi tên drop-down */
    color: #ffffff; /* Màu mũi tên là màu trắng */
}

/* Style hover và active */
.custom-select:hover {
    background-color: #0056b3; /* Màu nền xanh nhạt khi hover */
}

.custom-select:hover:after {
    color: #ffffff; /* Màu của mũi tên dropdown khi hover */
}

.custom-select:active {
    background-color: #0042a3; /* Màu nền xanh đậm khi active */
}


</style>
<div class="hero-section hero-background">
    <h1 class="page-title">Organic Fruits</h1>
</div>

<!-- Navigation section -->
<div class="container">
    <nav class="biolife-nav">
        <ul>
            <li class="nav-item"><a href="{{ route('home') }}" class="permal-link">Home</a></li>
            <li class="nav-item"><span class="current-page">Shopping Cart</span></li>
        </ul>
    </nav>
</div>

<div class="page-contain shopping-cart">

    <!-- Main content -->
    <div id="main-content" class="main-content">
        <div class="container">
            @if (!empty(session('cart')))
            <!-- Cart Table -->
            <div class="shopping-cart-container">
                <div class="row">
                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                        <h3 class="box-title">Giỏ hàng của bạn</h3>

                        <table class="shop_table cart-form">
                            <thead>
                                <tr>
                                    <th class="product-name">Tên Sản Phẩm</th>
                                    <th class="product-price">Giá</th>
                                    <th class="product-quantity">Số Lượng</th>
                                    <th class="product-subtotal">Tổng Tiền</th>
                                    <th class="product-subtotal"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (session('cart') as $item)
                                <tr class="cart_item">
                                    <td class="product-thumbnail" data-title="Product Name">
                                        <a class="prd-thumb" href="#">
                                            <figure><img width="113" height="113" src="{{$item['image']}}" alt="shipping cart"></figure>
                                        </a>
                                        <a class="prd-name" href="#">{{$item['name']}}</a>
                                    </td>
                                    <td class="product-price" data-title="Price">
                                        <div class="price price-contain">
                                            <ins><span class="price-amount"><span class="currencySymbol"></span>{{convertPrice($item['price'])}}</span></ins>
                                        </div>
                                    </td>
                                    <td class="product-quantity" data-title="Quantity">
                                        <div class="quantity-box type1">
                                            <div class="qty-input">
                                                <input type="text" onkeyup="kiemtrasoluong(this)" name="qty{{$item['product_id']}}" value="{{$item['quantity']}}" data-product_id="{{$item['product_id']}}" data-max_value="20" data-min_value="1" data-step="1" class="item-quantity">
                                                <a href="#" onclick="tangsoluong(this); return false;" class="qty-btn btn-up"><i class="fa fa-caret-up" aria-hidden="true"></i></a>
                                                <a href="#" onclick="giamsoluong(this); return false;" class="qty-btn btn-down"><i class="fa fa-caret-down" aria-hidden="true"></i></a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="product-subtotal" data-title="Total">
                                        <div class="price price-contain">
                                            <ins><span class="price-amount"><span class="currencySymbol"></span>{{convertPrice($item['price'] * $item['quantity'])}}</span></ins>
                                        </div>
                                    </td>
                                    <td class="shoping__cart__item__close">
                                        <div class="action">
                                            <a href="#" class="remove">
                                                <i class="fa fa-trash-o" onclick="confirmDelete({{ $item['product_id'] }})" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                <td class="wrap-btn-control" colspan="2">
                                        <a href="{{ route('shop') }}" class="btn back-to-shop">Tiếp Tục Mua Hàng</a>
                                </td>
                                <td class="wrap-btn-control" >
                                <form action="{{ route('apply.coupon') }}" method="POST">
                                    @csrf
                                    <input type="text" value="{{ old('coupon_name')}}" name="coupon_name" id="coupon_name" class="form-control" placeholder="Nhập mã giảm giá">
                                    <td class="wrap-btn-control" >
                                    <button type="submit" class="btn btn-primary">Áp dụng</button>
                                    </td>            
                                </form>
                                </td>

                                    
                                </tr>
                            </tbody>
                        </table>

                    </div>
                    <br>
                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                        <div class="shpcart-subtotal-block">
                            <div class="subtotal-line">
                                <b class="stt-name">Thông Tin Thanh Toán <span class="sub"></span></b>
                            </div>
                            <div class="subtotal-line">
                                <b class="stt-name">Tổng Tiền <span class="sub"></span></b>
                                <span class="stt-price">{{convertPrice(session('total_price'))}}</span>
                            </div>
                            <div class="subtotal-line">
                                <b class="stt-name">Giảm giá <span class="sub"></span></b>
                                <span class="stt-price"> -{{convertPrice(session('diss'))}} </span>
                            </div>
                            <div class="subtotal-line">
                                <b class="stt-name">Thanh Toán:</b>
                                <span class="stt-price">
                                    @if(session()->has('total_price_coupon'))
                                    <span>{{ convertPrice(session('total_price_coupon')) }}</span><br>
                                    @else
                                    <span>{{ convertPrice(session('total_price')) }}</span>
                                    @endif
                                </span>
                            </div>
                            <div class="btn-checkout">
                                <a href="{{ route('checkout') }}" class="btn checkout">Thanh Toán</a>
                            </div>
                            <p class="pickup-info"><b>Free Pickup</b> is available as soon as today More about shipping and pickup</p>
                        </div>
                    </div>
                </div>
            </div>

            @else

            <!-- Empty Cart -->
            <div class="shopping-cart-container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="text-align: center;">
                        <img src="/assets/frontend/images/image.png" alt="Giỏ hàng trống"><br>
                        <h3>“Hổng” có gì trong giỏ hết</h3>
                        <p>Về trang cửa hàng để chọn mua sản phẩm bạn nhé!!</p>
                        <form action="{{ route('shop') }}" method="get">
                            <button type="submit" class="primary-btn">Tiếp tục mua hàng</button>
                        </form>
                        <br>
                    </div>
                </div>
            </div>

            @endif
        </div>
    </div>
</div>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Bạn có muốn xóa sản phẩm này khỏi giỏ hàng không?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Đồng ý',
            cancelButtonText: 'Hủy bỏ'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/cart/delete/' + id;
            }
        })
    }
</script>

<script src="/assets/frontend/js/main.js"></script>

@endsection
