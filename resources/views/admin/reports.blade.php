@extends('layouts.app')

@section('title', 'Reports & Analytics - Admin')

@section('content')
    <div class="max-w-7xl mx-auto px-3 sm:px-4 py-4 sm:py-8">
        <!-- Page Header -->
        <div class="mb-6 sm:mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2">Reports & Analytics</h1>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Platform insights and statistics</p>
                </div>
                <form method="GET" class="flex items-center gap-2">
                    <select name="period" onchange="this.form.submit()"
                        class="px-4 py-2.5 pr-10 text-sm border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 hover:border-gray-300 dark:hover:border-gray-600 transition-colors cursor-pointer font-medium appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 fill=%27none%27 viewBox=%270 0 20 20%27%3E%3Cpath stroke=%27%236B7280%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27 stroke-width=%271.5%27 d=%27m6 8 4 4 4-4%27/%3E%3C/svg%3E')] bg-[length:1.25rem] bg-[center_right_0.5rem] bg-no-repeat">
                        <option value="7" {{ $period == '7' ? 'selected' : '' }}>Last 7 days</option>
                        <option value="30" {{ $period == '30' ? 'selected' : '' }}>Last 30 days</option>
                        <option value="90" {{ $period == '90' ? 'selected' : '' }}>Last 90 days</option>
                        <option value="365" {{ $period == '365' ? 'selected' : '' }}>Last year</option>
                    </select>
                </form>
            </div>
        </div>

        <!-- Content Stats -->
        <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 mb-6">
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Resources</h3>
                    <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                        <i class="bx bx-book-bookmark text-lg text-blue-600 dark:text-blue-400"></i>
                    </div>
                </div>
                <p class="text-2xl font-bold text-gray-900 dark:text-white mb-1">{{ $contentStats['total_resources'] }}</p>
                <div class="flex items-center gap-2 text-xs">
                    <span class="text-green-600 dark:text-green-400">+{{ $contentStats['new_resources'] }} new</span>
                    <span class="text-gray-400">|</span>
                    <span class="text-amber-600 dark:text-amber-400">{{ $contentStats['pending_resources'] }} pending</span>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Research Works</h3>
                    <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900/20 rounded-lg flex items-center justify-center">
                        <i class="bx bx-file-find text-lg text-purple-600 dark:text-purple-400"></i>
                    </div>
                </div>
                <p class="text-2xl font-bold text-gray-900 dark:text-white mb-1">{{ $contentStats['total_research_works'] }}</p>
                <div class="flex items-center gap-2 text-xs">
                    <span class="text-green-600 dark:text-green-400">+{{ $contentStats['new_research_works'] }} new</span>
                    <span class="text-gray-400">|</span>
                    <span class="text-amber-600 dark:text-amber-400">{{ $contentStats['pending_research_works'] }} pending</span>
                </div>
            </div>
        </div>

        <!-- User Growth Chart -->
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4 sm:p-6 mb-6">
            <h2 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white mb-4">User Growth</h2>
            <div class="h-64 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 rounded-lg flex items-center justify-center border border-gray-200 dark:border-gray-700">
                <div class="text-center">
                    <i class="bx bx-line-chart text-4xl text-gray-300 dark:text-gray-600 mb-2"></i>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">User growth visualization</p>
                    @if($userGrowth->count() > 0)
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">{{ $userGrowth->sum('count') }} new users in the last {{ $period }} days</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Top Contributors -->
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-800">
                <h2 class="text-base font-semibold text-gray-900 dark:text-white">Top Contributors</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Rank</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Contributor</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Resources</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Research Works</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse($topContributors as $index => $contributor)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                <td class="py-3 px-4">
                                    <span class="text-sm font-bold text-gray-500 dark:text-gray-400">#{{ $index + 1 }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm font-medium">
                                            {{ strtoupper(substr($contributor->first_name ?? 'U', 0, 1)) }}
                                        </div>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $contributor->first_name ?? 'User' }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $contributor->resources_count }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $contributor->research_works_count }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $contributor->resources_count + $contributor->research_works_count }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">No contributors found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
