<template>
  <div class="flex flex-wrap">
    <div class="w-[25%] font-[700] text-[12px]">
      <i :class="icon"></i>
      {{ label }}
    </div>
    <div class="flex-1">
      <div class="flex flex-row item-center" :style="'width: ' + width">
        <textarea
          class="w-full flex-1 border border-slate-300 focus:outline-none rounded-tl-[4px] rounded-bl-[4px] block px-[12px] py-[6px] border border-[#ccc] focus:border-[#66afe9] focus:shadow-[0_0px_2px_0_#66afe9]"
          @input="handleChange"
          v-model="content"
          cols="30"
          rows="2"
        ></textarea>
      </div>
      <span v-if="subText" class="block mt-2 text-[#737373]">{{ subText }}</span>
    </div>
  </div>
</template>
<script>
import { ref } from "vue";
export default {
  props: {
    icon: {
      type: String,
      default: "fa fa-list",
    },
    label: { type: String },
    subText: { type: String },
    width: {
      type: String,
      default: "100%",
    },
    value: { type: String },
    model: { type: String },
    input: { type: Function },
  },
  setup(props, { emit }) {
    const content = ref(props.value);
    const handleChange = () => {
      emit("onInput", { key: props.model, value: content.value });
    };
    return {
      content,
      handleChange,
    };
  },
};
</script>
