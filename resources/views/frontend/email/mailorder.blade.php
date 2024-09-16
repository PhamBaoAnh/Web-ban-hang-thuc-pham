<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thông báo đơn hàng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        h2 {
            color: #555;
        }
        p {
            margin-bottom: 10px;
        }
        strong {
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        img {
            max-width: 250px;
            height: auto;
            display: block;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Thông tin đơn hàng</h1>
        <p><strong>Tên khách hàng:</strong> {{ $order->name }}</p>
        <p><strong>Email:</strong> {{ $order->email }}</p>
        <p><strong>Số điện thoại:</strong> {{ $order->phone }}</p>
        <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
        <p><strong>Ghi chú:</strong> {{ $order->note }}</p>
        <p><strong>Phương thức thanh toán:</strong> {{ $order->payment == 1 ? 'Chuyển Khoản' : 'Thanh Toán Khi Nhận Hàng' }}</p>
        <p><strong>Tổng giá:</strong> {{ $order->total_price }}</p>
        <p><strong>Trạng thái:</strong> 
            @if ($order->status == 0)
                Đơn hàng đã hủy
            @elseif ($order->status == 1)
                Đơn hàng đã trả
            @elseif ($order->status == 2)
                Đơn hàng chờ xác nhận
            @elseif ($order->status == 3)
                Đơn hàng đang giao
            @elseif ($order->status == 4)
                Đơn hàng đã giao
            @else
                Trạng thái không xác định
            @endif
        </p>

        <p><strong>Ngày đặt hàng:</strong> {{ $order->created_at }}</p> <!-- Hiển thị ngày đặt hàng -->

        <h2>Chi tiết giỏ hàng</h2>
        <table>
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cart as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <!-- <td><img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"></td> -->
                    <td>{{ $item['quantity'] }}</td>
                    <td>{{ $item['price'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
