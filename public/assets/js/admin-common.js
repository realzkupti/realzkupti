/**
 * TailAdmin - Common Admin Functions
 * Shared utilities for all admin pages
 */

// CSRF Token
function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]').content;
}

// Fetch wrapper with error handling
async function adminFetch(url, options = {}) {
    const defaultOptions = {
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': getCsrfToken()
        }
    };

    const mergedOptions = {
        ...defaultOptions,
        ...options,
        headers: {
            ...defaultOptions.headers,
            ...(options.headers || {})
        }
    };

    try {
        const response = await fetch(url, mergedOptions);
        const result = await response.json();

        if (!response.ok) {
            throw result;
        }

        return result;
    } catch (error) {
        console.error('Admin fetch error:', error);
        throw error;
    }
}

// Show notification (using auth.js function)
function showNotification(message, type = 'success') {
    if (typeof auth !== 'undefined' && auth.showNotification) {
        auth.showNotification(message, type);
    } else {
        alert(message);
    }
}

// Show/hide loading on button
function setButtonLoading(buttonId, loading = true) {
    const button = document.getElementById(buttonId);
    if (!button) return;

    if (loading) {
        button.disabled = true;
        button.dataset.originalText = button.textContent;
        button.textContent = 'Loading...';
    } else {
        button.disabled = false;
        button.textContent = button.dataset.originalText || 'Submit';
    }
}

// Get form data as object
function getFormData(formId) {
    const form = document.getElementById(formId);
    const formData = new FormData(form);
    const data = {};

    for (let [key, value] of formData.entries()) {
        // Handle checkboxes
        if (form.elements[key].type === 'checkbox') {
            data[key] = form.elements[key].checked;
        } else {
            data[key] = value || null;
        }
    }

    return data;
}

// Clear form
function clearForm(formId) {
    const form = document.getElementById(formId);
    if (form) {
        form.reset();
    }
}

// Populate select dropdown
function populateSelect(selectId, items, valueKey = 'id', labelKey = 'label', placeholder = '-- Select --') {
    const select = document.getElementById(selectId);
    if (!select) return;

    select.innerHTML = `<option value="">${placeholder}</option>`;

    items.forEach(item => {
        const option = document.createElement('option');
        option.value = item[valueKey];
        option.textContent = item[labelKey];
        select.appendChild(option);
    });
}

// Format date
function formatDate(dateString) {
    if (!dateString) return '-';
    const date = new Date(dateString);
    return date.toLocaleDateString('th-TH', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

// Status badge helper
function getStatusBadge(isActive) {
    if (isActive) {
        return '<span style="background: #219653; color: white; padding: 4px 12px; border-radius: 12px; font-size: 12px;">Active</span>';
    }
    return '<span style="background: #D34053; color: white; padding: 4px 12px; border-radius: 12px; font-size: 12px;">Inactive</span>';
}

// Confirm delete
function confirmDelete(itemName = 'this item') {
    return confirm(`Are you sure you want to delete ${itemName}?`);
}
