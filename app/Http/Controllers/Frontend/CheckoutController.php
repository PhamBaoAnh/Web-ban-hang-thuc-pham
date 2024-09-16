<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use DB;
use App\Mail\Mailorder;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class CheckoutController extends Controller
{
    static $vnp_TmnCode = "W6YEW49O";
    static $vnp_HashSecret = "WSBCHHFZBEGYEQNOQHVKLNCGZVHQTHMU"; 
    static $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
    static $vnp_Returnurl = "/checkout/vnPayCheck"; 

    public function index(){
        return view('frontend.checkout');
    }

    public function checkout(Request $request)
    {
        $cart = session('cart', []);
       
        if (empty($cart)) {
            // If cart is empty, redirect back with an error message
            return back()->with('error', 'Giỏ hàng của bạn đang trống. Vui lòng thêm sản phẩm vào giỏ hàng trước khi tiếp tục.');
        }
       
       
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'address' => 'required|string',
            'note' => 'nullable|string',
            'payment' => 'required|in:1,2',
        ], [
            'name.required' => 'Vui lòng nhập Họ Tên.',
            'email.required' => 'Vui lòng nhập Email.',
            'email.email' => 'Email không hợp lệ.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.numeric' => 'Số điện thoại phải là số.',
            'address.required' => 'Vui lòng nhập địa chỉ.',
            'payment.required' => 'Vui lòng chọn phương thức thanh toán.',
            'payment.in' => 'Phương thức thanh toán không hợp lệ.',
        ]);
        
    
        // Thêm các thông tin cần thiết cho đơn hàng
        
       
        if(session('total_price_coupon')){
            $data['total_price'] = session('total_price_coupon');
        }else{
            $data['total_price'] = session('total_price');
        }

       // $data['user_id'] = \Auth::id();
        $data['status'] = 2; // Trạng thái chờ xác nhận
       
          // Nếu người dùng đã đăng nhập, thêm user_id vào dữ liệu
    if (\Auth::check()) {
        $data['user_id'] = \Auth::id();
    } else {
        $userData = $data; // Lưu lại dữ liệu từ $data vào biến $userData
        $userData['name'] = 'guess'; 
        $user = User::create($userData); // Tạo user mới từ dữ liệu trong $userData
        $data['user_id'] = $user->id; 

    }


        if ($data['payment'] == 2) {
            DB::beginTransaction();
            try {
                // Tạo order mới
                $order = Order::create($data);
    
                // Tạo chi tiết đơn hàng (giả sử hàm createOrderDetail đã được định nghĩa)
                $this->createOrderDetail($order);
    
                DB::commit();
           
                // Trong phần xử lý checkout của bạn
                $created_at = $order->created_at; // Lấy ngày tạo đơn hàng

                Mail::to($data['email'])->send(new Mailorder([
                    'order' => $order,
                    'cart' => $cart,
                    'created_at' => $created_at, // Truyền created_at vào mẫu email
                ]));

    
                return redirect()->route('checkout.success');
            } catch (\Throwable $e) {
                DB::rollback();
                throw $e;
            }
        }
    
        
        if ($data['payment'] == 1) {
           
            $order = Order::create($data);
            $created_at = $order->created_at;
             Mail::to($data['email'])->send(new Mailorder([
                    'order' => $order,
                    'cart' => $cart,
                    'created_at' => $created_at, // Truyền created_at vào mẫu email
                ]));
            $data = [
                'vnp_TxnRef' => $order->id,
                'vnp_OrderInfo' => 'Order Payment No.' .$order->id,
                'vnp_Amount' => $order->total_price,
            ];
            $data_url = $this->vnpay_create_payment($data);
            // Chuyển hướng đến URL lấy được
            return \Redirect::to($data_url);
        } 
            
 
    }
    

    protected function createOrderDetail($order){
        $carts = session('cart',[]);


        foreach($carts as $item){
            $order->products()->attach($item['product_id'], [
                'name' => $item['name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
      
            $product = product::where('id',$item['product_id'])->first();  
        //    $product->quantity -= $item['quantity'];
            $product->save();
        }

        session()->forget(['cart','total_price','total_price_coupon','coupon']);
    }

    protected function vnpay_create_payment(array $data)
    {
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $vnp_TxnRef = $data['vnp_TxnRef'];
        $vnp_OrderInfo = $data['vnp_OrderInfo'];
        $vnp_OrderType = 200000;
        $vnp_Amount = $data['vnp_Amount'] * 100;
        $vnp_Locale = 'vn';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = array(
            "vnp_Version" => "2.1.0", 
            "vnp_TmnCode" => self::$vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND", 
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => env('APP_URL') . self::$vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        //thêm 'vnp_BankCode'
        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        //thêm 'vnp_SecureHash'
        $vnp_Url = self::$vnp_Url . "?" . $query;
        if (isset(self::$vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, self::$vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        $returnData = [
            'code' => '00', 
            'message' => 'success',
            'data' => $vnp_Url
        ];


        return $returnData['data']; 
    }

    public function vnPayCheck(Request $request){

        //Lấy data từ URL (VNPay gửi về qua $vnp_Returnurl)
        $vnp_ResponseCode = $request->get('vnp_ResponseCode'); //Mã phản hồi kết quả thanh toán
        $vnp_TxnRef = $request->get('vnp_TxnRef'); // ID đơn  hàng

        // Kiểm tra mã phản hồi
        if($vnp_ResponseCode != null){
            $order = Order::find($vnp_TxnRef);

            //00: TH thành công
            if($vnp_ResponseCode == 00){
                $this->createOrderDetail($order);
                return redirect()->route('checkout.success');

            }elseif($vnp_ResponseCode == 24){ //24: Hủy thanh toán
                $order->delete();
                return redirect()->route('checkout');
            }
            else{
                $order->delete();
                toastr()->error('Có lỗi xảy ra khi thanh toán với VNPay.');
                return redirect()->route('checkout');
            }
        }
    }

    public function notification(){
        return view('frontend.notification');
    }
    public function checkOrderForm()
    {
        return view('frontend.check');
    }
    
    public function checkOrder(Request $request)
{
    // Validate dữ liệu từ request
    $data = $request->validate([
        'phone' => 'nullable|string',
        'email' => 'nullable|email',
    ]);

    // Lấy dữ liệu từ request
    $phone = $request->input('phone');
    $email = $request->input('email');

    // Kiểm tra nếu cả phone và email đều không có dữ liệu
    if (empty($phone) && empty($email)) {
        return back()->with('error', 'Vui lòng nhập số điện thoại hoặc email để kiểm tra đơn hàng.');
    }

    // Xử lý logic kiểm tra đơn hàng
    $ordersQuery = Order::query();

    // Áp dụng điều kiện tìm kiếm nếu có
    if ($phone) {
        $ordersQuery->where('phone', $phone);
    }
    if ($email) {
        $ordersQuery->where('email', $email);
    }

    // Lấy danh sách đơn hàng
    $orders = $ordersQuery->paginate(10);

    // Kiểm tra nếu không tìm thấy đơn hàng
    if ($orders->isEmpty()) {
        return back()->with('error', 'Không tìm thấy đơn hàng phù hợp.');
    }

    return view('frontend.checkorder', compact('orders'));
}

    
}



// Thẻ demo để test VNPay

// Ngân hàng: NCB
// Số thẻ: 9704198526191432198
// Tên chủ thẻ:NGUYEN VAN A
// Ngày phát hành:07/15
// Mật khẩu OTP:123456