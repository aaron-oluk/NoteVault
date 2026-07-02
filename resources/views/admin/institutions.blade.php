@extends('layouts.app')

@section('title', 'Institutions Management - Admin')

@section('content')
    <div class="max-w-7xl mx-auto px-3 sm:px-4 py-4 sm:py-8">
        <!-- Page Header -->
        <div class="mb-6 sm:mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2">Institutions Management</h1>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Manage the institutions that users can belong to</p>
                </div>
                <button type="button" id="add-institution-btn"
                    class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors whitespace-nowrap">
                    <i class="bx bx-plus mr-1.5"></i>
                    Add Institution
                </button>
            </div>
        </div>

        <!-- Add/Edit Form (hidden by default) -->
        <div id="institution-form-card" class="hidden bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4 sm:p-6 mb-6">
            <h2 class="text-base font-semibold text-gray-900 dark:text-white mb-4" id="institution-form-title">Add Institution</h2>
            <form id="institution-form" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <input type="hidden" name="id" id="institution-id">
                <div>
                    <label for="institution-name" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Name</label>
                    <input type="text" id="institution-name" name="name" required
                        class="w-full px-3 py-2 text-sm border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="institution-domain" class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Email Domain</label>
                    <input type="text" id="institution-domain" name="email_domain" required placeholder="university.edu"
                        class="w-full px-3 py-2 text-sm border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="flex items-center gap-2 sm:col-span-2">
                    <input type="checkbox" id="institution-active" name="active" checked class="rounded border-gray-300 dark:border-gray-700 text-blue-600">
                    <label for="institution-active" class="text-sm text-gray-700 dark:text-gray-300">Active</label>
                </div>
                <div class="sm:col-span-2 flex justify-end gap-2">
                    <button type="button" id="institution-form-cancel" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        Save
                    </button>
                </div>
            </form>
        </div>

        <!-- Institutions Table -->
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Name</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Email Domain</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Users</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Status</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="institutions-table-body" class="divide-y divide-gray-100 dark:divide-gray-800">
                        <tr>
                            <td colspan="5" class="py-8 text-center">
                                <i class="bx bx-loader-alt bx-spin text-2xl text-gray-400"></i>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tableBody = document.getElementById('institutions-table-body');
    const formCard = document.getElementById('institution-form-card');
    const form = document.getElementById('institution-form');
    const formTitle = document.getElementById('institution-form-title');
    const addBtn = document.getElementById('add-institution-btn');
    const cancelBtn = document.getElementById('institution-form-cancel');

    function showForm(institution = null) {
        form.reset();
        document.getElementById('institution-id').value = institution?.id || '';
        document.getElementById('institution-name').value = institution?.name || '';
        document.getElementById('institution-domain').value = institution?.email_domain || '';
        document.getElementById('institution-active').checked = institution ? !!institution.active : true;
        formTitle.textContent = institution ? 'Edit Institution' : 'Add Institution';
        formCard.classList.remove('hidden');
    }

    function hideForm() {
        formCard.classList.add('hidden');
        form.reset();
    }

    addBtn.addEventListener('click', () => showForm());
    cancelBtn.addEventListener('click', hideForm);

    function renderRow(institution) {
        const tr = document.createElement('tr');
        tr.className = 'hover:bg-gray-50 dark:hover:bg-gray-800/50';
        tr.innerHTML = `
            <td class="py-3 px-4 text-sm font-medium text-gray-900 dark:text-white">${institution.name}</td>
            <td class="py-3 px-4 text-sm text-gray-600 dark:text-gray-400">${institution.email_domain}</td>
            <td class="py-3 px-4 text-sm text-gray-600 dark:text-gray-400">${institution.users_count ?? 0}</td>
            <td class="py-3 px-4">
                <span class="px-2 py-1 text-xs font-medium rounded ${institution.active ? 'bg-green-100 dark:bg-green-900/20 text-green-700 dark:text-green-400' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-400'}">
                    ${institution.active ? 'Active' : 'Inactive'}
                </span>
            </td>
            <td class="py-3 px-4">
                <div class="flex items-center gap-2">
                    <button data-edit class="text-blue-600 dark:text-blue-400 hover:text-blue-700 text-sm">Edit</button>
                    <button data-delete class="text-red-600 dark:text-red-400 hover:text-red-700 text-sm">Delete</button>
                </div>
            </td>
        `;
        tr.querySelector('[data-edit]').addEventListener('click', () => showForm(institution));
        tr.querySelector('[data-delete]').addEventListener('click', () => deleteInstitution(institution.id, tr));
        return tr;
    }

    async function loadInstitutions() {
        try {
            const response = await fetch('/api/admin/institutions', {
                headers: { 'Accept': 'application/json' },
                credentials: 'same-origin'
            });
            const data = await response.json();
            const institutions = data.data || data;
            tableBody.innerHTML = '';
            if (!institutions || institutions.length === 0) {
                tableBody.innerHTML = '<tr><td colspan="5" class="py-8 text-center text-sm text-gray-500 dark:text-gray-400">No institutions found</td></tr>';
                return;
            }
            institutions.forEach(institution => tableBody.appendChild(renderRow(institution)));
        } catch (error) {
            console.error('Error loading institutions:', error);
            tableBody.innerHTML = '<tr><td colspan="5" class="py-8 text-center text-sm text-red-500">Failed to load institutions</td></tr>';
        }
    }

    async function deleteInstitution(id, row) {
        if (!confirm('Are you sure you want to delete this institution?')) return;
        try {
            const response = await fetch(`/api/admin/institutions/${id}`, {
                method: 'DELETE',
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': window.csrfToken },
                credentials: 'same-origin'
            });
            if (response.ok) {
                row.remove();
                if (window.flashMessage) window.flashMessage.show('Institution deleted successfully!', 'success');
            } else {
                if (window.flashMessage) window.flashMessage.show('Failed to delete institution', 'error');
            }
        } catch (error) {
            console.error('Error deleting institution:', error);
        }
    }

    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        const id = document.getElementById('institution-id').value;
        const payload = {
            name: document.getElementById('institution-name').value,
            email_domain: document.getElementById('institution-domain').value,
            active: document.getElementById('institution-active').checked,
        };

        const url = id ? `/api/admin/institutions/${id}` : '/api/admin/institutions';
        const method = id ? 'PATCH' : 'POST';

        try {
            const response = await fetch(url, {
                method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': window.csrfToken
                },
                body: JSON.stringify(payload),
                credentials: 'same-origin'
            });

            if (response.ok) {
                if (window.flashMessage) window.flashMessage.show('Institution saved successfully!', 'success');
                hideForm();
                loadInstitutions();
            } else {
                const error = await response.json();
                if (window.flashMessage) window.flashMessage.show(error.message || 'Failed to save institution', 'error');
            }
        } catch (error) {
            console.error('Error saving institution:', error);
        }
    });

    loadInstitutions();
});
</script>
@endsection
