<template>
  <div class="container">
    <div class="contents">
      <h1 class="title">{{ $t("joining.title") }}</h1>
      <span class="sub-title">{{ $t("joining.sub-title") }}</span>
      <alert-message class="alert-message" :message="alertMessage"></alert-message>
      <slot></slot>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";

import AlertMessage from "@/components/Messages/AlertMessage.vue";

export default defineComponent({
  components: { AlertMessage },
  emits: ["update:status"],
  props: {
    alertMessage: {
      type: String,
      required: true,
    },
  },
});
</script>

<style lang="scss" scoped>
.container {
  display: flex;
  justify-content: center;
}

.contents {
  padding: 56px 0;
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 100%;
  max-width: 860px;
}

.title {
  font-size: 32px;
}

.sub-title {
  font-size: 24px;
  margin-top: 32px;
}

.alert-message {
  margin: 40px 0 8px;
}
</style>
