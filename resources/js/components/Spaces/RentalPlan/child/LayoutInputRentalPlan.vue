<template>
  <div class="flex w-full h-9 border border-solid border-[#ddd] rounded">
    <div class="w-11 h-full flex items-center justify-center bg-[#eee] border-r border-solid border-[#ddd]">
      <slot name="left"></slot>
    </div>
    <div class="flex-1 h-full bg-white rounded-tr rounded-br">
      <slot name="right"></slot>
    </div>
  </div>
</template>

<script>
export default {
  name: "LayoutInputRentalPlan",
};
</script>

<style scoped></style>
