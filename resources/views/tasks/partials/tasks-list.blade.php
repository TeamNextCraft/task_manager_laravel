@if($tasks->count() > 0)
    <div class="space-y-4">
        @foreach ($tasks as $task)
            <div class="task-item border border-gray-200 rounded-lg p-4 hover:shadow-md transition-all duration-200
                {{ $task->completed ? 'completed bg-green-50 border-green-200' : 'bg-white' }}
                {{ $task->due_date && $task->due_date->isPast() && !$task->completed ? 'overdue bg-red-50 border-red-200' : '' }}"
                data-task-id="{{ $task->id }}"
                data-category="{{ $task->category ?? 'general' }}"
                data-priority="{{ $task->priority ?? 'medium' }}">

                <div class="flex flex-col md:flex-row gap-4 justify-between items-start">
                    <div class="flex items-start space-x-3 flex-1">
                        <!-- Completion Toggle -->
                        <form action="{{ route('tasks.toggle', $task->id) }}" method="POST" class="mt-1">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="focus:outline-none transition-transform duration-200 hover:scale-110">
                                @if($task->completed)
                                    <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center text-white shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                @else
                                    <div class="w-6 h-6 border-2 border-gray-300 rounded-full hover:border-green-500 transition-colors duration-200"></div>
                                @endif
                            </button>
                        </form>

                        <div class="flex-1">
                            <!-- Task Header with Status and Priority -->
                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                <h4 class="text-lg font-semibold {{ $task->completed ? 'text-green-700 line-through' : 'text-gray-800' }}">
                                    {{ $task->title }}
                                </h4>

                                <!-- Status Badge -->
                                @if($task->completed)
                                    <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                        Completed
                                    </span>
                                @elseif($task->due_date && $task->due_date->isPast())
                                    <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">
                                        Overdue
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium bg-orange-100 text-orange-800 rounded-full">
                                        Pending
                                    </span>
                                @endif

                                <!-- Priority Badge -->
                                @if($task->priority)
                                    <span class="px-2 py-1 text-xs font-medium rounded-full
                                        @if($task->priority === 'urgent') bg-red-100 text-red-800 border border-red-200
                                        @elseif($task->priority === 'high') bg-orange-100 text-orange-800 border border-orange-200
                                        @elseif($task->priority === 'medium') bg-yellow-100 text-yellow-800 border border-yellow-200
                                        @else bg-green-100 text-green-800 border border-green-200 @endif">
                                        {{ ucfirst($task->priority) }} Priority
                                    </span>
                                @endif

                                <!-- Category Badge -->
                                @if($task->category && $task->category !== 'general')
                                    <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full border border-blue-200 capitalize">
                                        {{ $task->category }}
                                    </span>
                                @endif
                            </div>

                            <!-- Description -->
                            @if($task->description)
                                <p class="text-gray-600 mt-1 {{ $task->completed ? 'line-through' : '' }}">
                                    {{ $task->description }}
                                </p>
                            @endif

                            <!-- Task Metadata -->
                            <div class="flex flex-col sm:flex-row sm:items-center gap-4 mt-3 text-sm text-gray-500">
                                <!-- Assigned User -->
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span>Assigned to: {{ $task->user->name }}</span>
                                </div>

                                <!-- Created Date -->
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>Created: {{ $task->created_at->format('M d, Y') }}</span>
                                </div>

                                <!-- Due Date -->
                                @if($task->due_date)
                                    <div class="flex items-center {{ $task->due_date->isPast() && !$task->completed ? 'text-red-600 font-medium' : '' }}">
                                        <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>
                                            Due: {{ $task->due_date->format('M d, Y g:i A') }}
                                            @if($task->due_date->isPast() && !$task->completed)
                                                ({{ $task->due_date->diffForHumans() }})
                                            @endif
                                        </span>
                                    </div>
                                @endif

                                <!-- Completion Date -->
                                @if($task->completed)
                                    <div class="flex items-center text-green-600">
                                        <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>Completed: {{ $task->updated_at->format('M d, Y') }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Time Indicators -->
                            @if(!$task->completed && $task->due_date)
                                <div class="mt-2">
                                    @php
                                        $daysUntilDue = $task->due_date->diffInDays(now());
                                        $isDueSoon = $daysUntilDue <= 2 && $daysUntilDue >= 0;
                                    @endphp
                                    @if($isDueSoon)
                                        <div class="flex items-center text-orange-600 text-xs font-medium">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Due {{ $task->due_date->diffForHumans() }}
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Admin Actions -->
                    @if(auth()->user()->role == 'admin')
                    <div class="flex space-x-2">
                        <a href="{{ route('tasks.edit', $task->id) }}"
                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded text-sm font-medium transition-colors duration-200 flex items-center shadow-sm hover:shadow-md">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit
                        </a>
                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this task? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded text-sm font-medium transition-colors duration-200 flex items-center shadow-sm hover:shadow-md">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
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
    <div class="text-center py-12">
        <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
        </svg>
        <h3 class="text-xl font-semibold text-gray-600 mb-2">No tasks found</h3>
        <p class="text-gray-500 mb-6 max-w-md mx-auto">
            @if(auth()->user()->role == 'admin')
                Get started by creating your first task to organize your team's work efficiently.
            @else
                You don't have any tasks assigned yet. Tasks assigned to you will appear here.
            @endif
        </p>
        @if(auth()->user()->role == 'admin')
        <a href="{{ route('tasks.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors duration-200 inline-flex items-center shadow-sm hover:shadow-md">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Create Your First Task
        </a>
        @endif
    </div>
@endif
