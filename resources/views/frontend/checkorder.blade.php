@extends('frontend.layout.master')

@section('content')

<section class="breadcrumb-section set-bg" data-setbg="{{ asset('assets/frontend/img/breadcrumb.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Lịch sử đơn hàng</h2>
                    <div class="breadcrumb__option">
                        <a href="/">Trang chủ</a>
                        <span>Lịch sử đơn hàng</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div id="tabs" class="project-tab">
    <div class="container shadow-sm bg-body rounded">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                <br>
                <div class="tab-content">
                    <div class="tab-pane active show mt-5">
                        @if ($orders->isEmpty())
                        <div class="alert alert-info">Không tìm thấy đơn hàng nào.</div>
                        @else
                        <table class="table" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Mã đơn hàng</th>
                                    <th>Người Đặt Hàng</th>
                                    <th>Số Điện</th>
                                    <th>Thời gian</th>
                                    <th class="text-center">Phương thức thanh toán</th>
                                    <th class="text-center">Trạng thái</th>
                                    <th class="text-center">Tổng tiền</th>
                                   
                             
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                <tr>
                                    <td>#{{ $order->id }}</td>
                                    <td>{{ $order->name }}</td>
                                    <td>{{ $order->phone }}</td>
                                    <td>{{ date_format($order->created_at,"d-m-Y / H:i:s") }}</td>
                                    <td class="text-center">{{ $order->payment == 1 ? 'VNPay' : 'Tiền mặt' }}</td>
                                    @if ($order->status == 0)
                                    <td class="text-center"><span class="status cancel">Hủy đơn</span></td>
                                    @elseif ($order->status == 1)
                                    <td class="text-center"><span class="status return">Trả hàng</span></td>
                                    @elseif ($order->status == 2)
                                    <td class="text-center"><span class="status pending">Chờ xác nhận</span></td>
                                    @elseif ($order->status == 3)
                                    <td class="text-center"><span class="status inprogress">Đang giao</span></td>
                                    @else
                                    <td class="text-center"><span class="status delivered">Đã giao</span></td>
                                    @endif
                                    <td class="text-center">{{ number_format($order->total_price) }}đ</td>
                                   
                                   
                                </div>


                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>

            </div>
            <div class="text-center">
                {{ $orders->links() }}
            </div>
        </div>
    </div>

</div>

@endsection
