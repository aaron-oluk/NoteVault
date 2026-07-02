@extends('layouts.app')

@section('title', 'Admin Dashboard - NoteVault')

@section('content')
    <div class="max-w-7xl mx-auto px-3 sm:px-4 py-4 sm:py-8">
        <!-- Page Header -->
        <div class="mb-6 sm:mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2">Admin Dashboard</h1>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Track performance across your platform</p>
                </div>
                <div class="flex items-center gap-2">
                    <button
                        class="flex items-center px-3 sm:px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300">
                        <i class="bx bx-calendar mr-2"></i>
                        Last 30 Days
                    </button>
                    <button
                        class="flex items-center px-3 sm:px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-xs sm:text-sm font-medium">
                        <i class="bx bx-download mr-2"></i>
                        Report
                    </button>
                </div>
            </div>
        </div>

        <!-- KPI Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6 sm:mb-8">
            <!-- Total Users Card -->
            <div
                class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4 sm:p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mb-1">Total Users</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">
                            {{ $stats['total_users'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                        <i class="bx bx-user text-2xl text-blue-600 dark:text-blue-400"></i>
                    </div>
                </div>
                <div class="flex items-center text-xs sm:text-sm text-green-600 dark:text-green-400">
                    <i class="bx bx-trending-up mr-1"></i>
                    <span>+12% this month</span>
                </div>
            </div>

            <!-- Active Contributors Card -->
            <div
                class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4 sm:p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mb-1">Active Contributors</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">
                            {{ $stats['active_contributors'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                        <i class="bx bx-user-check text-2xl text-green-600 dark:text-green-400"></i>
                    </div>
                </div>
                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Students, lecturers, and researchers</p>
            </div>

            <!-- Pending Resources Card -->
            <div
                class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4 sm:p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mb-1">Pending Resources</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">
                            {{ $stats['pending_resources'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/20 rounded-lg flex items-center justify-center">
                        <i class="bx bx-time text-2xl text-amber-600 dark:text-amber-400"></i>
                    </div>
                </div>
                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Awaiting approval</p>
            </div>

            <!-- Pending Research Works Card -->
            <div
                class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4 sm:p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mb-1">Pending Research</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">
                            {{ $stats['pending_research_works'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/20 rounded-lg flex items-center justify-center">
                        <i class="bx bx-file-find text-2xl text-purple-600 dark:text-purple-400"></i>
                    </div>
                </div>
                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">In review</p>
            </div>
        </div>

        <!-- Growth Chart -->
        <div class="mb-6 sm:mb-8">
            <div
                class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4 sm:p-6">
                <div class="mb-6">
                    <h2 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white mb-1">Growth Overview</h2>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">User growth and content submissions</p>
                </div>
                <div
                    class="h-64 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 rounded-lg flex items-center justify-center border border-gray-200 dark:border-gray-700">
                    <div class="text-center">
                        <i class="bx bx-line-chart text-4xl text-gray-300 dark:text-gray-600 mb-2"></i>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Chart visualization</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Table -->
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4 mb-6">
                <div>
                    <h2 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white mb-1">Recent Content</h2>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Latest submissions and activity</p>
                </div>
                <form method="GET" class="flex flex-wrap items-center gap-2 sm:gap-3">
                    <select name="status" onchange="this.form.submit()"
                        class="text-xs sm:text-sm border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-lg px-4 py-2.5 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 hover:border-gray-300 dark:hover:border-gray-600 transition-colors cursor-pointer font-medium appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 fill=%27none%27 viewBox=%270 0 20 20%27%3E%3Cpath stroke=%27%236B7280%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27 stroke-width=%271.5%27 d=%27m6 8 4 4 4-4%27/%3E%3C/svg%3E')] bg-[length:1.25rem] bg-[center_right_0.5rem] bg-no-repeat">
                        <option value="all" {{ $statusFilter === 'all' ? 'selected' : '' }}>All statuses</option>
                        <option value="pending" {{ $statusFilter === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ $statusFilter === 'approved' ? 'selected' : '' }}>Approved</option>
                    </select>
                    <select name="type" onchange="this.form.submit()"
                        class="text-xs sm:text-sm border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-lg px-4 py-2.5 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 hover:border-gray-300 dark:hover:border-gray-600 transition-colors cursor-pointer font-medium appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 fill=%27none%27 viewBox=%270 0 20 20%27%3E%3Cpath stroke=%27%236B7280%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27 stroke-width=%271.5%27 d=%27m6 8 4 4 4-4%27/%3E%3C/svg%3E')] bg-[length:1.25rem] bg-[center_right_0.5rem] bg-no-repeat">
                        <option value="all" {{ $typeFilter === 'all' ? 'selected' : '' }}>All types</option>
                        <option value="resource" {{ $typeFilter === 'resource' ? 'selected' : '' }}>Resources</option>
                        <option value="research_work" {{ $typeFilter === 'research_work' ? 'selected' : '' }}>Research Works</option>
                    </select>
                </form>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th
                                class="text-left py-2 sm:py-3 px-3 sm:px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
                                Title</th>
                            <th
                                class="text-left py-2 sm:py-3 px-3 sm:px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
                                Author</th>
                            <th
                                class="text-left py-2 sm:py-3 px-3 sm:px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
                                Type</th>
                            <th
                                class="text-left py-2 sm:py-3 px-3 sm:px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
                                Submitted</th>
                            <th
                                class="text-left py-2 sm:py-3 px-3 sm:px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
                                Status</th>
                            <th
                                class="text-left py-2 sm:py-3 px-3 sm:px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
                                Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contentItems as $item)
                            <tr
                                class="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                <td class="py-3 px-3 sm:px-4">
                                    <p class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white truncate">
                                        {{ $item['title'] }}</p>
                                </td>
                                <td class="py-3 px-3 sm:px-4">
                                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">{{ $item['author'] }}
                                    </p>
                                </td>
                                <td class="py-3 px-3 sm:px-4">
                                    <span
                                        class="px-2 py-1 bg-blue-100 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 text-xs font-medium rounded">{{ ucfirst(str_replace('_', ' ', $item['type'])) }}</span>
                                </td>
                                <td class="py-3 px-3 sm:px-4">
                                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">
                                        {{ optional($item['created_at'])->format('M d, Y') }}</p>
                                </td>
                                <td class="py-3 px-3 sm:px-4">
                                    @if ($item['status'] === 'approved')
                                        <span
                                            class="px-2 py-1 bg-green-100 dark:bg-green-900/20 text-green-700 dark:text-green-400 text-xs font-medium rounded">Approved</span>
                                    @else
                                        <span
                                            class="px-2 py-1 bg-amber-100 dark:bg-amber-900/20 text-amber-700 dark:text-amber-400 text-xs font-medium rounded">Pending</span>
                                    @endif
                                </td>
                                <td class="py-3 px-3 sm:px-4">
                                    <div class="flex items-center gap-2">
                                        @if ($item['status'] === 'pending')
                                            @if ($item['type'] === 'resource')
                                                <form method="POST"
                                                    action="{{ route('api.admin.resources.approve', $item['model']) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button
                                                        class="text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 text-xs sm:text-sm font-semibold">Approve</button>
                                                </form>
                                            @else
                                                <form method="POST"
                                                    action="{{ route('api.admin.research-works.approve', $item['model']) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button
                                                        class="text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 text-xs sm:text-sm font-semibold">Approve</button>
                                                </form>
                                            @endif
                                        @endif

                                        @if ($item['type'] === 'resource')
                                            <button onclick="deleteItem('{{ route('api.admin.resources.delete', $item['model']) }}', this.closest('tr'))"
                                                class="text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 text-xs sm:text-sm font-semibold">Delete</button>
                                            <a href="{{ route('resources.show', $item['model']) }}"
                                                class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300"
                                                title="View">
                                                <i class="bx bx-show text-lg"></i>
                                            </a>
                                        @else
                                            <button onclick="deleteItem('{{ route('api.admin.research-works.delete', $item['model']) }}', this.closest('tr'))"
                                                class="text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 text-xs sm:text-sm font-semibold">Delete</button>
                                            <a href="{{ route('research.show', $item['model']) }}"
                                                class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300"
                                                title="View">
                                                <i class="bx bx-show text-lg"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 px-4 text-center">
                                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">No content available</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($contentItems->hasPages())
                <div class="px-4 py-3 border-t border-gray-100 dark:border-gray-800">
                    {{ $contentItems->appends(['status' => $statusFilter, 'type' => $typeFilter])->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
<script>
function deleteItem(url, rowElement) {
    showConfirmToast('Are you sure you want to delete this item?', function() {
        performDelete(url, rowElement);
    });
}

function performDelete(url, rowElement) {
    fetch(url, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success || data.message) {
            rowElement.style.transition = 'opacity 0.3s ease-out';
            rowElement.style.opacity = '0';
            setTimeout(() => {
                rowElement.remove();
            }, 300);
            showToast('Item deleted successfully', 'success');
        } else {
            showToast(data.message || 'Failed to delete item', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('An error occurred while deleting', 'error');
    });
}

function showConfirmToast(message, onConfirm) {
    const toastContainer = document.createElement('div');
    toastContainer.className = 'fixed bottom-20 right-4 bg-amber-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 flex items-center gap-4 animate-slide-in';
    
    toastContainer.innerHTML = `
        <div class="flex items-center gap-3 flex-1">
            <i class="bx bx-info-circle text-lg flex-shrink-0"></i>
            <span class="text-sm font-medium">${message}</span>
        </div>
        <div class="flex gap-2 flex-shrink-0">
            <button onclick="this.closest('[data-toast]').remove(); ${onConfirm.toString()}()" class="px-4 py-1.5 bg-white/20 hover:bg-white/30 rounded text-xs font-semibold transition-colors whitespace-nowrap">Confirm</button>
            <button onclick="this.closest('[data-toast]').remove()" class="px-4 py-1.5 bg-white/10 hover:bg-white/20 rounded text-xs font-semibold transition-colors whitespace-nowrap">Cancel</button>
        </div>
    `;
    toastContainer.setAttribute('data-toast', 'true');
    
    document.body.appendChild(toastContainer);
}

function showToast(message, type = 'info', duration = 3000) {
    const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
    const icon = type === 'success' ? 'bx-check-circle' : type === 'error' ? 'bx-error-circle' : 'bx-bell';
    
    const toast = document.createElement('div');
    toast.className = `fixed bottom-20 right-4 ${bgColor} text-white px-6 py-4 rounded-lg shadow-lg z-50 flex items-center gap-3 animate-slide-in`;
    toast.setAttribute('data-toast', 'true');
    
    toast.innerHTML = `
        <i class="bx ${icon} text-lg flex-shrink-0"></i>
        <span class="text-sm font-medium">${message}</span>
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.transition = 'opacity 0.3s ease-out';
        toast.style.opacity = '0';
        setTimeout(() => toast.remove(), 300);
    }, duration);
}

const style = document.createElement('style');
style.textContent = `
    @keyframes slide-in {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    .animate-slide-in {
        animation: slide-in 0.3s ease-out;
    }
`;
document.head.appendChild(style);
</script>
@endsection
