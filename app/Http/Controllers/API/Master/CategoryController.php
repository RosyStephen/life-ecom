<?php

namespace App\Http\Controllers\API\Master;

use App\Http\Controllers\Controller;
use App\Http\Resources\Master\CategoryResource;
use App\Models\Master\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
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
        $categories = Category::paginate($limit, ['*'], 'page', $page);
        return response()->json([
            'data' => CategoryResource::collection($categories),
            'meta' => [
                'current_page' => $categories->currentPage(),
                'per_page' => $categories->perPage(),
                'total' => $categories->total(),
                'last_page' => $categories->lastPage(),
            ]
        ]);
    }

    public function rules(Request $request, Category $category = null)
    {
        $rules =  [
            'name' => 'required|string|max:255|unique:categories,name,' . ($category?->id ?? 'NULL') . ',id',
        ];

        $message = [
            'name.required' => 'Name is required',
            'name.unique' => 'This name is already taken. If you don\'t see it in the list, check the trashed items.',
            'name.string' => 'Name must be a string',
            'name.max' => 'Name is too long'
        ];
        return [$rules, $message];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!$request->user()->can('create-category')) {
            return response()->json(['error' => 'You are not authorized to perform this action'], 403);
        }
        $category = new Category();

        return $this->saveCategory($request, $category);

    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        if (!$request->user()->can('edit-category')) {
            return response()->json(['error' => 'You are not authorized to perform this action'], 403);
        }
        return $this->saveCategory($request, $category);
    }
    /**
     * Save the category
     */
    public function saveCategory($request, $category){
        [$rules, $message] = $this->rules($request, $category);
        $request->validate($rules, $message);
        $requestData = $request->all();
        $category->fill($requestData);
        $category->save();
        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Category $category)
    {
        if (!$request->user()->can('delete-category')) {
            return response()->json(['error' => 'You are not authorized to perform this action'], 403);
        }
        try {
            $category->deleted_user = Auth::user()->id;
            $category->save();
            $category->delete();
            return response()->json(['message' => 'Category deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete category', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * get trashed categories
     */
    public function trashed(){

        if (!request()->user()->can('view-trashed-category')) {
            return response()->json(['error' => 'You are not authorized to perform this action'], 403);
        }
        $page = request()->get('page', 1);
        $limit = 10;
        $categories = Category::onlyTrashed()->paginate($limit, ['*'], 'page', $page);
        return response()->json([
            'data' => CategoryResource::collection($categories),
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
        if (!request()->user()->can('restore-category')) {
            return response()->json(['error' => 'You are not authorized to perform this action'], 403);
        }
        try {
            $category = Category::onlyTrashed()->findOrFail($id);
            $category->restore();
            return response()->json(['message' => 'Category restored successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to restore category', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Force delete the specified resource from storage.
     */
    public function forceDelete($id){
        if (!request()->user()->can('force-delete-category')) {
            return response()->json(['error' => 'You are not authorized to perform this action'], 403);
        }
        try {
            $category = Category::findOrFail($id);
            $category->forceDelete();
            return response()->json(['message' => 'Category deleted permanently']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete category permanently', 'message' => $e->getMessage()], 500);
        }
    }
}
