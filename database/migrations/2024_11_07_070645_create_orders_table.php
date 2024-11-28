<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // Tạo cột id tự động tăng
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Khóa ngoại tới bảng users
            $table->decimal('total', 10, 2); // Tổng giá trị đơn hàng
            $table->string('status'); // Trạng thái đơn hàng
            $table->timestamps(); // Thời gian tạo và cập nhật
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->string('address')->nullable(); // Thêm cột address
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->nullable();
    
            // Nếu có bảng sản phẩm thì thêm ràng buộc khóa ngoại
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_method')->after('address'); // Thêm cột payment_method
        });
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->enum('status', ['pending', 'processed', 'shipped', 'delivered', 'canceled'])->default('pending');
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
        Schema::dropIfExists('orders'); // Xóa bảng khi rollback
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('address'); // Xóa cột address nếu cần rollback
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('payment_method'); // Xóa cột nếu cần rollback
        });
    }
}

