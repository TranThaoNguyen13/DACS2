<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'content', 'reply'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
     // Quan hệ với câu trả lời (nếu có)
     public function parentComment()
     {
         return $this->belongsTo(Comment::class, 'parent_id');
     }
 
     // Quan hệ với các câu trả lời
     public function replies()
     {
         return $this->hasMany(Comment::class, 'parent_id');
     }
}
