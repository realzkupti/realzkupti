<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index()
    {
        return view('admin.users');
    }

    /**
     * Get all users (API).
     */
    public function list(Request $request)
    {
        $users = User::with(['department'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'users' => $users
        ]);
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:sys_users',
            'password' => 'required|string|min:6',
            'department_id' => 'nullable|exists:sys_departments,id',
            'is_active' => 'boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['created_by'] = Auth::id();

        $user = User::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'user' => $user->load('department')
        ], 201);
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:sys_users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'department_id' => 'nullable|exists:sys_departments,id',
            'is_active' => 'boolean',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $validated['updated_by'] = Auth::id();

        $user->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
            'user' => $user->load('department')
        ]);
    }

    /**
     * Remove the specified user.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting admin@local
        if ($user->email === 'admin@local') {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete admin user'
            ], 403);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully'
        ]);
    }

    /**
     * Toggle user active status.
     */
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->updated_by = Auth::id();
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User status updated',
            'user' => $user->load('department')
        ]);
    }
}
