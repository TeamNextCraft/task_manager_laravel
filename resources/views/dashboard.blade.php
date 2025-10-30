<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Dashboard') }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Welcome back, {{ Auth::user()->name }}!</p>
            </div>
            <div class="text-sm text-gray-500">
                {{ now()->format('l, F j, Y') }}
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-blue-500">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Total Tasks</p>
                                <p class="text-2xl font-semibold text-gray-900">
                                    {{ \App\Models\Task::when(Auth::user()->role !== 'admin', function($query) {
                                        return $query->where('user_id', Auth::id());
                                    })->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-green-500">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Completed</p>
                                <p class="text-2xl font-semibold text-gray-900">
                                    {{ \App\Models\Task::when(Auth::user()->role !== 'admin', function($query) {
                                        return $query->where('user_id', Auth::id());
                                    })->where('completed', true)->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-orange-500">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Pending</p>
                                <p class="text-2xl font-semibold text-gray-900">
                                    {{ \App\Models\Task::when(Auth::user()->role !== 'admin', function($query) {
                                        return $query->where('user_id', Auth::id());
                                    })->where('completed', false)->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-red-500">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Overdue</p>
                                <p class="text-2xl font-semibold text-gray-900">
                                    {{ \App\Models\Task::when(Auth::user()->role !== 'admin', function($query) {
                                        return $query->where('user_id', Auth::id());
                                    })->where('completed', false)->where('due_date', '<', now())->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-purple-500">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Your Role</p>
                                <p class="text-2xl font-semibold text-gray-900 capitalize">
                                    {{ Auth::user()->role }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Recent Tasks & Priority Overview -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Recent Tasks -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 border-b border-gray-200">
                            <div class="flex justify-between items-center">
                                <h3 class="text-lg font-semibold text-gray-900">Recent Tasks</h3>
                                <a href="{{ route('tasks.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center">
                                    View All
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="p-6">
                            @php
                                $recentTasks = \App\Models\Task::with('user')
                                    ->when(Auth::user()->role !== 'admin', function($query) {
                                        return $query->where('user_id', Auth::id());
                                    })
                                    ->latest()
                                    ->take(6)
                                    ->get();
                            @endphp

                            @if($recentTasks->count() > 0)
                                <div class="space-y-4">
                                    @foreach($recentTasks as $task)
                                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                                            <div class="flex items-center space-x-3 flex-1">
                                                <div class="flex-shrink-0">
                                                    @if($task->completed)
                                                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                            </svg>
                                                        </div>
                                                    @elseif($task->due_date && $task->due_date->isPast())
                                                        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>
                                                        </div>
                                                    @else
                                                        <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center">
                                                            <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center space-x-2">
                                                        <h4 class="text-sm font-medium text-gray-900 truncate">{{ $task->title }}</h4>
                                                        @if($task->priority)
                                                            <span class="px-2 py-1 text-xs font-medium rounded-full
                                                                @if($task->priority === 'urgent') bg-red-100 text-red-800
                                                                @elseif($task->priority === 'high') bg-orange-100 text-orange-800
                                                                @elseif($task->priority === 'medium') bg-yellow-100 text-yellow-800
                                                                @else bg-green-100 text-green-800 @endif">
                                                                {{ $task->priority }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="flex flex-wrap items-center gap-2 mt-1 text-xs text-gray-500">
                                                        @if(Auth::user()->role === 'admin')
                                                            <span>Assigned to: {{ $task->user->name }}</span>
                                                        @endif
                                                        @if($task->category)
                                                            <span>•</span>
                                                            <span class="capitalize">{{ $task->category }}</span>
                                                        @endif
                                                        <span>•</span>
                                                        <span>{{ $task->created_at->diffForHumans() }}</span>
                                                        @if($task->due_date)
                                                            <span>•</span>
                                                            <span class="{{ $task->due_date->isPast() && !$task->completed ? 'text-red-600 font-medium' : '' }}">
                                                                Due: {{ $task->due_date->format('M j') }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                @if(Auth::user()->role === 'admin')
                                                    <a href="{{ route('tasks.edit', $task->id) }}" class="text-gray-400 hover:text-blue-600 transition-colors duration-200 p-1 rounded">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    <p class="text-gray-500">No tasks found</p>
                                    @if(Auth::user()->role === 'admin')
                                        <a href="{{ route('tasks.create') }}" class="inline-block mt-2 text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            Create your first task
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Priority Distribution -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Tasks by Priority</h3>
                        </div>
                        <div class="p-6">
                            @php
                                $priorities = [
                                    'urgent' => [
                                        'count' => \App\Models\Task::when(Auth::user()->role !== 'admin', function($query) {
                                            return $query->where('user_id', Auth::id());
                                        })->where('priority', 'urgent')->where('completed', false)->count(),
                                        'color' => 'bg-red-500',
                                        'text' => 'text-red-600',
                                        'bg' => 'bg-red-50'
                                    ],
                                    'high' => [
                                        'count' => \App\Models\Task::when(Auth::user()->role !== 'admin', function($query) {
                                            return $query->where('user_id', Auth::id());
                                        })->where('priority', 'high')->where('completed', false)->count(),
                                        'color' => 'bg-orange-500',
                                        'text' => 'text-orange-600',
                                        'bg' => 'bg-orange-50'
                                    ],
                                    'medium' => [
                                        'count' => \App\Models\Task::when(Auth::user()->role !== 'admin', function($query) {
                                            return $query->where('user_id', Auth::id());
                                        })->where('priority', 'medium')->where('completed', false)->count(),
                                        'color' => 'bg-yellow-500',
                                        'text' => 'text-yellow-600',
                                        'bg' => 'bg-yellow-50'
                                    ],
                                    'low' => [
                                        'count' => \App\Models\Task::when(Auth::user()->role !== 'admin', function($query) {
                                            return $query->where('user_id', Auth::id());
                                        })->where('priority', 'low')->where('completed', false)->count(),
                                        'color' => 'bg-green-500',
                                        'text' => 'text-green-600',
                                        'bg' => 'bg-green-50'
                                    ],
                                ];
                                $totalPending = array_sum(array_column($priorities, 'count'));
                            @endphp

                            <div class="space-y-4">
                                @foreach($priorities as $priority => $data)
                                    @if($data['count'] > 0)
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3 flex-1">
                                            <div class="w-3 h-3 {{ $data['color'] }} rounded-full"></div>
                                            <span class="text-sm font-medium text-gray-700 capitalize">{{ $priority }}</span>
                                            <span class="text-xs text-gray-500">({{ $data['count'] }})</span>
                                        </div>
                                        <div class="w-24 bg-gray-200 rounded-full h-2">
                                            <div class="{{ $data['color'] }} h-2 rounded-full transition-all duration-500"
                                                 style="width: {{ $totalPending > 0 ? ($data['count'] / $totalPending) * 100 : 0 }}%"></div>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach

                                @if($totalPending === 0)
                                    <p class="text-gray-500 text-sm text-center py-4">No pending tasks</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions & Stats -->
                <div class="space-y-8">
                    <!-- Quick Actions -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                <a href="{{ route('tasks.index') }}" class="w-full flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-200 transition-colors duration-200 group">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors duration-200">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                            </svg>
                                        </div>
                                        <span class="text-sm font-medium text-gray-700">View All Tasks</span>
                                    </div>
                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-600 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>

                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('tasks.create') }}" class="w-full flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-green-50 hover:border-green-200 transition-colors duration-200 group">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition-colors duration-200">
                                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                </svg>
                                            </div>
                                            <span class="text-sm font-medium text-gray-700">Create New Task</span>
                                        </div>
                                        <svg class="w-4 h-4 text-gray-400 group-hover:text-green-600 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                @endif

                                <a href="{{ route('profile.edit') }}" class="w-full flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-purple-50 hover:border-purple-200 transition-colors duration-200 group">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition-colors duration-200">
                                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                        <span class="text-sm font-medium text-gray-700">Edit Profile</span>
                                    </div>
                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-purple-600 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Overview -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Progress Overview</h3>
                        </div>
                        <div class="p-6">
                            @php
                                $totalTasks = \App\Models\Task::when(Auth::user()->role !== 'admin', function($query) {
                                    return $query->where('user_id', Auth::id());
                                })->count();

                                $completedTasks = \App\Models\Task::when(Auth::user()->role !== 'admin', function($query) {
                                    return $query->where('user_id', Auth::id());
                                })->where('completed', true)->count();

                                $completionRate = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;
                            @endphp

                            <div class="space-y-4">
                                <div>
                                    <div class="flex justify-between text-sm text-gray-600 mb-1">
                                        <span>Completion Rate</span>
                                        <span>{{ number_format($completionRate, 1) }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-green-600 h-2 rounded-full transition-all duration-500" style="width: {{ $completionRate }}%"></div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-3 gap-2 text-center">
                                    <div class="p-2 bg-blue-50 rounded-lg">
                                        <div class="text-lg font-semibold text-blue-600">{{ $totalTasks }}</div>
                                        <div class="text-xs text-gray-600">Total</div>
                                    </div>
                                    <div class="p-2 bg-green-50 rounded-lg">
                                        <div class="text-lg font-semibold text-green-600">{{ $completedTasks }}</div>
                                        <div class="text-xs text-gray-600">Done</div>
                                    </div>
                                    <div class="p-2 bg-orange-50 rounded-lg">
                                        <div class="text-lg font-semibold text-orange-600">{{ $totalTasks - $completedTasks }}</div>
                                        <div class="text-xs text-gray-600">Pending</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upcoming Deadlines -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Upcoming Deadlines</h3>
                        </div>
                        <div class="p-6">
                            @php
                                $upcomingTasks = \App\Models\Task::with('user')
                                    ->when(Auth::user()->role !== 'admin', function($query) {
                                        return $query->where('user_id', Auth::id());
                                    })
                                    ->where('completed', false)
                                    ->where('due_date', '>', now())
                                    ->where('due_date', '<=', now()->addDays(7))
                                    ->orderBy('due_date')
                                    ->take(3)
                                    ->get();
                            @endphp

                            @if($upcomingTasks->count() > 0)
                                <div class="space-y-3">
                                    @foreach($upcomingTasks as $task)
                                        <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                                            <div class="flex-1 min-w-0">
                                                <h4 class="text-sm font-medium text-gray-900 truncate">{{ $task->title }}</h4>
                                                <p class="text-xs text-gray-500 mt-1">
                                                    Due: {{ $task->due_date->format('M j, g:i A') }}
                                                    <span class="ml-1 text-orange-600">
                                                        ({{ $task->due_date->diffForHumans() }})
                                                    </span>
                                                </p>
                                            </div>
                                            @if($task->priority === 'urgent' || $task->priority === 'high')
                                                <span class="flex-shrink-0 ml-2 px-2 py-1 text-xs font-medium rounded-full
                                                    @if($task->priority === 'urgent') bg-red-100 text-red-800
                                                    @else bg-orange-100 text-orange-800 @endif">
                                                    {{ $task->priority }}
                                                </span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 text-sm text-center py-4">No upcoming deadlines</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Admin Stats (Only for admins) -->
            @if(Auth::user()->role === 'admin')
            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Admin Overview</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="text-center p-4 border border-gray-200 rounded-lg">
                            <div class="text-2xl font-bold text-blue-600">{{ \App\Models\User::count() }}</div>
                            <div class="text-sm text-gray-600">Total Users</div>
                        </div>
                        <div class="text-center p-4 border border-gray-200 rounded-lg">
                            <div class="text-2xl font-bold text-green-600">{{ \App\Models\Task::count() }}</div>
                            <div class="text-sm text-gray-600">All Tasks</div>
                        </div>
                        <div class="text-center p-4 border border-gray-200 rounded-lg">
                            <div class="text-2xl font-bold text-purple-600">
                                {{ \App\Models\Task::where('completed', true)->count() }}
                            </div>
                            <div class="text-sm text-gray-600">Completed Tasks</div>
                        </div>
                        <div class="text-center p-4 border border-gray-200 rounded-lg">
                            <div class="text-2xl font-bold text-orange-600">
                                {{ \App\Models\Task::where('completed', false)->count() }}
                            </div>
                            <div class="text-sm text-gray-600">Pending Tasks</div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
