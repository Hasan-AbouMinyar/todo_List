<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    // ✅ Get all tasks
    public function index()
    {
        return Task::all();
    }

    // ✅ Store new task
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'completed' => false,
        ]);

        return response()->json($task, 201);
    }

    // ✅ Show one task
    public function show($id)
    {
        return Task::findOrFail($id);
    }

    // ✅ Update task
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $task->update($request->all());

        return response()->json($task);
    }

    // ✅ Delete task
    public function destroy($id)
    {
        Task::destroy($id);

        return response()->json(null, 204);
    }
}