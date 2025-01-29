<template>
  <div :class="{ 'dark-mode': isDarkMode }" id="app">
    <button @click="toggleDarkMode">
      ダークモード: {{ isDarkMode ? 'オン' : 'オフ' }}
    </button>
    <h1>タスク管理アプリ</h1>
    <TaskForm @add-task="addTask" />
    <TaskList :tasks="tasks" @delete-task="deleteTask" @edit-task="editTask" />
    <Calendar :tasks="tasks" /> <!-- tasks を Calendar に渡す -->
  </div>
</template>

<script>
import TaskList from './components/TaskList.vue';
import TaskForm from './components/TaskForm.vue';
import Calendar from './components/Calendar.vue';
import apiClient from './api';

export default {
  components: {
    TaskList,
    TaskForm,
    Calendar,
  },
  data() {
    return {
      tasks: [], // タスク一覧
      isDarkMode: false, // ダークモード状態
    };
  },
  created() {
    this.fetchTasks(); // タスク一覧を取得
  },
  methods: {
    // タスク一覧を取得
    fetchTasks() {
      apiClient.get('/tasks')
        .then(response => {
          this.tasks = response.data.tasks; // タスク一覧を代入
        })
        .catch(error => {
          console.error('タスク一覧の取得に失敗しました:', error);
        });
    },
    // 新しいタスクを追加
    addTask(newTask) {
      apiClient.post('/tasks', newTask)
        .then(response => {
          this.tasks.push(response.data); // 新しいタスクをリストに追加
        })
        .catch(error => {
          console.error('タスクの追加に失敗しました:', error);
        });
    },
    // タスクを削除
    deleteTask(taskId) {
      apiClient.delete(`/tasks/${taskId}`)
        .then(() => {
          this.tasks = this.tasks.filter(task => task.id !== taskId); // タスクを削除
        })
        .catch(error => {
          console.error('タスクの削除に失敗しました:', error);
        });
    },
    // タスクを編集
   editTask(updatedTask) {
  console.log('送信する更新データ:', {
    ...updatedTask,
    start_date: updatedTask.start_date || null,
    end_date: updatedTask.end_date || null,
  });

  apiClient.put(`/tasks/${updatedTask.id}`, {
    ...updatedTask,
    start_date: updatedTask.start_date || null,
    end_date: updatedTask.end_date || null,
  })
    .then(response => {
      console.log('サーバーからの応答:', response.data);
      const index = this.tasks.findIndex(task => task.id === updatedTask.id);
      if (index !== -1) {
        this.tasks.splice(index, 1, response.data);
      }
    })
    .catch(error => {
      console.error('タスクの更新に失敗しました:', error);
    });
},
    // ダークモードを切り替える
    toggleDarkMode() {
      this.isDarkMode = !this.isDarkMode;
    },
  },
};
</script>

<style>
/* 通常モードのスタイル */
#app {
  font-family: Arial, sans-serif;
  text-align: center;
  margin: 20px;
}

/* ダークモードのスタイル */
.dark-mode {
  background-color: #333;
  color: #fff;
}

/* ボタンのスタイル */
button {
  margin: 10px;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

/* ダークモード用のボタンスタイル */
.dark-mode button {
  background-color: #555;
  color: #fff;
}
</style>
