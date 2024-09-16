<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class AuthUserController extends Controller
{
    public function login(){
        return view('frontend.auth.login');
    }

    public function loginPost(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('web')->attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'status' => 1
        ])){
            $request->session()->regenerate();
            
            toastr()->success('Đăng nhập thành công.');
            return redirect()->intended('/');
        }
 
        return back()->withErrors([
            'status' => 'Thông tin đăng nhập được cung cấp không khớp hoặc tài khoản của bạn đã bị khóa.',
        ]);
    }

    public function register(){
        return view('frontend.auth.register');
    }

    public function registerPost(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ],[
            'name.required' => 'Họ tên không được để trống.',
            'email.required' => 'Địa chỉ email không được để trống.',
            'password.required' => 'Mật khẩu không được để trống.',
            'password.confirmed' => 'Mật khẩu nhập lại không khớp.',
        ]);

        $user = User::create($validated);
        if($user){
            toastr()->success('Đăng ký tài khoản thành công.');
            return redirect()->route('login');
        }
        
    }

    public function logout(Request $request){
        Auth::guard('web')->logout();
        $cart = session('cart', []);
       // dd($cart);
        if(!$cart){
            session()->forget(['total_price_coupon','coupon']);
         }
        // $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/');
    }

    public function forgotPassword(){
        return view('frontend.auth.forgot-password');
    }

    public function forgotPasswordPost(Request $request){
        $request->validate(['email' => 'required|email'], ['email.required' => 'Vui lòng nhập địa chỉ email.']);
 
        $status = Password::sendResetLink(
            $request->only('email')
        );
     
        if($status === Password::RESET_LINK_SENT){
            toastr()->success('Vui lòng kiểm tra địa chỉ email của bạn.');
            return back();
        }else{
            return back()->withErrors(['email' => 'Địa chỉ email này chưa được đăng ký.']);
        }
    }

    public function resetPassword(string $token){
        return view('frontend.auth.reset-password', compact('token'));
    }

    public function resetPasswordPost(Request $request){
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ],[
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'password.required' => 'Vui lòng nhập mật khẩu mới.',
            'password.confirmed' => 'Mật khẩu nhập lại không khớp.',
        ]);
     
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => bcrypt($password)
                ]);
     
                $user->save();
     
                event(new PasswordReset($user));
            }
        );
     
        if($status === Password::PASSWORD_RESET){
            toastr()->success('Đặt lại mật khẩu thành công.');
            return redirect()->route('login');
        }else{
            return back()->withErrors(['email' => 'Địa chỉ email không hợp lệ.']);
        }
    }
}