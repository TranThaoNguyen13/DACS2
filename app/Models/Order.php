<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'total', 'status', 'address', 'phone', 'email' ,'username', // Đảm bảo thêm phone vào đây
    ];
    use HasFactory;
    public function product()
{
    return $this->belongsTo(Product::class, 'product_id');
}
// Model Order.php
public function products()
{
    return $this->belongsToMany(Product::class, 'order_product')
                ->withPivot('quantity', 'price');
}
public function user()
    {
        return $this->belongsTo(User::class);
    }
}
