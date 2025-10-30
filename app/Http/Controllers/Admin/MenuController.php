<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    /**
     * Display menu management page.
     */
    public function index()
    {
        return view('admin.menus');
    }

    /**
     * Get all menus with hierarchy (API).
     */
    public function list(Request $request)
    {
        $menus = Menu::with(['department', 'parent', 'children'])
            ->roots()
            ->get();

        return response()->json([
            'success' => true,
            'menus' => $menus
        ]);
    }

    /**
     * Get all menus flat (for select dropdowns).
     */
    public function listFlat()
    {
        $menus = Menu::with('department')
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'menus' => $menus
        ]);
    }

    /**
     * Store a newly created menu.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string|max:100|unique:sys_menus',
            'label' => 'required|string|max:150',
            'icon' => 'nullable|string|max:100',
            'route' => 'nullable|string|max:150',
            'url' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:sys_menus,id',
            'department_id' => 'nullable|exists:sys_departments,id',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
            'is_system' => 'boolean',
            'has_sticky_note' => 'boolean',
        ]);

        $validated['created_by'] = Auth::id();

        $menu = Menu::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Menu created successfully',
            'menu' => $menu->load(['department', 'parent'])
        ], 201);
    }

    /**
     * Update the specified menu.
     */
    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $validated = $request->validate([
            'key' => 'required|string|max:100|unique:sys_menus,key,' . $id,
            'label' => 'required|string|max:150',
            'icon' => 'nullable|string|max:100',
            'route' => 'nullable|string|max:150',
            'url' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:sys_menus,id',
            'department_id' => 'nullable|exists:sys_departments,id',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
            'is_system' => 'boolean',
            'has_sticky_note' => 'boolean',
        ]);

        $validated['updated_by'] = Auth::id();

        $menu->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Menu updated successfully',
            'menu' => $menu->load(['department', 'parent'])
        ]);
    }

    /**
     * Remove the specified menu.
     */
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        if ($menu->is_system) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete system menu'
            ], 403);
        }

        $menu->delete();

        return response()->json([
            'success' => true,
            'message' => 'Menu deleted successfully'
        ]);
    }

    /**
     * Toggle menu active status.
     */
    public function toggleStatus($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->is_active = !$menu->is_active;
        $menu->updated_by = Auth::id();
        $menu->save();

        return response()->json([
            'success' => true,
            'message' => 'Menu status updated',
            'menu' => $menu->load(['department', 'parent'])
        ]);
    }

    /**
     * Reorder menus.
     */
    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'menus' => 'required|array',
            'menus.*.id' => 'required|exists:sys_menus,id',
            'menus.*.sort_order' => 'required|integer',
        ]);

        foreach ($validated['menus'] as $menuData) {
            Menu::where('id', $menuData['id'])
                ->update([
                    'sort_order' => $menuData['sort_order'],
                    'updated_by' => Auth::id()
                ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Menus reordered successfully'
        ]);
    }
}
