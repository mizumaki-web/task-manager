<template>
  <div>
    <h1>タスク一覧</h1>
    <ul>
      <li v-for="task in tasks" :key="task.id">
        <div v-if="editTaskId === task.id">
          <input v-model="editTaskTitle" placeholder="タスク名を入力" />
          <select v-model="editTaskStatus">
            <option>未着手</option>
            <option>進行中</option>
            <option>完了</option>
          </select>
          <button @click="saveTask(task.id)">保存</button>
          <button @click="cancelEdit">キャンセル</button>
        </div>
        <div v-else>
          {{ task.title }} - {{ task.status }}
          <button @click="startEdit(task)">編集</button>
          <button @click="deleteTask(task.id)">削除</button>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  props: {
    tasks: Array,
  },
  data() {
    return {
      editTaskId: null,
      editTaskTitle: '',
      editTaskStatus: '',
    };
  },
  methods: {
    startEdit(task) {
      this.editTaskId = task.id;
      this.editTaskTitle = task.title;
      this.editTaskStatus = task.status;
    },
    saveTask(taskId) {
      this.$emit('edit-task', {
        id: taskId,
        title: this.editTaskTitle,
        status: this.editTaskStatus,
      });
      this.cancelEdit();
    },
    cancelEdit() {
      this.editTaskId = null;
      this.editTaskTitle = '';
      this.editTaskStatus = '';
    },
    deleteTask(taskId) {
      this.$emit('delete-task', taskId);
    },
  },
};
</script>

<style scoped>
ul {
  max-width: 600px;
  margin: 0 auto;
  padding: 0;
  background: white;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  border-radius: 8px;
}

li {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px;
  border-bottom: 1px solid #ddd;
}

li:last-child {
  border-bottom: none;
}

button {
  margin-left: 10px;
}
</style>