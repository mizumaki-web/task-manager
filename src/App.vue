<template>
  <div id="app">
    <h1>タスク管理アプリ</h1>
    <!-- カレンダー表示 -->
    <TaskCalendar :tasks="tasks" />

    <!-- タスク管理フォームとリスト -->
    <TaskForm @add-task="addTask" />
    <TaskList :tasks="tasks" @delete-task="deleteTask" @edit-task="editTask" />
  </div>
</template>

<script>
import TaskList from './components/TaskList.vue';
import TaskForm from './components/TaskForm.vue';
import TaskCalendar from './components/Calendar.vue'; // カレンダーコンポーネントをインポート
import apiClient from './api'; // APIクライアントをインポート

export default {
  components: {
    TaskList,
    TaskForm,
    TaskCalendar, // カレンダーコンポーネントを登録
  },
  data() {
    return {
      tasks: [], // タスクをAPIから取得
    };
  },
  created() {
    this.fetchTasks(); // コンポーネント作成時にタスク一覧を取得
  },
  methods: {
    fetchTasks() {
      apiClient.get('/tasks') // タスク一覧を取得
        .then(response => {
          console.log('タスク一覧取得:', response.data.tasks); // デバッグ用ログ
          this.tasks = response.data.tasks; // レスポンスデータを tasks に代入
        })
        .catch(error => {
          console.error('タスク一覧の取得に失敗しました:', error);
        });
    },
    addTask(newTask) {
      apiClient.post('/tasks', newTask) // バックエンドにタスクを送信
        .then(response => {
          console.log('追加されたタスク:', response.data); // デバッグ用ログ
          this.tasks.push(response.data); // レスポンスデータを tasks に追加
        })
        .catch(error => {
          console.error('タスクの追加に失敗しました:', error);
        });
    },
    deleteTask(taskId) {
      apiClient.delete(`/tasks/${taskId}`) // タスクをAPIから削除
        .then(() => {
          console.log(`削除されたタスクID: ${taskId}`); // デバッグ用ログ
          this.tasks = this.tasks.filter(task => task.id !== taskId); // ローカルのタスク一覧を更新
        })
        .catch(error => {
          console.error('タスクの削除に失敗しました:', error);
        });
    },
    editTask(updatedTask) {
      apiClient.put(`/tasks/${updatedTask.id}`, updatedTask) // タスクをAPIで更新
        .then(response => {
          console.log('更新されたタスク:', response.data); // デバッグ用ログ
          const index = this.tasks.findIndex(task => task.id === updatedTask.id);
          if (index !== -1) {
            this.tasks.splice(index, 1, response.data); // 更新内容を反映
          }
        })
        .catch(error => {
          console.error('タスクの更新に失敗しました:', error);
        });
    },
  },
};
</script>

<style>
#app {
  font-family: Arial, sans-serif;
  text-align: center;
  margin: 20px;
}
</style>

