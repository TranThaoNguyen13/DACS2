<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'new_price', // giá mới
        'old_price', // giá cũ
        'rating', // đánh giá
        'sold', // số lượng đã bán
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public $timestamps = true;
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product')
                    ->withPivot('quantity', 'price'); // Thêm các cột trung gian nếu cần
    }
    public function comments()
{
    return $this->hasMany(Comment::class);
}

}
