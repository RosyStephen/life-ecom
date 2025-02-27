<?php

namespace App\Models\Products\Traits;

use App\Models\Products\Product;

trait SearchTrait
{
    public static function searchQuery($requestData)
    {
        $query = Product::query();

        if (isset($requestData['search']) && $requestData['search'] != '') {
            $searchTerm = '%' . $requestData['search'] . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                ->orWhere('id', 'like', $searchTerm)
                ->orWhereHas('categories', function($q) use ($searchTerm) {
                    $q->where('name', 'like', $searchTerm);
                });
            });
        }

        if (!empty($requestData['category_id']) && is_array($requestData['category_id'])) {
            $query->whereHas('categories', function($q) use ($requestData) {
                $q->whereIn('categories.id', $requestData['category_id']);
            });
        }

        return $query;
    }
}
