<template>
  <div class="flex flex-wrap">
    <label v-for="(item, index) in optionProps" :key="index" class="mr-3 flex items-center">
      <input type="radio" :value="item.value" v-model="valueInput" class="mr-1" :disabled="disabledAll" />
      {{ item.label }}
    </label>
  </div>
</template>

<script>
import { watch, ref } from "vue";
export default {
  name: "InputRadio",
  emits: ["update:modelValue"],
  props: {
    optionProps: Object,
    modelValue: [Number, String],
    disabledAll: {
      type: Boolean,
      default: false,
    },
  },
  setup(props, context) {
    const valueInput = ref("");
    watch(
      () => props.modelValue,
      (value) => {
        valueInput.value = value;
      },
      { immediate: true }
    );
    watch(valueInput, (value) => {
      context.emit("update:modelValue", value);
    });

    return { valueInput };
  },
};
</script>

<style lang="scss" scoped></style>
