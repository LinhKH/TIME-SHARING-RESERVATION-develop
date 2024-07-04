<template>
  <div class="flex justify-center items-center">
    <i :class="`flag ${flag}`"></i>
  </div>
</template>

<script>
export default {
  name: "Flag",
  props: {
    flag: { type: String, default: "ja" },
  },
};
</script>

<style scoped></style>
