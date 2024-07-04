<template>
  <div v-if="isSuccess" class="bg-[#dff0d8] border border-solid border-[#d6e9c6] px-[10px] py-[12px] mb-[15px]">
    <i class="fa fa-check text-[#3c763d] mr-[5px]"></i>
    <span class="text-[12px] text-[#3c763d]">{{ $t("form_setting_news.success") }}</span>
  </div>
  <div>
    <h1 class="text-[18px] font-bold">{{ $t("csv_export.reservation_list") }}</h1>
    <div class="flex justify-start items-center flex-wrap my-[10px]">
      <label
        :for="itemRes.id"
        v-for="(itemRes, index) in manageReservations"
        :key="index"
        class="flex justify-start items-center my-[5px] w-[25%]"
      >
        <input checked :id="itemRes.id" type="checkbox" class="translate-y-[-1px] mr-[3px]" />
        <span class="text-[12px] font-bold"> {{ itemRes.title }} </span>
      </label>
    </div>
    <div>
      <button
        @click="handleSubmit"
        class="group bg-[#fff] hover:bg-[#ffbd00] border border-solid border-[#ffbd00] px-[12px] py-[6px] rounded shadow-[0_1px_1px_0_#a4966e] translate-y-0 hover:translate-y-1 transition-all"
      >
        <span class="text-[14px] text-[#ffbd00] group-hover:text-[#fff]"> {{ $t("form_setting_news.keep") }}</span>
      </button>
    </div>
  </div>
</template>

<script>
import { ref, computed, inject } from "vue";
import { useI18n } from "vue-i18n";
export default {
  name: "ManageReservations",
  setup() {
    const { t } = useI18n();
    const isSuccess = ref(false);
    const manageReservations = [
      {
        id: 1,
        title: t("csv_export.reservation_id"),
      },
      {
        id: 2,
        title: t("csv_export.reservation_id"),
      },
      {
        id: 3,
        title: t("csv_export.reservation_id"),
      },
      {
        id: 4,
        title: t("csv_export.reservation_id"),
      },
      {
        id: 5,
        title: t("csv_export.reservation_id"),
      },
      {
        id: 6,
        title: t("csv_export.reservation_id"),
      },
      {
        id: 7,
        title: t("csv_export.reservation_id"),
      },
      {
        id: 8,
        title: t("csv_export.reservation_id"),
      },
      {
        id: 9,
        title: t("csv_export.reservation_id"),
      },
      {
        id: 10,
        title: t("csv_export.reservation_id"),
      },
      {
        id: 11,
        title: t("csv_export.reservation_id"),
      },
      {
        id: 12,
        title: t("csv_export.reservation_id"),
      },
      {
        id: 13,
        title: t("csv_export.reservation_id"),
      },
    ];
    const handleSubmit = () => {
      isSuccess.value = true;
    };
    return {
      manageReservations,
      isSuccess,
      handleSubmit,
    };
  },
};
</script>

<style></style>
