<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
{
    /**
     * Display branch management page.
     */
    public function index()
    {
        return view('admin.branches');
    }

    /**
     * Get all branches (API).
     */
    public function list(Request $request)
    {
        $query = Branch::with('company');

        // Filter by company if provided
        if ($request->has('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        $branches = $query->orderBy('sort_order')->get();

        return response()->json([
            'success' => true,
            'branches' => $branches
        ]);
    }

    /**
     * Store a newly created branch.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:sys_companies,id',
            'code' => 'required|string|max:50|unique:sys_branches',
            'name' => 'required|string|max:150',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'is_active' => 'boolean',
            'is_head_office' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $validated['created_by'] = Auth::id();

        $branch = Branch::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Branch created successfully',
            'branch' => $branch->load('company')
        ], 201);
    }

    /**
     * Update the specified branch.
     */
    public function update(Request $request, $id)
    {
        $branch = Branch::findOrFail($id);

        $validated = $request->validate([
            'company_id' => 'required|exists:sys_companies,id',
            'code' => 'required|string|max:50|unique:sys_branches,code,' . $id,
            'name' => 'required|string|max:150',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'is_active' => 'boolean',
            'is_head_office' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $validated['updated_by'] = Auth::id();

        $branch->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Branch updated successfully',
            'branch' => $branch->load('company')
        ]);
    }

    /**
     * Remove the specified branch.
     */
    public function destroy($id)
    {
        $branch = Branch::findOrFail($id);
        $branch->delete();

        return response()->json([
            'success' => true,
            'message' => 'Branch deleted successfully'
        ]);
    }
}
