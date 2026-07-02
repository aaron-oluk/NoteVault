@extends('layouts.app')

@section('title', $department->name . ' - NoteVault')
@section('pageTitle', $department->name)

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('departments.index') }}" class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white text-sm">
            <i class="bx bx-arrow-back text-base mr-1"></i>
            Back to departments
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-12 h-12 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center flex-shrink-0">
                <i class="bx bx-buildings text-2xl text-blue-600 dark:text-blue-400"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $department->name }}</h1>
                @if ($department->code)
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $department->code }}</p>
                @endif
            </div>
        </div>
        @if ($department->institution)
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ $department->institution->name }}</p>
        @endif
    </div>

    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Courses</h2>
    @if ($department->courses->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($department->courses as $course)
                <a href="{{ route('courses.show', $course) }}"
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 hover:shadow-md hover:border-blue-400 dark:hover:border-blue-500 transition-all">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-1">{{ $course->name }}</h3>
                    @if ($course->code)
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">{{ $course->code }}</p>
                    @endif
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $course->courseUnits->count() }} {{ Str::plural('course unit', $course->courseUnits->count()) }}</p>
                </a>
            @endforeach
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-12 text-center">
            <i class="bx bx-book-bookmark text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No courses yet</h3>
            <p class="text-gray-500 dark:text-gray-400">This department has no courses listed yet.</p>
        </div>
    @endif
</div>
@endsection
