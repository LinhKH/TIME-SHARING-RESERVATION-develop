<template>
  <div>
    <div class="border border-solid border-[#bce8f1] bg-[#d9edf7] p-[15px]">
      <i class="fa fa-lightbulb-o text-[#31708f] mr-[5px] text-[12px]"></i>
      <span class="text-[#31708f] text-[12px]">{{ $t("transport.station_info") }}</span>
    </div>
    <div class="mt-[15px]">
      <StationInfoVue />
    </div>
  </div>
</template>
<script>
import StationInfoVue from "./StationInfo.vue";

export default {
  name: "EditEquipmentInfo",
  components: {
    StationInfoVue,
  },
};
</script>

<style></style>
