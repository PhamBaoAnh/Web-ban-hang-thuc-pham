@extends('frontend.layout.master')

@section('content')
<style>
    .cat-list li a {
        color: black; /* Màu mặc định */
        text-decoration: none; /* Bỏ gạch chân mặc định */
    }

    .cat-list li.active a {
        color: red; /* Màu đỏ khi được chọn */
        font-weight: bold; /* Tùy chọn: in đậm để nổi bật hơn */
    }

    .cat-list li a:hover {
        color: red; /* Màu đỏ khi hover */
    }
</style>

<!-- Hero Section -->
<div class="hero-section hero-background">
    <h1 class="page-title">Organic Fruits</h1>
</div>

<!-- Navigation Section -->
<div class="container">
    <nav class="biolife-nav">
        <ul>
            <br>
        </ul>
    </nav>
</div>

<!-- Main Content and Sidebar -->
<div class="page-contain category-page left-sidebar">
    <div class="container">
    <form action="">
        <div class="row">
            <!-- Main content -->
            <div id="main-content" class="main-content col-lg-9 col-md-8 col-sm-12 col-xs-12">
                <div class="product-category grid-style">
                <div id="top-functions-area" class="top-functions-area">
                    <div class="flt-item to-left group-on-mobile">
                        <!-- Nội dung của phần này -->
                    </div>
                    @if(request('search'))
                        <h4>Kết quả tìm kiếm cho từ khóa: "{{ request('search') }}"</h4>
                    @else
                        <div class="flt-item to-right">
                            <span class="flt-title">Sắp xếp:</span>
                            <div class="wrap-selectors">
                                <div class="selector-item orderby-selector">
                                    <form method="GET" action="{{ url()->current() }}" class="form-inline">
                                        <select name="sort_by" class="orderby form-control" onchange="this.form.submit()" aria-label="Shop order">
                                            <option {{ request('sort_by') == 'latest' ? 'selected' : '' }} value="latest">Mới nhất</option>
                                            <option {{ request('sort_by') == 'oldest' ? 'selected' : '' }} value="oldest">Cũ nhất</option>
                                            <option {{ request('sort_by') == 'price-ascending' ? 'selected' : '' }} value="price-ascending">Giá tăng dần</option>
                                            <option {{ request('sort_by') == 'price-descending' ? 'selected' : '' }} value="price-descending">Giá giảm dần</option>
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>


                        <div class="row">
                        <ul class="products-list row">
                            @foreach($products as $product)
                                <li class="product-item col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                    <div class="contain-product layout-default">
                                        <div class="product-thumb">
                                            <a href="{{ route('product', [$product, Str::slug($product->name)]) }}" class="link-to-product">
                                                <img src="{{ $product->images->first()->image }}" alt="{{ $product->name }}" class="product-thumbnail">
                                            </a>
                                        </div>
                                        <div class="info">
                                            <b class="categories">Fresh Fruit</b>
                                            <h4 class="product-title">
                                                <a href="{{ route('product', [$product, Str::slug($product->name)]) }}" class="pr-name">{{ $product->name }}</a>
                                            </h4>
                                            <div class="price">
                                                <ins><span class="price-amount">{{ convertPrice($product->price) }}</span></ins>
                                            </div>
                                            <div class="slide-down-box">
                                                <p class="message">All products are carefully selected to ensure food safety.</p>
                                                <div class="buttons">
                                                    <a href="#" class="btn wishlist-btn"><i class="fa fa-heart" aria-hidden="true"></i></a>
                                                    <a href="{{ route('cart.add', $product) }}" class="btn add-to-cart-btn"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i>Add to cart</a>
                                                    <a href="#" class="btn compare-btn"><i class="fa fa-random" aria-hidden="true"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="d-flex justify-content-center">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <aside id="sidebar" class="sidebar col-lg-3 col-md-4 col-sm-12 col-xs-12">
                <div class="biolife-mobile-panels">
                    <span class="biolife-current-panel-title">Sidebar</span>
                    <a class="biolife-close-btn" href="#" data-object="open-mobile-filter">&times;</a>
                </div>
                <div class="sidebar-contain">
                    <div class="widget biolife-filter">
                        <h4 class="wgt-title">Danh Mục</h4>
                        <div class="wgt-content">
                            <ul class="cat-list">
                                @foreach ($categories as $category)
                                    <li class="{{ request()->segment(2) == $category->id && request()->segment(1) == 'danh-muc' ? 'active' : '' }}">
                                        <a href="{{ route('category', $category) }}">{{ $category->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="widget price-filter biolife-filter">
                        <h4 class="wgt-title">Giá</h4>
                        <div class="wgt-content">
                            <div class="frm-contain">
                                <form action="#" name="price-filter" id="price-filter" method="get">
                                    <p class="f-item">
                                        <label for="pr-from"></label>
                                        <input class="input-number" type="number" id="pr-from" value="{{ request('min_price') }}" name="min_price">
                                    </p>
                                    <p class="f-item">
                                        <label for="pr-to">to </label>
                                        <input class="input-number" type="number" id="pr-to" value="{{ request('max_price') }}" name="max_price">
                                    </p>
                                    <br>
                                    <p class="f-item" style="text-align: center;"> <button class="btn-submit" type="submit">Tìm kiếm</button></p>
                                </form>
                            </div>
                        </div>
                    </div>



                    <div class="widget biolife-filter">
                        <h4>Thương hiệu</h4>
                        <form action="#" method="get">
                            @foreach($brands as $brand)
                                <div class="sidebar__item__publisher">
                                    <input type="checkbox" name="brand[{{$brand->id}}]" id="{{$brand->name}}" 
                                    {{ (request('brand')[$brand->id] ?? '' ) == 'on' ? 'checked' : ''}} onchange="this.form.submit()">
                                    <label for="{{$brand->name}}">
                                        {{$brand->name}}
                                    </label>
                                </div>
                            @endforeach
                        </form>
                    </div>

                    <div class="widget biolife-filter">
                        <h4 class="wgt-title">Bán Chạy Trong Tuần</h4>
                        <div class="wgt-content">
                            <ul class="products">
                                @foreach ($topProducts as $product)
                                    <li class="pr-item">
                                        <div class="contain-product style-widget">
                                            <div class="product-thumb">
                                                <a href="{{ route('product', [$product, Str::slug($product->name)]) }}" class="link-to-product" tabindex="0">
                                                    <img src="{{ $product->images->shift()->image }}" alt="{{ $product->name }}" width="270" height="270" class="product-thumbnail">
                                                </a>
                                            </div>
                                            <div class="info">
                                                <b class="categories">Đã bán {{ $product->totalSold }}</b>
                                                <h4 class="product-title"><a href="#" class="pr-name" tabindex="0">{{ $product->name }}</a></h4>
                                                <div class="price">
                                                    <ins><span class="price-amount"><span class="currencySymbol"></span>{{ convertPrice($product->price) }}</span></ins>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach  
                            </ul>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
        </form>
    </div>
</div>

@endsection
