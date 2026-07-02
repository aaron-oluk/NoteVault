<!-- Top Header Bar -->
<header
    class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 fixed top-0 left-0 right-0 md:left-56 z-40">
    <div class="px-4 sm:px-6 lg:px-8 flex items-center justify-between h-14">
        <!-- Page Title -->
        <div class="flex items-center">
            <h1 class="text-base font-semibold text-gray-900 dark:text-white">@yield('pageTitle', 'Dashboard')</h1>
        </div>

        <!-- Search Bar (Centered) -->
        <div class="flex-1 max-w-lg mx-8 hidden sm:block">
            <form action="{{ route('search') }}" method="GET">
                <div class="relative">
                    <i
                        class="bx bx-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500 text-lg"></i>
                    <input type="text" name="q" placeholder="Search resources, research, or people..."
                        value="{{ request('q') }}"
                        class="w-full pl-10 pr-4 py-2 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-full focus:border-blue-500 dark:focus:border-blue-400 focus:bg-white dark:focus:bg-gray-900 focus:outline-none text-sm placeholder-gray-400 dark:placeholder-gray-500 text-gray-900 dark:text-white">
                </div>
            </form>
        </div>

        <!-- Right Side Actions -->
        <div class="flex items-center space-x-2">
            <!-- Dark Mode Toggle -->
            <button onclick="toggleDarkMode()" id="theme-toggle"
                class="relative p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors w-10 h-10 flex items-center justify-center">
                <i class="bx bx-moon text-xl absolute" id="theme-toggle-dark-icon" style="display: block;"></i>
                <i class="bx bx-sun text-xl absolute" id="theme-toggle-light-icon" style="display: none;"></i>
            </button>

            @auth
                <!-- Notifications Dropdown -->
                <div class="relative" data-notifications-dropdown>
                    <button data-notifications-toggle
                        class="relative p-2 text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-colors">
                        <i class="bx bx-bell text-xl"></i>
                        <span id="notifications-badge" class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full hidden"></span>
                    </button>
                    <div id="notifications-menu" style="display: none;"
                        class="absolute right-0 mt-2 w-80 sm:w-96 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50 max-h-96 overflow-hidden flex flex-col">
                        <!-- Header -->
                        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Notifications</h3>
                            <button id="mark-all-read" class="text-xs text-blue-600 dark:text-blue-400 hover:underline">
                                Mark all as read
                            </button>
                        </div>
                        <!-- Notifications List -->
                        <div id="notifications-list" class="overflow-y-auto flex-1">
                            <div class="px-4 py-8 text-center">
                                <i class="bx bx-loader-alt bx-spin text-2xl text-gray-400"></i>
                            </div>
                        </div>
                        <!-- Footer -->
                        <div class="px-4 py-2 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
                            <p class="text-xs text-center text-gray-500 dark:text-gray-400">
                                <span id="unread-count">0</span> unread notifications
                            </p>
                        </div>
                    </div>
                </div>

                <!-- User Dropdown -->
                <div class="relative" data-dropdown>
                    <button data-dropdown-toggle
                        class="flex items-center space-x-2 p-1.5 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                        <div
                            class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm font-medium">
                            {{ strtoupper(substr(auth()->user()->first_name ?? 'U', 0, 1)) }}
                        </div>
                        <i class="bx bx-chevron-down text-gray-400 dark:text-gray-500"></i>
                    </button>
                    <div data-dropdown-menu style="display: none;"
                        class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 py-1 z-50">
                        <a href="{{ route('profile') }}"
                            class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <i class="bx bx-user mr-2"></i> Profile
                        </a>
                        <a href="{{ route('settings.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <i class="bx bx-cog mr-2"></i> Settings
                        </a>
                        @if (auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}"
                                class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <i class="bx bx-shield mr-2"></i> Admin
                            </a>
                        @endif
                        <hr class="my-1 border-gray-200 dark:border-gray-700">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <i class="bx bx-log-out mr-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <!-- Login/Signup Buttons -->
                <a href="{{ route('login') }}"
                    class="text-sm font-medium text-gray-600 hover:text-gray-900 px-3 py-2 rounded-lg hover:bg-gray-50 transition-colors">
                    Log In
                </a>
                <a href="{{ route('register') }}"
                    class="hidden sm:inline-block bg-blue-600 text-white px-4 py-2 text-sm font-medium hover:bg-blue-700 rounded-lg transition-colors">
                    Sign Up
                </a>
            @endauth
        </div>
    </div>
</header>
