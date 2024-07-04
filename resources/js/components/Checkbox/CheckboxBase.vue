<template>
  <input class="form-group mr-2" type="checkbox" :checked="checked" @change="onChange" />
</template>

<script>
import { ref, computed, watch, inject } from "vue";

export default {
  props: {
    value: {
      type: Array,
      default: () => [],
    },
    id: {
      type: Number,
    },
  },
  setup(props, context) {
    const checked = ref(false);
    const createdChecked = () => {
      checked.value = props.value?.includes(props.id);
    };
    watch(props.value, () => {
      checked.value = props.value.includes(props.id);
    });
    const onChange = () => {
      context.emit("changeChecked", props.id);
    };
    return {
      checked,
      createdChecked,
      onChange,
    };
  },
};
</script>

<style></style>
