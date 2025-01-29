<template>
  <div>
    <FullCalendar :options="calendarOptions" />
  </div>
</template>

<script>
import { defineComponent } from 'vue'
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'

export default defineComponent({
  name: 'TaskCalendar',
  components: {
    FullCalendar,
  },
  props: {
    tasks: Array, // タスク一覧を親から受け取る
  },
  data() {
    return {
      calendarOptions: {
        plugins: [dayGridPlugin],
        initialView: 'dayGridMonth',
        events: [], // イベントデータ
        eventTextColor: '#000000', // 黒文字
      },
    }
  },
  watch: {
    tasks: {
      handler(newTasks) {
        this.calendarOptions.events = newTasks.map(task => ({
          title: task.title,
          start: task.start_date,
          end: task.end_date ? this.addOneDay(task.end_date) : task.start_date, // end_dateを+1日
          backgroundColor: this.getEventColor(task.status), // ステータスによる色設定
          borderColor: this.getEventColor(task.status),
          textColor: '#000000', // 黒文字指定
        }));
      },
      deep: true,
    },
  },
  methods: {
    getEventColor(status) {
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
    addOneDay(dateString) {
      // 日付を1日加算
      let date = new Date(dateString);
      date.setDate(date.getDate() + 1);
      return date.toISOString().split('T')[0]; // YYYY-MM-DD 形式に戻す
    }
  }
})
</script>

<style scoped>
/* ダークモード対応 */
body.dark-mode {
  background-color: #333; /* 背景をダーク */
  color: #FFF; /* テキストを白に */
}

/* カレンダーの文字色や背景色を調整 */
.fc-event {
  font-weight: bold;
  padding: 2px;
}

/* イベントの背景を調整（ダークモード用） */
body.dark-mode .fc-event {
  color: #FFF !important; /* イベント内の文字を白 */
}
</style>
