<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

// タスク関連のAPIルート
Route::get('/tasks', [TaskController::class, 'index']); // タスク一覧取得
Route::post('/tasks', [TaskController::class, 'store']); // 新しいタスクを作成
Route::put('/tasks/{id}', [TaskController::class, 'update']); // タスクを更新
Route::delete('/tasks/{id}', [TaskController::class, 'destroy']); // タスクを削除
