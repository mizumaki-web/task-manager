<template>
  <div>
    <h1>タスク管理</h1>
    <task-list
      :tasks="tasks"
      @edit-task="editTask"
      @delete-task="deleteTask"
    />
  </div>
</template>

<script>
import TaskList from './TaskList.vue';
import axios from 'axios';

export default {
  components: {
    TaskList,
  },
  data() {
    return {
      tasks: [],
    };
  },
  created() {
    this.fetchTasks();
  },
  methods: {
    // タスク一覧を取得
    async fetchTasks() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/tasks');
        this.tasks = response.data;
      } catch (error) {
        console.error('タスク一覧の取得に失敗しました:', error);
      }
    },
    // タスクを編集
    async editTask(updatedTask) {
      try {
        const response = await axios.put(
          `http://127.0.0.1:8000/api/tasks/${updatedTask.id}`,
          updatedTask
        );
        this.tasks = this.tasks.map((task) =>
          task.id === updatedTask.id ? response.data.task : task
        );
      } catch (error) {
        console.error('タスクの編集に失敗しました:', error);
      }
    },
    // タスクを削除
    async deleteTask(taskId) {
      try {
        await axios.delete(`http://127.0.0.1:8000/api/tasks/${taskId}`);
        this.tasks = this.tasks.filter((task) => task.id !== taskId);
      } catch (error) {
        console.error('タスクの削除に失敗しました:', error);
      }
    },
  },
};
</script>
