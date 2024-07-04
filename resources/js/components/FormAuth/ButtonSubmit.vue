<template>
  <button
    @click="submitForm"
    class="w-full mt-[20px] bg-[#297fca] px-[25px] py-[10px] text-[#fff] font-[600] leading-[20px] rounded-[3px] border-[1px] border-[#297fca] shadow-[1px_1px_2px_0_#7d7d7d] hover:bg-[#7d7d7d] hover:border-[#fff]"
  >
    {{ content }}
  </button>
</template>
<script>
export default {
  props: {
    content: String,
  },
  setup() {},
};
</script>
