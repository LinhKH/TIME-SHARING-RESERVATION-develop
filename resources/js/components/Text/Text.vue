<template>
  <span class="text"><slot></slot></span>
</template>

<style lang="scss" scoped>
@import "@/assets/styles/colors.scss";

.text {
  font-size: 14px;
  color: $color-grey-6;
  white-space: pre-wrap;
}
</style>
