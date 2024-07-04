<template>
  <div>
    <div class="mt-[20px] mb-[10px] pb-[25px] text-[18px]">{{ $t("tracking_links.header") }}</div>
    <div class="flex">
      <div class="w-[30%] mb-[5px] font-bold">
        <i class="fa fa-link mr1"></i>
        <span>{{ $t("tracking_links.title") }}</span>
      </div>
      <div class="w-full">
        <div class="font-bold mb-[10px]">{{ $t("tracking_links.label") }}</div>
        <div class="font-medium mb-[10px]">{{ $t("tracking_links.sub_label") }}</div>
        <div v-if="isShowSuccess" class="p-[8px] font-medium mb-[10px] border border-[#d6e9c6] bg-[#dff0d8] rounded">
          <i class="fa fa-check text-[#3c763d]"></i>
          <span class="text-[#3c763d] ml-1"> {{ $t("tracking_links.save") }}</span>
        </div>
        <ButtonAddNew :text="$t('static_Page.text_button')" @clickBtn="goToCreateNew" />
        <div class="">
          <table class="w-full border-collapse mt-2">
            <thead>
              <tr class="even:bg-gray-100">
                <th class="w-[30%] border border-solid border-[#ddd] p-[8px] text-left">
                  {{ $t("tracking_links.url_name") }}
                </th>
                <th class="w-[50%] border border-solid border-[#ddd] p-[8px] text-left">
                  {{ $t("tracking_links.flow_url") }}
                </th>
                <th class="w-[50%] border border-solid border-[#ddd] p-[8px] text-left"></th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, index) in dataTable" :key="index" class="text-left even:bg-gray-10">
                <td class="p-[8px] border border-[#ddd]">{{ item.name }}</td>
                <td class="p-[8px] border border-[#ddd]">
                  <div class="mb-[10px]">
                    <i class="fa fa-link mr1"></i>
                    <span>{{ $t("tracking_links.name_title") }}</span>
                  </div>
                  <div class="flex justify-between border border-gray-300 rounded">
                    <input
                      class="p-4 w-full bg-[#eeeeee] border-r-[1px] border-gray-300"
                      type="text"
                      :value="item.tracking_code"
                      :id="item.id"
                    />
                    <button class="tooltip" @click="handleCopyUrl(item.id)">
                      <i class="fa fa-files-o text-[#fff]"></i>
                      <span class="toolTipText text-[#fff]">{{ $t("tracking_links.tooltip") }}</span>
                    </button>
                  </div>
                </td>
                <td class="p-[12px] border border-[#ddd] text-center">
                  <button class="border border-[#ddd] rounded hover:bg-[#eeeeee]" @click="goToEdit(item.id)">
                    <i class="fa fa-pencil p-[8px]"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <Pagination
      v-if="pagination"
      :pageCurrent="pagination.current_page"
      :totalPage="pagination.total_page"
      @onBack="handleBackPage"
      @onNext="handleNextPage"
    />
  </div>
</template>

<script>
import { useStore } from "vuex";
import { useI18n } from "vue-i18n";
import { ref, watch, inject, computed } from "vue";
import { useRouter, useRoute } from "vue-router";
import { ROUTER_PATH, MODULE_STORE, PAGE_DEFAULT } from "@/const";
import ButtonAddNew from "@/components/Buttons/ButtonAddNew";
import { getListGlobalLinksApi } from "@/api";
import Pagination from "@/components/Pagination";
export default {
  name: "TrackingLinks",
  components: { ButtonAddNew, Pagination },
  setup() {
    const { t } = useI18n();
    const router = useRouter();
    const route = useRoute();
    const store = useStore();
    const toast = inject("$toast");
    const dataTable = ref([]);
    const paginationPage = ref(null);
    const pageCurrent = computed(() => {
      if (!route.query.page) {
        return PAGE_DEFAULT || 1;
      }
      return Number(route.query.page);
    });
    watch(pageCurrent, (page) => {
      if (route.path !== ROUTER_PATH) {
        getListGlobalLinks(page);
      }
    });
    const handleBackPage = (page) => {
      router.push(`${ROUTER_PATH.CONFIGURATION}?page=${page}`);
    };
    const handleNextPage = (page) => {
      router.push(`${ROUTER_PATH.CONFIGURATION}?page=${page}`);
    };
    const getListGlobalLinks = async (page = PAGE_DEFAULT) => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const res = await getListGlobalLinksApi(page);
        dataTable.value = res.data;
        paginationPage.value = res.paginate;
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    const goToCreateNew = (id) => {
      router.push(`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.TRACKING_LINKS_ADD}?id=${id}`);
    };
    const goToEdit = (id) => {
      router.push(`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.TRACKING_LINKS_EDIT}?id=${id}`);
    };
    const handleCopyUrl = (id) => {
      const copyText = document.getElementById(id);
      copyText.select();
      copyText.setSelectionRange(0, 99999);
      navigator.clipboard.writeText(copyText.value);
    };
    getListGlobalLinks();
    return {
      goToCreateNew,
      ROUTER_PATH,
      dataTable,
      goToEdit,
      getListGlobalLinks,
      handleNextPage,
      handleBackPage,
      paginationPage,
      handleCopyUrl,
    };
  },
};
</script>

<style scoped>
.tooltip {
  position: relative;
  display: inline-block;
  width: 50px;
  padding: 6px 12px;
  background: #ffbd00;
}

.tooltip .toolTipText {
  visibility: hidden;
  width: 120px;
  background-color: black;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 10px 0;
  position: absolute;
  z-index: 1;
  top: 5px;
  left: 110%;
}

.tooltip .toolTipText::after {
  content: "";
  position: absolute;
  top: 50%;
  right: 100%;
  margin-top: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: transparent black transparent transparent;
}
.tooltip:hover .toolTipText {
  visibility: visible;
}
</style>
