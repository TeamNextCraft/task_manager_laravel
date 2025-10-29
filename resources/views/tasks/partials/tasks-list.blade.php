@if($tasks->count() > 0)
    <div class="space-y-4">
        @foreach ($tasks as $task)
            <div class="task-item border border-gray-200 rounded-lg p-4 hover:shadow-md transition-all duration-200 {{ $task->completed ? 'completed bg-green-50 border-green-200' : 'bg-white' }}" data-task-id="{{ $task->id }}">
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
                            <div class="flex items-center space-x-2">
                                <h4 class="text-lg font-semibold {{ $task->completed ? 'text-green-700 line-through' : 'text-gray-800' }}">
                                    {{ $task->title }}
                                </h4>
                                @if($task->completed)
                                    <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                        Completed
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium bg-orange-100 text-orange-800 rounded-full">
                                        Pending
                                    </span>
                                @endif
                            </div>

                            @if($task->description)
                                <p class="text-gray-600 mt-1 {{ $task->completed ? 'line-through' : '' }}">
                                    {{ $task->description }}
                                </p>
                            @endif

                            <div class="flex items-center mt-2 text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Assigned to: {{ $task->user->name }}
                            </div>

                            <div class="flex items-center mt-1 text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Created: {{ $task->created_at->format('M d, Y') }}

                                @if($task->completed)
                                    <svg class="w-4 h-4 ml-3 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Completed: {{ $task->updated_at->format('M d, Y') }}
                                @endif
                            </div>
                        </div>
                    </div>

                    @if(auth()->user()->role == 'admin')
                    <div class="flex space-x-2 ml-4">
                        <a href="{{ route('tasks.edit', $task->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm font-medium transition-colors duration-200 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit
                        </a>
                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this task?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm font-medium transition-colors duration-200 flex items-center">
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
    <div class="text-center py-8">
        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
        </svg>
        <h3 class="text-lg font-medium text-gray-900 mb-2">No tasks found</h3>
        <p class="text-gray-500 mb-4">
            @if(auth()->user()->role == 'admin')
                Create your first task to get started!
            @else
                No tasks have been assigned to you yet.
            @endif
        </p>
        @if(auth()->user()->role == 'admin')
        <a href="{{ route('tasks.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition-colors duration-200 inline-flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Create Your First Task
        </a>
        @endif
    </div>
@endif
