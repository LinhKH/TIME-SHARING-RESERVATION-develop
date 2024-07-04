<template>
  <div class="">
    <div class="flex flex-wrap">
      <button
        v-for="(category, indexCategory) in listCategories"
        class="p-2 border border-solid border-[#ddd] rounded block mr-2 mb-2"
        :class="category.active ? 'bg-[#337ab7] text-white' : 'text-[#337ab7] bg-white'"
        :key="indexCategory"
        @click="() => gotoCategory(category.id)"
      >
        {{ category.label }}
      </button>
    </div>
    <div class="text-end mb-[8px]">
      <button
        @click="handleAddNew"
        class="bg-[#ffbd00] px-[12px] py-[6px] rounded shadow-[0_1px_1px_0_#a4966e] translate-y-0 hover:translate-y-1 transition-all"
      >
        <i class="fa fa-plus text-[14px] text-[#fff] mr-[5px]"></i>
        <span class="text-[14px] text-[#fff]">{{ $t("form_setting_news.add_new") }}</span>
      </button>
    </div>
    <table class="table w-full border border-solid border-[#ccc] border-collapse" cellspacing="1">
      <thead>
        <tr>
          <th
            class="border border-solid border-[#ccc] border-collapse p-[8px] text-start"
            v-for="(newHeaderItem, index) in purposeUseHeader"
            :class="newHeaderItem.width"
            scope="col"
            :key="index"
          >
            {{ newHeaderItem.name }}
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(purposeItem, index) in listPurposeUse" :key="index" class="odd:bg-[#f9f9f9] group">
          <td class="border border-solid border-[#ccc] border-collapse p-2.5 text-start" scope="row">
            <img
              :src="purposeItem.url_img"
              @click="() => handleDetailPurpose(purposeItem.id)"
              class="text-[#337ab7] cursor-pointer hover:underline w-full object-cover"
            />
          </td>
          <td class="border border-solid border-[#ccc] border-collapse p-2.5 text-start" scope="row">
            <span
              @click="() => handleDetailPurpose(purposeItem.id)"
              class="text-[#337ab7] cursor-pointer hover:underline"
              >{{ purposeItem.title_ja || purposeItem.title_en || purposeItem.title_jp }}</span
            >
          </td>
          <td class="border border-solid border-[#ccc] border-collapse text-center" scope="row">
            <button
              class="border border-solid border-[#ccc] py-[6px] px-[15px] rounded group text-[#fff] hover:bg-[#e6e6e6] hover:border-[#adadad] mr-[5px]"
            >
              <i class="fa fa-chevron-up"></i>
            </button>
            <button
              class="border border-solid border-[#ccc] py-[6px] px-[15px] rounded group text-[#fff] hover:bg-[#e6e6e6] hover:border-[#adadad]"
            >
              <i class="fa fa-chevron-down"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <Pagination
    v-if="pagination"
    :pageCurrent="pagination.current_page"
    :totalPage="Math.ceil(pagination.total / pagination.per_page)"
    @onBack="handleBackPage"
    @onNext="handleNextPage"
  />
</template>

<script>
import { useI18n } from "vue-i18n";
import { ROUTER_PATH, MODULE_STORE, PAGE_DEFAULT } from "@/const";
import { useRouter, useRoute } from "vue-router";
import { ref, watch, inject, watchEffect } from "vue";
import { useStore } from "vuex";
import { getListPurposeOfUseByCategory } from "@/api";
import Pagination from "@/components/Pagination";

export default {
  name: "PurposeUse",
  components: { Pagination },
  setup() {
    const { t } = useI18n();
    const router = useRouter();
    const route = useRoute();
    const store = useStore();
    const toast = inject("$toast");
    const categoryId = ref();
    const pagination = ref(null);
    const listPurposeUse = ref([]);
    const purposeUseHeader = [
      { name: "", width: "w-[5%]" },
      { name: t("purpose_of_use.title"), width: "w-[85%]" },
      { name: "", width: "w-[10%]" },
    ];
    const listCategories =
      store.getters[`${MODULE_STORE.SETTING.NAME}/${MODULE_STORE.SETTING.GETTERS.GET_LIST_CATEGORY_PURPOSE_OF_USE}`];
    const gotoCategory = (categoryId) => router.push(`${route.path}?categoryId=${categoryId}`);
    const getListPurposeOfUseByCategoryFromApi = async (categoryId, page) => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const res = await getListPurposeOfUseByCategory(categoryId, page);
        listPurposeUse.value = res.data;
        pagination.value = res.paginate;
      } catch (errors) {
        const error = errors.msg || t("common.has_error");
        toast.error(error);
      }
      store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
    };
    watch(
      () => route.query.categoryId,
      (val) => {
        if (!val) return;
        categoryId.value = val;
        store.dispatch(`${MODULE_STORE.SETTING.NAME}/${MODULE_STORE.SETTING.ACTIONS.SET_ACTIVE_CATEGORY_PURPOSE}`, val);
      },
      { immediate: true }
    );
    watchEffect(() => {
      if (!categoryId.value) return;
      if (route.query.page) {
        getListPurposeOfUseByCategoryFromApi(categoryId.value, route.query.page);
      } else {
        getListPurposeOfUseByCategoryFromApi(categoryId.value, PAGE_DEFAULT);
      }
    });

    const handleDetailPurpose = (id) => {
      router.push(
        `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.PURPOSE_OF_USE_DETAIL}?idPurposeOfUse=${id}&categoryId=${categoryId.value}`
      );
    };
    const handleAddNew = () => {
      router.push(
        `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.PURPOSE_OF_USE_DETAIL}?categoryId=${categoryId.value}`
      );
    };
    const initData = () => {
      if (!route.query.categoryId) {
        gotoCategory("use-purpose-category");
      }
      store.dispatch(`${MODULE_STORE.SETTING.NAME}/setListCategoryPurposeOfUse`);
    };
    initData();
    const handleBackPage = (page) => {
      router.push(`${route.path}?categoryId=${categoryId.value}&page=${page}`);
    };
    const handleNextPage = (page) => {
      router.push(`${route.path}?categoryId=${categoryId.value}&page=${page}`);
    };
    return {
      purposeUseHeader,
      listPurposeUse,
      handleDetailPurpose,
      handleAddNew,
      listCategories,
      gotoCategory,
      pagination,
      handleBackPage,
      handleNextPage,
    };
  },
};
</script>

<style scope></style>
