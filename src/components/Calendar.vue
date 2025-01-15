<template>
  <FullCalendar
    :plugins="calendarPlugins"
    :events="events"
  ></FullCalendar>
</template>

<script>
import FullCalendar from '@fullcalendar/vue3';
import dayGridPlugin from '@fullcalendar/daygrid';

export default {
  name: 'TaskCalendar',
  props: {
    tasks: {
      type: Array,
      required: true,
    },
  },
  components: { FullCalendar },
  data() {
    return {
      events: [],
      calendarPlugins: [dayGridPlugin], // 必須のプラグインを明示的に指定
    };
  },
  watch: {
    tasks: {
      immediate: true,
      handler(newTasks) {
        this.events = newTasks.map(task => ({
          title: task.title,
          start: task.due_date,
        }));
      },
    },
  },
};
</script>

<style>
/* 必要であればスタイルを追加 */
</style>
