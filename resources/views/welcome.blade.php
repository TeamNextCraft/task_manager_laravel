<x-app-layout>
    <section class="py-12 bg-gradient-to-br from-blue-50 to-indigo-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Hero Section -->
            <div class="text-center mb-16 w-full">
                <h1 class="text-3xl lg:text-5xl font-bold text-gray-900 mb-6 text-wrap">
                    Streamline Your
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-700">
                        Task Management
                    </span>
                </h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto mb-8">
                    Efficiently manage personal and team tasks. Admins assign tasks, users track progress,
                    and everyone stays productive with our intuitive task management system.
                </p>

                @auth
                    <div class="flex flex-col sm:flex-row justify-center gap-4 mb-12">
                        <a href="{{ route('tasks.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-all duration-200 transform hover:scale-105 shadow-lg flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            View My Tasks
                        </a>
                        @if(Auth::user()->role === 'admin')
                        <a href="{{ route('tasks.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-all duration-200 transform hover:scale-105 shadow-lg flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Create New Task
                        </a>
                        @endif
                    </div>
                @else
                    <div class="flex flex-col sm:flex-row justify-center gap-4 mb-12">
                        <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg font-semibold text-lg transition-all duration-200 transform hover:scale-105 shadow-lg">
                            Get Started - Login
                        </a>
                        <a href="{{ route('register') }}" class="border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white px-8 py-4 rounded-lg font-semibold text-lg transition-all duration-200 transform hover:scale-105">
                            Create Account
                        </a>
                    </div>
                @endauth
            </div>

            <!-- Features Grid -->
            <div class="grid md:grid-cols-3 gap-8 mb-16">
                <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Role-Based Access</h3>
                    <p class="text-gray-600">
                        Admins create and assign tasks to users. Team members view and manage their assigned tasks efficiently.
                    </p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Task Tracking</h3>
                    <p class="text-gray-600">
                        Monitor task progress with detailed descriptions and user assignments. Stay on top of your workload.
                    </p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Quick Actions</h3>
                    <p class="text-gray-600">
                        Create, assign, and manage tasks with our intuitive interface designed for maximum productivity.
                    </p>
                </div>
            </div>

            <!-- Stats Section -->
            @auth
            <div class="bg-white rounded-2xl shadow-xl p-8 mb-16">
                <h2 class="text-3xl font-bold text-center text-gray-900 mb-8">Your Dashboard Overview</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div class="text-center p-4">
                        <div class="text-3xl font-bold text-blue-600 mb-2">
                            {{ Auth::user()->tasks->count() }}
                        </div>
                        <div class="text-gray-600 font-medium">Total Tasks</div>
                    </div>
                    <div class="text-center p-4">
                        <div class="text-3xl font-bold text-green-600 mb-2">
                            {{ Auth::user()->tasks->where('completed', true)->count() }}
                        </div>
                        <div class="text-gray-600 font-medium">Completed</div>
                    </div>
                    <div class="text-center p-4">
                        <div class="text-3xl font-bold text-orange-600 mb-2">
                            {{ Auth::user()->tasks->where('completed', false)->count() }}
                        </div>
                        <div class="text-gray-600 font-medium">Pending</div>
                    </div>
                    <div class="text-center p-4">
                        <div class="text-3xl font-bold text-purple-600 mb-2">
                            {{ Auth::user()->role === 'admin' ? 'Admin' : 'User' }}
                        </div>
                        <div class="text-gray-600 font-medium">Role</div>
                    </div>
                </div>
            </div>
            @endif

            <!-- How It Works -->
            <div class="text-center">
                <h2 class="text-3xl font-bold text-gray-900 mb-12">How It Works</h2>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-blue-600 text-white rounded-full flex items-center justify-center text-xl font-bold mx-auto mb-4">1</div>
                        <h3 class="text-xl font-semibold mb-3">Admins Create Tasks</h3>
                        <p class="text-gray-600">Administrators create tasks with titles and descriptions</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-green-600 text-white rounded-full flex items-center justify-center text-xl font-bold mx-auto mb-4">2</div>
                        <h3 class="text-xl font-semibold mb-3">Assign to Users</h3>
                        <p class="text-gray-600">Tasks are assigned to specific team members</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-purple-600 text-white rounded-full flex items-center justify-center text-xl font-bold mx-auto mb-4">3</div>
                        <h3 class="text-xl font-semibold mb-3">Track Progress</h3>
                        <p class="text-gray-600">Users update task status and mark completion</p>
                    </div>
                </div>
            </div>

            <!-- Recent Activity (Placeholder for future implementation) -->
            @auth
            <div class="mt-16 bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-8 text-center text-white">
                <h2 class="text-2xl font-bold mb-4">Ready to boost your productivity?</h2>
                <p class="text-blue-100 mb-6">Start managing your tasks effectively today</p>
                <a href="{{ route('tasks.index') }}" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-blue-50 transition-colors duration-200 inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                    Go to Task Dashboard
                </a>
            </div>
            @endif
        </div>
    </section>
</x-app-layout>
