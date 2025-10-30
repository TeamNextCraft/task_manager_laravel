<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-5 md:flex-row justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Tasks') }}
                    <span id="last-updated" class="text-sm text-gray-500 font-normal ml-2"></span>
                </h2>
            </div>
            @if (auth()->user()->role == 'admin')
                <a href="{{ route('tasks.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-lg px-4 py-2 rounded-lg font-semibold transition-colors duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Create Task
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Auto-refresh indicator -->
            <div id="refresh-indicator" class="hidden mb-4 bg-blue-50 border border-blue-200 rounded-lg p-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span class="text-blue-800 font-medium">Checking for new tasks...</span>
                    </div>
                    <button onclick="stopAutoRefresh()" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        Stop Auto-Refresh
                    </button>
                </div>
            </div>

            <!-- Welcome Message -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Welcome, {{ auth()->user()->name }}!</h3>
                            <p class="text-gray-600 mt-1">
                                @if (auth()->user()->role == 'admin')
                                    You can create, edit, and assign tasks to users.
                                @else
                                    Here are the tasks assigned to you.
                                @endif
                            </p>
                        </div>
                        <div class="mt-4 md:mt-0 flex space-x-2">
                            <button id="filter-all" class="filter-btn active px-3 py-2 text-sm font-medium rounded-lg bg-blue-100 text-blue-800 border border-blue-200 transition-colors duration-200">
                                All Tasks
                            </button>
                            <button id="filter-pending" class="filter-btn px-3 py-2 text-sm font-medium rounded-lg bg-orange-100 text-orange-800 border border-orange-200 transition-colors duration-200">
                                Pending
                            </button>
                            <button id="filter-completed" class="filter-btn px-3 py-2 text-sm font-medium rounded-lg bg-green-100 text-green-800 border border-green-200 transition-colors duration-200">
                                Completed
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and Filters -->
            <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                    <!-- Search -->
                    <div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" id="search-input" placeholder="Search tasks..."
                                class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                        </div>
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <select id="category-filter"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                            <option value="">All Categories</option>
                            <option value="general">General</option>
                            <option value="development">Development</option>
                            <option value="design">Design</option>
                            <option value="marketing">Marketing</option>
                            <option value="support">Support</option>
                        </select>
                    </div>

                    <!-- Priority Filter -->
                    <div>
                        <select id="priority-filter"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                            <option value="">All Priorities</option>
                            <option value="urgent">Urgent</option>
                            <option value="high">High</option>
                            <option value="medium">Medium</option>
                            <option value="low">Low</option>
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <select id="status-filter"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                            <option value="">All Status</option>
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                            <option value="overdue">Overdue</option>
                        </select>
                    </div>
                </div>

                <!-- Active Filters Display -->
                <div id="active-filters" class="hidden flex flex-wrap gap-2 mt-2">
                    <!-- Active filters will appear here -->
                </div>
            </div>

            <!-- Tasks Container -->
            <div id="tasks-container">
                @include('tasks.partials.tasks-list', ['tasks' => $tasks])
            </div>

            <!-- No Results Message -->
            <div id="no-results" class="hidden text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No tasks found</h3>
                <p class="text-gray-500">Try adjusting your search or filters</p>
                <button onclick="clearAllFilters()" class="mt-4 text-blue-600 hover:text-blue-800 font-medium">
                    Clear all filters
                </button>
            </div>
        </div>
    </div>

    <script>
        let autoRefreshInterval;
        let isAutoRefreshEnabled = true;
        let currentFilters = {
            search: '',
            category: '',
            priority: '',
            status: '',
            completion: 'all'
        };

        // Filter functionality
        document.addEventListener('DOMContentLoaded', function() {
            initializeFilters();
            startAutoRefresh();
            addManualRefreshButton();
        });

        function initializeFilters() {
            // Status filter buttons
            const filterButtons = document.querySelectorAll('.filter-btn');
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    filterButtons.forEach(btn => btn.classList.remove('active', 'bg-blue-100', 'text-blue-800', 'border-blue-200'));
                    this.classList.add('active', 'bg-blue-100', 'text-blue-800', 'border-blue-200');

                    const filter = this.id.replace('filter-', '');
                    currentFilters.completion = filter;
                    applyFilters();
                });
            });

            // Search input
            const searchInput = document.getElementById('search-input');
            let searchTimeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    currentFilters.search = this.value.toLowerCase();
                    applyFilters();
                }, 300);
            });

            // Category filter
            document.getElementById('category-filter').addEventListener('change', function() {
                currentFilters.category = this.value;
                applyFilters();
            });

            // Priority filter
            document.getElementById('priority-filter').addEventListener('change', function() {
                currentFilters.priority = this.value;
                applyFilters();
            });

            // Status filter
            document.getElementById('status-filter').addEventListener('change', function() {
                currentFilters.status = this.value;
                applyFilters();
            });
        }

        function applyFilters() {
            const taskItems = document.querySelectorAll('.task-item');
            let visibleCount = 0;
            updateActiveFiltersDisplay();

            taskItems.forEach(task => {
                const title = task.querySelector('h4').textContent.toLowerCase();
                const description = task.querySelector('p') ? task.querySelector('p').textContent.toLowerCase() : '';
                const category = task.dataset.category || 'general';
                const priority = task.dataset.priority || 'medium';
                const isCompleted = task.classList.contains('completed');
                const isOverdue = task.classList.contains('overdue');

                // Apply filters
                const matchesSearch = !currentFilters.search ||
                    title.includes(currentFilters.search) ||
                    description.includes(currentFilters.search);

                const matchesCategory = !currentFilters.category || category === currentFilters.category;
                const matchesPriority = !currentFilters.priority || priority === currentFilters.priority;

                let matchesStatus = true;
                if (currentFilters.status === 'completed') {
                    matchesStatus = isCompleted;
                } else if (currentFilters.status === 'pending') {
                    matchesStatus = !isCompleted;
                } else if (currentFilters.status === 'overdue') {
                    matchesStatus = isOverdue;
                }

                let matchesCompletion = true;
                if (currentFilters.completion === 'pending') {
                    matchesCompletion = !isCompleted;
                } else if (currentFilters.completion === 'completed') {
                    matchesCompletion = isCompleted;
                }

                const shouldShow = matchesSearch && matchesCategory && matchesPriority && matchesStatus && matchesCompletion;
                task.style.display = shouldShow ? 'block' : 'none';

                if (shouldShow) visibleCount++;
            });

            // Show/hide no results message
            const noResults = document.getElementById('no-results');
            const tasksContainer = document.getElementById('tasks-container');

            if (visibleCount === 0 && hasActiveFilters()) {
                noResults.classList.remove('hidden');
                tasksContainer.classList.add('hidden');
            } else {
                noResults.classList.add('hidden');
                tasksContainer.classList.remove('hidden');
            }
        }

        function updateActiveFiltersDisplay() {
            const activeFiltersContainer = document.getElementById('active-filters');
            activeFiltersContainer.innerHTML = '';

            const filters = [];

            if (currentFilters.search) {
                filters.push(`Search: "${currentFilters.search}"`);
            }
            if (currentFilters.category) {
                filters.push(`Category: ${currentFilters.category}`);
            }
            if (currentFilters.priority) {
                filters.push(`Priority: ${currentFilters.priority}`);
            }
            if (currentFilters.status) {
                filters.push(`Status: ${currentFilters.status}`);
            }
            if (currentFilters.completion && currentFilters.completion !== 'all') {
                filters.push(`${currentFilters.completion.charAt(0).toUpperCase() + currentFilters.completion.slice(1)}`);
            }

            if (filters.length > 0) {
                activeFiltersContainer.classList.remove('hidden');
                filters.forEach(filter => {
                    const badge = document.createElement('span');
                    badge.className = 'px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full flex items-center';
                    badge.innerHTML = `
                        ${filter}
                        <button onclick="removeFilter('${filter.split(':')[0].trim().toLowerCase()}')" class="ml-2 text-blue-600 hover:text-blue-800">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    `;
                    activeFiltersContainer.appendChild(badge);
                });
            } else {
                activeFiltersContainer.classList.add('hidden');
            }
        }

        function removeFilter(filterType) {
            switch(filterType) {
                case 'search':
                    currentFilters.search = '';
                    document.getElementById('search-input').value = '';
                    break;
                case 'category':
                    currentFilters.category = '';
                    document.getElementById('category-filter').value = '';
                    break;
                case 'priority':
                    currentFilters.priority = '';
                    document.getElementById('priority-filter').value = '';
                    break;
                case 'status':
                    currentFilters.status = '';
                    document.getElementById('status-filter').value = '';
                    break;
                case 'all':
                case 'pending':
                case 'completed':
                    currentFilters.completion = 'all';
                    document.querySelectorAll('.filter-btn').forEach(btn => {
                        if (btn.id === 'filter-all') {
                            btn.classList.add('active', 'bg-blue-100', 'text-blue-800', 'border-blue-200');
                        } else {
                            btn.classList.remove('active', 'bg-blue-100', 'text-blue-800', 'border-blue-200');
                        }
                    });
                    break;
            }
            applyFilters();
        }

        function clearAllFilters() {
            currentFilters = {
                search: '',
                category: '',
                priority: '',
                status: '',
                completion: 'all'
            };

            document.getElementById('search-input').value = '';
            document.getElementById('category-filter').value = '';
            document.getElementById('priority-filter').value = '';
            document.getElementById('status-filter').value = '';

            document.querySelectorAll('.filter-btn').forEach(btn => {
                if (btn.id === 'filter-all') {
                    btn.classList.add('active', 'bg-blue-100', 'text-blue-800', 'border-blue-200');
                } else {
                    btn.classList.remove('active', 'bg-blue-100', 'text-blue-800', 'border-blue-200');
                }
            });

            applyFilters();
        }

        function hasActiveFilters() {
            return currentFilters.search || currentFilters.category || currentFilters.priority ||
                   currentFilters.status || (currentFilters.completion && currentFilters.completion !== 'all');
        }

        // Auto-refresh functionality
        function startAutoRefresh() {
            autoRefreshInterval = setInterval(() => {
                if (isAutoRefreshEnabled) {
                    refreshTasks();
                }
            }, 60000);
            updateLastUpdatedTime();
        }

        function refreshTasks() {
            const indicator = document.getElementById('refresh-indicator');
            indicator.classList.remove('hidden');

            fetch('{{ route('tasks.index') }}?ajax=1', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html',
                }
            })
            .then(response => response.text())
            .then(html => {
                document.getElementById('tasks-container').innerHTML = html;
                indicator.classList.add('hidden');
                updateLastUpdatedTime();
                showUpdateNotification('Tasks updated successfully');
                // Re-apply filters after refresh
                applyFilters();
            })
            .catch(error => {
                console.error('Error refreshing tasks:', error);
                indicator.classList.add('hidden');
            });
        }

        function stopAutoRefresh() {
            isAutoRefreshEnabled = false;
            clearInterval(autoRefreshInterval);
            document.getElementById('refresh-indicator').classList.add('hidden');
            showUpdateNotification('Auto-refresh disabled');
        }

        function enableAutoRefresh() {
            isAutoRefreshEnabled = true;
            startAutoRefresh();
            showUpdateNotification('Auto-refresh enabled');
        }

        function updateLastUpdatedTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString();
            document.getElementById('last-updated').textContent = `Last updated: ${timeString}`;
        }

        function showUpdateNotification(message) {
            let notification = document.getElementById('update-notification');
            if (!notification) {
                notification = document.createElement('div');
                notification.id = 'update-notification';
                notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300';
                document.body.appendChild(notification);
            }

            notification.textContent = message;
            notification.classList.remove('translate-x-full');

            setTimeout(() => {
                notification.classList.add('translate-x-full');
            }, 3000);
        }

        function manualRefresh() {
            refreshTasks();
        }

        function addManualRefreshButton() {
            if (!document.getElementById('manual-refresh-btn')) {
                const header = document.querySelector('h2.font-semibold');
                const refreshBtn = document.createElement('button');
                refreshBtn.id = 'manual-refresh-btn';
                refreshBtn.className = 'ml-4 text-gray-500 hover:text-gray-700 transition-colors duration-200';
                refreshBtn.innerHTML = `
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                `;
                refreshBtn.title = 'Refresh tasks';
                refreshBtn.onclick = manualRefresh;
                header.appendChild(refreshBtn);
            }
        }

        window.addEventListener('beforeunload', function() {
            clearInterval(autoRefreshInterval);
        });
    </script>
</x-app-layout>

{{-- <x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-gray-800 leading-tight">
                    {{ __('Tasks') }}
                </h2>

                <div class="flex space-x-4 mt-2">
                    <button id="filter-all"
                        class="filter-btn active px-3 py-1 text-sm font-medium rounded-full bg-blue-100 text-blue-800 border border-blue-200">
                        All Tasks
                    </button>
                    <button id="filter-pending"
                        class="filter-btn px-3 py-1 text-sm font-medium rounded-full bg-orange-100 text-orange-800 border border-orange-200">
                        Pending
                    </button>
                    <button id="filter-completed"
                        class="filter-btn px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-800 border border-green-200">
                        Completed
                    </button>
                </div>
            </div>

            @if (auth()->user()->role == 'admin')
                <a href="{{ route('tasks.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center text-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Create Task
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Message -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Welcome, {{ auth()->user()->name }}!</h3>
                    <p class="text-gray-600 mt-1">
                        @if (auth()->user()->role == 'admin')
                            You can create, edit, and assign tasks to users.
                        @else
                            Here are the tasks assigned to you.
                        @endif
                    </p>
                </div>
            </div>

            <!-- Tasks List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if ($tasks->count() > 0)
                        <div class="space-y-4">
                            @foreach ($tasks as $task)
                                <div
                                    class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-200">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h4 class="text-lg font-semibold text-gray-800">{{ $task->title }}</h4>
                                            @if ($task->description)
                                                <p class="text-gray-600 mt-1">{{ $task->description }}</p>
                                            @endif
                                            <div class="flex items-center mt-2 text-sm text-gray-500">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                    </path>
                                                </svg>
                                                Assigned to: {{ $task->user->name }}
                                            </div>
                                            <div class="flex items-center mt-1 text-sm text-gray-500">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                                Created: {{ $task->created_at->format('M d, Y') }}
                                            </div>
                                        </div>

                                        @if (auth()->user()->role == 'admin')
                                            <div class="flex space-x-2 ml-4">
                                                <a href="{{ route('tasks.edit', $task->id) }}"
                                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm font-medium transition-colors duration-200 flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                        </path>
                                                    </svg>
                                                    Edit
                                                </a>
                                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this task?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm font-medium transition-colors duration-200 flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                            </path>
                                                        </svg>
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No tasks found</h3>
                            <p class="text-gray-500 mb-4">
                                @if (auth()->user()->role == 'admin')
                                    Create your first task to get started!
                                @else
                                    No tasks have been assigned to you yet.
                                @endif
                            </p>
                            @if (auth()->user()->role == 'admin')
                                <a href="{{ route('tasks.create') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition-colors duration-200 inline-flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Create Your First Task
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}
