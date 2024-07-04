<template>
  <div class="p-[5px]">
    <div v-if="isSuccess" class="bg-[#dff0d8] border border-solid border-[#d6e9c6] px-[10px] py-[12px] mb-[10px]">
      <i class="fa fa-check text-[#3c763d] mr-[5px]"></i>
      <span class="text-[12px] text-[#3c763d]">{{ $t("form_setting_news.success") }}</span>
    </div>
    <p>{{ $t("tour_setting.tour_request_settings") }}</p>
    <p class="my-[20px]">{{ $t("tour_setting.check_update_button") }}</p>
    <div>
      <label
        v-for="(settingItem, index) in listSettingTour"
        :key="index"
        :for="settingItem.id"
        class="font-bold mr-[10px] inline-block justify-start items-center"
        ><input
          class="mr-[3px]"
          @click="handleChecked(settingItem.id)"
          :id="settingItem.id"
          type="checkbox"
          :checked="settingItem.isChecked"
        /><span>{{ settingItem.title }}</span></label
      >
    </div>
    <div class="w-[100%] text-center mt-[20px]">
      <button
        @click="() => updateSettingTour()"
        class="w-[90%] py-3 px-9 border border-solid border-[#ccc] rounded mb-1 text-[#fff] cursor-pointer bg-[#52c195] hover:opacity-[0.8] transiton-all"
      >
        {{ $t("tour_setting.update") }}
      </button>
    </div>
  </div>
</template>

<script>
import { ref } from "vue";
export default {
  name: "TourSetting",
  setup() {
    const isSuccess = ref(false);
    const listSettingTour = ref([
      {
        id: 1,
        title: "#191<名称未設定>",
        isChecked: false,
        value: "",
      },
      {
        id: 2,
        title: "#123<名称未設定>",
        isChecked: false,
        value: "",
      },
      {
        id: 3,
        title: "sang222",
        isChecked: false,
        value: "",
      },
      {
        id: 4,
        title: "#84<名称未設定>",
        isChecked: false,
        value: "",
      },
      {
        id: 5,
        title: "Akasaka Zen Space",
        isChecked: false,
        value: "",
      },
      {
        id: 6,
        title: "Lounge-R Premium",
        isChecked: false,
        value: "",
      },
      {
        id: 7,
        title: "#Lounge-R TERRACE渋谷",
        isChecked: false,
        value: "",
      },
      {
        id: 8,
        title: "TIME SHARING 新宿6C（タイムシェアリング）",
        isChecked: false,
        value: "",
      },

      {
        id: 9,
        title: "TIME SHARING 新宿6A（タイムシェアリング）",
        isChecked: true,
        value: "",
      },
      {
        id: 10,
        title: "TIME SHARING 新宿6A（タイムシェアリング）",
        isChecked: true,
        value: "",
      },
    ]);
    const updateSettingTour = () => {
      const checked = listSettingTour.value.some((item) => {
        return item.isChecked === true;
      });
      if (checked) {
        isSuccess.value = true;
      }
    };
    const handleChecked = (id) => {
      listSettingTour.value.forEach((item) => {
        if (item.id === id) {
          item.isChecked = !item.isChecked;
        }
      });
    };
    return { listSettingTour, isSuccess, updateSettingTour, handleChecked };
  },
};
</script>

<style></style>
