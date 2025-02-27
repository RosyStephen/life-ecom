<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = User::select(['id', 'name','email', 'created_at']);

             // Search filter
             if (!empty($request->search['value'])) {
                $searchValue = $request->search['value'];
                $query->where(function($query) use ($searchValue) {
                    $query->where('name', 'LIKE', "%{$searchValue}%")
                          ->orWhere('phone', 'LIKE', "%{$searchValue}%")
                          ->orWhere('email', 'LIKE', "%{$searchValue}%");
                });
            }

            $totalRecords = User::count(); // Total records before filtering
            $filteredRecords = $query->count(); // Total records after filtering

            // Apply pagination
            $users = $query->offset($request->start)
                                 ->limit($request->length)
                                 ->get();


            $data = [];
            foreach ($users as $key => $value) {
                $data[] = [
                    'DT_RowIndex' => $key + 1, // Serial number
                    'id' => $value->id,
                    'name' => $value->name,
                    'email' => $value->email,


                    'roles' => $value->roles->pluck('name')->toArray(),


                    'created_at' => $value->created_at->format('d M Y'), // Format date
                    'action' => '
                        <a href="javascript:void(0)" data-id="'.$value->id.'" class="btn btn-sm btn-primary edit-btn"><i class="fas fa-edit"></i> Edit</a>
                        <a href="javascript:void(0)" data-id="'.$value->id.'" class="btn btn-sm btn-danger delete-btn"><i class="fas fa-trash-alt"></i> Delete</a>
                        <a href="javascript:void(0)" data-id="'.$value->id.'" class="btn btn-sm btn-warning pwd-btn"><i class="fas fa-key"></i> Change Password</a>




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

        $roles = Role::select(['id', 'name'])->get();

        return view('users.user.index', compact('roles'));
    }


    private function rules($request){
        $rules = [
            'name' => 'required|string|max:255',

        ];

        if($request->input('userId')){
            $rules['email'] = 'required|unique:users,email,'.$request->input('userId');
        }else{
            $rules['email'] = 'required|unique:users';
        }

        $message = [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',


        ];


        return ['rules' => $rules, 'message' => $message];
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate($this->rules($request)['rules'], $this->rules($request)['message']);



        if ($request->input('password')) {
            $data['password'] = Hash::make($request->input('password'));
        }

        $user = User::create($data);

        $roles = Role::whereIn('id', (array) $request->role)->pluck('name');
        if ($roles->isEmpty()) {
            return response()->json([
                'error' => 'One or more roles do not exist!'
            ], 400);
        }

        if (!$user) {
            return response()->json([
                'error' => 'User not found!'
            ], 404);
        }

        $user->syncRoles($roles);

        return response()->json([
            'success' => 'User created successfully',
            'user' => $user
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $user = User::findOrFail($id);
        $hasRoles = $user->roles->pluck('id');
        return response()->json([
            'data' => $user,
            'hasRoles' => $hasRoles

        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate($this->rules($request)['rules'], $this->rules($request)['message']);
        $user = User::findOrFail($id);
        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];
      $user->update($data);

        $roles = Role::whereIn('id', (array) $request->role)->pluck('name');
        if ($roles->isEmpty()) {
            return response()->json([
                'error' => 'One or more roles do not exist!'
            ], 400);
        }

        $user->syncRoles($roles);

       return response()->json([
            'success' => 'User updated Successfully!',
            'user' => $user
        ], 200);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'error' => 'User not found!'
            ], 404);
        }

        // Remove all roles from the user
        $user->syncRoles([]);

        // Delete the user
        $user->delete();

        return response()->json([
            'success' => 'User Deleted Successfully!'
        ]);
    }


    public function changePassword(Request $request, string $id)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = User::findOrFail($id);

        // Verify old password
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'error' => 'Old password is incorrect.'
            ], 400);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'success' => 'Password changed successfully!'
        ]);
    }






    }
