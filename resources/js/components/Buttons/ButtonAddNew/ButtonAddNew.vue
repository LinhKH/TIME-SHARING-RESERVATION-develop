<template>
  <button class="block bg-[#FFBD00] p-2 rounded" @click="handleClick">
    <i class="fa fa-plus text-white mr-1" aria-hidden="true"></i>
    <span class="text-white">
      {{ text || "No-data" }}
    </span>
  </button>
</template>

<script>
export default {
  name: "ButtonAddNew",

  data() {
    return {};
  },
  props: { text: String },
  mounted() {},

  methods: {
    handleClick() {
      this.$emit("clickBtn");
    },
  },
};
</script>

<style scoped></style>
