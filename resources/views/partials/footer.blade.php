<footer class="bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 border-t border-gray-200 dark:border-gray-800 py-12 sm:py-16 mt-16 sm:mt-20 md:pl-56">
    <div class="px-4 sm:px-6 lg:px-8">
        <!-- Main Footer Content -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 sm:gap-12 mb-8 sm:mb-12 pb-8 sm:pb-12 border-b border-gray-200 dark:border-gray-800">
            <!-- About NoteVault -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">About NoteVault</h3>
                <p class="text-sm leading-relaxed text-gray-600 dark:text-gray-400">A notes and research publishing platform for university communities. Share course resources and publish research within your institution.</p>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Links</h3>
                <ul class="space-y-3 text-sm">
                    <li>
                        <a href="{{ route('resources.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Resources</a>
                    </li>
                    <li>
                        <a href="{{ route('research.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Research</a>
                    </li>
                    <li>
                        <a href="{{ route('departments.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Departments</a>
                    </li>
                    <li>
                        <a href="{{ route('creators.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">People</a>
                    </li>
                </ul>
            </div>

            <!-- Legal -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Legal</h3>
                <ul class="space-y-3 text-sm">
                    <li>
                        <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Privacy Policy</a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Terms of Service</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Copyright -->
        <div class="text-center text-sm text-gray-500 dark:text-gray-600">
            <p>&copy; 2026 NoteVault. All rights reserved.</p>
        </div>
    </div>
</footer>
