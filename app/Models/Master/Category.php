<?php

namespace App\Models\Master;

use App\Models\Model;
use App\Models\Products\Product;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    public $slugFromField = 'name';


    protected $fillable = ['name', 'slug'];

    public function products() {
        return $this->belongsToMany(Product::class);
    }
}
