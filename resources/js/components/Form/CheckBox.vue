<template>
  <div class="flex flex-wrap">
    <label v-for="(item, index) in option" :key="index" class="flex items-center mr-8">
      <input type="checkbox" :value="item.value" class="mr-1" v-model="value" />
      {{ item.label }}
    </label>
  </div>
</template>

<script>
import { ref, watch } from "vue";

export default {
  name: "CheckBox",
  props: {
    option: Array,
  },
  setup(_, context) {
    const value = ref([]);
    watch(value, (value) => {
      context.emit("updateValue", value);
    });
    return { value };
  },
};
</script>

<style lang="scss" scoped></style>
