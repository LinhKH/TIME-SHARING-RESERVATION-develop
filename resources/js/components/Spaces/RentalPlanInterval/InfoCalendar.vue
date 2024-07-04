<template>
  <div class="flex flex-wrap justify-between px-2 mt-3">
    <div class="w-1/5" v-for="(item, index) in exampleCalendar" :key="index">
      <div class="px-2 mb-3 text-center">{{ item.name }}</div>
      <ul class="mb-3">
        <li
          class="p-2 border-t border-solid border-[#ddd] flex justify-center"
          v-for="(time, indexTime) in item.timeLine"
          :key="indexTime"
        >
          <div class="flex-1 flex justify-center">{{ time.start }}</div>
          <div class="flex-1 flex justify-center">
            <i class="fa fa-chevron-right"></i>
          </div>
          <div class="flex-1 flex justify-center">{{ time.end }}</div>
          <div class="flex-[3_3_0%] flex justify-center" v-if="time.action">{{ time.action }}</div>
        </li>
      </ul>
      <div class="p-3 bg-[#f5f5f5] border-t border-solid border-[#ddd] text-center">
        {{ item.reservationSlot }}
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "InfoCalendar",
  setup() {
    const exampleCalendar = [
      {
        name: "例：スペシャルプラン各種",
        timeLine: [
          {
            start: "07:00",
            end: "11:00",
            action: "王様の朝食",
          },
          {
            start: "11:30",
            end: "14:30",
            action: "スペシャルランチコース",
          },
          {
            start: "18:00",
            end: "20:30",
            action: "豪華ディナー",
          },
          {
            start: "21:00",
            end: "23:30",
            action: "夜食スペシャル",
          },
        ],
        reservationSlot: "予約枠はつなげられません (単体枠予約のみ)。",
      },
      {
        name: "例：レストラン",
        timeLine: [
          {
            start: "08:00",
            end: "09:00",
            action: "",
          },
          {
            start: "09:00",
            end: "10:30",
            action: "",
          },
          {
            start: "...",
            end: "...",
            action: "",
          },
          {
            start: "23:00",
            end: "24:00",
            action: "",
          },
        ],
        reservationSlot: "予約枠をつなげて連続予約が可能です。",
      },
      {
        name: "例：パーティールームレンタル",
        timeLine: [
          {
            start: "00:00",
            end: "08:00",
            action: "オールナイトレンタル",
          },
          {
            start: "09:00",
            end: "12:00",
            action: "午前レンタル",
          },
          {
            start: "13:00",
            end: "17:00",
            action: "午後レンタル",
          },
          {
            start: "18:00",
            end: "23:00",
            action: "夜間レンタル",
          },
        ],
        reservationSlot: "予約枠はつなげられません (単体枠予約のみ)。",
      },
    ];
    return { exampleCalendar };
  },
};
</script>

<style lang="scss" scoped></style>
