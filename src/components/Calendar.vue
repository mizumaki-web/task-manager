<template>
  <div>
    <FullCalendar
      :events="events"
      :initialView="'dayGridMonth'"
      @dateClick="handleDateClick"
    />
  </div>
</template>

<script>
import FullCalendar from "@fullcalendar/vue3";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";

export default {
  components: {
    FullCalendar,
  },
  data() {
    return {
      events: [
        { title: "タスク1", start: "2025-01-15" },
        { title: "タスク2", start: "2025-01-20" },
      ],
    };
  },
  methods: {
    handleDateClick(info) {
      console.log("選択した日付:", info.dateStr);
    },
  },
};
</script>
