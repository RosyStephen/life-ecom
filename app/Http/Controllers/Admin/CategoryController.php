<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Master\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $query = Category::select(['id', 'name','slug','is_active', 'created_at']);

             // Search filter
             if (!empty($request->search['value'])) {
                $searchValue = $request->search['value'];
                $query->where('name', 'LIKE', "%{$searchValue}%");
            }

            $totalRecords = Category::count(); // Total records before filtering
            $filteredRecords = $query->count(); // Total records after filtering

            // Apply pagination
            $categories = $query->offset($request->start)
                                 ->limit($request->length)
                                 ->get();


            $data = [];
            foreach ($categories as $key => $value) {
                $data[] = [
                    'DT_RowIndex' => $key + 1, // Serial number
                    'id' => $value->id,
                    'name' => $value->name,
                    'slug' => $value->slug,
                    'status' => $value->is_active == 1 ? '<i class="fas fa-check-circle text-success"></i>' : '<i class="fas fa-times-circle text-danger"></i>',

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
        return view('admin.category.index');
    }
}
