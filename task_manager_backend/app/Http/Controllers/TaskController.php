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
    public function update(Request $request, $id) // ここを Task $task から $id に変更
{
    \Log::info('受信した更新リクエスト:', $request->all());

    // IDからタスクを取得
    $task = Task::findOrFail($id);

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'status' => 'required|string|max:255',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date',
    ]);

    \Log::info('バリデーション後のデータ:', $validated);

    // データを手動で代入
    $task->title = $validated['title'];
    $task->status = $validated['status'];
    $task->start_date = $validated['start_date'] ?? null;
    $task->end_date = $validated['end_date'] ?? null;

    // 変更を保存
    $task->save();

    // 変更を強制的に取得
    $task->refresh();

    \Log::info('更新後のタスク:', $task->toArray());

    return response()->json($task);
}
// タスクを削除
public function destroy($id)
{
    \Log::info("削除リクエストを受信: タスクID {$id}");

    // タスクを検索して削除
    $task = Task::find($id);
    if (!$task) {
        \Log::error("タスクが見つかりません: ID {$id}");
        return response()->json(['error' => 'タスクが見つかりません'], 404);
    }

    $task->delete();
    \Log::info("タスクを削除しました: ID {$id}");

    return response()->json(null, 204); // 204: No Content
}


}
