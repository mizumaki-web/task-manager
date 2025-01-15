<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

// タスク管理用のエンドポイント
Route::get('/tasks', [TaskController::class, 'index']); // タスク一覧取得
Route::post('/tasks', [TaskController::class, 'store']); // タスク作成
Route::put('/tasks/{id}', [TaskController::class, 'update']); // タスク更新
Route::delete('/tasks/{id}', [TaskController::class, 'destroy']); // タスク削除
