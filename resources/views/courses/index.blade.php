@extends('layouts.app')

@section('title', 'Courses - NoteVault')
@section('pageTitle', 'Courses')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Courses</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Browse courses and their course units</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 mb-6">
        <form action="{{ route('courses.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <div class="relative">
                    <i class="bx bx-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search courses by name or code..."
                           class="w-full pl-10 pr-4 py-2 border border-gray-200 dark:border-gray-600 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                </div>
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                Search
            </button>
        </form>
    </div>

    @if ($courses->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($courses as $course)
                <a href="{{ route('courses.show', $course) }}"
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md hover:border-blue-400 dark:hover:border-blue-500 transition-all">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center flex-shrink-0">
                            <i class="bx bx-book-bookmark text-lg text-blue-600 dark:text-blue-400"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">{{ $course->name }}</h3>
                    </div>
                    @if ($course->code)
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">{{ $course->code }}</p>
                    @endif
                    @if ($course->department)
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">{{ $course->department->name }}</p>
                    @endif
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $course->course_units_count }} {{ Str::plural('course unit', $course->course_units_count) }}</p>
                </a>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $courses->links() }}
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-12 text-center">
            <i class="bx bx-book-bookmark text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No courses found</h3>
            <p class="text-gray-500 dark:text-gray-400">Try adjusting your search criteria</p>
        </div>
    @endif
</div>
@endsection
