<template>
  <div :class="borderFooter && 'border-b border-solid border-[#ddd]'" class="pb-4">
    <div class="p-2 w-full bg-[#eee]">
      <div class="">
        <i v-if="icon" :class="icon"></i>
        <span class="ml-1">
          {{ title }}
        </span>
      </div>
    </div>
    <div class="p-2">
      <slot></slot>
    </div>
  </div>
</template>
<script>
export default {
  name: "LayoutForm",
  props: {
    title: {
      type: String,
      required: true,
    },
    icon: {
      type: String,
      default: "",
    },
    borderFooter: {
      type: Boolean,
      default: true,
    },
  },
  data() {
    return {};
  },

  mounted() {},

  methods: {},
};
</script>

<style scoped></style>
