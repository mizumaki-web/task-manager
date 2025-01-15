<template>
    <div>
      <h2>タスク追加</h2>
      <form @submit.prevent="addTask">
        <input
          type="text"
          v-model="newTask.title"
          placeholder="タスク名を入力"
        />
        <select v-model="newTask.status">
          <option>未着手</option>
          <option>進行中</option>
          <option>完了</option>
        </select>
        <button type="submit">追加</button>
      </form>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        newTask: {
          title: '',
          status: '未着手',
        },
      };
    },
    methods: {
      addTask() {
        this.$emit('add-task', { ...this.newTask, id: Date.now() });
        this.newTask.title = '';
        this.newTask.status = '未着手';
      },
    },
  };
  </script>
  
  <style scoped>
  form {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
    align-items: center;
    justify-content: center;
  }
  
  input, select {
    flex: 1;
    max-width: 300px;
  }
  
  button {
    flex-shrink: 0;
  }
  </style>
  