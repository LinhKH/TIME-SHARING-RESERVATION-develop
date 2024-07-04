<template>
  <div class="w-[50%] h-[480px] border-2 border-solid border-[#cbcbcb]" @watchCheckAll="watchCheckAll">
    <div :class="[isActive ? 'bg-[#fcf3d3]' : '']">
      <div class="w-full flex items-center justify-around py-[5px] cursor-pointer border-b-2 border-solid">
        <div class="text-center text-[18px] leading-7">
          <i class="fa fa-circle-o text-[#626262] mr-2" :class="[isActive ? 'fa fa-dot-circle-o' : '']"></i>
          <span for="title" class="ml-1 text-[#626262]">
            {{ $t("reservation_calendar.check_reservation.title") }}
          </span>
        </div>
        <div class="float-right bg-[#b9e0a5] rounded text-[14px] px-[5px] leading-7">
          <span class="">{{ $t("reservation_calendar.check_reservation.required") }}</span>
        </div>
      </div>
      <div
        class="w-full p-[10px] text-left text-[18px] leading-7 cursor-pointer border-b-2 border-[#cbcbcb] border-solid"
        @click="checkAll"
      >
        <i class="mr-2" :class="[isCheckAll ? 'fa fa-check-circle-o text-[#ff3b30]' : 'fa fa-circle-o']">
          <input class="p-2 text-center w-0 h-0" type="checkbox" v-model="isCheckAll" />
        </i>
        <span>{{ $t("reservation_calendar.check_reservation.chech_all") }}</span>
      </div>
    </div>
    <div class="h-[380px] overflow-y-auto">
      <div
        class="w-full border-b-2 border-[#cbcbcb] border-solid flex justify-between items-center p-[10px]"
        v-for="item in selectTime"
        :key="item"
      >
        <div class="items-center text-center">
          <input type="checkbox" :value="item" @change="updateCheckAll()" v-model="selected" class="text-center" />
          <label class=""> {{ item }}</label>
        </div>
        <div class="cursor-pointer">
          <button @click="handleCancelSelect" class="mx-3 text-center"></button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, watch } from "vue";
export default {
  props: {
    isCheck: {
      type: Boolean,
      default: false,
      require: true,
    },
  },
  name: "CheckPlanMoney",
  setup(props, context) {
    const isActive = ref(true);
    const isCheckAll = ref(false);
    const selected = ref([]);
    const selectTime = [
      "1:00 - 2:00",
      "2:00 - 3:00",
      "3:00 - 4:00",
      "4:00 - 5:00", 
    ];
    const checkAll = () => {
      isCheckAll.value = !isCheckAll.value;
      selected.value = [];
      if (isCheckAll.value) {
        for (let key in selectTime) {
          selected.value.push(selectTime[key]);
        }
      }
    };
    const updateCheckAll = () => {
      if (selected.value.length == selectTime.length) {
        isCheckAll.value = true;
      } else {
        isCheckAll.value = false;
      }
    };
    watch(
      () => props.isCheck,
      (val) => {
        if (val) {
          isCheckAll.value = false;
          checkAll();
        } else {
          isCheckAll.value = true;
          checkAll();
        }
      }
    );

    return {
      selectTime,
      selected,
      isCheckAll,
      isActive,
      checkAll,
      updateCheckAll,
    };
  },
};
</script>

<style>
</style>
