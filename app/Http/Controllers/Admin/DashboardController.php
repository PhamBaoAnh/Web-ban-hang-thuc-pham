<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Lấy tổng số lượng sản phẩm và đơn hàng
        $data = [
            'total_product' => Product::count(),
            'total_order' => Order::count(),
        ];
    
        // Lấy tổng doanh thu từ các đơn hàng đã giao thành công
        $data['total_income'] = Order::where('status', 4)->sum('total_price');
    
        // Lấy năm và tháng từ request
        $currentYear = $request->input('year', date('Y'));
        $currentMonth = $request->input('month', '');
    
        // Lựa chọn hiển thị dữ liệu
        if ($currentMonth) {
            // Người dùng đã chọn tháng cụ thể
            $totalSalesByDay = $this->getSalesDataByDay($currentYear, $currentMonth);
            $chartCategories = $this->getDayLabels($currentMonth, $currentYear);
            $totalSalesByMonth = []; // Đặt $totalSalesByMonth là mảng rỗng khi chọn tháng
        } else {
            // Mặc định hiển thị tổng doanh thu của các tháng trong năm
            $totalSalesByDay = $this->getTotalSalesForYear($currentYear);
            $chartCategories = $this->getMonthLabels(); // Sử dụng labels của tháng
            $totalSalesByMonth = []; // Đặt $totalSalesByDay là mảng rỗng khi không chọn tháng
           // dd( $chartCategories);
        }
    
        // Lấy 10 sản phẩm bán chạy nhất
        $bestSellingProducts = Product::orderByDesc('sold')->take(10)->get();
    
        // Lấy 10 đơn hàng mới nhất
        $latestOrders = Order::orderByDesc('id')->take(10)->get();
    
        // Trả về view với các dữ liệu đã lấy được
        return view('admin.index', compact('totalSalesByDay', 'totalSalesByMonth', 'chartCategories', 'data', 'bestSellingProducts', 'latestOrders'));
    }
    
    private function getSalesDataByDay($year, $month)
    {
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $salesData = [];
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $salesData[$day] = $this->getTotalSalesForDay($year, $month, $day);
        }
        return $salesData;
    }
    
    private function getTotalSalesForDay($year, $month, $day)
    {
        return Order::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->whereDay('created_at', $day)
            ->where('status', 4)
            ->sum('total_price');
    }
    
    private function getTotalSalesForYear($year)
    {
        $salesData = [];
        for ($month = 1; $month <= 12; $month++) {
            $salesData[$month] = $this->getTotalSalesForMonth($year, $month);
        }
        return $salesData;
    }
    
    private function getTotalSalesForMonth($year, $month)
    {
        return Order::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->where('status', 4)
            ->sum('total_price');
    }
    
    private function getMonthLabels()
    {
        return [
            'Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4',
            'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8',
            'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12',
        ];
    }
    
    private function getDayLabels($month, $year)
    {
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $labels = [];
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $labels[] = "$day";
        }
        return $labels;
    }
}
