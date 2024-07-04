<template>
  <div class="shaded-text"><slot></slot></div>
</template>

<style lang="scss" scoped>
@import "@/assets/styles/colors.scss";

.shaded-text {
  padding: 16px;
  font-size: 14px;
  color: $color-grey-3;
  background: $color-whitish-blue;
  white-space: pre-wrap;
}
</style>
