<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\OrderItem;

class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
        'image',
        'category_id'
    ];

    // Ép kiểu dữ liệu
    protected $casts = [
        'price' => 'float',
    ];

    // Quan hệ với Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Quan hệ với OrderItem
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Lấy link ảnh (tránh null)
    public function getImageUrlAttribute()
    {
        return $this->image 
            ? asset('storage/' . $this->image) 
            : asset('images/default.png');
    }
}