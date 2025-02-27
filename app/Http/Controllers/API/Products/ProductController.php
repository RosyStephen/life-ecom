<?php

namespace App\Http\Controllers\API\Products;

use App\Http\Controllers\Controller;
use App\Http\Resources\Products\ProductResource;
use App\Models\Products\Product;
use App\Models\Products\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);

    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page = request()->get('page', 1);
        $limit = 10;

        $requestData = request()->all();

        $query = Product::searchQuery($requestData);

        $products = $query->paginate($limit, ['*'], 'page', $page);
        return response()->json([
            'status' => 'success',
            'data' => ProductResource::collection($products),
            'meta' => [
                'current_page' => $products->currentPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
                'last_page' => $products->lastPage(),
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!$request->user()->can('create-product')) {
           return $this->sendUnautoriszedResponse();
        }
        $product = new Product();
        return  $this->saveProduct($request, $product);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        if (!$request->user()->can('edit-product')) {
           return $this->sendUnautoriszedResponse();
        }
        return $this->saveProduct($request, $product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Product $product)
    {
        if (!$request->user()->can('delete-product')) {
           return $this->sendUnautoriszedResponse();
        }
        try {
            $product->deleted_user = Auth::user()->id;
            $product->save();
            $product->delete();
            return response()->json(['status' => 'success', 'message' => 'Product deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'failed', 'error' => 'Failed to delete product', 'message' => $e->getMessage()], 500);
        }
    }
    /**
     * Save the product data
     */
    public function saveProduct(Request $request, Product $product = null)
    {
        $validated = $this->validateProduct($request, $product);

        try{
            $product->fill($validated);
            $product->save();
            if (isset($validated['categories'])) {
                $product->categories()->sync($validated['categories']);
            }
            $this->saveImages($request, $product);

            return new ProductResource($product);

        } catch (\Exception $e) {
            return response()->json(['status' => 'failed', 'error' => 'Failed to save product', 'message' => $e->getMessage()], 500);
        }
    }
    public function saveImages(Request $request, Product $product)
    {

        if ($request->hasFile('main_image')) {
            $filename = "main_image_" . now()->format('YmdHis') . "." . $request->file('main_image')->getClientOriginalExtension();
            $mainImagePath = Storage::disk('public')->putFileAs("uploads/products/{$product->id}", $request->file('main_image'), $filename);

            $product->main_image_id = ProductImage::create([
                'file_path' => $mainImagePath,
                'is_main' => true,
                'product_id' => $product->id
            ])->id;

            $product->save();
        }

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $index =>  $image) {
                $filename = "gallery_image_" . $index . '_' . now()->format('YmdHis') . "." . $request->file('main_image')->getClientOriginalExtension();
                $galleryImagePath = Storage::disk('public')->putFileAs("uploads/products/{$product->id}", $image, $filename);
                ProductImage::create([
                    'file_path' => $galleryImagePath,
                    'is_main' => false,
                    'product_id' => $product->id
                ]);
            }
        }
    }
    /**
     * Delete the specified image from storage.
     */
    public function deleteImage($imageId)
    {
        if(!request()->user()->can('delete-product-image')) {
            return $this->sendUnautoriszedResponse();
        }
        $image = ProductImage::find($imageId);

        if (!$image) {
            return response()->json(['status' => 'failed', 'message' => 'Image not found'], 404);
        }

        // Delete the image file from storage
        Storage::delete($image->file_path);

        // If the image being deleted is the main image, update the product
        if ($image->is_main) {
            $image->product->update(['main_image_id' => null]);
        }

        // Delete the image record
        $image->delete();

        return response()->json(['status' => 'success', 'message' => 'Image deleted successfully']);
    }
    /**
     * Validate the product data
     */
    private function validateProduct(Request $request, Product $product = null)
    {
        $rules = [
            'name' => 'required|string|max:255|unique:products,name,' . ($product ? $product->id : 'NULL'),
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'main_image' => 'required|image|mimes:jpg,jpeg,png|max:2048', // Main image validation
            'gallery.*' => 'image|mimes:jpg,jpeg,png|max:2048', // Multiple images
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ];

        return $request->validate($rules);
    }

    /**
     * get trashed categories
     */
    public function trashed(){

        if (!request()->user()->can('view-trashed-product')) {
          return $this->sendUnautoriszedResponse();
        }
        $page = request()->get('page', 1);
        $limit = 10;
        $categories = Product::onlyTrashed()->paginate($limit, ['*'], 'page', $page);
        return response()->json([
            'data' => ProductResource::collection($categories),
            'meta' => [
                'current_page' => $categories->currentPage(),
                'per_page' => $categories->perPage(),
                'total' => $categories->total(),
                'last_page' => $categories->lastPage(),
            ]
        ]);
    }
    /**
     * Restore the specified resource from storage.
     */
    public function restore($id){
        if (!request()->user()->can('restore-product')) {
          return $this->sendUnautoriszedResponse();
        }
        try {
            $product = Product::onlyTrashed()->findOrFail($id);
            $product->restore();
            return response()->json(['status' => 'success', 'message' => 'Product restored successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'failed', 'error' => 'Failed to restore product', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Force delete the specified resource from storage.
     */
    public function forceDelete($id){
        if (!request()->user()->can('force-delete-product')) {
           return $this->sendUnautoriszedResponse();
        }
        try {
            $product = Product::findOrFail($id);
            $product->forceDelete();
            return response()->json(['status' => 'success', 'message' => 'Product deleted permanently']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'failed', 'error' => 'Failed to delete product permanently', 'message' => $e->getMessage()], 500);
        }
    }
    private function sendUnautoriszedResponse()
    {
        return response()->json(['status' => 'failed', 'error' => 'You are not authorized to perform this action'], 403);
    }
}
