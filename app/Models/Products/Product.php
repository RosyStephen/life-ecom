<?php

namespace App\Models\Products;

use App\Models\Master\Category;
use App\Models\Model;
use App\Models\Products\ProductImage;
use App\Models\Products\Traits\SearchTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    use SearchTrait;

    public $slugFromField = 'name';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'stock_quantity',
        'main_image_id',
        'created_user',
        'updated_user',
        'deleted_user'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function mainImage()
    {
        return $this->belongsTo(ProductImage::class, 'main_image_id');
    }
    public function galleryImages(){
        return $this->hasMany(ProductImage::class)->where('is_main', 0);
    }
}
