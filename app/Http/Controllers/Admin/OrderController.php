<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Orders\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Order::with('items', 'user');


            $user = User::find(Auth::id());

            if($user->hasRole('customer')) {
                $query->where('user_id', Auth::id());
            }

             // Search filter
             if (!empty($request->search['value'])) {
                $searchValue = $request->search['value'];
                $query->where('name', 'LIKE', "%{$searchValue}%");
            }

            $totalRecords = Order::count(); // Total records before filtering
            $filteredRecords = $query->count(); // Total records after filtering

            // Apply pagination
            $orders = $query->offset($request->start)
                                 ->limit($request->length)
                                 ->get();


            $data = [];
            foreach ($orders as $key => $value) {
                $data[] = [
                    'DT_RowIndex' => $key + 1, // Serial number
                    'id' => $value->id,
                    'customer_name' => $value->user->name,
                    'customer_email' => $value->user->email,
                    'total_items' => $value->items->count(),
                    'total_price' => $value->total_price,
                    'payment_method' => $value->payment_method,
                    'payment_status' => $value->payment_status,
                    'status' => $value->status,
                    'shipping_address' => $value->shipping_address,
                    'created_at' => $value->created_at->format('d M Y'), // Format date

                ];
            }

            return response()->json([
                "draw" => intval($request->draw), // Use request's draw parameter
                "recordsTotal" => $totalRecords, // Total records before filtering
                "recordsFiltered" => $filteredRecords, // Total records after filtering
                "data" => $data
            ]); // Return JSON data
        }
        return view('admin.order.index');
    }
}
