<template>
  <div class="flex border border-solid border-[#ddd] rounded" :class="customCss">
    <!-- <div class="w-[40px] bg-[#eee] border-r border-solid border-[#ddd] flex items-center justify-center"> -->
    <div class="bg-[#ccc] p-[10px]">
      <slot name="left"></slot>
    </div>
    <div class="flex-1 h-full">
      <slot name="right"></slot>
    </div>
  </div>
</template>

<script>
export default {
  name: "FormRentalInterVal",
  props: {
    customCss: {
      type: String,
      default: "",
    },
  },
  setup() {},
};
</script>

<style scoped></style>
