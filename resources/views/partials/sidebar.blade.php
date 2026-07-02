<!-- Desktop Sidebar Navigation -->
<div
    class="hidden md:flex md:flex-col md:w-56 md:fixed md:inset-y-0 md:bg-white dark:md:bg-gray-900 md:border-r md:border-gray-200 dark:md:border-gray-800 md:z-30">
    <!-- Logo -->
    <div class="px-5 py-5 border-b border-gray-100 dark:border-gray-800">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                <i class="bx bx-book-open text-white text-base"></i>
            </div>
            <div>
                <span class="text-base font-bold text-gray-900 dark:text-white">NoteVault</span>
                <p class="text-[10px] text-gray-500 dark:text-gray-400 -mt-0.5">Notes and research, organized by institution</p>
            </div>
        </a>
    </div>

    <!-- Navigation Menu -->
    <div class="flex-1 flex flex-col min-h-0 overflow-y-auto sidebar-scroll">
        <nav class="flex-1 px-3 py-4">
            <div class="space-y-0.5">
                <a href="{{ auth()->check() ? route('dashboard') : url('/') }}"
                    class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('dashboard') || request()->is('/') ? 'bg-blue-50 dark:bg-gray-800 text-blue-700 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                    <i
                        class="bx bx-home-alt mr-3 text-lg {{ request()->routeIs('dashboard') || request()->is('/') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400 dark:text-gray-500' }}"></i>
                    Home
                </a>

                <a href="{{ route('resources.index') }}"
                    class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('resources.*') ? 'bg-blue-50 dark:bg-gray-800 text-blue-700 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                    <i
                        class="bx bx-book-bookmark mr-3 text-lg {{ request()->routeIs('resources.*') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400 dark:text-gray-500' }}"></i>
                    Resources
                </a>

                <a href="{{ route('research.index') }}"
                    class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('research.*') ? 'bg-purple-50 dark:bg-purple-900/20 text-purple-700 dark:text-purple-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                    <i
                        class="bx bx-file-find mr-3 text-lg {{ request()->routeIs('research.*') ? 'text-purple-600 dark:text-purple-400' : 'text-gray-400 dark:text-gray-500' }}"></i>
                    Research
                </a>

                <a href="{{ route('departments.index') }}"
                    class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('departments.*') || request()->routeIs('courses.*') ? 'bg-blue-50 dark:bg-gray-800 text-blue-700 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                    <i
                        class="bx bx-buildings mr-3 text-lg {{ request()->routeIs('departments.*') || request()->routeIs('courses.*') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400 dark:text-gray-500' }}"></i>
                    Departments
                </a>

                <a href="{{ route('creators.index') }}"
                    class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('creators.*') || request()->routeIs('profile.creator') ? 'bg-blue-50 dark:bg-gray-800 text-blue-700 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                    <i
                        class="bx bx-user-circle mr-3 text-lg {{ request()->routeIs('creators.*') || request()->routeIs('profile.creator') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400 dark:text-gray-500' }}"></i>
                    Lecturers and Researchers
                </a>

                @auth
                    @if(auth()->user()->role === 'admin')
                        <!-- Admin Section -->
                        <div class="pt-4 mt-4 border-t border-gray-200 dark:border-gray-700">
                            <p class="px-3 mb-2 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Admin</p>

                            <a href="{{ route('admin.dashboard') }}"
                                class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 dark:bg-gray-800 text-blue-700 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                                <i class="bx bx-tachometer mr-3 text-lg {{ request()->routeIs('admin.dashboard') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400 dark:text-gray-500' }}"></i>
                                Dashboard
                            </a>

                            <a href="{{ route('admin.users') }}"
                                class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.users*') ? 'bg-blue-50 dark:bg-gray-800 text-blue-700 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                                <i class="bx bx-user mr-3 text-lg {{ request()->routeIs('admin.users*') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400 dark:text-gray-500' }}"></i>
                                Users
                            </a>

                            @if (Route::has('admin.institutions'))
                                <a href="{{ route('admin.institutions') }}"
                                    class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.institutions*') ? 'bg-blue-50 dark:bg-gray-800 text-blue-700 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                                    <i class="bx bx-buildings mr-3 text-lg {{ request()->routeIs('admin.institutions*') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400 dark:text-gray-500' }}"></i>
                                    Institutions
                                </a>
                            @endif

                            <a href="{{ route('admin.reports') }}"
                                class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.reports*') ? 'bg-blue-50 dark:bg-gray-800 text-blue-700 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                                <i class="bx bx-bar-chart-alt-2 mr-3 text-lg {{ request()->routeIs('admin.reports*') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400 dark:text-gray-500' }}"></i>
                                Reports & Analytics
                            </a>
                        </div>
                    @endif
                @endauth
            </div>
        </nav>

        <!-- Bottom Section -->
        <div class="px-3 pb-4 mt-auto">
            @auth
                <!-- Settings -->
                <a href="{{ route('settings.index') }}"
                    class="flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors mb-3 {{ request()->routeIs('settings.*') ? 'bg-blue-50 dark:bg-gray-800 text-blue-700 dark:text-blue-400' : '' }}">
                    <i
                        class="bx bx-cog mr-3 text-lg {{ request()->routeIs('settings.*') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400 dark:text-gray-500' }}"></i>
                    Settings
                </a>

                <!-- User Profile -->
                @php
                    $roleLabels = ['student' => 'Student', 'lecturer' => 'Lecturer', 'researcher' => 'Researcher', 'admin' => 'Administrator'];
                @endphp
                <a href="{{ route('profile') }}"
                    class="flex items-center gap-3 px-3 py-2 border-t border-gray-100 dark:border-gray-800 pt-4 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-colors">
                    <div
                        class="w-9 h-9 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm font-medium">
                        {{ strtoupper(substr(auth()->user()->first_name ?? 'U', 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                            {{ auth()->user()->first_name ?? 'User' }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                            {{ $roleLabels[auth()->user()->role] ?? 'Member' }}</p>
                    </div>
                </a>
            @endauth
        </div>
    </div>
</div>
