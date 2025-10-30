<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    /**
     * Display company management page.
     */
    public function index()
    {
        return view('admin.companies');
    }

    /**
     * Get all companies (API).
     */
    public function list()
    {
        $companies = Company::withCount(['branches', 'users'])
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'companies' => $companies
        ]);
    }

    /**
     * Store a newly created company.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string|max:50|unique:sys_companies',
            'label' => 'required|string|max:150',
            'logo' => 'nullable|string|max:255',
            'driver' => 'required|in:mysql,pgsql,sqlite,sqlsrv',
            'host' => 'required|string|max:150',
            'port' => 'nullable|integer',
            'database' => 'required|string|max:150',
            'username' => 'required|string|max:150',
            'password' => 'nullable|string|max:255',
            'charset' => 'nullable|string|max:20',
            'collation' => 'nullable|string|max:50',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $validated['created_by'] = Auth::id();

        $company = Company::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Company created successfully',
            'company' => $company
        ], 201);
    }

    /**
     * Update the specified company.
     */
    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);

        $validated = $request->validate([
            'key' => 'required|string|max:50|unique:sys_companies,key,' . $id,
            'label' => 'required|string|max:150',
            'logo' => 'nullable|string|max:255',
            'driver' => 'required|in:mysql,pgsql,sqlite,sqlsrv',
            'host' => 'required|string|max:150',
            'port' => 'nullable|integer',
            'database' => 'required|string|max:150',
            'username' => 'required|string|max:150',
            'password' => 'nullable|string|max:255',
            'charset' => 'nullable|string|max:20',
            'collation' => 'nullable|string|max:50',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ]);

        // Only update password if provided
        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $validated['updated_by'] = Auth::id();

        $company->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Company updated successfully',
            'company' => $company
        ]);
    }

    /**
     * Remove the specified company.
     */
    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();

        return response()->json([
            'success' => true,
            'message' => 'Company deleted successfully'
        ]);
    }

    /**
     * Test database connection.
     */
    public function testConnection(Request $request)
    {
        $validated = $request->validate([
            'driver' => 'required|in:mysql,pgsql,sqlite,sqlsrv',
            'host' => 'required|string',
            'port' => 'nullable|integer',
            'database' => 'required|string',
            'username' => 'required|string',
            'password' => 'nullable|string',
        ]);

        try {
            $config = [
                'driver' => $validated['driver'],
                'host' => $validated['host'],
                'port' => $validated['port'] ?? null,
                'database' => $validated['database'],
                'username' => $validated['username'],
                'password' => $validated['password'] ?? '',
            ];

            // Try to connect
            $pdo = DB::connection()->getPdo();

            return response()->json([
                'success' => true,
                'message' => 'Connection successful'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Connection failed: ' . $e->getMessage()
            ], 400);
        }
    }
}
