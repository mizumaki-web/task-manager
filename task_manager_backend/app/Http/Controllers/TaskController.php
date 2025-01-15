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
        $task = Task::create($request->only(['title', 'status']));
        return response()->json($task, 201); // 201: Created
    }

    // タスクを更新
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->update($request->only(['title', 'status']));
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
