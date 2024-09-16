<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Voucher;
class CartController extends Controller
{
    public function cart(){
        $coupons = Voucher::where('is_active', true)->get();
       
        return view('frontend.cart', compact('coupons'));
    }

    public function add(Product $product, Request $request)
    {
        $quantity = $request->input('quantity', 1); // Default quantity is 1 if not provided
    
        // Check if requested quantity exceeds available product quantity
        if ($quantity > $product->quantity) {
            toastr()->error('Số lượng sản phẩm không đủ.');
        } else {
            // Retrieve current cart from session
            $cart = session()->get('cart', []);
    
            // Clear coupon-related session data if cart is empty
            if (empty($cart)) {
                session()->forget(['total_price_coupon', 'coupon', 'diss']);
            }
    
            // Check if the product is already in the cart
            if (isset($cart[$product->id])) {
             //   $cart[$product->id]['quantity'] += $quantity;
                toastr()->info('Sản phẩm đã có trong giỏ hàng.');
            } else {
                // Add product to cart
                $cart[$product->id] = [
                    'product_id' => $product->id,
                    'image' => $product->images->first()->image,
                    'name' => $product->name,
                    'quantity' => $quantity,
                    'price' => $product->price,
                ];
                toastr()->success('Thêm sản phẩm thành công.');
            }
    
            // Update cart in session
            session()->put('cart', $cart);
    
            // Recalculate total price if necessary
            $this->totalPrice();
        }
    
        return redirect()->back();
    }
    
    

    public function increase($product_id){ 
        $cart = session('cart', []);
        $product = Product::find($product_id);

        if(isset($cart[$product_id])){

            if($cart[$product_id]['quantity'] == $product->quantity){
                toastr()->error('Quá số lượng sản phẩm.');
            }
            else{
                $cart[$product_id]['quantity'] += 1;
                session()->put('cart', $cart);
                $this->totalPrice();
                toastr()->success('Cập nhật thành công.');
            }
        };
        
        return redirect()->back();
    }

    public function decrease($product_id){ 
        $cart = session('cart', []);
        if(isset($cart[$product_id])){
            $cart[$product_id]['quantity'] -= 1;
            if($cart[$product_id]['quantity'] === 0){
                unset($cart[$product_id]);
            }
        };
        session()->put('cart', $cart);
        $this->totalPrice();
        toastr()->success('Cập nhật thành công.');
        return redirect()->back();
    }

    public function delete($product_id){
        $cart = session('cart');
        unset($cart[$product_id]);
        session()->put('cart', $cart);
        $this->totalPrice();
        toastr()->success('Xóa thành công');
        return back();
    }



    public function applyCoupon(Request $request)
    {
        $validatedData = $request->validate([
            'coupon_name' => 'nullable', // Validation cho phép coupon_name có thể null
        ]);
    
        // Nếu không có 'coupon_name', gán giá trị null cho biến $couponName
        $couponName = $validatedData['coupon_name'] ?? null;
    
        // Tiếp tục xử lý mã giảm giá...
        if ($couponName === null) {
            toastr()->error('Vui lòng nhập mã giảm giá.');
            return redirect()->back();
        }else{
        
               // Tìm mã giảm giá trong cơ sở dữ liệu
        $coupon = Voucher::where('name',$couponName)->first();
        if (!$coupon) {
            toastr()->error('Mã giảm giá không tồn tại.');
        } elseif (!$coupon->is_active) {
            toastr()->error('Mã giảm giá đã hết hạn.');
        } else {
            // Lưu mã giảm giá vào session
            session()->put('coupon', $coupon);
    
            // Tính lại tổng giá trị sau khi áp dụng mã giảm giá
            if (session()->has('cart')) {
                $total_price = 0;
                foreach (session('cart') as $item) {
                    $total_price += $item['quantity'] * $item['price'];
                }
                $discounted_price = $total_price * (1 - ($coupon->discount_amount / 100));
                $dis=  $total_price -$discounted_price;
                session()->put('total_price_coupon', $discounted_price);
                session()->put('diss', $dis);
              //  dd($discounted_price);
            }
    
            toastr()->success('Áp dụng mã giảm giá thành công.');
           /*session()->forget(['cart','total_price','total_price_coupon','coupon']); */
        }
          
    
        return redirect()->back();

        }
     
    }
    
    

    protected function totalPrice()
    {
        $total_price = 0;
        foreach(session('cart', []) as $item){
            $total_price += $item['quantity'] * $item['price'];
        }
        
        session()->put('total_price', $total_price);
    
        if(session()->has('coupon')){
            $coupon = session('coupon');
            $discounted_price = $total_price * (1 - ($coupon->discount_amount / 100));
            $dis=  $total_price -$discounted_price;
            session()->put('total_price_coupon', $discounted_price);
            session()->put('diss', $dis);
          
        } else {
            session()->forget('total_price_coupon');
            session()->forget('diss');
        }
    }

    

}
