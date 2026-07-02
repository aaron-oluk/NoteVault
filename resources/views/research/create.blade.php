@extends('layouts.app')

@section('title', 'Submit Research - NoteVault')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-6 sm:mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2 flex items-center gap-2">
                        <i class="bx bx-file-find text-purple-600 dark:text-purple-400"></i>
                        Submit Research
                    </h1>
                    <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">Papers and theses are saved as a draft until submitted for review</p>
                </div>
                <a href="{{ route('research.index') }}"
                   class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white text-sm">
                    <i class="bx bx-arrow-back text-base mr-1"></i>
                    Back
                </a>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-md shadow-sm border-t-4 border-purple-500 p-4 sm:p-6">
            <form id="research-create-form" data-research-form>
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
                               placeholder="Enter the title of your research work"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                    </div>

                    <!-- Field of Study & Department -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="field_of_study" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Field of Study
                            </label>
                            <input id="field_of_study"
                                   name="field_of_study"
                                   type="text"
                                   placeholder="e.g., Computer Science"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                        </div>
                        <div>
                            <label for="department_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Department ID
                            </label>
                            <input id="department_id"
                                   name="department_id"
                                   type="number"
                                   placeholder="Department ID, if known"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                        </div>
                    </div>

                    <!-- License Type -->
                    <div>
                        <label for="license_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            License Type
                        </label>
                        <select id="license_type"
                                name="license_type"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="">Select a license</option>
                            <option value="all_rights_reserved">All Rights Reserved</option>
                            <option value="cc_by">Creative Commons Attribution (CC BY)</option>
                            <option value="cc_by_sa">Creative Commons Attribution ShareAlike (CC BY SA)</option>
                            <option value="cc_by_nc">Creative Commons Attribution NonCommercial (CC BY NC)</option>
                            <option value="public_domain">Public Domain</option>
                        </select>
                    </div>

                    <!-- File Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Upload File
                        </label>
                        <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-md p-6 text-center">
                            <input type="file" id="file-input" name="file" accept=".pdf,.doc,.docx" class="hidden">
                            <div id="file-upload-area">
                                <i class="bx bx-cloud-upload text-4xl text-gray-400 dark:text-gray-500 mb-2"></i>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                    <button type="button" id="select-file-btn" class="text-purple-600 hover:text-purple-700 font-medium">
                                        Click to upload
                                    </button> or drag and drop
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">PDF, DOC, DOCX up to 10MB</p>
                            </div>
                            <div id="file-info" class="hidden">
                                <i class="bx bx-file text-3xl text-purple-600 mb-2"></i>
                                <p class="text-sm text-gray-900 dark:text-white font-medium" id="file-name"></p>
                                <p class="text-xs text-gray-500 dark:text-gray-400" id="file-size"></p>
                                <button type="button" id="remove-file-btn" class="mt-2 text-sm text-red-600 hover:text-red-700">
                                    Remove
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Citation -->
                    <div>
                        <label for="citation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Citation
                        </label>
                        <textarea id="citation"
                                  name="citation"
                                  rows="2"
                                  placeholder="Preferred citation format for this work..."
                                  class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500"></textarea>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Abstract
                        </label>
                        <textarea id="description"
                                  name="description"
                                  rows="8"
                                  placeholder="Describe your research, methodology, and findings..."
                                  class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500"></textarea>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-between items-center pt-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            <i class="bx bx-info-circle"></i> Saved as a draft, not publicly visible until endorsed
                        </p>
                        <div class="flex space-x-3">
                            <a href="{{ route('research.index') }}"
                                class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-6 py-2 bg-purple-600 text-white text-sm font-medium rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-colors">
                                Save Draft
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
    const form = document.getElementById('research-create-form');
    if (form && window.ResearchWorkForm) {
        new ResearchWorkForm(form, {
            mode: 'create',
            redirectUrl: '{{ route('research.index') }}',
        });
    }
});
</script>
@endsection
