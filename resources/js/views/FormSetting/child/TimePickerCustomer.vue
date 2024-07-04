<template>
  <div class="flex flex-wrap" :style="gap ? 'gap:' + gap : ''">
    <div class="w-[25%] font-[700] text-[12px] text-[#333]">
      <i v-if="icon" :class="icon"></i>
      {{ label }}
    </div>
    <div class="flex-1">
      <label class="flex flex-row item-center h-[34px]" :style="'width: ' + width">
        <DatePicker
          v-model="time"
          startingView="time"
          inputFormat="HH:mm"
          minimumView="time"
          class="w-full flex-1 border border-slate-300 focus:outline-none rounded-tl-[4px] rounded-bl-[4px] block px-[12px] py-[6px] border border-[#ccc] h-[34px]"
        />
        <span
          v-if="tag"
          v-html="tag"
          class="flex items-center p-3 bg-[#eee] rounded-tr-[4px] rounded-br-[4px] border border-[#ccc] border-l-0 text-[#555] text-[14px] text-[400]"
        ></span>
      </label>
    </div>
  </div>
</template>

<script>
import { ref, watch } from "vue";
import DatePicker from "vue3-datepicker";
import moment from "moment";
export default {
  props: {
    icon: {
      type: String,
    },
    label: {
      type: String,
      default: "",
    },
    subText: {
      type: String,
      default: "",
    },
    tag: {
      type: String,
      default: "<i class='fa fa-clock-o'/>",
    },
    value: {
      type: String,
    },
    model: {
      type: String,
    },
    width: Number,
    gap: String,
  },
  components: {
    DatePicker,
  },
  setup(props, { emit }) {
    const convertStringToTime = (input) => {
      // Example: convert "10:00" -> "Thu Aug 11 2022 10:10:00 GMT+0700 (Indochina Time)"
      const newTime = new Date();
      if (input) {
        const timeSplit = input.split(":");
        newTime.setHours(timeSplit[0]);
        newTime.setMinutes(timeSplit[1]);
      }
      return newTime;
    };

    const time = ref(convertStringToTime(props.value));
    watch(time, () => {
      emit("onInput", {
        key: props.model,
        value: moment(time.value).format("HH:mm"),
      });
    });
    return {
      time,
      convertStringToTime,
    };
  },
};
</script>
