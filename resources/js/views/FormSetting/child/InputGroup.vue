<template>
  <div class="flex flex-wrap" :style="gap ? 'gap:' + gap : ''">
    <div class="w-[25%] font-[700] text-[12px] text-[#333]">
      <i v-if="icon" :class="icon"></i>
      {{ label }}
    </div>
    <div class="flex-1">
      <div class="flex flex-row item-center h-[34px]" :style="'width: ' + width">
        <input
          :type="type"
          class="w-full flex-1 border border-slate-300 focus:outline-none rounded-tl-[4px] rounded-bl-[4px] block px-[12px] py-[6px] border border-[#ccc] focus:border-[#66afe9] focus:shadow-[0_0px_2px_0_#66afe9]"
          :class="!tag ? 'rounded-[4px]' : ''"
          v-model="content"
          @input="handleChange"
        />
        <span
          v-if="tag"
          v-html="tag"
          class="flex items-center p-3 bg-[#eee] rounded-tr-[4px] rounded-br-[4px] border border-[#ccc] border-l-0 text-[#555] text-[14px] text-[400]"
        ></span>
      </div>
      <span v-if="subText" class="block mt-2 text-[#737373]">{{ subText }}</span>
    </div>
  </div>
</template>
<script>
import { ref } from "vue";
export default {
  props: {
    icon: { type: String },
    label: { type: String },
    subText: { type: String },
    tag: { type: String },
    type: {
      type: String,
      default: "number",
    },
    width: {
      type: String,
      default: "100%",
    },
    gap: { type: String },
    value: { type: [String, Number] },
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
