<template>
  <input
    type="number"
    min="0"
    class="outline-none p-2 rounded border border-solid border-[#ddd] focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 disabled:bg-[#eee]"
    @input="(event) => $emit('onInput', event.target.value)"
    :value="value"
  />
</template>

<script>
export default {
  name: "InputNumber",
  emits: ["onInput"],
  props: {
    value: [String, Number],
  },
};
</script>
