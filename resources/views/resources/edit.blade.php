@extends('layouts.app')

@section('title', 'Edit ' . $resource->title . ' - NoteVault')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-6 sm:mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2">Edit Resource</h1>
                    <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">Update the details for this resource</p>
                </div>
                <a href="{{ route('resources.show', $resource) }}"
                   class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white text-sm">
                    <i class="bx bx-arrow-back text-base mr-1"></i>
                    Back
                </a>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-md shadow-sm p-4 sm:p-6">
            <form id="resource-edit-form" data-resource-form data-resource-uuid="{{ $resource->uuid }}">
                <div class="space-y-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Title <span class="text-red-500">*</span>
                        </label>
                        <input id="title"
                               name="title"
                               type="text"
                               required
                               value="{{ old('title', $resource->title) }}"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    </div>

                    <!-- Type & Course Unit -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Type <span class="text-red-500">*</span>
                            </label>
                            <select id="type"
                                    name="type"
                                    required
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                @php
                                    $types = ['lecture_notes' => 'Lecture Notes', 'past_paper' => 'Past Paper', 'study_guide' => 'Study Guide', 'assignment' => 'Assignment', 'summary' => 'Summary', 'presentation' => 'Presentation', 'other' => 'Other'];
                                @endphp
                                @foreach ($types as $value => $label)
                                    <option value="{{ $value }}" {{ old('type', $resource->type) === $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="course_unit_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Course Unit ID
                            </label>
                            <input id="course_unit_id"
                                   name="course_unit_id"
                                   type="number"
                                   value="{{ old('course_unit_id', $resource->course_unit_id) }}"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                    </div>

                    <!-- Semester & Academic Year -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="semester" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Semester
                            </label>
                            <input id="semester"
                                   name="semester"
                                   type="text"
                                   value="{{ old('semester', $resource->semester) }}"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                        <div>
                            <label for="academic_year" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Academic Year
                            </label>
                            <input id="academic_year"
                                   name="academic_year"
                                   type="text"
                                   value="{{ old('academic_year', $resource->academic_year) }}"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Description
                        </label>
                        <textarea id="description"
                                  name="description"
                                  rows="6"
                                  class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">{{ old('description', $resource->description) }}</textarea>
                    </div>

                    <!-- Changelog (lecturer content only) -->
                    @if ($resource->is_lecturer_content)
                        <div data-changelog-field>
                            <label for="changelog" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Changelog
                            </label>
                            <textarea id="changelog"
                                      name="changelog"
                                      rows="3"
                                      placeholder="Describe what changed in this revision..."
                                      class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500"></textarea>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">This resource is lecturer content, saving creates a new version entry.</p>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="flex justify-end items-center pt-4">
                        <div class="flex space-x-3">
                            <a href="{{ route('resources.show', $resource) }}"
                                class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('resource-edit-form');
    if (form && window.ResourceForm) {
        new ResourceForm(form, {
            mode: 'edit',
            resourceUuid: form.getAttribute('data-resource-uuid'),
            redirectUrl: '{{ route('resources.show', $resource) }}',
        });
    }
});
</script>
@endsection
