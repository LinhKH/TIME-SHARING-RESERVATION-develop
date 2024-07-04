<template>
  <div class="mb-[10px] flex my-2 items-center font-bold flex items-start justify-start">
    <div class="w-64 flex">
      <i :class="icon"></i>
      <label :for="id">{{ label }}</label>
    </div>
    <div class="w-full">
      <div class="w-[50%] font-normal">
        <slot></slot>
      </div>
    </div>
  </div>
</template>

<script>
import Input from "@/components/Form/Input.vue";
export default {
  name: "BaseFormCoupon",
  components: { Input },
  props: {
    label: {
      type: String,
      default: "",
    },
    id: {
      type: String,
      default: "",
    },
    icon: {
      type: String,
      default: "",
    },
  },
  setup(props, { emit }) {
    const typeInput = "input";
    return {
      typeInput,
    };
  },
};
</script>

<style></style>
