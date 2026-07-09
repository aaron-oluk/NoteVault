@extends('layouts.app')

@section('title', 'Settings - NoteVault')
@section('pageTitle', 'Settings')

@section('content')
<div class="max-w-4xl mx-auto px-3 sm:px-4 py-4 sm:py-8">
    <!-- Page Header -->
    <div class="mb-6 sm:mb-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2">Settings</h1>
        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Manage your account preferences and settings</p>
    </div>

    <!-- Settings Navigation Tabs -->
    <div class="mb-6 sm:mb-8">
        <div class="overflow-x-auto">
            <nav class="flex space-x-2 sm:space-x-4 whitespace-nowrap">
                <button onclick="switchTab('profile')" id="profile-tab"
                    class="settings-tab px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 transition-colors">
                    Profile
                </button>
                <button onclick="switchTab('password')" id="password-tab"
                    class="settings-tab px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    Password
                </button>
                <button onclick="switchTab('danger')" id="danger-tab"
                    class="settings-tab px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    Danger Zone
                </button>
            </nav>
        </div>
    </div>

    <!-- Profile Tab -->
    <div id="profile-content" class="settings-content">
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
            <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/50">
                <div class="flex items-center gap-2 mb-2">
                    <i class="bx bx-user text-lg text-gray-600 dark:text-gray-400"></i>
                    <h2 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white">Profile Information</h2>
                </div>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Update your account's profile information and email address.</p>
            </div>
            <form action="{{ route('settings.profile.update') }}" method="POST" class="p-4 sm:p-6 space-y-4">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="first_name" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">First Name</label>
                        <input type="text" name="first_name" id="first_name"
                               value="{{ old('first_name', auth()->user()->first_name) }}"
                               class="w-full px-3 sm:px-4 py-2 text-xs sm:text-sm border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                        @error('first_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="last_name" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Last Name</label>
                        <input type="text" name="last_name" id="last_name"
                               value="{{ old('last_name', auth()->user()->last_name) }}"
                               class="w-full px-3 sm:px-4 py-2 text-xs sm:text-sm border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                        @error('last_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Address</label>
                    <input type="email" name="email" id="email"
                           value="{{ old('email', auth()->user()->email) }}"
                           class="w-full px-3 sm:px-4 py-2 text-xs sm:text-sm border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="px-4 sm:px-6 py-2 bg-blue-600 text-white text-xs sm:text-sm rounded-lg hover:bg-blue-700 transition-colors font-medium">
                        Save Changes
                    </button>
                </div>

                @if(session('status') === 'profile-updated')
                    <div class="p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                        <p class="text-green-700 dark:text-green-300 text-xs sm:text-sm font-medium">✓ Profile updated successfully.</p>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Password Tab -->
    <div id="password-content" class="settings-content hidden">
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
            <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/50">
                <div class="flex items-center gap-2 mb-2">
                    <i class="bx bx-lock text-lg text-gray-600 dark:text-gray-400"></i>
                    <h2 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white">Update Password</h2>
                </div>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Ensure your account is using a long, random password to stay secure.</p>
            </div>
            <form action="{{ route('settings.password.update') }}" method="POST" class="p-4 sm:p-6 space-y-4">
                @csrf
                @method('PATCH')

                <div>
                    <label for="current_password" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Current Password</label>
                    <input type="password" name="current_password" id="current_password"
                           class="w-full px-3 sm:px-4 py-2 text-xs sm:text-sm border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    @error('current_password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">New Password</label>
                    <input type="password" name="password" id="password"
                           class="w-full px-3 sm:px-4 py-2 text-xs sm:text-sm border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="w-full px-3 sm:px-4 py-2 text-xs sm:text-sm border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="px-4 sm:px-6 py-2 bg-blue-600 text-white text-xs sm:text-sm rounded-lg hover:bg-blue-700 transition-colors font-medium">
                        Update Password
                    </button>
                </div>

                @if(session('status') === 'password-updated')
                    <div class="p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                        <p class="text-green-700 dark:text-green-300 text-xs sm:text-sm font-medium">✓ Password updated successfully.</p>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Danger Zone Tab -->
    <div id="danger-content" class="settings-content hidden">
        <div class="rounded-xl border-2 border-red-200 dark:border-red-900/40 overflow-hidden">
            <div class="px-4 sm:px-6 py-4 sm:py-5 bg-gradient-to-r from-red-50 to-red-50/50 dark:from-red-900/20 dark:to-red-900/10 border-b border-red-200 dark:border-red-900/40">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-red-100 dark:bg-red-900/40 flex items-center justify-center flex-shrink-0">
                        <i class="bx bx-error text-lg text-red-600 dark:text-red-400"></i>
                    </div>
                    <div>
                        <h2 class="text-base sm:text-lg font-semibold text-red-900 dark:text-red-300">Danger Zone</h2>
                        <p class="text-xs sm:text-sm text-red-700 dark:text-red-400">Irreversible and destructive actions. Please proceed with caution.</p>
                    </div>
                </div>
            </div>
            <div class="p-4 sm:p-6 bg-white dark:bg-gray-900">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 p-4 sm:p-5 border border-gray-200 dark:border-gray-800 rounded-lg">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-lg bg-red-50 dark:bg-red-900/20 flex items-center justify-center flex-shrink-0">
                            <i class="bx bx-trash text-lg text-red-600 dark:text-red-400"></i>
                        </div>
                        <div>
                            <h3 class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white">Delete Account</h3>
                            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">Permanently delete your account, your uploaded resources, and your research works. This cannot be undone.</p>
                        </div>
                    </div>
                    <button onclick="confirmDelete()" class="px-4 py-2 bg-red-600 text-white text-xs sm:text-sm rounded-lg hover:bg-red-700 transition-colors font-medium whitespace-nowrap flex-shrink-0">
                        Delete Account
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl max-w-md w-full p-6 border border-gray-100 dark:border-gray-800">
        <div class="w-12 h-12 rounded-full bg-red-100 dark:bg-red-900/40 flex items-center justify-center mb-4">
            <i class="bx bx-error text-2xl text-red-600 dark:text-red-400"></i>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Delete your account?</h3>
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">This permanently removes your account and everything tied to it. This action cannot be undone.</p>
        <ul class="text-sm text-gray-500 dark:text-gray-400 mb-6 space-y-1.5">
            <li class="flex items-center gap-2"><i class="bx bx-x text-red-500"></i> Your profile and login access</li>
            <li class="flex items-center gap-2"><i class="bx bx-x text-red-500"></i> Resources and research works you have published</li>
            <li class="flex items-center gap-2"><i class="bx bx-x text-red-500"></i> Comments, upvotes, and follows tied to your account</li>
        </ul>
        <form action="{{ route('profile.destroy') }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="mb-4">
                <label for="delete_password" class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Enter your password to confirm</label>
                <input type="password" name="password" id="delete_password" required
                       class="w-full px-3 sm:px-4 py-2 text-xs sm:text-sm border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-red-500 focus:ring-1 focus:ring-red-500">
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-xs sm:text-sm rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white text-xs sm:text-sm rounded-lg hover:bg-red-700 transition-colors font-medium">
                    Delete Account
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
function switchTab(tab) {
    // Update tab buttons
    document.querySelectorAll('.settings-tab').forEach(btn => {
        btn.classList.remove('bg-blue-100', 'dark:bg-blue-900/30', 'text-blue-600', 'dark:text-blue-400');
        btn.classList.add('text-gray-500', 'dark:text-gray-400');
    });

    const activeTab = document.getElementById(tab + '-tab');
    activeTab.classList.remove('text-gray-500', 'dark:text-gray-400');
    activeTab.classList.add('bg-blue-100', 'dark:bg-blue-900/30', 'text-blue-600', 'dark:text-blue-400');

    // Update content
    document.querySelectorAll('.settings-content').forEach(content => {
        content.classList.add('hidden');
    });
    document.getElementById(tab + '-content').classList.remove('hidden');
}

function confirmDelete() {
    const modal = document.getElementById('deleteModal');
    if (modal) modal.classList.replace('hidden', 'flex');
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    if (modal) modal.classList.replace('flex', 'hidden');
}
</script>
@endsection
