<?php

namespace App\Http\Controllers\API\Orders;

use App\Http\Controllers\Controller;
use App\Http\Resources\Orders\OrderResource;
use App\Models\Orders\Order;
use App\Models\Orders\OrderItem;
use App\Models\Products\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $page = request()->get('page', 1);
        $limit = 10;

        $requestData = request()->all();

        $query = Order::searchQuery($requestData);

        $products = $query->paginate($limit, ['*'], 'page', $page);
        return response()->json([
            'status' => 'success',
            'data' => OrderResource::collection($products),
            'meta' => [
                'current_page' => $products->currentPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
                'last_page' => $products->lastPage(),
            ]
        ]);
    }

    /**
     * Store a newly created order in storage.
     */
    public function createOrder(Request $request)
    {
        $user = Auth::user();

        // Start Transaction to prevent partial order creation
        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => 0, // Will be calculated later
                'status' => 'pending',
            ]);

            $total = 0;

            foreach ($request->products as $item) {
                $product = Product::find($item['id']);

                // Validate stock BEFORE adding to order
                if (!$product || $product->stock_quantity < $item['quantity']) {
                    DB::rollBack(); // Cancel order creation if stock is insufficient
                    return response()->json([
                        'message' => "Insufficient stock for {$product->name}. Available stock: {$product->stock_quantity}"
                    ], 400);
                }

                // Add product to order
                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ]);

                // Reduce stock
                $product->decrement('stock_quantity', $item['quantity']);
                $total += $product->price * $item['quantity'];
            }

            // Update order total
            $order->update(['total_amount' => $total]);

            // Commit transaction (order is now final)
            DB::commit();

            return response()->json([
                'message' => 'Order created successfully!',
                'order' => $order
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback in case of an error
            return response()->json(['message' => 'Something went wrong!'], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($code)
    {
        $order = Order::where('code', $code)->firstOrFail();
        return new OrderResource($order->load('items.product'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {


        try {
            DB::transaction(function () use ($order) {
                $order->update(['deleted_user' => Auth::id()]);
                $order->delete();
            });

            return response()->json(['message' => 'Order deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete order', 'message' => $e->getMessage()], 500);
        }
    }
}
