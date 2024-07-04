<template>
  <button class="block p-2 rounded" @click="handleClick" :class="bg">
    <i class="text-white" :class="icon"></i>
    <span class="text-white">
      {{ text }}
    </span>
  </button>
</template>

<script>
export default {
  name: "ButtonUser",
  props: { text: String, bg: String, icon: String },
  methods: {
    handleClick() {
      this.$emit("onClick");
    },
  },
};
</script>

<style scoped></style>
