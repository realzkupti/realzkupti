/**
 * TailAdmin - User Management
 */

let users = [];
let departments = [];
let isEditMode = false;

// Load data on page load
document.addEventListener('DOMContentLoaded', function() {
    loadDepartments();
    loadUsers();
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
    const select = document.getElementById('userDepartment');
    const currentOptions = select.innerHTML;

    departments.forEach(dept => {
        const option = document.createElement('option');
        option.value = dept.id;
        option.textContent = dept.label;
        select.appendChild(option);
    });
}

// Load all users
async function loadUsers() {
    try {
        const response = await fetch('/admin/users/list', {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        const result = await response.json();

        if (result.success) {
            users = result.users;
            renderUsersTable();
        }
    } catch (error) {
        console.error('Error loading users:', error);
        document.getElementById('usersTable').innerHTML = '<p style="color: red; text-align: center; padding: 20px;">Error loading users</p>';
    }
}

// Render users table
function renderUsersTable() {
    const container = document.getElementById('usersTable');

    if (users.length === 0) {
        container.innerHTML = '<p style="text-align: center; padding: 20px;">No users found</p>';
        return;
    }

    let html = `
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 2px solid #E2E8F0;">
                    <th style="padding: 12px; text-align: left;">Name</th>
                    <th style="padding: 12px; text-align: left;">Email</th>
                    <th style="padding: 12px; text-align: left;">Department</th>
                    <th style="padding: 12px; text-align: center;">Status</th>
                    <th style="padding: 12px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
    `;

    users.forEach(user => {
        const statusBadge = user.is_active
            ? '<span style="background: #219653; color: white; padding: 4px 12px; border-radius: 12px; font-size: 12px;">Active</span>'
            : '<span style="background: #D34053; color: white; padding: 4px 12px; border-radius: 12px; font-size: 12px;">Inactive</span>';

        html += `
            <tr style="border-bottom: 1px solid #E2E8F0;">
                <td style="padding: 12px;">${user.name}</td>
                <td style="padding: 12px;">${user.email}</td>
                <td style="padding: 12px;">${user.department ? user.department.label : '-'}</td>
                <td style="padding: 12px; text-align: center;">${statusBadge}</td>
                <td style="padding: 12px; text-align: center;">
                    <button onclick="editUser(${user.id})" style="background: #3C50E0; color: white; padding: 6px 12px; border: none; border-radius: 4px; margin-right: 4px; cursor: pointer;">Edit</button>
                    ${user.email !== 'admin@local' ? `<button onclick="deleteUser(${user.id})" style="background: #D34053; color: white; padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer;">Delete</button>` : ''}
                </td>
            </tr>
        `;
    });

    html += `
            </tbody>
        </table>
    `;

    container.innerHTML = html;
}

// Show add user modal
function showAddUserModal() {
    isEditMode = false;
    document.getElementById('modalTitle').textContent = 'Add New User';
    document.getElementById('userForm').reset();
    document.getElementById('userId').value = '';
    document.getElementById('userActive').checked = true;
    document.getElementById('passwordHint').style.display = 'none';
    document.getElementById('userPassword').required = true;
    document.getElementById('userModal').style.display = 'flex';
}

// Edit user
function editUser(userId) {
    const user = users.find(u => u.id === userId);
    if (!user) return;

    isEditMode = true;
    document.getElementById('modalTitle').textContent = 'Edit User';
    document.getElementById('userId').value = user.id;
    document.getElementById('userName').value = user.name;
    document.getElementById('userEmail').value = user.email;
    document.getElementById('userDepartment').value = user.department_id || '';
    document.getElementById('userActive').checked = user.is_active;
    document.getElementById('userPassword').value = '';
    document.getElementById('userPassword').required = false;
    document.getElementById('passwordHint').style.display = 'block';
    document.getElementById('userModal').style.display = 'flex';
}

// Close modal
function closeUserModal() {
    document.getElementById('userModal').style.display = 'none';
}

// Handle user submit
async function handleUserSubmit(event) {
    event.preventDefault();

    const userId = document.getElementById('userId').value;
    const formData = {
        name: document.getElementById('userName').value,
        email: document.getElementById('userEmail').value,
        department_id: document.getElementById('userDepartment').value || null,
        is_active: document.getElementById('userActive').checked,
    };

    const password = document.getElementById('userPassword').value;
    if (password) {
        formData.password = password;
    }

    const button = document.getElementById('submitUserBtn');
    button.disabled = true;
    button.textContent = 'Saving...';

    try {
        const url = isEditMode ? `/admin/users/${userId}` : '/admin/users';
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
            closeUserModal();
            loadUsers();
        } else {
            auth.showNotification(result.message || 'Failed to save user', 'error');
            if (result.errors) {
                auth.showErrors(result.errors, 'userForm');
            }
        }
    } catch (error) {
        console.error('Error saving user:', error);
        auth.showNotification('An error occurred', 'error');
    } finally {
        button.disabled = false;
        button.textContent = 'Save User';
    }
}

// Delete user
async function deleteUser(userId) {
    if (!confirm('Are you sure you want to delete this user?')) {
        return;
    }

    try {
        const response = await fetch(`/admin/users/${userId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        const result = await response.json();

        if (result.success) {
            auth.showNotification(result.message, 'success');
            loadUsers();
        } else {
            auth.showNotification(result.message || 'Failed to delete user', 'error');
        }
    } catch (error) {
        console.error('Error deleting user:', error);
        auth.showNotification('An error occurred', 'error');
    }
}
