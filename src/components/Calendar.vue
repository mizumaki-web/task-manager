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
  data() {
    return { 
      calendarOptions: {
        plugins: [dayGridPlugin],
        initialView: 'dayGridMonth',
        events: [], // タスクのイベントデータをここに追加
      },
    };
  },
  props: {
    tasks: Array, // タスク一覧を親から受け取る
  },
  watch: {
  tasks: {
    handler(newTasks) {
      this.calendarOptions.events = newTasks
        .filter(task => task.start_date && task.end_date) // 日付があるタスクだけ
        .map(task => ({
          title: task.title,
          start: task.start_date, // 開始日
          end: task.end_date,     // 締切日
        }));
    },
    deep: true,
  },
},

});
</script>

<style>
/* 必要に応じてCSSを追加 */
</style>
