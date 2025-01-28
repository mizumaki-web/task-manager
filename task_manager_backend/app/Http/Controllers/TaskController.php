<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    // タスク一覧を取得
    public function index()
    {
        return response()->json([
            'tasks' => Task::all(),
        ]);
    }

    // 新しいタスクを作成
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);
    
        $task = Task::create($validated);
    
        return response()->json($task, 201);
    }
    

    // タスクを更新
    public function update(Request $request, Task $task)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'status' => 'required|string|max:255',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date',
    ]);

    $task->update($validated);

    return response()->json($task);
}


    // タスクを削除
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return response()->json(null, 204); // 204: No Content
    }
}
