<template>
  <div class=" flex items-center border-2 bordder-solid border-[#eee] rounded mr-[50px]">
    <div class="h-full items-center bg-[#eee] font-[12px] p-2">
      <input type="radio" :id="id" name="main" :value= "value" class="h-full " />
    </div>
    <label :for="id" class="text-center mx-4">
      <i :class="icon"></i>
      <span class="text-[12px]">{{ namLabel }}</span>
    </label>
  </div>
</template>

<script>
export default {
  name: "InputRadioRegister",
  props: {
    id: String,
    value: String,
    icon: String,
    namLabel: String,
  },
};
</script>

<style>
</style>
