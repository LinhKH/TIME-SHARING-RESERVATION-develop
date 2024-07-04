<template>
  <div class="w-full h-full bg-[#151515]">
    <div class="max-w-[1120px] h-full py-6 items-center m-auto">
      <div class="border-b-2 border-solid border-[#3f3f3f]">
        <img :src="logoTimeSharing" alt="logoTimeSharing" class="w-1/5 h-1/5 object-contain" />
      </div>
    </div>
  </div>
</template>

<script>
import logoTimeSharing from "@/assets/images/time_sharing_logo.png";
export default {
  name: "RootSpaceDetailClient",
  setup() {
    return {
      logoTimeSharing,
    };
  },
};
</script>

<style>
</style>
