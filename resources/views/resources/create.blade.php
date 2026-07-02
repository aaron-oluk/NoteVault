@extends('layouts.app')

@section('title', 'Add Resource - NoteVault')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-6 sm:mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2">Add Resource</h1>
                    <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">Share notes, past papers, or study guides with your course</p>
                </div>
                <a href="{{ route('resources.index') }}"
                   class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white text-sm">
                    <i class="bx bx-arrow-back text-base mr-1"></i>
                    Back
                </a>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-md shadow-sm p-4 sm:p-6">
            <form id="resource-create-form" data-resource-form>
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
                               placeholder="Enter resource title"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
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
                                <option value="">Select type</option>
                                <option value="lecture_notes">Lecture Notes</option>
                                <option value="past_paper">Past Paper</option>
                                <option value="study_guide">Study Guide</option>
                                <option value="assignment">Assignment</option>
                                <option value="summary">Summary</option>
                                <option value="presentation">Presentation</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div>
                            <label for="course_unit_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Course Unit ID
                            </label>
                            <input id="course_unit_id"
                                   name="course_unit_id"
                                   type="number"
                                   placeholder="Course unit ID, if known"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
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
                                   placeholder="e.g., Semester 1"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                        </div>
                        <div>
                            <label for="academic_year" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Academic Year
                            </label>
                            <input id="academic_year"
                                   name="academic_year"
                                   type="text"
                                   placeholder="e.g., 2025/2026"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                        </div>
                    </div>

                    <!-- File Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Upload File
                        </label>
                        <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-md p-6 text-center">
                            <input type="file" id="file-input" name="file" accept=".pdf,.doc,.docx,.txt,.rtf,.ppt,.pptx" class="hidden">
                            <div id="file-upload-area">
                                <i class="bx bx-cloud-upload text-4xl text-gray-400 dark:text-gray-500 mb-2"></i>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                    <button type="button" id="select-file-btn" class="text-blue-600 hover:text-blue-700 font-medium">
                                        Click to upload
                                    </button> or drag and drop
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">PDF, DOC, DOCX, TXT, RTF, PPT, PPTX up to 10MB</p>
                            </div>
                            <div id="file-info" class="hidden">
                                <i class="bx bx-file text-3xl text-blue-600 mb-2"></i>
                                <p class="text-sm text-gray-900 dark:text-white font-medium" id="file-name"></p>
                                <p class="text-xs text-gray-500 dark:text-gray-400" id="file-size"></p>
                                <button type="button" id="remove-file-btn" class="mt-2 text-sm text-red-600 hover:text-red-700">
                                    Remove
                                </button>
                            </div>
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
                                  placeholder="Describe the resource and what it covers..."
                                  class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500"></textarea>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-between items-center pt-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            <i class="bx bx-info-circle"></i> Visible to your institution once submitted
                        </p>
                        <div class="flex space-x-3">
                            <a href="{{ route('resources.index') }}"
                                class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                                Add Resource
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
    const form = document.getElementById('resource-create-form');
    if (form && window.ResourceForm) {
        new ResourceForm(form, {
            mode: 'create',
            redirectUrl: '{{ route('resources.index') }}',
        });
    }
});
</script>
@endsection
