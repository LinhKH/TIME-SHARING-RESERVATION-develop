<template>
  <div class="w-[380px] flex">
    <select
      :disabled="disabled"
      class="w-full bg-white border min-h-[32px] border-solid border-[#ddd] rounded outline-none focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50"
      :class="disabled && 'bg-[#eee]'"
      v-model="selected"
      :multiple="multiple"
      :size="size"
    >
      <option v-for="(option, index) in optionsSelect" :value="option.value" :key="index">
        {{ option.label }}
      </option>
    </select>
  </div>
</template>

<script>
import { ref } from "vue";
export default {
  name: "Select",
  setup(props) {
    let selected = ref(props.currentValue);
    return { selected };
  },
  watch: {
    selected(value) {
      this.$emit("changeValue", { value: value, key: this.inputKey });
    },
  },
  props: {
    inputKey: String,
    currentValue: String,
    optionsSelect: { type: Array, default: [] },
    disabled: {
      type: Boolean,
      default: false,
    },
    multiple: { type: Boolean, default: false },
    size: Number,
  },

  methods: {},
};
</script>

<style scoped></style>
