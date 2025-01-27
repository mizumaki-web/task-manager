<template>
  <div>
    <h2>タスク一覧</h2>
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
  padding: 0;
  list-style: none;
}
li {
  margin: 10px 0;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
</style>
