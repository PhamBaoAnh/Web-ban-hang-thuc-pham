@extends('frontend.layout.master')


@section('content')
<style>
      .buttons {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }
    .primary-btn {
        background-color: #7faf51; /* Màu nền của nút */
        color: #fff; /* Màu chữ của nút */
        border: 1px solid #7faf51; /* Viền của nút */
        padding: 10px 20px; /* Khoảng cách giữa nội dung và viền của nút */
        cursor: pointer; /* Con trỏ chỉ vào nút */
        display: inline-block; /* Hiển thị nút dưới dạng khối nội dung inline */
        text-align: center; /* Căn chỉnh văn bản vào giữa nút */
        text-decoration: none; /* Loại bỏ gạch chân mặc định cho các liên kết */
        border-radius: 4px; /* Bo tròn các góc của nút */
        transition: background-color 0.3s, color 0.3s, border-color 0.3s; /* Hiệu ứng chuyển đổi màu */
    }
    .primary-btn:hover {
        background-color: #0056b3; /* Màu nền của nút khi di chuột vào */
        border-color: #0056b3; /* Màu viền của nút khi di chuột vào */
        color: #fff; /* Màu chữ của nút khi di chuột vào */
        text-decoration: none; /* Loại bỏ gạch chân mặc định cho các liên kết */
    }
</style>
    <!--Hero Section-->
    <div class="hero-section hero-background">
        <h1 class="page-title">Organic Fruits</h1>
    </div>

    <!--Navigation section-->
    <div class="container">
        <nav class="biolife-nav">
            <ul>
                <li class="nav-item"><a href="index-2.html" class="permal-link">Trang chủ</a></li>
                <li class="nav-item"><a href="#" class="permal-link">{{$product->category->name}}</a></li>
                <li class="nav-item"><span class="current-page">{{$product->name}}</span></li>
            </ul>
        </nav>
    </div>

    <div class="page-contain single-product">
        <div class="container">

            <!-- Main content -->
            <div id="main-content" class="main-content">
                                    
                                <div class="sumary-product single-layout">
                                <div class="media">
    
                                <ul class="biolife-carousel slider-for" data-slick='{"arrows":false,"dots":false,"slidesMargin":30,"slidesToShow":1,"slidesToScroll":1,"fade":true,"asNavFor":".slider-nav"}'>
                                    @foreach ($product->images as $item)
                                        <li><img src="{{$item->image}}" alt="" width="500" height="500"></li>
                                    @endforeach
                                </ul>
                                <ul class="biolife-carousel slider-nav" data-slick='{"arrows":false,"dots":false,"centerMode":false,"focusOnSelect":true,"slidesMargin":10,"slidesToShow":4,"slidesToScroll":1,"asNavFor":".slider-for"}'>
                                    @foreach ($product->images as $item)
                                        <li><img data-imgbigurl="{{$item->image}}" src="{{$item->image}}" alt=""></li>
                                    @endforeach
                                </ul>
                            </div>


                    <div class="product-attribute">
                        <form action="{{route('cart.add', $product)}}">
                        <h3 class="title">{{$product->name}}</h3>
                        <div class="product-info">
                            <div class="price">
                            <ins><span class="price-amount"><span class="currencySymbol">Giá: </span>{{convertPrice($product->price)}}</span></ins>
                            </div>
                            <div class="stock-info">
                            <span class="stock">
                                <b>Tình trạng: </b>
                                @if ($product->quantity > 0)
                                <span class="text-success">Còn hàng</span>
                                @else
                                <span class="text-danger">Hết hàng</span>
                                @endif
                            </span>
                            <br>
                            @if ($product->sold > 0)
                                <span class="sku"><b>Đã bán: </b> {{$product->sold}} sản phẩm</span>
                                <br>
                            @endif
                            </div>
                            <div class="product-details">
                            <span class="sku"><b>Thương hiệu: </b> {{$product->brand->name}}</span>
                            <br>
                            @if ($product->weight > 0)
                                <span class="sku"><b>Khối lượng: </b>{{$product->weight}}/quả</span>
                                <br>
                            @endif
                            <span class="sku"><b>Chính sách giao hàng</b>: Nhận hàng trong 4 tiếng - 6 tiếng</span>
                            <br>
                            </div>
                        </div>

                        <div class="action-form">
                            <div class="quantity-box">
                            <div class="qty-input">
                                    <input type="text" name="quantity"  value="1" data-max_value="20" data-min_value="1" data-step="1">
                                    <a href="#" class="qty-btn btn-up"><i class="fa fa-caret-up" aria-hidden="true"></i></a>
                                    <a href="#" class="qty-btn btn-down"><i class="fa fa-caret-down" aria-hidden="true"></i></a>
                                </div>
                            </div>
                            <div class="buttons">
                            <button type="submit" class="primary-btn">
                                <i class="fas fa-cart-plus"></i> Thêm vào giỏ hàng
                            </button>
                        </div>
                        </div>
                        </form>
                    </div>
                    </div>

                <!-- Tab info -->
                <div class="product-tabs single-layout biolife-tab-contain">
                    <div class="tab-head">
                        <ul class="tabs">
                            <li class="tab-element active"><a href="#tab_1st" class="tab-link">Thông Tin Sản Phẩm</a></li>
                            <li class="tab-element" ><a href="#tab_3rd" class="tab-link">Chính Sách vận Chuyển </a></li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div id="tab_1st" class="tab-contain desc-tab active">
                           {!!$product->description!!}
                           
                        </div>
                        
                        <div id="tab_3rd" class="tab-contain shipping-delivery-tab">
                            <div class="accodition-tab biolife-accodition">
                            @include('frontend.layout.shipping-policy')
                            </div>
                        </div>
                    
                    </div>
                </div>

                <!-- related products -->
                <div class="product-related-box single-layout">
                    <div class="biolife-title-box lg-margin-bottom-26px-im">
                        <span class="biolife-icon icon-organic"></span>
                        <span class="subtitle">All the best item for You</span>
                        <h3 class="main-title">Sản phẩm tương tự</h3>
                    </div>
                    <ul class="products-list biolife-carousel nav-center-02 nav-none-on-mobile" data-slick='{"rows":1,"arrows":true,"dots":false,"infinite":false,"speed":400,"slidesMargin":0,"slidesToShow":5, "responsive":[{"breakpoint":1200, "settings":{ "slidesToShow": 4}},{"breakpoint":992, "settings":{ "slidesToShow": 3, "slidesMargin":20 }},{"breakpoint":768, "settings":{ "slidesToShow": 2, "slidesMargin":10}}]}'>
                    @foreach($relatedProducts as $product)
                        <li class="product-item">
                            <div class="contain-product layout-default">
                                <div class="product-thumb">
                                    <a href="{{route('product', [$product,Str::slug($product->name)])}}" class="link-to-product">
                                        <img src="{{$product->images->first()->image}}" alt="dd" width="270" height="270" class="product-thumnail">
                                    </a>
                                </div>
                                <div class="info">
                                    <b class="categories">Fresh Fruit</b>
                                    <h4 class="product-title"><a href="{{route('product', [$product,Str::slug($product->name)])}}" class="pr-name">{{$product->name}}</a></h4>
                                    <div class="price">
                                        <ins><span class="price-amount"><span class="currencySymbol"></span>{{convertPrice($product->price)}}</span></ins>
                                    </div>
                                    <div class="slide-down-box">
                                        <p class="message">All products are carefully selected to ensure food safety.</p>
                                        <div class="buttons">
                                            <a href="{{route('cart.add', $product)}}" class="btn add-to-cart-btn"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i>Thêm vào giỏ hàng</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                       
                        @endforeach
                    </ul>
                </div>
                
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var inputElement = document.querySelector('.qty-input input[type="text"]');
            var btnUp = document.querySelector('.qty-btn.btn-up');
            var btnDown = document.querySelector('.qty-btn.btn-down');
            
            btnUp.addEventListener('click', function(e) {
                e.preventDefault();
                var currentValue = parseInt(inputElement.value);
                var maxValue = parseInt(inputElement.getAttribute('data-max_value'));
                
                if (currentValue < maxValue) {
                    inputElement.value = currentValue + 1;
                }
            });
            
            btnDown.addEventListener('click', function(e) {
                e.preventDefault();
                var currentValue = parseInt(inputElement.value);
                var minValue = parseInt(inputElement.getAttribute('data-min_value'));
                
                if (currentValue > minValue) {
                    inputElement.value = currentValue - 1;
                }
            });
        });
    </script>
@endsection