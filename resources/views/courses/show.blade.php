@extends('layouts.app')

@section('title', $course->name . ' - NoteVault')
@section('pageTitle', $course->name)

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('courses.index') }}" class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white text-sm">
            <i class="bx bx-arrow-back text-base mr-1"></i>
            Back to courses
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-12 h-12 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center flex-shrink-0">
                <i class="bx bx-book-bookmark text-2xl text-blue-600 dark:text-blue-400"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $course->name }}</h1>
                @if ($course->code)
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $course->code }}</p>
                @endif
            </div>
        </div>
        <div class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400 mt-2">
            @if ($course->department)
                <span>{{ $course->department->name }}</span>
                <span class="text-gray-400 dark:text-gray-600">&middot;</span>
            @endif
            @if ($course->institution)
                <span>{{ $course->institution->name }}</span>
            @endif
        </div>
    </div>

    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Course Units</h2>
    @if ($course->courseUnits->count() > 0)
        <div class="space-y-6">
            @foreach ($course->courseUnits as $courseUnit)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white">{{ $courseUnit->name }}</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                @if ($courseUnit->code) {{ $courseUnit->code }} @endif
                                @if ($courseUnit->semester) &middot; {{ $courseUnit->semester }} @endif
                            </p>
                        </div>
                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ $courseUnit->resources->count() }} {{ Str::plural('resource', $courseUnit->resources->count()) }}</span>
                    </div>

                    @if ($courseUnit->resources->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach ($courseUnit->resources as $resource)
                                <a href="{{ route('resources.show', $resource) }}"
                                    class="flex items-start gap-3 p-3 rounded-lg border border-gray-100 dark:border-gray-700 hover:border-blue-400 dark:hover:border-blue-500 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center flex-shrink-0">
                                        <i class="bx bx-file-pdf text-blue-600 dark:text-blue-400"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $resource->title }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ ucfirst(str_replace('_', ' ', $resource->type)) }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500 dark:text-gray-400">No resources shared for this course unit yet.</p>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-12 text-center">
            <i class="bx bx-list-ul text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No course units yet</h3>
            <p class="text-gray-500 dark:text-gray-400">This course has no course units listed yet.</p>
        </div>
    @endif
</div>
@endsection
