<template>
  <div class="flex items-center justify-around text-[16px] mb-[15px]">
    <div class="w-[25%] flex justify-star items-center flex-wrap">
      <span class="text-[#626262] leading-[25px] mr-[5px]">{{ visitItem.title }}</span>
      <span v-if="visitItem.required" class="text-white bg-red-400 py-1 px-3 rounded text-[14px]">{{
        $t("space_tour.required")
      }}</span>
    </div>
    <div class="w-[75%] flex justify-start items-center text-[14px]">
      <div class="w-[50%] mr-[4px]">
        <Field :name="visitItem.name" v-slot="{ field }">
          <Datepicker
            v-bind="field"
            ref="inputValue"
            placeholder="2022-01-02"
            v-model="date"
            class="w-[100%] py-2 px-2.5 rounded border border-solid border-[#ccc] focus:outline-none focus:border-sky-500"
          />
        </Field>
      </div>
      <div class="w-[50%] mr-[4px]">
        <Datepicker
          v-model="time"
          class="w-[100%] py-2 px-2.5 rounded border border-solid border-[#ccc] focus:outline-none focus:border-sky-500"
          timePicker
        />
      </div>
    </div>
  </div>
</template>
<script>
import { Field } from "vee-validate";
import Datepicker from "vue3-datepicker";
import { ref } from "vue";
export default {
  name: "InputDate",
  components: {
    Datepicker,
    Field,
  },

  props: {
    visitItem: {
      type: Object,
      default: () => {},
    },
  },
  setup() {
    const date = ref(new Date(""));
    const timePicker = ref(true);
    const time = ref({
      hours: new Date().getHours(),
      minutes: new Date().getMinutes(),
    });
    return {
      date,
      time,
      timePicker,
    };
  },
};
</script>
<style></style>
