<?php

namespace App\Http\Resources\Products;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'price' => $this->price,
            'stock_quantity' => $this->stock_quantity,
            // Return main image with ID and path
            'main_image' => $this->mainImage
            ? [
                'id' => $this->mainImage->id,
                'path' => asset('storage/' . $this->mainImage->file_path)
            ]
            : null,

            // Return gallery images with ID and path
            'gallery' => $this->galleryImages?->map(fn($image) => [
                'id' => $image->id,
                'path' => asset('storage/' . $image->file_path),
            ]),
            'categories' => $this->categories->pluck('name'),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
