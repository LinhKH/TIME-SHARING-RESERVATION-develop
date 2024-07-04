<template>
  <span class="text-white px-[2px] bg-[#fe5457] mr-1 rounded inline-block" v-if="required">
    {{ $t("form_user_manage.mandatory") }}
  </span>
  <i v-if="iconClass" :class="iconClass"></i>
  <span class="font-bold">{{ label }}</span>
</template>

<script>
export default {
  name: "Label",
  props: {
    iconClass: String,
    label: String,
    required: Boolean,
  },
};
</script>

<style scoped></style> 
