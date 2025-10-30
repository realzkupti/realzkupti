/**
 * TailAdmin - Menu Management
 */

let menus = [];
let departments = [];
let isEditMode = false;

// Load data on page load
document.addEventListener('DOMContentLoaded', function() {
    loadDepartments();
    loadMenus();
});

// Load departments for dropdown
async function loadDepartments() {
    try {
        const response = await fetch('/admin/departments/list', {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        const result = await response.json();

        if (result.success) {
            departments = result.departments;
            populateDepartmentDropdown();
        }
    } catch (error) {
        console.error('Error loading departments:', error);
    }
}

// Populate department dropdown
function populateDepartmentDropdown() {
    const select = document.getElementById('menuDepartment');
    if (!select) return;

    departments.forEach(dept => {
        const option = document.createElement('option');
        option.value = dept.id;
        option.textContent = dept.label;
        select.appendChild(option);
    });
}

// Load all menus
async function loadMenus() {
    try {
        const response = await fetch('/admin/menus/list', {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        const result = await response.json();

        if (result.success) {
            menus = result.menus;
            renderMenusTable();
            populateParentMenuDropdown();
        }
    } catch (error) {
        console.error('Error loading menus:', error);
        document.getElementById('menusTable').innerHTML = '<p style="color: red; text-align: center; padding: 20px;">Error loading menus</p>';
    }
}

// Populate parent menu dropdown
function populateParentMenuDropdown() {
    const select = document.getElementById('menuParent');
    if (!select) return;

    // Clear existing options except first one
    select.innerHTML = '<option value="">-- None (Root Menu) --</option>';

    menus.forEach(menu => {
        if (!menu.parent_id) { // Only root menus can be parents
            const option = document.createElement('option');
            option.value = menu.id;
            option.textContent = menu.label;
            select.appendChild(option);
        }
    });
}

// Render menus table
function renderMenusTable() {
    const container = document.getElementById('menusTable');

    if (menus.length === 0) {
        container.innerHTML = '<p style="text-align: center; padding: 20px;">No menus found</p>';
        return;
    }

    let html = `
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 2px solid #E2E8F0;">
                    <th style="padding: 12px; text-align: left;">Label</th>
                    <th style="padding: 12px; text-align: left;">Key</th>
                    <th style="padding: 12px; text-align: left;">Route</th>
                    <th style="padding: 12px; text-align: left;">Parent</th>
                    <th style="padding: 12px; text-align: center;">Sort</th>
                    <th style="padding: 12px; text-align: center;">Status</th>
                    <th style="padding: 12px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
    `;

    // Group by parent
    const rootMenus = menus.filter(m => !m.parent_id);
    const childMenus = menus.filter(m => m.parent_id);

    rootMenus.forEach(menu => {
        html += renderMenuRow(menu, false);

        // Render children
        const children = childMenus.filter(c => c.parent_id === menu.id);
        children.forEach(child => {
            html += renderMenuRow(child, true);
        });
    });

    html += `
            </tbody>
        </table>
    `;

    container.innerHTML = html;
}

// Render single menu row
function renderMenuRow(menu, isChild) {
    const statusBadge = menu.is_active
        ? '<span style="background: #219653; color: white; padding: 4px 12px; border-radius: 12px; font-size: 12px;">Active</span>'
        : '<span style="background: #D34053; color: white; padding: 4px 12px; border-radius: 12px; font-size: 12px;">Inactive</span>';

    const parentLabel = menu.parent_id
        ? (menus.find(m => m.id === menu.parent_id)?.label || '-')
        : '-';

    const prefix = isChild ? '&nbsp;&nbsp;&nbsp;&nbsp;↳ ' : '';

    return `
        <tr style="border-bottom: 1px solid #E2E8F0;">
            <td style="padding: 12px;">${prefix}${menu.label}</td>
            <td style="padding: 12px; font-family: monospace; font-size: 12px;">${menu.key}</td>
            <td style="padding: 12px; font-family: monospace; font-size: 12px;">${menu.route || '-'}</td>
            <td style="padding: 12px;">${parentLabel}</td>
            <td style="padding: 12px; text-align: center;">${menu.sort_order}</td>
            <td style="padding: 12px; text-align: center;">${statusBadge}</td>
            <td style="padding: 12px; text-align: center;">
                <button onclick="editMenu(${menu.id})" style="background: #3C50E0; color: white; padding: 6px 12px; border: none; border-radius: 4px; margin-right: 4px; cursor: pointer;">Edit</button>
                ${!menu.is_system ? `<button onclick="deleteMenu(${menu.id})" style="background: #D34053; color: white; padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer;">Delete</button>` : ''}
            </td>
        </tr>
    `;
}

// Show add menu modal
function showAddMenuModal() {
    isEditMode = false;
    document.getElementById('modalTitle').textContent = 'Add New Menu';
    document.getElementById('menuForm').reset();
    document.getElementById('menuId').value = '';
    document.getElementById('menuActive').checked = true;
    document.getElementById('menuStickyNote').checked = false;
    document.getElementById('menuModal').style.display = 'flex';
    populateParentMenuDropdown();
}

// Edit menu
function editMenu(menuId) {
    const menu = menus.find(m => m.id === menuId);
    if (!menu) return;

    isEditMode = true;
    document.getElementById('modalTitle').textContent = 'Edit Menu';
    document.getElementById('menuId').value = menu.id;
    document.getElementById('menuKey').value = menu.key;
    document.getElementById('menuLabel').value = menu.label;
    document.getElementById('menuIcon').value = menu.icon || '';
    document.getElementById('menuRoute').value = menu.route || '';
    document.getElementById('menuUrl').value = menu.url || '';
    document.getElementById('menuParent').value = menu.parent_id || '';
    document.getElementById('menuDepartment').value = menu.department_id || '';
    document.getElementById('menuSortOrder').value = menu.sort_order;
    document.getElementById('menuActive').checked = menu.is_active;
    document.getElementById('menuStickyNote').checked = menu.has_sticky_note;
    document.getElementById('menuModal').style.display = 'flex';
    populateParentMenuDropdown();
}

// Close modal
function closeMenuModal() {
    document.getElementById('menuModal').style.display = 'none';
}

// Handle menu submit
async function handleMenuSubmit(event) {
    event.preventDefault();

    const menuId = document.getElementById('menuId').value;
    const formData = {
        key: document.getElementById('menuKey').value,
        label: document.getElementById('menuLabel').value,
        icon: document.getElementById('menuIcon').value || null,
        route: document.getElementById('menuRoute').value || null,
        url: document.getElementById('menuUrl').value || null,
        parent_id: document.getElementById('menuParent').value || null,
        department_id: document.getElementById('menuDepartment').value || null,
        sort_order: parseInt(document.getElementById('menuSortOrder').value) || 0,
        is_active: document.getElementById('menuActive').checked,
        has_sticky_note: document.getElementById('menuStickyNote').checked,
    };

    const button = document.getElementById('submitMenuBtn');
    button.disabled = true;
    button.textContent = 'Saving...';

    try {
        const url = isEditMode ? `/admin/menus/${menuId}` : '/admin/menus';
        const method = isEditMode ? 'PUT' : 'POST';

        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(formData)
        });

        const result = await response.json();

        if (result.success) {
            auth.showNotification(result.message, 'success');
            closeMenuModal();
            loadMenus();
        } else {
            auth.showNotification(result.message || 'Failed to save menu', 'error');
            if (result.errors) {
                auth.showErrors(result.errors, 'menuForm');
            }
        }
    } catch (error) {
        console.error('Error saving menu:', error);
        auth.showNotification('An error occurred', 'error');
    } finally {
        button.disabled = false;
        button.textContent = 'Save Menu';
    }
}

// Delete menu
async function deleteMenu(menuId) {
    if (!confirm('Are you sure you want to delete this menu? This will also delete all child menus.')) {
        return;
    }

    try {
        const response = await fetch(`/admin/menus/${menuId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        const result = await response.json();

        if (result.success) {
            auth.showNotification(result.message, 'success');
            loadMenus();
        } else {
            auth.showNotification(result.message || 'Failed to delete menu', 'error');
        }
    } catch (error) {
        console.error('Error deleting menu:', error);
        auth.showNotification('An error occurred', 'error');
    }
}
