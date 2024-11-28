<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');  // Khóa ngoại liên kết với bảng orders
            $table->foreignId('product_id')->constrained()->onDelete('cascade');  // Khóa ngoại liên kết với bảng products
            $table->integer('quantity');
            $table->decimal('price', 10, 2);  // Giá sản phẩm tại thời điểm thanh toán
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_product');
    }
};
