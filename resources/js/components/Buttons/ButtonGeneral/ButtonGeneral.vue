<template>
  <button class="block bg-[#FFBD00] p-2 rounded" @click="handleClick">
    <i :class="icon" aria-hidden="true"></i>
    <span class="text-white">
      {{ text || "No-data" }}
    </span>
  </button>
</template>

<script>
export default {
  name: "ButtonGeneral",

  data() {
    return {};
  },
  props: { text: String, icon: String },
  mounted() {},

  methods: {
    handleClick() {
      this.$emit("clickButton");
    },
  },
};
</script>

<style scoped></style>
