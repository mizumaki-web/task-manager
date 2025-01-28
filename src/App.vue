<template>
  <div id="app">
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
    };
  },
  created() {
    this.fetchTasks(); // タスク一覧を取得
  },
  methods: {
    fetchTasks() {
      apiClient.get('/tasks')
        .then(response => {
          this.tasks = response.data.tasks; // タスク一覧を代入
        })
        .catch(error => {
          console.error('タスク一覧の取得に失敗しました:', error);
        });
    },
    addTask(newTask) {
    apiClient.post('/tasks', newTask)
      .then(response => {
        this.tasks.push(response.data); // 新しいタスクをリストに追加
      })
      .catch(error => {
        console.error('タスクの追加に失敗しました:', error);
      });
  },
    deleteTask(taskId) {
      apiClient.delete(`/tasks/${taskId}`)
        .then(() => {
          this.tasks = this.tasks.filter(task => task.id !== taskId); // タスクを削除
        })
        .catch(error => {
          console.error('タスクの削除に失敗しました:', error);
        });
    },
    editTask(updatedTask) {
      apiClient.put(`/tasks/${updatedTask.id}`, updatedTask)
        .then(response => {
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
