<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'table_id',
        'total_price',
        'status'
    ];

    /**
     * Quan hệ với bàn
     */
    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    /**
     * Quan hệ với order_items
     */
    public function items()
    {
        return $this->hasMany(\App\Models\OrderItem::class);
    }

    /**
     * Quan hệ với products (nếu cần)
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }
}