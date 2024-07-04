<template>
  <div class="w-full h-full bg-[#ebebeb] text-[14px] font-bold p-[10px]">
    <slot></slot>
    {{ text }}
  </div>
</template>

<script>
export default {
  name: "LayoutLable",
  props: {
    text: String,
  },
};
</script>

<style></style>
