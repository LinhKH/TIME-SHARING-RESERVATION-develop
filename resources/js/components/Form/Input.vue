<template>
  <div class="w-full border border-solid border-[#ddd] rounded flex h-8">
    <input
      :type="type ? type : 'text'"
      class="flex-1 h-full rounded-tl rounded-bl focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 outline-none px-2 rounded-tr rounded-br"
      :placeholder="placeholder"
      v-model="valueInput"
      :min="min"
    />
    <div class="label-input" v-if="label">
      {{ label }}
    </div>
    <div class="label-input" v-else-if="icon">
      <i :class="icon"></i>
    </div>
    <button class="button-remove-input" v-else @click="removeInput()">
      <i class="fa fa-times" aria-hidden="true"></i>
    </button>
  </div>
</template>

<script>
import { ref, watch } from "vue";
export default {
  name: "Input",
  setup(props) {
    let valueInput = ref("");
    watch(
      () => props.inputText,
      (value) => {
        valueInput.value = value;
      },
      { immediate: true }
    );
    return { valueInput };
  },
  watch: {
    valueInput(value) {
      if (this.inputKey) {
        this.$emit("changeValue", { value: value, key: this.inputKey });
      }
    },
  },
  props: {
    type: String,
    min: String,
    placeholder: String,
    inputKey: String,
    inputText: { type: String, default: "" },
    label: String,
    icon: { type: String, default: "" },
  },
  methods: {
    removeInput() {
      this.valueInput = "";
    },
  },
};
</script>

<style scoped>
.button-remove-input {
  border-top-left-radius: 0 !important;
  border-bottom-left-radius: 0 !important;
  font-size: 14px;
  font-weight: 400;
  line-height: 1;
  color: #555;
  text-align: center;
  background-color: #eee;
  border-left: 1px solid #ddd;
  border-radius: 4px;
  width: 8%;
  white-space: nowrap;
  vertical-align: middle;
}
.label-input {
  border-top-left-radius: 0 !important;
  border-bottom-left-radius: 0 !important;
  font-size: 14px;
  font-weight: 400;
  line-height: 1;
  color: #555;
  text-align: center;
  background-color: #eee;
  border-left: 1px solid #ccc;
  border-radius: 4px;
  padding: 0 8px;
  display: flex;
  align-items: center;
}
</style>
