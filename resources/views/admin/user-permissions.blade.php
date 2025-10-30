@extends('layouts.dashboard')

@section('title', 'User Permissions - TailAdmin')

@section('content')
<div class="page-header">
    <h1>User Permissions</h1>
    <p style="color: #64748B; margin-top: 8px;">Manage user-specific permission overrides (higher priority than department permissions)</p>
</div>

<div class="card">
    <div class="card-title">
        <span>Select User</span>
    </div>

    <select id="userSelect" onchange="loadUserPermissions()" class="form-input" style="max-width: 300px;">
        <option value="">-- Select User --</option>
    </select>
</div>

<div id="permissionsSection" style="display: none;">
    <div class="card">
        <div class="card-title flex justify-between items-center">
            <div>
                <span>Menu Permissions for <strong id="userName"></strong></span>
                <p style="font-size: 12px; color: #64748B; margin-top: 4px;">
                    User: <span id="userEmail"></span> | Department: <span id="userDepartment"></span>
                </p>
            </div>
            <button onclick="savePermissions()" class="btn btn-primary" id="saveBtn" style="width: auto;">
                Save Permissions
            </button>
        </div>

        <div style="background: #FEF3C7; padding: 12px; border-radius: 6px; margin-bottom: 15px; font-size: 13px;">
            <strong>Note:</strong> Leave all unchecked to use department permissions. Check specific permissions to override department settings.
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
                            <button onclick="clearAll()" class="btn" style="font-size: 11px; padding: 4px 8px; background: #D34053; color: white;">Clear All</button>
                        </th>
                    </tr>
                </thead>
                <tbody id="permissionsBody">
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 20px;">Please select a user</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script src="/assets/js/admin-permissions.js"></script>
<script>
    const permissionType = 'user';
</script>
@endpush
@endsection
