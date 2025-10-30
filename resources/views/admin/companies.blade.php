@extends('layouts.dashboard')

@section('title', 'Company Management - TailAdmin')

@section('content')
<div class="page-header">
    <h1>Company Management</h1>
</div>

<div class="card">
    <div class="card-title flex justify-between items-center">
        <span>All Companies</span>
        <button onclick="showAddCompanyModal()" class="btn btn-primary" style="width: auto;">
            + Add New Company
        </button>
    </div>

    <div id="companiesTable">
        <p style="text-align: center; padding: 20px;">Loading companies...</p>
    </div>
</div>

<!-- Add/Edit Company Modal -->
<div id="companyModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; padding: 30px; border-radius: 10px; max-width: 700px; width: 90%; max-height: 90vh; overflow-y: auto;">
        <h2 id="modalTitle" style="margin-bottom: 20px;">Add New Company</h2>

        <form id="companyForm" onsubmit="handleCompanySubmit(event)">
            <input type="hidden" id="companyId">

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="form-group">
                    <label class="form-label" for="companyKey">Key *</label>
                    <input type="text" id="companyKey" name="key" class="form-input" required placeholder="e.g., company1">
                </div>

                <div class="form-group">
                    <label class="form-label" for="companyLabel">Label *</label>
                    <input type="text" id="companyLabel" name="label" class="form-input" required placeholder="Company Name">
                </div>

                <div class="form-group">
                    <label class="form-label" for="companyDriver">Database Driver *</label>
                    <select id="companyDriver" name="driver" class="form-input" required>
                        <option value="mysql">MySQL</option>
                        <option value="pgsql">PostgreSQL</option>
                        <option value="sqlite">SQLite</option>
                        <option value="sqlsrv">SQL Server</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="companyHost">Host *</label>
                    <input type="text" id="companyHost" name="host" class="form-input" required value="127.0.0.1">
                </div>

                <div class="form-group">
                    <label class="form-label" for="companyPort">Port</label>
                    <input type="number" id="companyPort" name="port" class="form-input" placeholder="3306">
                </div>

                <div class="form-group">
                    <label class="form-label" for="companyDatabase">Database *</label>
                    <input type="text" id="companyDatabase" name="database" class="form-input" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="companyUsername">Username *</label>
                    <input type="text" id="companyUsername" name="username" class="form-input" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="companyPassword">Password</label>
                    <input type="password" id="companyPassword" name="password" class="form-input">
                    <p style="font-size: 12px; color: #64748B; margin-top: 4px;" id="passwordHint">Leave blank to keep current password</p>
                </div>
            </div>

            <div style="display: flex; gap: 10px; margin-top: 15px;">
                <label class="checkbox-wrapper">
                    <input type="checkbox" id="companyActive" name="is_active" value="1" class="checkbox-input" checked>
                    <span class="checkbox-label">Active</span>
                </label>

                <button type="button" onclick="testConnection()" class="btn" style="background: #219653; color: white; width: auto;">
                    Test Connection
                </button>
            </div>

            <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 24px;">
                <button type="button" onclick="closeCompanyModal()" class="btn" style="background: #E2E8F0; color: #1C2434;">
                    Cancel
                </button>
                <button type="submit" class="btn btn-primary" id="submitCompanyBtn">
                    Save Company
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="/assets/js/admin-companies.js"></script>
@endpush
@endsection
