<!-- Mobile Bottom Navigation -->
<nav
    class="md:hidden fixed bottom-0 left-0 right-0 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 z-50 safe-area-bottom">
    <div class="flex justify-between items-center py-2 px-4 max-w-lg mx-auto">
        <a href="{{ auth()->check() ? route('dashboard') : url('/') }}"
            class="flex flex-col items-center justify-center min-w-0 flex-1 py-1.5 rounded-lg transition-colors {{ request()->routeIs('dashboard') || request()->is('/') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400' }}">
            <i
                class="bx {{ request()->routeIs('dashboard') || request()->is('/') ? 'bxs-home' : 'bx-home-alt' }} text-[22px]"></i>
            <span class="text-[10px] font-medium mt-0.5">Home</span>
        </a>
        <a href="{{ route('resources.index') }}"
            class="flex flex-col items-center justify-center min-w-0 flex-1 py-1.5 rounded-lg transition-colors {{ request()->routeIs('resources.*') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400' }}">
            <i
                class="bx {{ request()->routeIs('resources.*') ? 'bxs-book' : 'bx-book' }} text-[22px]"></i>
            <span class="text-[10px] font-medium mt-0.5">Resources</span>
        </a>
        <a href="{{ route('research.index') }}"
            class="flex flex-col items-center justify-center min-w-0 flex-1 py-1.5 rounded-lg transition-colors {{ request()->routeIs('research.*') ? 'text-purple-600 dark:text-purple-400' : 'text-gray-500 dark:text-gray-400' }}">
            <i
                class="bx {{ request()->routeIs('research.*') ? 'bxs-file-find' : 'bx-file-find' }} text-[22px]"></i>
            <span class="text-[10px] font-medium mt-0.5">Research</span>
        </a>
        <a href="{{ route('creators.index') }}"
            class="flex flex-col items-center justify-center min-w-0 flex-1 py-1.5 rounded-lg transition-colors {{ request()->routeIs('creators.*') || request()->routeIs('profile.creator') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400' }}">
            <i
                class="bx {{ request()->routeIs('creators.*') || request()->routeIs('profile.creator') ? 'bxs-user-circle' : 'bx-user-circle' }} text-[22px]"></i>
            <span class="text-[10px] font-medium mt-0.5">People</span>
        </a>
        @auth
            <a href="{{ route('profile') }}"
                class="flex flex-col items-center justify-center min-w-0 flex-1 py-1.5 rounded-lg transition-colors {{ request()->routeIs('profile') || request()->routeIs('profile.edit') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400' }}">
                <i
                    class="bx {{ request()->routeIs('profile') || request()->routeIs('profile.edit') ? 'bxs-user' : 'bx-user' }} text-[22px]"></i>
                <span class="text-[10px] font-medium mt-0.5">Profile</span>
            </a>
        @endauth
    </div>
</nav>
