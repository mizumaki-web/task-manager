<template>
  <form @submit.prevent="submitTask">
    <input v-model="task.title" type="text" placeholder="タスク名を入力" required />
    <select v-model="task.status">
      <option value="未着手">未着手</option>
      <option value="進行中">進行中</option>
      <option value="完了">完了</option>
    </select>
    <input v-model="task.start_date" type="date" placeholder="開始日" />
    <input v-model="task.end_date" type="date" placeholder="締切日" />
    <button type="submit">追加</button>
  </form>
</template>

<script>
export default {
  name: 'TaskForm',
  data() {
    return {
      task: {
        title: '',
        status: '未着手',
        start_date: '', // 開始日
        end_date: '',   // 締切日
      },
    };
  },
  methods: {
    submitTask() {
      this.$emit('add-task', this.task);
      this.task = {
        title: '',
        status: '未着手',
        start_date: '',
        end_date: '',
      }; // フォームをリセット
    },
  },
};
</script>


<style scoped>
form {
  display: flex;
  gap: 10px;
  justify-content: center;
  align-items: center;
}
</style>
