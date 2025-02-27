<?php

namespace App\Models\Orders\Traits;

use App\Models\Orders\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait SearchTrait
{
    public static function searchQuery($requestData)
    {
        $user = User::find(Auth::id());

        $query = Order::query();

        if ($user && $user->hasRole('customer')) {
            $query->where('user_id', $user->id);
        }

       if (isset($requestData['search'])) {
            $query->where('status', 'like', '%' . $requestData['search'] . '%');
            $query->orWhere('id', 'like', '%' . $requestData['search'] . '%');
            $query->orWhereHas('user', function ($q) use ($requestData) {
                $q->where('name', 'like', '%' . $requestData['search'] . '%');
            });
            $query->orWhereHas('items', function ($q) use ($requestData) {
                $q->whereHas('product', function ($q) use ($requestData) {
                    $q->where('name', 'like', '%' . $requestData['search'] . '%');
                });
            });
       }
       if(isset($requestData['status'])) {
           $query->where('status', $requestData['status']);
       }
       if(isset($requestData['user_id'])) {
           $query->where('user_id', $requestData['user_id']);
       }
       if(isset($requestData['order_date'])) {
           $query->whereDate('created_at', $requestData['order_date']);
       }
       if(isset($requestData['category_id']) && is_array($requestData['category_id'])) {
           $query->whereHas('items.product.categories', function ($q) use ($requestData) {
               $q->whereIn('categories.id', $requestData['category_id']);
           });
       }
       if(isset($requestData['price_from'])) {
           $query->where('total_price', '>=', $requestData['price_from']);
       }
       if(isset($requestData['price_to'])) {
           $query->where('total_price', '<=', $requestData['price_to']);
       }
       return $query;
   }
}
