@extends('layouts.dashboard')

@section('title', 'User Management - TailAdmin')

@section('content')
<div class="page-header">
    <h1>User Management</h1>
</div>

<div class="card">
    <div class="card-title flex justify-between items-center">
        <span>All Users</span>
        <button onclick="showAddUserModal()" class="btn btn-primary" style="width: auto;">
            + Add New User
        </button>
    </div>

    <div id="usersTable">
        <p style="text-align: center; padding: 20px;">Loading users...</p>
    </div>
</div>

<!-- Add/Edit User Modal (simplified structure) -->
<div id="userModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; padding: 30px; border-radius: 10px; max-width: 500px; width: 90%;">
        <h2 id="modalTitle" style="margin-bottom: 20px;">Add New User</h2>

        <form id="userForm" onsubmit="handleUserSubmit(event)">
            <input type="hidden" id="userId">

            <div class="form-group">
                <label class="form-label" for="userName">Name</label>
                <input type="text" id="userName" name="name" class="form-input" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="userEmail">Email</label>
                <input type="email" id="userEmail" name="email" class="form-input" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="userPassword">Password</label>
                <input type="password" id="userPassword" name="password" class="form-input">
                <p style="font-size: 12px; color: #64748B; margin-top: 4px;" id="passwordHint">Leave blank to keep current password</p>
            </div>

            <div class="form-group">
                <label class="form-label" for="userDepartment">Department</label>
                <select id="userDepartment" name="department_id" class="form-input">
                    <option value="">-- Select Department --</option>
                </select>
            </div>

            <div class="form-group">
                <label class="checkbox-wrapper">
                    <input type="checkbox" id="userActive" name="is_active" value="1" class="checkbox-input">
                    <span class="checkbox-label">Active</span>
                </label>
            </div>

            <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 24px;">
                <button type="button" onclick="closeUserModal()" class="btn" style="background: #E2E8F0; color: #1C2434;">
                    Cancel
                </button>
                <button type="submit" class="btn btn-primary" id="submitUserBtn">
                    Save User
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="/assets/js/admin-users.js"></script>
@endpush
@endsection
