@extends('layouts.app')

@section('title', 'Edit ' . $researchWork->title . ' - NoteVault')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-6 sm:mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2 flex items-center gap-2">
                        <i class="bx bx-file-find text-purple-600 dark:text-purple-400"></i>
                        Edit Research Work
                    </h1>
                    <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">Update the details for this research work</p>
                </div>
                <a href="{{ route('research.show', $researchWork) }}"
                   class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white text-sm">
                    <i class="bx bx-arrow-back text-base mr-1"></i>
                    Back
                </a>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-md shadow-sm border-t-4 border-purple-500 p-4 sm:p-6">
            <form id="research-edit-form" data-research-form data-research-work-uuid="{{ $researchWork->uuid }}">
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
                               value="{{ old('title', $researchWork->title) }}"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
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
                                   value="{{ old('field_of_study', $researchWork->field_of_study) }}"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                        <div>
                            <label for="department_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Department ID
                            </label>
                            <input id="department_id"
                                   name="department_id"
                                   type="number"
                                   value="{{ old('department_id', $researchWork->department_id) }}"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
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
                            @php
                                $licenses = ['all_rights_reserved' => 'All Rights Reserved', 'cc_by' => 'Creative Commons Attribution (CC BY)', 'cc_by_sa' => 'Creative Commons Attribution ShareAlike (CC BY SA)', 'cc_by_nc' => 'Creative Commons Attribution NonCommercial (CC BY NC)', 'public_domain' => 'Public Domain'];
                            @endphp
                            <option value="">Select a license</option>
                            @foreach ($licenses as $value => $label)
                                <option value="{{ $value }}" {{ old('license_type', $researchWork->license_type) === $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Citation -->
                    <div>
                        <label for="citation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Citation
                        </label>
                        <textarea id="citation"
                                  name="citation"
                                  rows="2"
                                  class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">{{ old('citation', $researchWork->citation) }}</textarea>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Abstract
                        </label>
                        <textarea id="description"
                                  name="description"
                                  rows="8"
                                  class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-purple-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">{{ old('description', $researchWork->description) }}</textarea>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end items-center pt-4">
                        <div class="flex space-x-3">
                            <a href="{{ route('research.show', $researchWork) }}"
                                class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-6 py-2 bg-purple-600 text-white text-sm font-medium rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-colors">
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
    const form = document.getElementById('research-edit-form');
    if (form && window.ResearchWorkForm) {
        new ResearchWorkForm(form, {
            mode: 'edit',
            researchWorkUuid: form.getAttribute('data-research-work-uuid'),
            redirectUrl: '{{ route('research.show', $researchWork) }}',
        });
    }
});
</script>
@endsection
