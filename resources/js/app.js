import './bootstrap';

// Dark Mode Toggle
(function () {
    // Update theme icons based on current mode
    function updateThemeIcons() {
        const isDark = document.documentElement.classList.contains('dark');
        const lightIcon = document.getElementById('theme-toggle-light-icon');
        const darkIcon = document.getElementById('theme-toggle-dark-icon');

        if (lightIcon && darkIcon) {
            if (isDark) {
                // In dark mode, show sun icon (to switch to light)
                lightIcon.style.display = 'block';
                darkIcon.style.display = 'none';
            } else {
                // In light mode, show moon icon (to switch to dark)
                lightIcon.style.display = 'none';
                darkIcon.style.display = 'block';
            }
        }
    }

    // Check for saved dark mode preference or default to light mode
    const darkMode = localStorage.getItem('dark-mode');
    if (darkMode === 'enabled') {
        document.documentElement.classList.add('dark');
    }

    // Update icons immediately and on page load
    updateThemeIcons();
    document.addEventListener('DOMContentLoaded', updateThemeIcons);

    // Toggle dark mode function
    window.toggleDarkMode = function () {
        const isDark = document.documentElement.classList.toggle('dark');
        localStorage.setItem('dark-mode', isDark ? 'enabled' : 'disabled');
        updateThemeIcons();
    };
})();

// Global utilities
window.utils = {
    // Format date to relative time
    formatDate(dateString) {
        if (!dateString) return 'Unknown date';

        const date = new Date(dateString);
        if (isNaN(date.getTime())) return 'Invalid date';

        const now = new Date();
        const diffTime = Math.abs(now.getTime() - date.getTime());
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

        if (diffDays === 1) return 'Yesterday';
        if (diffDays < 7) return `${diffDays} days ago`;
        if (diffDays < 30) return `${Math.floor(diffDays / 7)} weeks ago`;
        if (diffDays < 365) return `${Math.floor(diffDays / 30)} months ago`;

        return date.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
    },

    // Debounce function
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    },

    // Show toast notification
    showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-md ${type === 'success' ? 'bg-green-500 text-white' :
                type === 'error' ? 'bg-red-500 text-white' :
                    'bg-blue-500 text-white'
            }`;
        toast.textContent = message;

        document.body.appendChild(toast);

        setTimeout(() => {
            toast.remove();
        }, 3000);
    },

    // Copy text to clipboard
    async copyToClipboard(text) {
        try {
            await navigator.clipboard.writeText(text);
            this.showToast('Copied to clipboard!');
        } catch (error) {
            console.error('Failed to copy text:', error);
            this.showToast('Failed to copy text', 'error');
        }
    },

    // Share content
    async shareContent(data) {
        if (navigator.share) {
            try {
                await navigator.share(data);
            } catch (error) {
                if (error.name !== 'AbortError') {
                    console.error('Error sharing:', error);
                }
            }
        } else {
            // Fallback: copy to clipboard
            const text = `${data.title}\n\n${data.text}\n\n${data.url}`;
            await this.copyToClipboard(text);
        }
    }
};

// Global event listeners
document.addEventListener('DOMContentLoaded', function () {
    // Auto-hide flash messages
    const flashMessages = document.querySelectorAll('.bg-green-50, .bg-red-50');
    flashMessages.forEach(message => {
        setTimeout(() => {
            message.style.transition = 'opacity 0.5s ease';
            message.style.opacity = '0';
            setTimeout(() => message.remove(), 500);
        }, 5000);
    });

    // Handle form submissions
    document.addEventListener('submit', function (event) {
        const form = event.target;
        const submitButton = form.querySelector('button[type="submit"]');

        if (submitButton) {
            submitButton.disabled = true;
            submitButton.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Processing...';
        }
    });

    // Handle confirmation dialogs
    document.addEventListener('click', function (event) {
        if (event.target.matches('[data-confirm]')) {
            const message = event.target.getAttribute('data-confirm');
            if (!confirm(message)) {
                event.preventDefault();
                event.stopPropagation();
            }
        }
    });
});

// CSRF token for AJAX requests
window.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

// Add CSRF token to all AJAX requests
if (window.csrfToken) {
    const originalFetch = window.fetch;
    window.fetch = function (url, options = {}) {
        if (options.method && options.method !== 'GET') {
            options.headers = {
                ...options.headers,
                'X-CSRF-TOKEN': window.csrfToken
            };
        }
        return originalFetch(url, options);
    };
}

// ============================================
// Vanilla JS Components
// ============================================

// Flash Message System
class FlashMessage {
    constructor(containerId = 'flash-message-container') {
        this.container = document.getElementById(containerId);
        this.messageElement = null;
    }

    show(message, type = 'success') {
        if (!this.container) {
            // Create container if it doesn't exist
            this.container = document.createElement('div');
            this.container.id = 'flash-message-container';
            this.container.className = 'fixed top-16 left-1/2 transform -translate-x-1/2 z-50 max-w-md w-full px-4';
            document.body.appendChild(this.container);
        }

        // Remove existing message
        if (this.messageElement) {
            this.messageElement.remove();
        }

        // Create new message
        this.messageElement = document.createElement('div');
        this.messageElement.className = `p-4 rounded-md flex items-center justify-between ${type === 'success'
                ? 'bg-blue-50 border border-blue-200 text-blue-800'
                : 'bg-red-50 border border-red-200 text-red-800'
            }`;

        this.messageElement.innerHTML = `
            <div class="flex items-center space-x-2">
                <i class="bx ${type === 'success' ? 'bx-check-circle' : 'bx-error-circle'} text-lg"></i>
                <span class="text-sm font-normal">${message}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="ml-4 ${type === 'success'
                ? 'text-blue-600 hover:text-blue-800'
                : 'text-red-600 hover:text-red-800'
            }">
                <i class="bx bx-x text-lg"></i>
            </button>
        `;

        this.container.appendChild(this.messageElement);

        // Auto-hide after 5 seconds
        setTimeout(() => {
            if (this.messageElement && this.messageElement.parentElement) {
                this.messageElement.style.transition = 'opacity 0.5s ease';
                this.messageElement.style.opacity = '0';
                setTimeout(() => {
                    if (this.messageElement && this.messageElement.parentElement) {
                        this.messageElement.remove();
                    }
                }, 500);
            }
        }, 5000);
    }

    hide() {
        if (this.messageElement) {
            this.messageElement.remove();
        }
    }
}

// Resource Detail Component (upvote, download, comments)
class ResourceDetail {
    constructor(container, options = {}) {
        this.container = container;
        this.resourceUuid = options.resourceUuid;
        this.hasUpvoted = options.hasUpvoted || false;
        this.isAuthenticated = options.isAuthenticated || false;
        this.apiBaseUrl = options.apiBaseUrl || '/api/resources';

        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || window.csrfToken;

        this.init();
    }

    init() {
        const upvoteBtn = this.container.querySelector('[data-upvote-button]');
        if (upvoteBtn) {
            upvoteBtn.addEventListener('click', () => this.toggleUpvote());
        }

        const downloadLink = this.container.querySelector('[data-download-link]');
        if (downloadLink) {
            downloadLink.addEventListener('click', () => this.trackDownload());
        }

        const commentForm = this.container.querySelector('[data-comment-form]');
        if (commentForm) {
            commentForm.addEventListener('submit', (e) => {
                e.preventDefault();
                this.submitComment();
            });
        }
    }

    async toggleUpvote() {
        if (!this.isAuthenticated) {
            window.location.href = '/login';
            return;
        }

        try {
            const url = `${this.apiBaseUrl}/${this.resourceUuid}/${this.hasUpvoted ? 'remove-upvote' : 'upvote'}`;
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            });

            if (response.ok) {
                const data = await response.json();
                this.hasUpvoted = data.upvoted;
                this.updateUpvoteDisplay(data.upvote_count);
            } else if (window.flashMessage) {
                window.flashMessage.show('Failed to update upvote', 'error');
            }
        } catch (error) {
            console.error('Error toggling upvote:', error);
            if (window.flashMessage) {
                window.flashMessage.show('Error: ' + error.message, 'error');
            }
        }
    }

    updateUpvoteDisplay(count) {
        const upvoteBtn = this.container.querySelector('[data-upvote-button]');
        const upvoteCountEl = this.container.querySelector('[data-upvote-count]');
        const icon = upvoteBtn?.querySelector('i');

        if (upvoteBtn) {
            upvoteBtn.classList.remove('bg-blue-50', 'dark:bg-blue-900/30', 'text-blue-600', 'dark:text-blue-400', 'bg-gray-100', 'dark:bg-gray-800', 'text-gray-600', 'dark:text-gray-300');
            if (this.hasUpvoted) {
                upvoteBtn.classList.add('bg-blue-50', 'dark:bg-blue-900/30', 'text-blue-600', 'dark:text-blue-400');
            } else {
                upvoteBtn.classList.add('bg-gray-100', 'dark:bg-gray-800', 'text-gray-600', 'dark:text-gray-300');
            }
        }

        if (icon) {
            icon.className = this.hasUpvoted ? 'bx bxs-upvote' : 'bx bx-upvote';
        }

        if (upvoteCountEl && count !== undefined) {
            upvoteCountEl.textContent = count;
        }
    }

    async trackDownload() {
        // The download link itself navigates to the download route, which
        // logs the engagement server side. Nothing else to do client side.
    }

    async submitComment() {
        const commentForm = this.container.querySelector('[data-comment-form]');
        const textarea = commentForm?.querySelector('textarea');
        const body = textarea?.value.trim();

        if (!body) return;

        try {
            const response = await fetch(`${this.apiBaseUrl}/${this.resourceUuid}/comments`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ body }),
                credentials: 'same-origin'
            });

            if (response.ok) {
                if (textarea) textarea.value = '';
                if (window.flashMessage) {
                    window.flashMessage.show('Comment posted successfully!', 'success');
                }
                setTimeout(() => window.location.reload(), 500);
            } else if (window.flashMessage) {
                window.flashMessage.show('Failed to post comment', 'error');
            }
        } catch (error) {
            console.error('Error submitting comment:', error);
            if (window.flashMessage) {
                window.flashMessage.show('Error: ' + error.message, 'error');
            }
        }
    }
}

// Resource Form Handler (create/edit, including file upload and changelog for lecturer content)
class ResourceForm {
    constructor(formElement, options = {}) {
        this.form = formElement;
        this.mode = options.mode || 'create';
        this.resourceUuid = options.resourceUuid || null;
        this.redirectUrl = options.redirectUrl || '/resources';
        this.apiBaseUrl = '/api/resources';
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || window.csrfToken;
        this.selectedFile = null;

        this.fileInput = this.form.querySelector('#file-input');
        this.selectFileBtn = this.form.querySelector('#select-file-btn');
        this.removeFileBtn = this.form.querySelector('#remove-file-btn');
        this.fileUploadArea = this.form.querySelector('#file-upload-area');
        this.fileInfo = this.form.querySelector('#file-info');
        this.fileNameEl = this.form.querySelector('#file-name');
        this.fileSizeEl = this.form.querySelector('#file-size');

        this.init();
    }

    init() {
        if (this.selectFileBtn && this.fileInput) {
            this.selectFileBtn.addEventListener('click', () => this.fileInput.click());
            this.fileInput.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (file) {
                    this.selectedFile = file;
                    this.displayFileInfo(file);
                }
            });
        }

        if (this.removeFileBtn) {
            this.removeFileBtn.addEventListener('click', () => {
                this.selectedFile = null;
                if (this.fileInput) this.fileInput.value = '';
                this.fileUploadArea?.classList.remove('hidden');
                this.fileInfo?.classList.add('hidden');
            });
        }

        this.form.addEventListener('submit', (e) => {
            e.preventDefault();
            this.submit();
        });
    }

    displayFileInfo(file) {
        if (this.fileNameEl) this.fileNameEl.textContent = file.name;
        if (this.fileSizeEl) this.fileSizeEl.textContent = this.formatFileSize(file.size);
        this.fileUploadArea?.classList.add('hidden');
        this.fileInfo?.classList.remove('hidden');
    }

    formatFileSize(bytes) {
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / 1048576).toFixed(1) + ' MB';
    }

    getFormData() {
        const data = {};
        const fields = ['title', 'description', 'type', 'course_unit_id', 'semester', 'academic_year', 'changelog'];
        fields.forEach(field => {
            const el = this.form.querySelector(`[name="${field}"]`);
            if (el && el.value !== '') data[field] = el.value;
        });
        return data;
    }

    async submit() {
        const submitBtn = this.form.querySelector('button[type="submit"]');
        if (submitBtn) submitBtn.disabled = true;

        try {
            const payload = this.getFormData();
            const url = this.mode === 'edit' ? `${this.apiBaseUrl}/${this.resourceUuid}` : this.apiBaseUrl;
            const method = this.mode === 'edit' ? 'PATCH' : 'POST';

            const response = await fetch(url, {
                method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload),
                credentials: 'same-origin'
            });

            if (!response.ok) {
                const error = await response.json();
                throw new Error(error.message || 'Failed to save resource');
            }

            const resource = await response.json();

            if (this.selectedFile) {
                await this.uploadFile(resource.uuid || this.resourceUuid);
            }

            if (window.flashMessage) {
                window.flashMessage.show('Resource saved successfully!', 'success');
            }

            setTimeout(() => {
                window.location.href = this.redirectUrl;
            }, 800);
        } catch (error) {
            console.error('Error saving resource:', error);
            if (window.flashMessage) {
                window.flashMessage.show(error.message || 'Failed to save resource', 'error');
            }
        } finally {
            if (submitBtn) submitBtn.disabled = false;
        }
    }

    async uploadFile(resourceUuid) {
        if (!resourceUuid || !this.selectedFile) return null;

        try {
            const formData = new FormData();
            formData.append('file', this.selectedFile);

            const response = await fetch(`${this.apiBaseUrl}/${resourceUuid}/upload-file`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                },
                body: formData,
                credentials: 'same-origin'
            });

            if (!response.ok) {
                const error = await response.json();
                throw new Error(error.message || 'Failed to upload file');
            }

            const data = await response.json();
            return data.file_url;
        } catch (error) {
            console.error('Error uploading file:', error);
            if (window.flashMessage) {
                window.flashMessage.show(error.message || 'Failed to upload file', 'error');
            }
            return null;
        }
    }
}

// Modal Component
class Modal {
    constructor(modalElement, options = {}) {
        this.modal = modalElement;
        this.name = options.name || modalElement.getAttribute('data-modal-name');
        this.show = options.show || false;
        this.focusableSelector = 'a, button, input:not([type="hidden"]), textarea, select, details, [tabindex]:not([tabindex="-1"])';

        this.init();
    }

    init() {
        // Set initial state
        if (this.show) {
            this.show();
        } else {
            this.hide();
        }

        // Close buttons
        const closeButtons = this.modal.querySelectorAll('[data-modal-close]');
        closeButtons.forEach(btn => {
            btn.addEventListener('click', () => this.hide());
        });

        // Backdrop click
        const backdrop = this.modal.querySelector('[data-modal-backdrop]');
        if (backdrop) {
            backdrop.addEventListener('click', () => this.hide());
        }

        // Escape key
        const escapeHandler = (e) => {
            if (e.key === 'Escape' && this.show) {
                this.hide();
            }
        };
        document.addEventListener('keydown', escapeHandler);
        this.modal._escapeHandler = escapeHandler;

        // Tab trapping
        const tabHandler = (e) => {
            if (e.key === 'Tab' && this.show) {
                this.trapFocus(e);
            }
        };
        this.modal.addEventListener('keydown', tabHandler);
        this.modal._tabHandler = tabHandler;

        // Listen for open/close events
        const openHandler = (e) => {
            if (e.detail === this.name) {
                this.show();
            }
        };
        window.addEventListener('open-modal', openHandler);
        this.modal._openHandler = openHandler;

        const closeHandler = (e) => {
            if (e.detail === this.name) {
                this.hide();
            }
        };
        window.addEventListener('close-modal', closeHandler);
        this.modal._closeHandler = closeHandler;
    }

    show() {
        this.show = true;
        const backdrop = this.modal.querySelector('[data-modal-backdrop]');
        const content = this.modal.querySelector('[data-modal-content]');

        if (backdrop) backdrop.style.display = 'block';
        if (content) content.style.display = 'block';
        this.modal.style.display = 'block';
        document.body.classList.add('overflow-y-hidden');

        // Focus first element
        setTimeout(() => {
            const firstFocusable = this.getFocusables()[0];
            if (firstFocusable) firstFocusable.focus();
        }, 100);
    }

    hide() {
        this.show = false;
        const backdrop = this.modal.querySelector('[data-modal-backdrop]');
        const content = this.modal.querySelector('[data-modal-content]');

        if (backdrop) backdrop.style.display = 'none';
        if (content) content.style.display = 'none';
        this.modal.style.display = 'none';
        document.body.classList.remove('overflow-y-hidden');
    }

    getFocusables() {
        return Array.from(this.modal.querySelectorAll(this.focusableSelector))
            .filter(el => !el.hasAttribute('disabled'));
    }

    trapFocus(e) {
        const focusables = this.getFocusables();
        const firstFocusable = focusables[0];
        const lastFocusable = focusables[focusables.length - 1];
        const currentIndex = focusables.indexOf(document.activeElement);

        if (e.shiftKey) {
            if (document.activeElement === firstFocusable) {
                e.preventDefault();
                lastFocusable.focus();
            }
        } else {
            if (document.activeElement === lastFocusable) {
                e.preventDefault();
                firstFocusable.focus();
            }
        }
    }
}

// Dropdown Component
class Dropdown {
    constructor(dropdownElement) {
        this.dropdown = dropdownElement;
        this.toggle = dropdownElement.querySelector('[data-dropdown-toggle]');
        this.menu = dropdownElement.querySelector('[data-dropdown-menu]');
        this.open = false;

        this.init();
    }

    init() {
        if (this.toggle) {
            this.toggle.addEventListener('click', (e) => {
                e.stopPropagation();
                this.toggleMenu();
            });
        }

        // Close on outside click
        document.addEventListener('click', (e) => {
            if (this.open && !this.dropdown.contains(e.target)) {
                this.close();
            }
        });

        // Close on escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.open) {
                this.close();
            }
        });
    }

    toggleMenu() {
        this.open = !this.open;
        if (this.menu) {
            this.menu.style.display = this.open ? 'block' : 'none';
        }
    }

    close() {
        this.open = false;
        if (this.menu) {
            this.menu.style.display = 'none';
        }
    }
}

// Initialize components on DOM ready
document.addEventListener('DOMContentLoaded', function () {
    // Initialize FlashMessage
    window.flashMessage = new FlashMessage();

    // Initialize modals (only if not already initialized by component script)
    document.querySelectorAll('[data-modal]').forEach(modal => {
        if (!modal.dataset.modalInitialized) {
            const name = modal.getAttribute('data-modal-name');
            new Modal(modal, { name });
            modal.dataset.modalInitialized = 'true';
        }
    });

    // Initialize dropdowns (only if not already initialized by component script)
    document.querySelectorAll('[data-dropdown]').forEach(dropdown => {
        if (!dropdown.dataset.initialized) {
            new Dropdown(dropdown);
            dropdown.dataset.initialized = 'true';
        }
    });
});

// Research Work Form Handler (create/edit, license type, file upload)
class ResearchWorkForm {
    constructor(formElement, options = {}) {
        this.form = formElement;
        this.mode = options.mode || 'create';
        this.researchWorkUuid = options.researchWorkUuid || null;
        this.redirectUrl = options.redirectUrl || '/research';
        this.apiBaseUrl = '/api/research-works';
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || window.csrfToken;
        this.selectedFile = null;

        this.fileInput = this.form.querySelector('#file-input');
        this.selectFileBtn = this.form.querySelector('#select-file-btn');
        this.removeFileBtn = this.form.querySelector('#remove-file-btn');
        this.fileUploadArea = this.form.querySelector('#file-upload-area');
        this.fileInfo = this.form.querySelector('#file-info');
        this.fileNameEl = this.form.querySelector('#file-name');
        this.fileSizeEl = this.form.querySelector('#file-size');

        this.init();
    }

    init() {
        if (this.selectFileBtn && this.fileInput) {
            this.selectFileBtn.addEventListener('click', () => this.fileInput.click());
            this.fileInput.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (file) {
                    this.selectedFile = file;
                    this.displayFileInfo(file);
                }
            });
        }

        if (this.removeFileBtn) {
            this.removeFileBtn.addEventListener('click', () => {
                this.selectedFile = null;
                if (this.fileInput) this.fileInput.value = '';
                this.fileUploadArea?.classList.remove('hidden');
                this.fileInfo?.classList.add('hidden');
            });
        }

        this.form.addEventListener('submit', (e) => {
            e.preventDefault();
            this.submit();
        });
    }

    displayFileInfo(file) {
        if (this.fileNameEl) this.fileNameEl.textContent = file.name;
        if (this.fileSizeEl) this.fileSizeEl.textContent = this.formatFileSize(file.size);
        this.fileUploadArea?.classList.add('hidden');
        this.fileInfo?.classList.remove('hidden');
    }

    formatFileSize(bytes) {
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / 1048576).toFixed(1) + ' MB';
    }

    getFormData() {
        const data = {};
        const fields = ['title', 'description', 'field_of_study', 'license_type', 'department_id', 'citation'];
        fields.forEach(field => {
            const el = this.form.querySelector(`[name="${field}"]`);
            if (el && el.value !== '') data[field] = el.value;
        });
        return data;
    }

    async submit() {
        const submitBtn = this.form.querySelector('button[type="submit"]');
        if (submitBtn) submitBtn.disabled = true;

        try {
            const payload = this.getFormData();
            const url = this.mode === 'edit' ? `${this.apiBaseUrl}/${this.researchWorkUuid}` : this.apiBaseUrl;
            const method = this.mode === 'edit' ? 'PATCH' : 'POST';

            const response = await fetch(url, {
                method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload),
                credentials: 'same-origin'
            });

            if (!response.ok) {
                const error = await response.json();
                throw new Error(error.message || 'Failed to save research work');
            }

            if (window.flashMessage) {
                window.flashMessage.show('Research work saved successfully!', 'success');
            }

            setTimeout(() => {
                window.location.href = this.redirectUrl;
            }, 800);
        } catch (error) {
            console.error('Error saving research work:', error);
            if (window.flashMessage) {
                window.flashMessage.show(error.message || 'Failed to save research work', 'error');
            }
        } finally {
            if (submitBtn) submitBtn.disabled = false;
        }
    }
}

// Research Work Manager (show page: submit for review, review submission, endorsement action, comments)
class ResearchWorkManager {
    constructor(container, options = {}) {
        this.container = container;
        this.researchWorkUuid = options.researchWorkUuid;
        this.isAuthenticated = options.isAuthenticated || false;
        this.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || window.csrfToken;

        this.init();
    }

    init() {
        const submitForReviewBtn = this.container.querySelector('[data-submit-for-review]');
        if (submitForReviewBtn) {
            submitForReviewBtn.addEventListener('click', () => this.submitForReview());
        }

        const reviewForm = this.container.querySelector('[data-review-form]');
        if (reviewForm) {
            reviewForm.addEventListener('submit', (e) => {
                e.preventDefault();
                this.submitReview(reviewForm);
            });
        }

        const endorsementForm = this.container.querySelector('[data-endorsement-form]');
        if (endorsementForm) {
            endorsementForm.addEventListener('submit', (e) => {
                e.preventDefault();
                this.submitEndorsement(endorsementForm);
            });
        }

        const commentForm = this.container.querySelector('[data-comment-form]');
        if (commentForm) {
            commentForm.addEventListener('submit', (e) => {
                e.preventDefault();
                this.submitComment(commentForm);
            });
        }
    }

    async submitForReview() {
        try {
            const response = await fetch(`/api/research-works/${this.researchWorkUuid}/submit-for-review`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            });

            if (response.ok) {
                if (window.flashMessage) {
                    window.flashMessage.show('Submitted for review!', 'success');
                }
                setTimeout(() => window.location.reload(), 800);
            } else {
                const error = await response.json();
                if (window.flashMessage) {
                    window.flashMessage.show(error.message || 'Failed to submit for review', 'error');
                }
            }
        } catch (error) {
            console.error('Error submitting for review:', error);
        }
    }

    async submitReview(form) {
        const payload = {
            status: form.querySelector('[name="status"]')?.value,
            comments: form.querySelector('[name="comments"]')?.value,
            blind_review: form.querySelector('[name="blind_review"]')?.checked || false,
        };

        try {
            const response = await fetch(`/api/research-works/${this.researchWorkUuid}/reviews`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload),
                credentials: 'same-origin'
            });

            if (response.ok) {
                if (window.flashMessage) {
                    window.flashMessage.show('Review submitted!', 'success');
                }
                setTimeout(() => window.location.reload(), 800);
            } else if (window.flashMessage) {
                window.flashMessage.show('Failed to submit review', 'error');
            }
        } catch (error) {
            console.error('Error submitting review:', error);
        }
    }

    async submitEndorsement(form) {
        const payload = {
            status: form.querySelector('[name="status"]')?.value,
            notes: form.querySelector('[name="notes"]')?.value,
        };

        try {
            const response = await fetch(`/api/research-works/${this.researchWorkUuid}/endorsements`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload),
                credentials: 'same-origin'
            });

            if (response.ok) {
                if (window.flashMessage) {
                    window.flashMessage.show('Endorsement saved!', 'success');
                }
                setTimeout(() => window.location.reload(), 800);
            } else if (window.flashMessage) {
                window.flashMessage.show('Failed to save endorsement', 'error');
            }
        } catch (error) {
            console.error('Error saving endorsement:', error);
        }
    }

    async submitComment(form) {
        const textarea = form.querySelector('textarea[name="body"]');
        const body = textarea?.value.trim();
        if (!body) return;

        try {
            const response = await fetch(`/api/research-works/${this.researchWorkUuid}/comments`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ body }),
                credentials: 'same-origin'
            });

            if (response.ok) {
                if (textarea) textarea.value = '';
                if (window.flashMessage) {
                    window.flashMessage.show('Comment posted successfully!', 'success');
                }
                setTimeout(() => window.location.reload(), 500);
            } else if (window.flashMessage) {
                window.flashMessage.show('Failed to post comment', 'error');
            }
        } catch (error) {
            console.error('Error submitting comment:', error);
        }
    }
}

// Form Handler for generic CRUD forms
class CRUDFormHandler {
    constructor(formElement, options = {}) {
        this.form = formElement;
        this.onSubmit = options.onSubmit;
        this.onSuccess = options.onSuccess;
        this.onError = options.onError;
        this.validateFn = options.validate;
        this.isSubmitting = false;

        this.init();
    }

    init() {
        this.form.addEventListener('submit', async (e) => {
            e.preventDefault();
            await this.handleSubmit();
        });

        // Real-time validation
        const inputs = this.form.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            input.addEventListener('blur', () => this.validateField(input));
            input.addEventListener('input', () => this.clearFieldError(input));
        });
    }

    async handleSubmit() {
        if (this.isSubmitting) return;

        // Validate
        if (this.validateFn && !this.validateFn(this.getFormData())) {
            return;
        }

        this.isSubmitting = true;
        this.setSubmitButtonState(true);

        try {
            const formData = this.getFormData();
            
            if (this.onSubmit) {
                const result = await this.onSubmit(formData);
                
                if (result && this.onSuccess) {
                    this.onSuccess(result);
                }
            }
        } catch (error) {
            console.error('Form submission error:', error);
            if (this.onError) {
                this.onError(error);
            }
        } finally {
            this.isSubmitting = false;
            this.setSubmitButtonState(false);
        }
    }

    getFormData() {
        const formData = new FormData(this.form);
        const data = {};
        
        for (let [key, value] of formData.entries()) {
            // Handle checkboxes
            if (this.form.elements[key]?.type === 'checkbox') {
                data[key] = this.form.elements[key].checked;
            } else {
                data[key] = value;
            }
        }
        
        return data;
    }

    validateField(field) {
        const value = field.value.trim();
        const required = field.hasAttribute('required');
        
        if (required && !value) {
            this.showFieldError(field, 'This field is required');
            return false;
        }
        
        // Email validation
        if (field.type === 'email' && value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                this.showFieldError(field, 'Please enter a valid email');
                return false;
            }
        }
        
        // URL validation
        if (field.type === 'url' && value) {
            try {
                new URL(value);
            } catch {
                this.showFieldError(field, 'Please enter a valid URL');
                return false;
            }
        }
        
        // Number validation
        if (field.type === 'number' && value) {
            const min = field.getAttribute('min');
            const max = field.getAttribute('max');
            const numValue = parseFloat(value);
            
            if (min && numValue < parseFloat(min)) {
                this.showFieldError(field, `Value must be at least ${min}`);
                return false;
            }
            
            if (max && numValue > parseFloat(max)) {
                this.showFieldError(field, `Value must be at most ${max}`);
                return false;
            }
        }
        
        this.clearFieldError(field);
        return true;
    }

    showFieldError(field, message) {
        this.clearFieldError(field);
        
        const errorEl = document.createElement('p');
        errorEl.className = 'mt-1 text-sm text-red-600';
        errorEl.textContent = message;
        errorEl.dataset.fieldError = field.name;
        
        field.classList.add('border-red-500', 'focus:border-red-500');
        field.parentElement.appendChild(errorEl);
    }

    clearFieldError(field) {
        const errorEl = field.parentElement.querySelector(`[data-field-error="${field.name}"]`);
        if (errorEl) {
            errorEl.remove();
        }
        field.classList.remove('border-red-500', 'focus:border-red-500');
    }

    setSubmitButtonState(loading) {
        const submitBtn = this.form.querySelector('button[type="submit"]');
        if (!submitBtn) return;
        
        if (loading) {
            submitBtn.disabled = true;
            submitBtn.dataset.originalText = submitBtn.textContent;
            submitBtn.innerHTML = `
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Processing...
            `;
        } else {
            submitBtn.disabled = false;
            if (submitBtn.dataset.originalText) {
                submitBtn.textContent = submitBtn.dataset.originalText;
            }
        }
    }

    reset() {
        this.form.reset();
        this.form.querySelectorAll('[data-field-error]').forEach(el => el.remove());
        this.form.querySelectorAll('.border-red-500').forEach(el => {
            el.classList.remove('border-red-500', 'focus:border-red-500');
        });
    }
}

// Export classes for global use
window.FlashMessage = FlashMessage;
window.ResourceDetail = ResourceDetail;
window.ResourceForm = ResourceForm;
window.Modal = Modal;
window.Dropdown = Dropdown;
window.ResearchWorkForm = ResearchWorkForm;
window.ResearchWorkManager = ResearchWorkManager;
window.CRUDFormHandler = CRUDFormHandler;

// Notifications System
class NotificationsDropdown {
    constructor() {
        this.dropdown = document.querySelector('[data-notifications-dropdown]');
        this.toggle = document.querySelector('[data-notifications-toggle]');
        this.menu = document.getElementById('notifications-menu');
        this.list = document.getElementById('notifications-list');
        this.badge = document.getElementById('notifications-badge');
        this.unreadCountEl = document.getElementById('unread-count');
        this.markAllReadBtn = document.getElementById('mark-all-read');
        this.isOpen = false;
        this.notifications = [];
        this.unreadCount = 0;

        if (this.dropdown) {
            this.init();
        }
    }

    init() {
        // Toggle dropdown
        if (this.toggle) {
            this.toggle.addEventListener('click', (e) => {
                e.stopPropagation();
                this.toggleDropdown();
            });
        }

        // Mark all as read
        if (this.markAllReadBtn) {
            this.markAllReadBtn.addEventListener('click', () => this.markAllAsRead());
        }

        // Close on outside click
        document.addEventListener('click', (e) => {
            if (this.isOpen && !this.dropdown.contains(e.target)) {
                this.closeDropdown();
            }
        });

        // Close on escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.isOpen) {
                this.closeDropdown();
            }
        });

        // Fetch notifications on load
        this.fetchNotifications();

        // Poll for new notifications every 30 seconds
        setInterval(() => this.fetchNotifications(), 30000);
    }

    toggleDropdown() {
        this.isOpen = !this.isOpen;
        if (this.menu) {
            this.menu.style.display = this.isOpen ? 'flex' : 'none';
        }
        if (this.isOpen) {
            this.fetchNotifications();
        }
    }

    closeDropdown() {
        this.isOpen = false;
        if (this.menu) {
            this.menu.style.display = 'none';
        }
    }

    async fetchNotifications() {
        try {
            const response = await fetch('/api/notifications?limit=10', {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': window.csrfToken
                },
                credentials: 'same-origin'
            });

            if (response.ok) {
                const data = await response.json();
                this.notifications = data.notifications || [];
                this.unreadCount = data.unread_count || 0;
                this.render();
            }
        } catch (error) {
            console.error('Error fetching notifications:', error);
        }
    }

    render() {
        // Update badge
        if (this.badge) {
            if (this.unreadCount > 0) {
                this.badge.classList.remove('hidden');
            } else {
                this.badge.classList.add('hidden');
            }
        }

        // Update unread count text
        if (this.unreadCountEl) {
            this.unreadCountEl.textContent = this.unreadCount;
        }

        // Render notifications list
        if (this.list) {
            if (this.notifications.length === 0) {
                this.list.innerHTML = `
                    <div class="px-4 py-8 text-center">
                        <i class="bx bx-bell-off text-3xl text-gray-300 dark:text-gray-600 mb-2"></i>
                        <p class="text-sm text-gray-500 dark:text-gray-400">No notifications yet</p>
                    </div>
                `;
            } else {
                this.list.innerHTML = this.notifications.map(notification => this.renderNotification(notification)).join('');

                // Add click handlers for marking as read
                this.list.querySelectorAll('[data-notification-id]').forEach(el => {
                    el.addEventListener('click', () => {
                        const id = el.dataset.notificationId;
                        this.markAsRead(id);
                        if (el.dataset.notificationLink) {
                            window.location.href = el.dataset.notificationLink;
                        }
                    });
                });
            }
        }
    }

    renderNotification(notification) {
        const isUnread = !notification.read_at;
        const timeAgo = this.formatTimeAgo(new Date(notification.created_at));
        const iconBgColors = {
            blue: 'bg-blue-100 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400',
            green: 'bg-green-100 dark:bg-green-900/20 text-green-600 dark:text-green-400',
            red: 'bg-red-100 dark:bg-red-900/20 text-red-600 dark:text-red-400',
            amber: 'bg-amber-100 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400',
            purple: 'bg-purple-100 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400',
        };
        const iconBgClass = iconBgColors[notification.icon_bg_color] || iconBgColors.blue;

        return `
            <div
                data-notification-id="${notification.id}"
                data-notification-link="${notification.link || ''}"
                class="px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer border-b border-gray-100 dark:border-gray-700 last:border-b-0 ${isUnread ? 'bg-blue-50/50 dark:bg-blue-900/10' : ''}"
            >
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-9 h-9 ${iconBgClass} rounded-full flex items-center justify-center">
                        <i class="bx ${notification.icon || 'bx-bell'} text-lg"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 dark:text-white ${isUnread ? '' : 'font-normal'}">${notification.title}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">${notification.message}</p>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">${timeAgo}</p>
                    </div>
                    ${isUnread ? '<span class="w-2 h-2 bg-blue-500 rounded-full flex-shrink-0"></span>' : ''}
                </div>
            </div>
        `;
    }

    formatTimeAgo(date) {
        const now = new Date();
        const diffInSeconds = Math.floor((now - date) / 1000);

        if (diffInSeconds < 60) return 'just now';
        if (diffInSeconds < 3600) return Math.floor(diffInSeconds / 60) + 'm ago';
        if (diffInSeconds < 86400) return Math.floor(diffInSeconds / 3600) + 'h ago';
        if (diffInSeconds < 604800) return Math.floor(diffInSeconds / 86400) + 'd ago';
        return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
    }

    async markAsRead(id) {
        try {
            await fetch(`/api/notifications/${id}/read`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': window.csrfToken
                },
                credentials: 'same-origin'
            });

            // Update local state
            const notification = this.notifications.find(n => n.id == id);
            if (notification && !notification.read_at) {
                notification.read_at = new Date().toISOString();
                this.unreadCount = Math.max(0, this.unreadCount - 1);
                this.render();
            }
        } catch (error) {
            console.error('Error marking notification as read:', error);
        }
    }

    async markAllAsRead() {
        try {
            await fetch('/api/notifications/read-all', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': window.csrfToken
                },
                credentials: 'same-origin'
            });

            // Update local state
            this.notifications.forEach(n => n.read_at = new Date().toISOString());
            this.unreadCount = 0;
            this.render();
        } catch (error) {
            console.error('Error marking all notifications as read:', error);
        }
    }
}

// Initialize notifications on DOM ready
document.addEventListener('DOMContentLoaded', function() {
    new NotificationsDropdown();
});

// Export for global use
window.NotificationsDropdown = NotificationsDropdown;

