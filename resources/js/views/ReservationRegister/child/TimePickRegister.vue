<template>
  <div class="flex flex-wrap" :style="gap ? 'gap:' + gap : ''">
    <div class="flex-1">
      <label class="flex flex-row item-center h-[34px]" :style="'width: ' + width">
        <Field>
          <!-- <DatePicker
            v-model="time"
            startingView="time"
            inputFormat="HH:mm"
            minimumView="time"
            class="w-full flex-1 border border-slate-300 focus:outline-none rounded-tl-[4px] rounded-bl-[4px] block px-[12px] py-[6px] border border-[#ccc] h-[34px]"
          /> -->
          <V3Datepicker v-model="time" minutes-increment="15" time-picker auto-apply class="time-picker" />
        </Field>
        <span
          class="flex items-center p-3 bg-[#eee] rounded-tr-[4px] rounded-br-[4px] border border-[#ccc] border-l-0 text-[#555] text-[14px] text-[400]"
          >{{ label }}</span
        >
      </label>
    </div>
  </div>
</template>

<script>
import { ref, watch } from "vue";
import DatePicker from "vue3-datepicker";
import moment from "moment";
import V3Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
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
    V3Datepicker,
  },
  setup(props, { emit }) {
    const convertStringToTime = (input) => {
      const newTime = new Date();
      if (input) {
        const hour = input.value.getHours();
        const minutes = input.value.getMinutes();
        newTime.setHours(hour);
        newTime.setMinutes(minutes);
        return newTime;
      }
      return newTime;
    };
    const time = ref();
    watch(time, () => {
      emit("onInput", {
        key: props.model,
        // value: moment(time.value).format("HH:mm"),
        value: `${time.value.hours}:${time.value.minutes}`,
      });
    });
    return {
      time,
    };
  },
};
</script>

<style scoped lang="scss">
.time-picker {
  :deep(.dp__input) {
    padding: 4px 12px;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
  }
  :deep(.dp__input_icon_pad) {
    padding-left: 35px;
  }
}
</style>
