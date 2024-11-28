<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicSpa extends Model
{
    use HasFactory;

    protected $table = 'clinic_spa'; // Tên bảng trong cơ sở dữ liệu
    protected $fillable = ['name', 'image', 'description', 'durationtype', 'price', 'created_at', 'updated_at'];

}
