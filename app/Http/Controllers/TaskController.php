<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    // ✅ Get all tasks
    public function index()
    {
        return response()->json(Task::all(), 200);
    }

    // ✅ Store new task
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'completed' => 'required|boolean',
        ]);

        $task = Task::create($validated);

        return response()->json($task, 201);
    }

    // ✅ Show one task
    public function show($id)
    {
        $task = Task::findOrFail($id);
        return response()->json($task, 200);
    }

    // ✅ Update task
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'completed' => 'required|boolean',
        ]);

        $task->update($validated);

        return response()->json($task, 200);
    }

    // ✅ Delete task
    public function destroy($id)
    {
        Task::destroy($id);

        return response()->json(['message' => 'Task deleted successfully'], 204);
    }
}