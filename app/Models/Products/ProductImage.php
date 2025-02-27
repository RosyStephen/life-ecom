<?php

namespace App\Models\Products;

use App\Models\Model;


class ProductImage extends Model
{
    protected $fillable = ['product_id', 'file_path', 'is_main'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
