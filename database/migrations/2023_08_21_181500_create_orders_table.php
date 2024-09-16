<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->string('note')->nullable();
            $table->double('total_price');
            $table->tinyInteger('payment')->comment('1: VNPay, 2: COD');
            $table->tinyInteger('status')->comment('0: Hủy, 1: Trả hàng, 2: Chờ xác nhận, 3: Đang giao, 4: Đã giao');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};