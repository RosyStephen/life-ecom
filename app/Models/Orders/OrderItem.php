<?php

namespace App\Models\Orders;

use App\Models\Model;
use App\Models\Orders\Order;
use App\Models\Products\Product;


class OrderItem extends Model
{
    protected $fillable = ['order_id', 'product_id', 'quantity', 'price'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
