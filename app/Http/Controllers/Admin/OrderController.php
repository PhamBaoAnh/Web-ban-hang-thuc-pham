<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index(Request $request){
        $status = $request->status;
        $order_id = $request->order_id;
        $orders = Order::when($order_id, function($query, $order_id){
            $query->where('id', $order_id);
        })->orderByDesc('id');
        
        if(isset($status)){
            $orders = $orders->where('status', $status);
        }
        $orders = $orders->paginate(10);
        return view('admin.order.list', compact('orders'));
    }

    public function show(Order $order){
        return view('admin.order.show', compact('order'));
    }

    public function confirm(Order $order){
        $products = $order->products;
      //  dd($products);
        // Lặp qua từng sản phẩm để cập nhật số lượng
        foreach ($products as $product) {
            // Lấy số lượng từ bảng pivot của sản phẩm trong đơn hàng
            $quantityOrdered = $product->pivot->quantity;
    
            // Trừ số lượng sản phẩm trong kho
            $product->quantity -= $quantityOrdered;
            $product->sold += $quantityOrdered;
            // Lưu lại sản phẩm sau khi cập nhật số lượng
            $product->save();
        }
       // dd($product);
        $order->status = 3;
        $order->save();

        return redirect()->back()->with('success', 'Đơn hàng đã được xác nhận.');
    }

    public function delivered(Order $order){
        
        // Cập nhật trạng thái đơn hàng
        $order->status = 4; // Đơn hàng đã được giao
        $order->save();

        return redirect()->back()->with('success', 'Đơn hàng đã được giao.');
    }

    public function back(Order $order){
        $products = $order->products;
        //  dd($products);
          // Lặp qua từng sản phẩm để cập nhật số lượng
          foreach ($products as $product) {
              // Lấy số lượng từ bảng pivot của sản phẩm trong đơn hàng
              $quantityOrdered = $product->pivot->quantity;
      
              // Trừ số lượng sản phẩm trong kho
              $product->quantity += $quantityOrdered;
              $product->sold -= $quantityOrdered;
              // Lưu lại sản phẩm sau khi cập nhật số lượng
              $product->save();
          }
        $order->status = 1;
        $order->save();

        return redirect()->back()->with('success', 'Đơn hàng đã được hoàn trả.');
    }
}