<template>
  <div class="flex items-center my-4">
    <div class="mr-20 w-32">
      <i class="fa fa-level-up"></i>
      <span class="font-bold">
        {{ title }}
      </span>
    </div>
    <FormKit
      type="radio"
      label=""
      :options="value"
      wrapper-class="flex"
      options-class="flex"
      outer-class="w-96"
      label-class="w-16 font-bold ml-1 mr-4"
    />
  </div>
</template>
<script>
export default {
  props: {
    title: { type: String, default: "" },
    value: { type: Array, default: [] },
  },
};
</script>
