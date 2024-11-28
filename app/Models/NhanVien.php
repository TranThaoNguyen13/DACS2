<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NhanVien extends Model
{
    use HasFactory;

    protected $table = 'nhanvien'; // Tên bảng
    protected $fillable = [
        'name', 
        'birthday', 
        'phone', 
        'email', 
        'address', 
        'funcion',
        'wage'
    ];
}
