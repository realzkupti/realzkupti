<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
use App\Models\Menu;
use App\Models\DepartmentMenuPermission;
use App\Models\UserMenuPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    /**
     * Display department permissions page.
     */
    public function departmentIndex()
    {
        return view('admin.department-permissions');
    }

    /**
     * Display user permissions page.
     */
    public function userIndex()
    {
        return view('admin.user-permissions');
    }

    /**
     * Get department permissions.
     */
    public function getDepartmentPermissions($departmentId)
    {
        $department = Department::findOrFail($departmentId);
        $menus = Menu::with(['department'])->orderBy('sort_order')->get();

        $permissions = DepartmentMenuPermission::where('department_id', $departmentId)
            ->get()
            ->keyBy('menu_id');

        $menusWithPermissions = $menus->map(function ($menu) use ($permissions) {
            $permission = $permissions->get($menu->id);

            return [
                'menu' => $menu,
                'permission' => $permission ? [
                    'can_view' => $permission->can_view,
                    'can_create' => $permission->can_create,
                    'can_update' => $permission->can_update,
                    'can_delete' => $permission->can_delete,
                    'can_export' => $permission->can_export,
                    'can_approve' => $permission->can_approve,
                ] : [
                    'can_view' => false,
                    'can_create' => false,
                    'can_update' => false,
                    'can_delete' => false,
                    'can_export' => false,
                    'can_approve' => false,
                ]
            ];
        });

        return response()->json([
            'success' => true,
            'department' => $department,
            'menus' => $menusWithPermissions
        ]);
    }

    /**
     * Save department permissions.
     */
    public function saveDepartmentPermissions(Request $request, $departmentId)
    {
        $department = Department::findOrFail($departmentId);

        $validated = $request->validate([
            'permissions' => 'required|array',
            'permissions.*.menu_id' => 'required|exists:sys_menus,id',
            'permissions.*.can_view' => 'boolean',
            'permissions.*.can_create' => 'boolean',
            'permissions.*.can_update' => 'boolean',
            'permissions.*.can_delete' => 'boolean',
            'permissions.*.can_export' => 'boolean',
            'permissions.*.can_approve' => 'boolean',
        ]);

        // Delete existing permissions
        DepartmentMenuPermission::where('department_id', $departmentId)->delete();

        // Create new permissions
        foreach ($validated['permissions'] as $permission) {
            DepartmentMenuPermission::create([
                'department_id' => $departmentId,
                'menu_id' => $permission['menu_id'],
                'can_view' => $permission['can_view'] ?? false,
                'can_create' => $permission['can_create'] ?? false,
                'can_update' => $permission['can_update'] ?? false,
                'can_delete' => $permission['can_delete'] ?? false,
                'can_export' => $permission['can_export'] ?? false,
                'can_approve' => $permission['can_approve'] ?? false,
                'created_by' => Auth::id(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Department permissions saved successfully'
        ]);
    }

    /**
     * Get user permissions.
     */
    public function getUserPermissions($userId)
    {
        $user = User::with('department')->findOrFail($userId);
        $menus = Menu::with(['department'])->orderBy('sort_order')->get();

        $permissions = UserMenuPermission::where('user_id', $userId)
            ->get()
            ->keyBy('menu_id');

        $menusWithPermissions = $menus->map(function ($menu) use ($permissions) {
            $permission = $permissions->get($menu->id);

            return [
                'menu' => $menu,
                'permission' => $permission ? [
                    'can_view' => $permission->can_view,
                    'can_create' => $permission->can_create,
                    'can_update' => $permission->can_update,
                    'can_delete' => $permission->can_delete,
                    'can_export' => $permission->can_export,
                    'can_approve' => $permission->can_approve,
                ] : null
            ];
        });

        return response()->json([
            'success' => true,
            'user' => $user,
            'menus' => $menusWithPermissions
        ]);
    }

    /**
     * Save user permissions.
     */
    public function saveUserPermissions(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        $validated = $request->validate([
            'permissions' => 'required|array',
            'permissions.*.menu_id' => 'required|exists:sys_menus,id',
            'permissions.*.can_view' => 'nullable|boolean',
            'permissions.*.can_create' => 'nullable|boolean',
            'permissions.*.can_update' => 'nullable|boolean',
            'permissions.*.can_delete' => 'nullable|boolean',
            'permissions.*.can_export' => 'nullable|boolean',
            'permissions.*.can_approve' => 'nullable|boolean',
        ]);

        // Delete existing permissions
        UserMenuPermission::where('user_id', $userId)->delete();

        // Create new permissions (only if at least one permission is set)
        foreach ($validated['permissions'] as $permission) {
            $hasAnyPermission = ($permission['can_view'] ?? false) ||
                               ($permission['can_create'] ?? false) ||
                               ($permission['can_update'] ?? false) ||
                               ($permission['can_delete'] ?? false) ||
                               ($permission['can_export'] ?? false) ||
                               ($permission['can_approve'] ?? false);

            if ($hasAnyPermission) {
                UserMenuPermission::create([
                    'user_id' => $userId,
                    'menu_id' => $permission['menu_id'],
                    'can_view' => $permission['can_view'] ?? false,
                    'can_create' => $permission['can_create'] ?? false,
                    'can_update' => $permission['can_update'] ?? false,
                    'can_delete' => $permission['can_delete'] ?? false,
                    'can_export' => $permission['can_export'] ?? false,
                    'can_approve' => $permission['can_approve'] ?? false,
                    'created_by' => Auth::id(),
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'User permissions saved successfully'
        ]);
    }
}
