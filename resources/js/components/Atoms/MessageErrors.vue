<template>
  <div v-if="messages" class="text-[#ff1515]">{{ messages }}</div>
</template>

<script>
export default {
  name: "MessageErrors",
  props: { messages: { type: String, required: true } },
};
</script>

<style lang="scss" scoped></style>
