@extends('layouts.dashboard')

@section('title', 'Department Management - TailAdmin')

@section('content')
<div class="page-header">
    <h1>Department Management</h1>
</div>

<div class="card">
    <div class="card-title flex justify-between items-center">
        <span>All Departments</span>
        <button onclick="showAddDepartmentModal()" class="btn btn-primary" style="width: auto;">
            + Add New Department
        </button>
    </div>

    <div id="departmentsTable">
        <p style="text-align: center; padding: 20px;">Loading departments...</p>
    </div>
</div>

<!-- Add/Edit Department Modal -->
<div id="departmentModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; padding: 30px; border-radius: 10px; max-width: 500px; width: 90%;">
        <h2 id="modalTitle" style="margin-bottom: 20px;">Add New Department</h2>

        <form id="departmentForm" onsubmit="handleDepartmentSubmit(event)">
            <input type="hidden" id="departmentId">

            <div class="form-group">
                <label class="form-label" for="departmentKey">Key *</label>
                <input type="text" id="departmentKey" name="key" class="form-input" required placeholder="e.g., finance">
            </div>

            <div class="form-group">
                <label class="form-label" for="departmentLabel">Label *</label>
                <input type="text" id="departmentLabel" name="label" class="form-input" required placeholder="e.g., การเงิน">
            </div>

            <div class="form-group">
                <label class="form-label" for="departmentSort">Sort Order</label>
                <input type="number" id="departmentSort" name="sort_order" class="form-input" value="0">
            </div>

            <div class="form-group">
                <label class="checkbox-wrapper">
                    <input type="checkbox" id="departmentActive" name="is_active" value="1" class="checkbox-input" checked>
                    <span class="checkbox-label">Active</span>
                </label>
            </div>

            <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 24px;">
                <button type="button" onclick="closeDepartmentModal()" class="btn" style="background: #E2E8F0; color: #1C2434;">
                    Cancel
                </button>
                <button type="submit" class="btn btn-primary" id="submitDepartmentBtn">
                    Save Department
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
{{-- TODO: Implement admin-departments.js for department management functionality --}}
{{-- <script src="/assets/js/admin-departments.js?v={{ config('app.asset_version', '1.0.0') }}"></script> --}}
@endpush
@endsection
