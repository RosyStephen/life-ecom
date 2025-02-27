<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Role::select(['id', 'name', 'created_at']);

             // Search filter
             if (!empty($request->search['value'])) {
                $searchValue = $request->search['value'];
                $query->where('name', 'LIKE', "%{$searchValue}%");
            }

            $totalRecords = Role::count(); // Total records before filtering
            $filteredRecords = $query->count(); // Total records after filtering

            // Apply pagination
            $roles = $query->offset($request->start)
                                 ->limit($request->length)
                                 ->get();


            $data = [];
            foreach ($roles as $key => $value) {
                $data[] = [
                    'DT_RowIndex' => $key + 1, // Serial number
                    'id' => $value->id,
                    'name' => $value->name,
                    'permissions' => $value->permissions->pluck('name')->toArray(),

                    'created_at' => $value->created_at->format('d M Y'), // Format date
                    'action' => '
                       <a href="javascript:void(0)" data-id="'.$value->id.'" class="btn btn-sm btn-primary edit-btn"><i class="fas fa-edit"></i> Edit</a>
                        <a href="javascript:void(0)" data-id="'.$value->id.'" class="btn btn-sm btn-danger delete-btn"><i class="fas fa-trash-alt"></i> Delete</a>


                    '
                ];
            }

            return response()->json([
                "draw" => intval($request->draw), // Use request's draw parameter
                "recordsTotal" => $totalRecords, // Total records before filtering
                "recordsFiltered" => $filteredRecords, // Total records after filtering
                "data" => $data
            ]); // Return JSON data
        }

        $permissions = Permission::select(['id', 'name'])->get();

        return view('users.roles.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    private function rules($request){
        if($request->input('roleId')){
            $rules['name'] = 'required|unique:roles,name,'.$request->input('roleId');
        }else{
            $rules['name'] = 'required|unique:roles';
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
        $role = Role::create(['name' => $request->name]);

    if (!empty($request->permissions)) {
        $validPermissions = Permission::whereIn('id', $request->permissions)->pluck('name')->toArray();
        foreach ($validPermissions as $permission) {
            $role->givePermissionTo($permission);
        }
    }

     return response()->json([
            'success' => ' role Added Successfully!',
            'role' => $role
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
        $role = Role::findOrFail($id);
        $hasPermissions = $role->permissions->pluck('id')->toArray();
        $permissions = Permission::select(['id', 'name'])->get();
        return response()->json([
            'data' => $role,
            'permissions' => $permissions,
            'hasPermissions' => $hasPermissions

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate($this->rules($request)['rules'], $this->rules($request)['message']);
        $role = Role::findOrFail($id);
        $role->update(['name' => $request->name]);

        if (!empty($request->permissions)) {
            $validPermissions = Permission::whereIn('id', $request->permissions)->pluck('name')->toArray();
            $role->syncPermissions($validPermissions);
        } else {
            $role->syncPermissions([]);
        }

        return response()->json([
            'success' => 'role updated Successfully!',
            'role' => $role
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json([
                'error' => 'Role not found!'
            ], 404);
        }

        $role->delete();

        return response()->json([
            'success' => 'role Deleted Successfully!'
        ]);
    }
}
