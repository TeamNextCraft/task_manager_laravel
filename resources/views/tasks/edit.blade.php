<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Task') }}
            </h2>
            <a href="{{ route('tasks.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white text-lg px-4 py-2 rounded-lg font-semibold transition-colors duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Tasks
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <!-- Basic Task Information -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">Basic Information</h3>

                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                                    Task Title *
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" name="title" id="title" required
                                        class="block w-full pl-10 border border-gray-300 rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                        value="{{ old('title', $task->title) }}"
                                        placeholder="Enter a clear and descriptive task title">
                                </div>
                                @error('title')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                                    Description
                                </label>
                                <div class="relative">
                                    <div class="absolute top-3 left-3 pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                                        </svg>
                                    </div>
                                    <textarea name="description" id="description" rows="5"
                                        class="block w-full pl-10 border border-gray-300 rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                        placeholder="Provide detailed information about the task, requirements, and any specific instructions">{{ old('description', $task->description) }}</textarea>
                                </div>
                                @error('description')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Task Configuration -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">Task Configuration</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Assign To -->
                                <div>
                                    <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">
                                        Assign To *
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                        <select name="user_id" id="user_id" required
                                            class="block w-full pl-10 border border-gray-300 rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 appearance-none bg-white">
                                            <option value="">Select a team member</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" {{ old('user_id', $task->user_id) == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }} ({{ $user->email }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    @error('user_id')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Category -->
                                <div>
                                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">
                                        Category
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                            </svg>
                                        </div>
                                        <select name="category" id="category"
                                            class="block w-full pl-10 border border-gray-300 rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 appearance-none bg-white">
                                            <option value="general" {{ old('category', $task->category ?? 'general') == 'general' ? 'selected' : '' }}>General</option>
                                            <option value="development" {{ old('category', $task->category) == 'development' ? 'selected' : '' }}>Development</option>
                                            <option value="design" {{ old('category', $task->category) == 'design' ? 'selected' : '' }}>Design</option>
                                            <option value="marketing" {{ old('category', $task->category) == 'marketing' ? 'selected' : '' }}>Marketing</option>
                                            <option value="support" {{ old('category', $task->category) == 'support' ? 'selected' : '' }}>Support</option>
                                            <option value="research" {{ old('category', $task->category) == 'research' ? 'selected' : '' }}>Research</option>
                                            <option value="documentation" {{ old('category', $task->category) == 'documentation' ? 'selected' : '' }}>Documentation</option>
                                            <option value="testing" {{ old('category', $task->category) == 'testing' ? 'selected' : '' }}>Testing</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    @error('category')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Priority -->
                                <div>
                                    <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">
                                        Priority
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                        </div>
                                        <select name="priority" id="priority"
                                            class="block w-full pl-10 border border-gray-300 rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 appearance-none bg-white">
                                            <option value="low" {{ old('priority', $task->priority ?? 'medium') == 'low' ? 'selected' : '' }}>Low</option>
                                            <option value="medium" {{ old('priority', $task->priority ?? 'medium') == 'medium' ? 'selected' : '' }}>Medium</option>
                                            <option value="high" {{ old('priority', $task->priority ?? 'medium') == 'high' ? 'selected' : '' }}>High</option>
                                            <option value="urgent" {{ old('priority', $task->priority ?? 'medium') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    @error('priority')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Due Date -->
                                <div>
                                    <label for="due_date" class="block text-sm font-medium text-gray-700 mb-1">
                                        Due Date
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <input type="datetime-local" name="due_date" id="due_date"
                                            class="block w-full pl-10 border border-gray-300 rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                            value="{{ old('due_date', $task->due_date ? $task->due_date->format('Y-m-d\TH:i') : '') }}"
                                            min="{{ now()->format('Y-m-d\TH:i') }}">
                                    </div>
                                    @error('due_date')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Completion Status -->
                            <div class="flex items-center space-x-3 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <input type="checkbox" name="completed" id="completed" value="1"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2"
                                    {{ old('completed', $task->completed) ? 'checked' : '' }}>
                                <label for="completed" class="text-sm font-medium text-gray-700">
                                    Mark task as completed
                                </label>
                            </div>
                        </div>

                        <!-- Priority Indicators -->
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <h4 class="text-sm font-medium text-gray-700 mb-3">Priority Guidelines</h4>
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-3 text-xs">
                                <div class="flex items-center space-x-2 p-2 rounded border border-red-200 bg-red-50">
                                    <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                    <span class="font-medium text-red-800">Urgent</span>
                                    <span class="text-red-600">Critical issues</span>
                                </div>
                                <div class="flex items-center space-x-2 p-2 rounded border border-orange-200 bg-orange-50">
                                    <div class="w-3 h-3 bg-orange-500 rounded-full"></div>
                                    <span class="font-medium text-orange-800">High</span>
                                    <span class="text-orange-600">Important tasks</span>
                                </div>
                                <div class="flex items-center space-x-2 p-2 rounded border border-yellow-200 bg-yellow-50">
                                    <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                                    <span class="font-medium text-yellow-800">Medium</span>
                                    <span class="text-yellow-600">Standard work</span>
                                </div>
                                <div class="flex items-center space-x-2 p-2 rounded border border-green-200 bg-green-50">
                                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                    <span class="font-medium text-green-800">Low</span>
                                    <span class="text-green-600">Backlog items</span>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                            <div class="text-sm text-gray-500">
                                Last updated: {{ $task->updated_at->format('M j, Y g:i A') }}
                            </div>
                            <div class="flex space-x-4">
                                <a href="{{ route('tasks.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold transition-colors duration-200 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Cancel
                                </a>
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors duration-200 flex items-center shadow-sm hover:shadow-md">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Update Task
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Set minimum datetime for due date to current time
            const dueDateInput = document.getElementById('due_date');
            const now = new Date();
            now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
            dueDateInput.min = now.toISOString().slice(0, 16);

            // Priority visual feedback
            const prioritySelect = document.getElementById('priority');
            const updatePriorityStyle = () => {
                const value = prioritySelect.value;
                const colors = {
                    'urgent': 'border-red-500 bg-red-50 text-red-900',
                    'high': 'border-orange-500 bg-orange-50 text-orange-900',
                    'medium': 'border-yellow-500 bg-yellow-50 text-yellow-900',
                    'low': 'border-green-500 bg-green-50 text-green-900'
                };

                // Remove all color classes
                prioritySelect.className = prioritySelect.className.replace(/border-(red|orange|yellow|green)-500/g, '')
                    .replace(/bg-(red|orange|yellow|green)-50/g, '')
                    .replace(/text-(red|orange|yellow|green)-900/g, '');

                // Add current color class
                if (colors[value]) {
                    prioritySelect.classList.add(...colors[value].split(' '));
                }
            };

            prioritySelect.addEventListener('change', updatePriorityStyle);
            updatePriorityStyle(); // Initial call

            // Form submission loading state
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                const submitButton = this.querySelector('button[type="submit"]');
                const originalText = submitButton.innerHTML;

                submitButton.disabled = true;
                submitButton.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Updating Task...
                `;

                // Re-enable after 10 seconds if still disabled (error case)
                setTimeout(() => {
                    if (submitButton.disabled) {
                        submitButton.disabled = false;
                        submitButton.innerHTML = originalText;
                    }
                }, 10000);
            });
        });
    </script>
</x-app-layout>
