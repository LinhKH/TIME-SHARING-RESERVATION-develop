<template>
  <div v-for="(itemCsv, index) in listCsv" :key="index" class="font-serif mb-[10px]">
    <router-link :to="itemCsv.link">
      <span class="text-[18px] text-[#337ab7] hover:underline cursor-pointer">{{ itemCsv.title }}</span>
    </router-link>
  </div>
</template>
<script>
import { useStore } from "vuex";
import { useI18n } from "vue-i18n";
import { useRouter, useRoute } from "vue-router";
import { ref, computed, watch, inject } from "vue";
import { ROUTER_PATH, MODULE_STORE, PAGE_DEFAULT, BOOLEAN } from "@/const";
export default {
  name: "CsvExport",
  setup() {
    const { t } = useI18n();
    const listCsv = [
      {
        id: 1,
        title: t("csv_export.reservation_list"),
        name: "",
        link: `${ROUTER_PATH.CSV_MANAGE_RESERVATIONS}`,
      },
      {
        id: 2,
        title: t("csv_export.company_group"),
        name: "",
        link: "",
      },
      {
        id: 3,
        title: t("csv_export.owner"),
        name: "",
        link: "",
      },
      {
        id: 4,
        title: t("csv_export.user"),
        name: "",
        link: "",
      },
      {
        id: 5,
        title: t("csv_export.space"),
        name: "",
        link: "",
      },
      {
        id: 6,
        title: t("csv_export.query_space"),
        name: "",
        link: "",
      },
      {
        id: 7,
        title: t("csv_export.word_of_mouth"),
        name: "",
        link: "",
      },
      {
        id: 8,
        title: t("csv_export.chef_inquiry"),
        name: "",
        link: "",
      },
      {
        id: 9,
        title: t("csv_export.everyone_inquiry"),
        name: "",
        link: "",
      },
      {
        id: 10,
        title: t("csv_export.space_search"),
        name: "",
        link: "",
      },
      {
        id: 11,
        title: t("csv_export.inquiry"),
        name: "",
        link: "",
      },
    ];
    return {
      listCsv,
    };
  },
};
</script>

<style></style>
