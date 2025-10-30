<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    /**
     * Display department management page.
     */
    public function index()
    {
        return view('admin.departments');
    }

    /**
     * Get all departments (API).
     */
    public function list()
    {
        $departments = Department::withCount(['users', 'menus'])
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'departments' => $departments
        ]);
    }

    /**
     * Store a newly created department.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string|max:50|unique:sys_departments',
            'label' => 'required|string|max:150',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $validated['created_by'] = Auth::id();

        $department = Department::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Department created successfully',
            'department' => $department
        ], 201);
    }

    /**
     * Update the specified department.
     */
    public function update(Request $request, $id)
    {
        $department = Department::findOrFail($id);

        $validated = $request->validate([
            'key' => 'required|string|max:50|unique:sys_departments,key,' . $id,
            'label' => 'required|string|max:150',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $validated['updated_by'] = Auth::id();

        $department->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Department updated successfully',
            'department' => $department
        ]);
    }

    /**
     * Remove the specified department.
     */
    public function destroy($id)
    {
        $department = Department::findOrFail($id);

        if ($department->is_default) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete default department'
            ], 403);
        }

        $department->delete();

        return response()->json([
            'success' => true,
            'message' => 'Department deleted successfully'
        ]);
    }
}
