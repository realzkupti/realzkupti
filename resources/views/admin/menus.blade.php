@extends('layouts.dashboard')

@section('title', 'Menu Management - TailAdmin')

@section('content')
<div class="page-header">
    <h1>Menu Management</h1>
</div>

<div class="card">
    <div class="card-title flex justify-between items-center">
        <span>All Menus</span>
        <button onclick="showAddMenuModal()" class="btn btn-primary" style="width: auto;">
            + Add New Menu
        </button>
    </div>

    <div id="menusTable">
        <p style="text-align: center; padding: 20px;">Loading menus...</p>
    </div>
</div>

<!-- Add/Edit Menu Modal -->
<div id="menuModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; padding: 30px; border-radius: 10px; max-width: 600px; width: 90%; max-height: 90vh; overflow-y: auto;">
        <h2 id="modalTitle" style="margin-bottom: 20px;">Add New Menu</h2>

        <form id="menuForm" onsubmit="handleMenuSubmit(event)">
            <input type="hidden" id="menuId">

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <div class="form-group">
                    <label class="form-label" for="menuKey">Key *</label>
                    <input type="text" id="menuKey" name="key" class="form-input" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="menuLabel">Label *</label>
                    <input type="text" id="menuLabel" name="label" class="form-input" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="menuIcon">Icon</label>
                    <input type="text" id="menuIcon" name="icon" class="form-input" placeholder="home, users, settings">
                </div>

                <div class="form-group">
                    <label class="form-label" for="menuRoute">Route</label>
                    <input type="text" id="menuRoute" name="route" class="form-input" placeholder="dashboard">
                </div>

                <div class="form-group">
                    <label class="form-label" for="menuParent">Parent Menu</label>
                    <select id="menuParent" name="parent_id" class="form-input">
                        <option value="">-- Root Menu --</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="menuDepartment">Department</label>
                    <select id="menuDepartment" name="department_id" class="form-input">
                        <option value="">-- Select Department --</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="menuSort">Sort Order</label>
                    <input type="number" id="menuSort" name="sort_order" class="form-input" value="0">
                </div>
            </div>

            <div style="display: flex; gap: 15px; margin-top: 15px;">
                <label class="checkbox-wrapper">
                    <input type="checkbox" id="menuActive" name="is_active" value="1" class="checkbox-input" checked>
                    <span class="checkbox-label">Active</span>
                </label>

                <label class="checkbox-wrapper">
                    <input type="checkbox" id="menuSystem" name="is_system" value="1" class="checkbox-input">
                    <span class="checkbox-label">System Menu (Cannot Delete)</span>
                </label>

                <label class="checkbox-wrapper">
                    <input type="checkbox" id="menuSticky" name="has_sticky_note" value="1" class="checkbox-input">
                    <span class="checkbox-label">Enable Sticky Notes</span>
                </label>
            </div>

            <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 24px;">
                <button type="button" onclick="closeMenuModal()" class="btn" style="background: #E2E8F0; color: #1C2434;">
                    Cancel
                </button>
                <button type="submit" class="btn btn-primary" id="submitMenuBtn">
                    Save Menu
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="/assets/js/admin-menus.js"></script>
@endpush
@endsection
