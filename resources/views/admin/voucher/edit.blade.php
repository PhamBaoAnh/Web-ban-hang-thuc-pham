@extends('admin.layout.master')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Chỉnh sửa Voucher</h5>
                <!-- admin.voucher.create và admin.voucher.edit -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('voucher.update', $voucher) }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Tên</label>
                        <input type="text" name="name" value="{{ $voucher->name }}" class="form-control" id="name">
                    </div>

                    <div class="mb-3">
                        <label for="discount_amount" class="form-label">Số tiền giảm giá</label>
                        <input type="text" name="discount_amount" value="{{ $voucher->discount_amount }}" class="form-control" id="discount_amount">
                    </div>

                    <div class="mb-3">
                        <label for="start_date" class="form-label">Ngày bắt đầu</label>
                        <input type="date" name="start_date" value="{{ $voucher->start_date->format('Y-m-d') }}" class="form-control" id="start_date">
                    </div>

                    <div class="mb-3">
                        <label for="expiry_date" class="form-label">Ngày hết hạn</label>
                        <input type="date" name="expiry_date" value="{{ $voucher->expiry_date->format('Y-m-d') }}" class="form-control" id="expiry_date">
                    </div>



                    <div class="mb-3">
                        <label for="is_active" class="form-label">Trạng thái</label>
                        <select class="form-select" name="is_active" id="is_active">
                            <option value="1" {{ $voucher->is_active ? 'selected' : '' }}>Hoạt động</option>
                            <option value="0" {{ !$voucher->is_active ? 'selected' : '' }}>Không hoạt động</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
@endsection
