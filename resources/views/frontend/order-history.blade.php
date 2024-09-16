@extends('frontend.layout.master')

<link rel="stylesheet" href="/assets/frontend/css/acc.css">
@section('content')

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
        <br>

        <div class="row">
            <div class="col-md-12">
                <div class="tab-content mt-5">
                    <div class="tab-pane active show">
                        <table class="table" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Mã đơn hàng</th>
                                    <th>Thời gian</th>
                                    <th>Phương thức thanh toán</th>
                                    <th>Trạng thái</th>
                                    <th>Tổng tiền</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ date_format($order->created_at,"d-m-Y / H:i:s") }}</td>
                                        <td>{{ $order->payment == 1 ? 'VNPay' : 'Tiền mặt'}}</td>
                                        <td>
                                            @if($order->status == 0)
                                                <span class="status cancel">Hủy đơn</span>
                                            @elseif($order->status == 1)
                                                <span class="status return">Trả hàng</span>
                                            @elseif($order->status == 2)
                                                <span class="status pending">Chờ xác nhận</span>
                                            @elseif($order->status == 3)
                                                <span class="status inprogress">Đang giao</span>
                                            @else
                                                <span class="status delivered">Đã giao</span>
                                            @endif
                                        </td>
                                        <td>{{ number_format($order->total_price) }}đ</td>
                                        <td>
                                        <div class="d-flex justify-content-end align-items-center">
                                            @if($order->status == 2)
                                                <form action="{{ route('order.cancel', $order) }}" method="POST" class="mr-3 mb-0">
                                                    @csrf
                                                    <button type="submit" class="btn btn-secondary cancel">Hủy đơn</button>
                                                </form>
                                            @elseif($order->status == 3)
                                                <!--
                                                <form action="{{ route('order.return', $order) }}" method="POST" class="mr-3 mb-0">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger return">Trả hàng</button>
                                                </form>
                                                <form action="{{ route('order.receive', $order) }}" method="POST" class="mr-3 mb-0">
                                                    @csrf
                                                    <button type="submit" class="btn btn-info receive">Nhận hàng</button>
                                                </form>
                                                -->
                                               
                                            </form>
                                            @elseif($order->status == 0)
                                             <form action="{{ route('order.orderagain', $order) }}" method="POST" class="mb-0">
                                                @csrf
                                                <button type="submit" class="btn btn-secondary cancel">Đặt Lại</button>
                                            </form>
                                            @endif
                                            <a href="{{ route('order.detail', $order) }}" class="btn btn-primary text-white mr-3">Xem chi tiết</a>
                                            
                                            
                                        </div>
                                    </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="text-center">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</section>

@endsection
