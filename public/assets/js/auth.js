/**
 * TailAdmin Template - Authentication JavaScript
 * Handles all authentication requests via AJAX
 */

class AuthManager {
    constructor() {
        this.baseUrl = window.location.origin;
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    }

    /**
     * Make AJAX request
     */
    async request(url, method = 'GET', data = null) {
        const options = {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            credentials: 'same-origin'
        };

        // Add CSRF token for POST, PUT, DELETE requests
        if (['POST', 'PUT', 'DELETE', 'PATCH'].includes(method.toUpperCase())) {
            options.headers['X-CSRF-TOKEN'] = this.csrfToken;
        }

        // Add body for POST, PUT, PATCH requests
        if (data && ['POST', 'PUT', 'PATCH'].includes(method.toUpperCase())) {
            options.body = JSON.stringify(data);
        }

        try {
            const response = await fetch(url, options);
            const result = await response.json();

            // Handle non-2xx responses
            if (!response.ok) {
                throw result;
            }

            return result;
        } catch (error) {
            console.error('Request failed:', error);
            throw error;
        }
    }

    /**
     * Handle login
     */
    async login(formData) {
        return await this.request('/api/auth/login', 'POST', formData);
    }

    /**
     * Handle registration
     */
    async register(formData) {
        return await this.request('/api/auth/register', 'POST', formData);
    }

    /**
     * Handle logout
     */
    async logout() {
        return await this.request('/api/auth/logout', 'POST');
    }

    /**
     * Handle forgot password
     */
    async forgotPassword(formData) {
        return await this.request('/api/auth/forgot-password', 'POST', formData);
    }

    /**
     * Get current user
     */
    async getUser() {
        return await this.request('/api/auth/user', 'GET');
    }

    /**
     * Update profile
     */
    async updateProfile(formData) {
        return await this.request('/api/auth/update-profile', 'PUT', formData);
    }

    /**
     * Show loading state on button
     */
    setButtonLoading(button, loading = true) {
        if (loading) {
            button.disabled = true;
            button.dataset.originalText = button.innerHTML;
            button.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Processing...
            `;
        } else {
            button.disabled = false;
            button.innerHTML = button.dataset.originalText;
        }
    }

    /**
     * Display error messages
     */
    showErrors(errors, formId) {
        // Clear previous errors
        this.clearErrors(formId);

        if (typeof errors === 'object') {
            Object.keys(errors).forEach(field => {
                const input = document.querySelector(`#${formId} [name="${field}"]`);
                if (input) {
                    input.classList.add('border-red-500');
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'error-message text-red-500 text-sm mt-1';
                    errorDiv.textContent = Array.isArray(errors[field]) ? errors[field][0] : errors[field];
                    input.parentElement.appendChild(errorDiv);
                }
            });
        }
    }

    /**
     * Clear error messages
     */
    clearErrors(formId) {
        const form = document.getElementById(formId);
        if (form) {
            form.querySelectorAll('.error-message').forEach(el => el.remove());
            form.querySelectorAll('.border-red-500').forEach(el => {
                el.classList.remove('border-red-500');
            });
        }
    }

    /**
     * Show notification
     */
    showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `fixed top-5 right-5 z-50 px-6 py-4 rounded-lg shadow-lg ${
            type === 'success' ? 'bg-green-500' : 'bg-red-500'
        } text-white transform transition-transform duration-300`;
        notification.textContent = message;

        document.body.appendChild(notification);

        // Auto remove after 3 seconds
        setTimeout(() => {
            notification.style.transform = 'translateX(400px)';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    /**
     * Get form data as object
     */
    getFormData(formId) {
        const form = document.getElementById(formId);
        const formData = new FormData(form);
        const data = {};

        for (let [key, value] of formData.entries()) {
            data[key] = value;
        }

        return data;
    }
}

// Initialize AuthManager
const auth = new AuthManager();

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = AuthManager;
}
