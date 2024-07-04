<template>
  <div class="w-full h-[57px] flex items-center pl-[16px] border-b-[1px] border-[#eaeaea]">
    <img :src="logoTimeSharing" alt="logoTimeSharing" class="w-[194px] h-[34px] object-contain" />
  </div>
</template>

<script>
import logoTimeSharing from "@/assets/images/time_sharing_logo.png";

export default {
  setup() {
    return {
      logoTimeSharing,
    };
  },
};
</script>
