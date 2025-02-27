<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;


class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Fetch query with pagination
            $query = Permission::select(['id', 'name', 'created_at']);

            // Search filter
            if (!empty($request->search['value'])) {
                $searchValue = $request->search['value'];
                $query->where('name', 'LIKE', "%{$searchValue}%");
            }

            $totalRecords = Permission::count(); // Total records before filtering
            $filteredRecords = $query->count(); // Total records after filtering

            // Apply pagination
            $permissions = $query->offset($request->start)
                                 ->limit($request->length)
                                 ->get();

            // Format data for DataTables
            $data = [];
            foreach ($permissions as $key => $value) {
                $data[] = [
                    'DT_RowIndex' => $request->start + $key + 1, // Serial number
                    'id' => $value->id,
                    'name' => $value->name,
                    'created_at' => $value->created_at->format('d M Y'),
                    'action' => '
                        <a href="javascript:void(0)" data-id="'.$value->id.'" class="btn btn-sm btn-primary edit-btn"><i class="fas fa-edit"></i> Edit</a>
                        <a href="javascript:void(0)" data-id="'.$value->id.'" class="btn btn-sm btn-danger delete-btn"><i class="fas fa-trash-alt"></i> Delete</a>
                    '
                ];
            }

            // Return JSON response with proper pagination details
            return response()->json([
                "draw" => intval($request->draw), // Use request's draw parameter
                "recordsTotal" => $totalRecords, // Total records before filtering
                "recordsFiltered" => $filteredRecords, // Total records after filtering
                "data" => $data
            ]);
        }

        return view('users.permissions.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    private function rules($request){
        if($request->input('permissionId')){
            $rules['name'] = 'required|unique:permissions,name,'.$request->input('permissionId');
        }else{
            $rules['name'] = 'required|unique:permissions';
        }

        $message = [
            'name.required' => 'Name is required',

        ];


        return ['rules' => $rules, 'message' => $message];
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate($this->rules($request)['rules'], $this->rules($request)['message']);

        $permission = Permission::create($request->all());


        return response()->json([
            'success' => ' Permission Added Successfully!',
            'permission' => $permission
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $permission = Permission::findOrFail($id);
        return response()->json([
            'data' => $permission
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate($this->rules($request)['rules'], $this->rules($request)['message']);
        $permission = Permission::findOrFail($id);

        $permission->update($request->all());

        return response()->json([
            'success' => 'Permission Updated Successfully!',
            'permission' => $permission
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = Permission::find($id);

        if (!$permission) {
            return response()->json([
                'error' => 'Permission not found!'
            ], 404);
        }

        $permission->delete();

        return response()->json([
            'success' => 'Permission Deleted Successfully!'
        ]);
    }
}
