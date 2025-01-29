<template>
  <div>
    <h2>タスク一覧</h2>
    <ul>
      <li
        v-for="task in tasks"
        :key="task.id"
        :style="{ backgroundColor: getTaskColor(task.status), color: getTaskTextColor() }"
      >
        <!-- 編集モード -->
        <div v-if="editTaskId === task.id">
          <input v-model="editTaskTitle" placeholder="タスク名を入力" />
          <input v-model="editTaskStartDate" type="date" placeholder="開始日" />
          <input v-model="editTaskEndDate" type="date" placeholder="終了日" />
          <select v-model="editTaskStatus">
            <option>未着手</option>
            <option>進行中</option>
            <option>完了</option>
          </select>
          <button @click="saveTask(task.id)">保存</button>
          <button @click="cancelEdit">キャンセル</button>
        </div>

        <!-- 通常モード -->
        <div v-else>
          {{ task.title }} - {{ task.status }}
          <br />
          開始日: {{ task.start_date ? task.start_date : '未設定' }}
          <br />
          終了日: {{ task.end_date ? task.end_date : '未設定' }}
          <button @click="startEdit(task)">編集</button>
          <button @click="confirmDelete(task)">削除</button>
        </div>
      </li>
    </ul>
    
    <!-- 削除確認モーダル -->
    <div v-if="showDeleteConfirm" class="modal-overlay">
      <div class="modal">
        <p>「{{ deleteTaskTitle }}」を削除しますか？</p>
        <button @click="deleteTask">削除する</button>
        <button @click="cancelDelete">キャンセル</button>
      </div>
    </div>
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
      editTaskStartDate: '',
      editTaskEndDate: '',
      showDeleteConfirm: false,
      deleteTaskId: null,
      deleteTaskTitle: '',
    };
  },
  methods: {
    startEdit(task) {
      this.editTaskId = task.id;
      this.editTaskTitle = task.title || ''; // nullの時に空文字をセット
      this.editTaskStatus = task.status || '未着手'; 
      this.editTaskStartDate = task.start_date ? task.start_date : ''; 
      this.editTaskEndDate = task.end_date ? task.end_date : ''; 
    },
    saveTask(taskId) {
  this.$emit('edit-task', {
    id: taskId,
    title: this.editTaskTitle.trim(), // タイトルのトリム処理
    status: this.editTaskStatus,
    start_date: this.editTaskStartDate || null, // 空文字をnullに変換
    end_date: this.editTaskEndDate || null, // 空文字をnullに変換
  });
  this.cancelEdit();
},
    cancelEdit() {
      this.editTaskId = null;
      this.editTaskTitle = '';
      this.editTaskStatus = '';
      this.editTaskStartDate = '';
      this.editTaskEndDate = '';
    },
    confirmDelete(task) {
      this.showDeleteConfirm = true;
      this.deleteTaskId = task.id;
      this.deleteTaskTitle = task.title;
    },
    deleteTask() {
      this.$emit('delete-task', this.deleteTaskId);
      this.cancelDelete();
    },
    cancelDelete() {
      this.showDeleteConfirm = false;
      this.deleteTaskId = null;
      this.deleteTaskTitle = '';
    },
    getTaskColor(status) {
      switch (status) {
        case '未着手':
          return '#FFCCCC'; // 赤
        case '進行中':
          return '#FFFF99'; // 黄色
        case '完了':
          return '#CCFFCC'; // 緑
        default:
          return '#FFFFFF'; // デフォルト白
      }
    },
    getTaskTextColor() {
      return document.body.classList.contains('dark-mode') ? '#000000' : '#333333';
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
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  display: flex;
  flex-direction: column; /* 縦に並べる */
}
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}
.modal {
  background: #fff;
  padding: 20px;
  border-radius: 5px;
  text-align: center;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}
.modal button {
  margin: 10px;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}
.modal button:first-child {
  background: #ff4444;
  color: #fff;
}
.modal button:last-child {
  background: #ccc;
  color: #333;
}
</style>
