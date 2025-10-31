import './bootstrap';

/**
 * TailAdmin Template - Main JavaScript
 *
 * This file handles:
 * - Dark mode toggle
 * - Sidebar menu interactions
 * - Global utilities
 */

// Dark Mode Toggle
document.addEventListener('DOMContentLoaded', function() {
    // Initialize dark mode from localStorage
    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }

    // Dark mode toggle button handler
    const darkModeToggle = document.getElementById('darkModeToggle');
    if (darkModeToggle) {
        darkModeToggle.addEventListener('click', function() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                document.documentElement.classList.add('dark');
                localStorage.theme = 'dark';
            }
        });
    }

    // Sidebar menu toggle (for parent menus with children)
    const menuParents = document.querySelectorAll('.menu-item-has-children .menu-parent');
    menuParents.forEach(parent => {
        parent.addEventListener('click', function(e) {
            e.preventDefault();
            const menuItem = this.closest('.menu-item-has-children');
            menuItem.classList.toggle('open');
        });
    });

    // Auto-expand active parent menu
    const activeMenu = document.querySelector('.sidebar-menu li a.active');
    if (activeMenu) {
        const parentMenu = activeMenu.closest('.menu-item-has-children');
        if (parentMenu) {
            parentMenu.classList.add('open');
        }
    }
});

// Global utility functions
window.copyToClipboard = function(text) {
    navigator.clipboard.writeText(text).then(() => {
        console.log('Copied to clipboard:', text);
    }).catch(err => {
        console.error('Failed to copy:', err);
    });
};

window.formatDate = function(date, format = 'YYYY-MM-DD') {
    const d = new Date(date);
    const year = d.getFullYear();
    const month = String(d.getMonth() + 1).padStart(2, '0');
    const day = String(d.getDate()).padStart(2, '0');

    return format
        .replace('YYYY', year)
        .replace('MM', month)
        .replace('DD', day);
};

window.formatCurrency = function(amount, currency = 'THB') {
    return new Intl.NumberFormat('th-TH', {
        style: 'currency',
        currency: currency
    }).format(amount);
};

window.debounce = function(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
};

window.throttle = function(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
};
