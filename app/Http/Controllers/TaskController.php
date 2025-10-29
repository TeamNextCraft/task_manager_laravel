<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the tasks.
     */
    public function index(Request $request)
    {
        $tasks = Task::with('user')
            ->when(Auth::user()->role !== 'admin', function ($query) {
                return $query->where('user_id', Auth::id());
            })
            ->latest()
            ->get();

        // Check if it's an AJAX request
        if ($request->ajax() || $request->has('ajax')) {
            return view('tasks.partials.tasks-list', compact('tasks'))->render();
        }

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new task.
     */
    public function create()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('tasks.create', compact('users'));
    }

    /**
     * Store a newly created task in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
        ]);

        Task::create($request->all());

        return redirect()->route('tasks.index')
            ->with('success', 'Task created successfully.');
    }

    /**
     * Show the form for editing the specified task.
     */
    public function edit(Task $task)
    {
        $users = User::all();
        return view('tasks.edit', compact('task', 'users'));
    }

    /**
     * Update the specified task in storage.
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $task->update($request->all());

        return redirect()->route('tasks.index')
            ->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified task from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Task deleted successfully.');
    }

    /**
     * Toggle task completion status
     */
    public function toggle(Request $request, Task $task)
    {
        // Check if user is authorized to toggle this task
        if (Auth::user()->role !== 'admin' && $task->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $task->update([
            'completed' => !$task->completed
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'completed' => $task->completed,
                'message' => $task->completed ? 'Task marked as completed!' : 'Task marked as pending!'
            ]);
        }

        return redirect()->route('tasks.index')
            ->with('success', $task->completed ? 'Task marked as completed!' : 'Task marked as pending!');
    }
}
