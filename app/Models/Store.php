<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    // Đặt tên bảng nếu khác tên mặc định (Laravel sẽ tự động lấy tên bảng là số nhiều của tên model, ví dụ 'stores')
    protected $table = 'stores';

    // Các cột có thể được gán giá trị (mass assignable)
    public $timestamps = false;

    protected $fillable = [
        'name', 'address', 'phone', 'map_url',
    ];

    // Nếu bạn không muốn cho phép một số cột được gán giá trị, bạn có thể sử dụng $guarded
    // protected $guarded = ['id'];
}
