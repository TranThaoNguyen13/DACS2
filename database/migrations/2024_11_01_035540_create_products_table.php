<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('new_price', 10, 2)->after('image'); // Thay đổi kích thước tùy theo nhu cầu
            $table->decimal('old_price', 10, 2)->after('new_price');
            $table->integer('sold')->default(0)->after('old_price'); // Cột sold để theo dõi số lượng đã bán
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('image')->nullable();
            $table->timestamps();
            $table->unsignedInteger('sold')->default(0); // Thêm cột sold với giá trị mặc định là 0
            $table->integer('quantity')->default(1);
            
        });
       
    }

    public function down()
    {
        Schema::dropIfExists('products');
        $table->dropColumn(['new_price', 'old_price', 'sold']);
       
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['created_at', 'updated_at']);
            $table->dropColumn('quantity');
        });
    }
}
