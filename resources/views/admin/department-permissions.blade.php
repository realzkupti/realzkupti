@extends('tailadmin.layouts.app')

@section('title', 'Department Permissions - TailAdmin')

@section('content')
<div class="page-header">
    <h1>Department Permissions</h1>
    <p style="color: #64748B; margin-top: 8px;">Manage menu access permissions for each department</p>
</div>

<div class="card">
    <div class="card-title">
        <span>Select Department</span>
    </div>

    <select id="departmentSelect" onchange="loadDepartmentPermissions()" class="form-input" style="max-width: 300px;">
        <option value="">-- Select Department --</option>
    </select>
</div>

<div id="permissionsSection" style="display: none;">
    <div class="card">
        <div class="card-title flex justify-between items-center">
            <span>Menu Permissions for <strong id="departmentName"></strong></span>
            <button onclick="savePermissions()" class="btn btn-primary" id="saveBtn" style="width: auto;">
                Save Permissions
            </button>
        </div>

        <div style="overflow-x: auto;">
            <table id="permissionsTable" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 2px solid #E2E8F0;">
                        <th style="padding: 12px; text-align: left;">Menu</th>
                        <th style="padding: 12px; text-align: center; width: 80px;">View</th>
                        <th style="padding: 12px; text-align: center; width: 80px;">Create</th>
                        <th style="padding: 12px; text-align: center; width: 80px;">Update</th>
                        <th style="padding: 12px; text-align: center; width: 80px;">Delete</th>
                        <th style="padding: 12px; text-align: center; width: 80px;">Export</th>
                        <th style="padding: 12px; text-align: center; width: 80px;">Approve</th>
                        <th style="padding: 12px; text-align: center; width: 100px;">
                            <button onclick="toggleAll()" class="btn" style="font-size: 11px; padding: 4px 8px;">Toggle All</button>
                        </th>
                    </tr>
                </thead>
                <tbody id="permissionsBody">
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 20px;">Please select a department</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
{{-- TODO: Implement admin-permissions.js for permission management functionality --}}
{{-- <script src="/assets/js/admin-permissions.js?v={{ config('app.asset_version', '1.0.0') }}"></script>
<script>
    const permissionType = 'department';
</script> --}}
@endpush
@endsection
