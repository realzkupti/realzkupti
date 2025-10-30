@extends('layouts.dashboard')

@section('title', 'Branch Management - TailAdmin')

@section('content')
<div class="page-header">
    <h1>Branch Management</h1>
</div>

<div class="card">
    <div class="card-title flex justify-between items-center">
        <span>All Branches</span>
        <div style="display: flex; gap: 10px;">
            <select id="filterCompany" onchange="loadBranches()" class="form-input" style="width: 200px;">
                <option value="">All Companies</option>
            </select>
            <button onclick="showAddBranchModal()" class="btn btn-primary" style="width: auto;">
                + Add New Branch
            </button>
        </div>
    </div>

    <div id="branchesTable">
        <p style="text-align: center; padding: 20px;">Loading branches...</p>
    </div>
</div>

<!-- Add/Edit Branch Modal -->
<div id="branchModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; padding: 30px; border-radius: 10px; max-width: 600px; width: 90%; max-height: 90vh; overflow-y: auto;">
        <h2 id="modalTitle" style="margin-bottom: 20px;">Add New Branch</h2>

        <form id="branchForm" onsubmit="handleBranchSubmit(event)">
            <input type="hidden" id="branchId">

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label class="form-label" for="branchCompany">Company *</label>
                    <select id="branchCompany" name="company_id" class="form-input" required>
                        <option value="">-- Select Company --</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="branchCode">Code *</label>
                    <input type="text" id="branchCode" name="code" class="form-input" required placeholder="e.g., BKK01">
                </div>

                <div class="form-group">
                    <label class="form-label" for="branchName">Name *</label>
                    <input type="text" id="branchName" name="name" class="form-input" required placeholder="Branch Name">
                </div>

                <div class="form-group" style="grid-column: 1 / -1;">
                    <label class="form-label" for="branchAddress">Address</label>
                    <textarea id="branchAddress" name="address" class="form-input" rows="2"></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label" for="branchPhone">Phone</label>
                    <input type="text" id="branchPhone" name="phone" class="form-input" placeholder="02-123-4567">
                </div>

                <div class="form-group">
                    <label class="form-label" for="branchEmail">Email</label>
                    <input type="email" id="branchEmail" name="email" class="form-input" placeholder="branch@company.com">
                </div>

                <div class="form-group">
                    <label class="form-label" for="branchSort">Sort Order</label>
                    <input type="number" id="branchSort" name="sort_order" class="form-input" value="0">
                </div>
            </div>

            <div style="display: flex; gap: 15px; margin-top: 15px;">
                <label class="checkbox-wrapper">
                    <input type="checkbox" id="branchActive" name="is_active" value="1" class="checkbox-input" checked>
                    <span class="checkbox-label">Active</span>
                </label>

                <label class="checkbox-wrapper">
                    <input type="checkbox" id="branchHeadOffice" name="is_head_office" value="1" class="checkbox-input">
                    <span class="checkbox-label">Head Office</span>
                </label>
            </div>

            <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 24px;">
                <button type="button" onclick="closeBranchModal()" class="btn" style="background: #E2E8F0; color: #1C2434;">
                    Cancel
                </button>
                <button type="submit" class="btn btn-primary" id="submitBranchBtn">
                    Save Branch
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
{{-- TODO: Implement admin-branches.js for branch management functionality --}}
{{-- <script src="/assets/js/admin-branches.js?v={{ config('app.asset_version', '1.0.0') }}"></script> --}}
@endpush
@endsection
