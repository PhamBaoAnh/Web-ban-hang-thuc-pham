@extends('admin.layout.master')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Tạo Voucher Mới</h5>
            <form method="POST" action="{{ route('voucher.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Tên</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name') }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="discount_amount" class="form-label">Số tiền giảm giá</label>
                    <input type="number" name="discount_amount" class="form-control @error('discount_amount') is-invalid @enderror" id="discount_amount" value="{{ old('discount_amount') }}">
                    @error('discount_amount')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="start_date" class="form-label">Ngày bắt đầu</label>
                    <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" value="{{ old('start_date') }}">
                    @error('start_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="expiry_date" class="form-label">Ngày kết thúc</label>
                    <input type="date" name="expiry_date" class="form-control @error('expiry_date') is-invalid @enderror" id="expiry_date" value="{{ old('expiry_date') }}">
                    @error('expiry_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="is_active" class="form-label">Trạng thái</label>
                    <select name="is_active" id="is_active" class="form-control">
                        <option value="1">Hoạt động</option>
                        <option value="0">Hết Hạn</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Lưu</button>
            </form>
        </div>
    </div>
</div>
@endsection
