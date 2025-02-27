<?php

namespace App\Models\Orders;

use App\Models\Model;
use App\Models\Orders\Traits\SearchTrait;
use App\Models\Orders\OrderItem;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class Order extends Model
{
    use SoftDeletes;
    use SearchTrait;

    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_REFUNDED = 'refunded';

    const STATUS_PICKED_UP = 'picked_up';
    const STATUS_ON_THE_WAY = 'on_the_way';
    const STATUS_NEAR_DELIVERY = 'near_delivery';
    const STATUS_DELIVERED = 'delivered';

    protected $fillable = ['code', 'user_id', 'total_price', 'status', 'created_user', 'updated_user', 'deleted_user'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($order) {
            $order->code = (string) Str::uuid();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
