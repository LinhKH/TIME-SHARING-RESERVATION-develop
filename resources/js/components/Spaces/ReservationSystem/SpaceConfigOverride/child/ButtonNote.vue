<template>
  <div :class="`p-2 ${backGroundColor} mr-2`">
    {{ text }}
  </div>
</template>

<script>
export default {
  name: "ButtonNote",
  props: {
    text: String,
    backGroundColor: String,
  },
  setup() {},
};
</script>

<style scoped></style>
