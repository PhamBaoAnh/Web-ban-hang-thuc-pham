@extends('admin.layout.master')

@section('content')

@if (Auth::guard('admin')->user()->role === 'Quản trị viên')
    <div class="container-fluid">
        <!--  Row 1 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row alig n-items-start">
                                    <div class="col-8">
                                        <h5 class="card-title mb-9 fw-semibold">Tổng sản phẩm </h5>
                                        <h2 class="fw-semibold mb-3">{{number_format($data['total_product'])}}</h2>
                                    </div>
                                    <div class="col-4">
                                        <div class="d-flex justify-content-end">
                                            <div
                                                class="text-white bg-danger rounded-circle p-6 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-apple fs-6"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <!-- Monthly Earnings -->
                        <div class="card">
                            <div class="card-body">
                                <div class="row alig n-items-start">
                                    <div class="col-8">
                                        <h5 class="card-title mb-9 fw-semibold">Tổng đơn hàng</h5>
                                        <h2 class="fw-semibold mb-3">{{number_format($data['total_order'])}}</h2>
                                    </div>
                                    <div class="col-4">
                                        <div class="d-flex justify-content-end">
                                            <div
                                                class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-users fs-6"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <!-- Monthly Earnings -->
                        <div class="card">
                            <div class="card-body">
                                <div class="row alig n-items-start">
                                    <div class="col-8">
                                        <h5 class="card-title mb-9 fw-semibold">Tổng doanh thu</h5>
                                        <h2 class="fw-semibold mb-3">{{number_format($data['total_income'])}} đ</h2>
                                    </div>
                                    <div class="col-4">
                                        <div class="d-flex justify-content-end">
                                            <div
                                                class="text-white bg-success rounded-circle p-6 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-cash fs-6"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 d-flex align-items-strech">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                        <div class="mb-3 mb-sm-0">
                            <h5 class="card-title fw-semibold">Doanh số bán hàng</h5>
                        </div>
                        <form>
                            <div class="d-flex align-items-center">
                                <select name="month" class="form-select me-2" onchange="this.form.submit()">
                                    <option value="">Tất cả</option>
                                    @for ($i = 1; $i < 13; $i++)
                                        @php
                                            $selected = (request('month') == $i) ? 'selected' : '';
                                            $currentMonth = (date('m') == $i && request('month') == '') ? 'selected' : '';
                                        @endphp
                                        <option value="{{$i}}" {{$selected ?? $currentMonth}}>Tháng {{$i}}</option>
                                    @endfor
                                </select>
                                <select name="year" class="form-select" onchange="this.form.submit()">
                                    @php
                                        $currentYear = date('Y');
                                    @endphp
                                    @for ($year = $currentYear; $year >= $currentYear - 5; $year--)
                                        @php
                                            $selectedYear = (request('year') == $year) ? 'selected' : '';
                                        @endphp
                                        <option value="{{$year}}" {{$selectedYear}}>{{$year}}</option>
                                    @endfor
                                </select>
                            </div>
                        </form>
                    </div>
                    <div id="sales"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-5 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-semibold mb-4">Sản phẩm bán chạy</h5>
                        <div class="table-responsive">
                            <table class="table text-nowrap mb-0 align-middle">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">STT</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Tên Sản phẩm</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Đã bán</h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bestSellingProducts as $key=>$product)
                                        <tr>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">#{{$key+1}}</h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <a href="{{route('product.show', $product)}}">
                                                    <h6 class="fw-semibold mb-1">{{$product->name}}</h6>
                                                </a>
                                            </td>
                                            <td class="border-bottom-0">
                                                <p class="mb-0 fw-normal">{{$product->sold}}</p>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-semibold mb-4">Đơn hàng gần đây</h5>
                        <div class="table-responsive">
                            <table class="table text-nowrap mb-0 align-middle">
                                <thead class="text-dark fs-4">
                                    <tr>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">STT</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Tên khách hàng</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Tổng tiền</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Thời gian</h6>
                                        </th>
                                        <th class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">Trạng thái</h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($latestOrders as $key => $order)
                                <tr>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">#{{$key+1}}</h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <h6 class="fw-semibold mb-1">{{$order->name}}</h6>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="fw-semibold mb-0">{{ number_format($order->total_price) }}đ</p>
                                    </td>
                                    <td class="border-bottom-0">
                                        <p class="fw-semibold mb-0">{{ date_format($order->created_at,'H:i A - d/m') }}</p>
                                    </td>
                                    <td class="border-bottom-0">
                                        @if ($order->status == 0)
                                            <span class="badge bg-dark rounded-3 fw-semibold">Hủy đơn</span>
                                        @elseif ($order->status == 1)
                                            <span class="badge bg-danger rounded-3 fw-semibold">Trả hàng</span>
                                        @elseif ($order->status == 2)
                                            <span class="badge bg-warning rounded-3 fw-semibold">Chờ xác nhận</span>
                                        @elseif ($order->status == 3)
                                            <span class="badge bg-info rounded-3 fw-semibold">Đang giao</span>
                                        @elseif ($order->status == 4)
                                            <span class="badge bg-success rounded-3 fw-semibold">Đã giao</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>


                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="container-fluid text-center ">
        <h3>Trang này chỉ dành cho quản trị viên.</h3>
    </div>
@endif

@push('js')
    <script>
        var dataChart = <?php echo json_encode($totalSalesByDay ?? $totalSalesByMonth); ?>;
        var chartCategories = <?php echo json_encode($chartCategories); ?>;

        var chart = {
            series: [
                { name: "Tổng tiền", data: Object.values(dataChart) },
            ],
            chart: {
                type: "bar",
                height: 345,
                offsetX: -15,
                toolbar: { show: true },
                foreColor: "#adb0bb",
                fontFamily: 'inherit',
                sparkline: { enabled: false },
            },
            colors: ["#49BEFF"],
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: "75%",
                    borderRadius: [6],
                    borderRadiusApplication: 'end',
                    borderRadiusWhenStacked: 'all'
                },
            },
            markers: { size: 0 },
            dataLabels: { enabled: false },
            legend: { show: false },
            grid: {
                borderColor: "rgba(0,0,0,0.1)",
                strokeDashArray: 3,
                xaxis: { lines: { show: false } },
            },
            xaxis: {
                type: "category",
                categories: chartCategories,
                labels: { style: { cssClass: "grey--text lighten-2--text fill-color" } },
            },
            yaxis: {
                show: true,
                min: 0,
                tickAmount: 4,
                labels: { style: { cssClass: "grey--text lighten-2--text fill-color" } },
            },
            stroke: { show: true, width: 3, lineCap: "butt", colors: ["transparent"] },
            tooltip: { theme: "light" },
            responsive: [
                {
                    breakpoint: 600,
                    options: {
                        plotOptions: { bar: { borderRadius: 3 } }
                    },
                },
            ]
        };

        var chart = new ApexCharts(document.querySelector("#sales"), chart);
        chart.render();
    </script>
@endpush


@endsection