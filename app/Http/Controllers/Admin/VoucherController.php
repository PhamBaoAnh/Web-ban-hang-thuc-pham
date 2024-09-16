<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class VoucherController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->input('name');
        
        $vouchers = Voucher::when($name, function ($query, $name) {
            return $query->where('name', 'LIKE', "%$name%");
        })
        ->orderByDesc('id')
        ->get();

        return view('admin.voucher.list', compact('vouchers'));
    }

    public function create()
    {
        return view('admin.voucher.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:vouchers',
            'discount_amount' => 'required|numeric|min:0|max:100', // Thêm max:100 để giới hạn giá trị từ 0 đến 100
            'start_date' => [
                'required',
                'date',
                'after_or_equal:today', // Ngày bắt đầu phải lớn hơn hoặc bằng ngày hiện tại
            ],
            'expiry_date' => [
                'required',
                'date',
                'after_or_equal:start_date', // Ngày kết thúc phải sau hoặc bằng ngày bắt đầu
            ],
            'is_active' => 'boolean',
        ]);
    
        // Bắt đầu giao dịch
        DB::beginTransaction();
    
        try {
            // Tạo voucher
            $voucher = new Voucher();
            $voucher->name = $request->name;
            $voucher->discount_amount = $request->discount_amount;
            $voucher->start_date = $request->start_date;
            $voucher->expiry_date = $request->expiry_date;
            $voucher->is_active = $request->boolean('is_active');
            $voucher->save();
    
            // Commit giao dịch nếu mọi thứ thành công
            DB::commit();
    
            return redirect()->route('voucher.index')->with('success', 'Tạo khuyến mãi thành công');
        } catch (\Exception $e) {
            // Nếu có lỗi xảy ra, rollback giao dịch
            DB::rollback();
    
            // Log lỗi hoặc thông báo cho người dùng
            \Log::error('Lỗi khi tạo voucher: ' . $e->getMessage());
    
            return back()->withErrors(['error' => 'Đã có lỗi xảy ra, vui lòng thử lại sau.'])->withInput();
        }
    }

    public function __construct()
    {
        // Kiểm tra và cập nhật trạng thái của các vouchers
        $this->checkAndUpdateVoucherStatus();
    }

    private function checkAndUpdateVoucherStatus()
    {
        $now = Carbon::now();

        // Cập nhật trạng thái các voucher hết hạn
        Voucher::whereDate('expiry_date', '<', $now->toDateString())
               ->update(['is_active' => false]);
    }

    public function edit(Voucher $voucher)
    {
        return view('admin.voucher.edit', compact('voucher'));
    }

    public function update(Request $request, Voucher $voucher)
    {
        $request->validate([
            'name' => 'required|unique:vouchers,name,'.$voucher->id,
            'discount_amount' => 'required|numeric|min:0|max:100', // Thêm max:100 để giới hạn giá trị từ 0 đến 100
            'start_date' => 'required|date',
            'expiry_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'boolean',
        ]);

        // Cập nhật thông tin voucher
        $voucher->name = $request->name;
        $voucher->discount_amount = $request->discount_amount;
        $voucher->start_date = $request->start_date;
        $voucher->expiry_date = $request->expiry_date;
        $voucher->is_active = $request->boolean('is_active');
        $voucher->save();

        return redirect()->route('voucher.index')->with('success', 'Cập nhật voucher thành công');
    }

    public function destroy(Voucher $voucher)
    {
        $voucher->delete();

        return redirect()->route('voucher.index')->with('success', 'Xóa voucher thành công');
    }
}
