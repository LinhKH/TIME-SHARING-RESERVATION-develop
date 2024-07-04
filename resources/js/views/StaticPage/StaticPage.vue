<template>
  <div class="flex justify-end hover:translate-y-0.5">
    <ButtonAddNew :text="$t('static_Page.text_button')" @clickBtn="goToCreateNew" />
  </div>
  <StaticPageTable :dataTable="dataTable" :dataPageList="dataPageList" />
  <Pagination
    v-if="pagination"
    :pageCurrent="pagination.current_page"
    :totalPage="pagination.total_page"
    @onBack="handleBackPage"
    @onNext="handleNextPage"
  />
</template>

<script>
import { useI18n } from "vue-i18n";
import { ROUTER_PATH, MODULE_STORE, PAGE_DEFAULT } from "@/const";
import ButtonAddNew from "@/components/Buttons/ButtonAddNew";
import { getListPageNewApi } from "@/api";
import StaticPageTable from "@/components/StaticPageTable/StaticPageTable.vue";
import { useRouter, useRoute } from "vue-router";
import { useStore } from "vuex";
import Pagination from "@/components/Pagination";
import { ref, computed, watch, inject, reactive } from "vue";
export default {
  name: "StaticPage",
  components: { StaticPageTable, ButtonAddNew, Pagination },
  setup() {
    const { t } = useI18n();
    const router = useRouter();
    const route = useRoute();
    const store = useStore();
    const toast = inject("$toast");
    const pagination = ref(null);
    const dataPageList = ref([]);
    const dataTable = {
      header: [
        {
          text: t("static_Page.key"),
          width: "10%",
        },
        {
          text: t("static_Page.label"),
          width: "20%",
        },
        {
          text: t("static_Page.content"),
          width: "70%",
        },
      ],
    };
    const goToCreateNew = () => {
      router.push(`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.STATIC_PAGE_ADD}`);
    };
    const pageCurrent = computed(() => {
      if (!route.query.page) {
        return PAGE_DEFAULT || 1;
      }
      return Number(route.query.page);
    });
    watch(pageCurrent, (page) => {
      if (route.path !== ROUTER_PATH.TOUR) {
        getAllSettingNew(page);
      }
    });
    const handleBackPage = (page) => {
      router.push(`${ROUTER_PATH.CONFIGURATION}?page=${page}`);
    };
    const handleNextPage = (page) => {
      router.push(`${ROUTER_PATH.CONFIGURATION}?page=${page}`);
    };
    const getAllPageNew = async (page = PAGE_DEFAULT) => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const res = await getListPageNewApi(page);
        dataPageList.value = res.data;
        pagination.value = res.pagination;
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    getAllPageNew(pageCurrent);
    return { dataTable, dataPageList, goToCreateNew, handleBackPage, handleNextPage, pagination };
  },
};
</script>

<style></style>
