<template>
  <div class="flex justify-end">
    <ButtonAddNew :text="$t('compilation_setting.new')" @clickBtn="handleGotoAdd" />
  </div>
  <table class="w-full mt-2">
    <thead>
      <tr>
        <th class="w-[5%]"></th>
        <th class="w-[20%]">{{ $t("compilation_setting.access_key") }}</th>
        <th>{{ $t("compilation_setting.title") }}</th>
        <th class="w-[5%]">{{ $t("compilation_setting.title") }}</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(item, index) in listCompilation" :key="index" class="odd:bg-[#f9f9f9]">
        <td>
          <img class="w-full h-10 object-cover" :src="item.image_url" alt="image" />
        </td>
        <td>
          <span
            class="text-[#337ab7] cursor-pointer hover:underline block p-2"
            @click="() => handleGotoEdit(item.rental_space_compilation_id)"
          >
            {{ item.access_key }}
          </span>
        </td>
        <td>
          <span
            class="text-[#337ab7] cursor-pointer hover:underline block p-2"
            @click="() => handleGotoEdit(item.rental_space_compilation_id)"
          >
            {{ item.title_ja }}
          </span>
        </td>
        <td class="">
          <div class="flex items-center justify-center">
            <button
              class="px-2 py-1 bg-white rounded border border-solid border-[#9b9b9b] mr-2"
              @click="() => handleUp(index)"
            >
              <i class="fa fa-angle-up text-black" aria-hidden="true"></i>
            </button>
            <button
              class="px-2 py-1 bg-white rounded border border-solid border-[#9b9b9b]"
              @click="() => handleDown(index)"
            >
              <i class="fa fa-angle-down text-black" aria-hidden="true"></i>
            </button>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
  <Pagination
    v-if="pagination"
    :pageCurrent="pagination.current_page"
    :totalPage="pagination.total_page"
    @onBack="handleBackPage"
    @onNext="handleNextPage"
  />
</template>

<script>
import ButtonAddNew from "@/components/Buttons/ButtonAddNew";
import { ref, inject, computed, watch } from "vue";
import { useRoute, useRouter } from "vue-router";
import { ROUTER_PATH, MODULE_STORE, PAGE_DEFAULT } from "@/const";
import { getListSummary } from "@/api";
import { useStore } from "vuex";
import { useI18n } from "vue-i18n";
import Pagination from "@/components/Pagination";

export default {
  name: "Compilation",
  components: { ButtonAddNew, Pagination },
  setup() {
    const router = useRouter();
    const store = useStore();
    const { t } = useI18n();
    const toast = inject("$toast");
    const listCompilation = ref([]);
    const pagination = ref();
    const route = useRoute();
    const handleUp = (index) => {
      if (!listCompilation.value[index - 1]) return;
      const arrayCurrent = [...listCompilation.value];
      listCompilation.value[index - 1] = arrayCurrent[index];
      listCompilation.value[index] = arrayCurrent[index - 1];
    };
    const handleDown = (index) => {
      if (!listCompilation.value[index + 1]) return;
      const arrayCurrent = [...listCompilation.value];
      listCompilation.value[index + 1] = arrayCurrent[index];
      listCompilation.value[index] = arrayCurrent[index + 1];
    };
    const pageCurrent = computed(() => {
      if (route.query.page) {
        return route.query.page;
      } else {
        return PAGE_DEFAULT;
      }
    });
    const handleGotoAdd = () =>
      router.push(`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.RENTAL_SPACE_COMPILATION_ADD}`);

    const handleGotoEdit = (id) =>
      router.push(
        `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.RENTAL_SPACE_COMPILATION_EDIT}?idSummary=${id}`
      );
    const getListSummaryFromApi = async (page) => {
      store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
      try {
        const res = await getListSummary(page);
        listCompilation.value = res.data.map((item) => ({
          ...item,
          image_url: !!item.rental_space_compilation_images.length ? item.rental_space_compilation_images[0].s3key : "",
        }));
        pagination.value = res.pagination;
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      }
      store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
    };

    const initData = async () => {
      getListSummaryFromApi(pageCurrent.value);
    };
    watch(pageCurrent, (page) => {
      getListSummaryFromApi(page);
    });
    const handleNextPage = (page) => {
      router.push(
        `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.RENTAL_SPACE_COMPILATION}?page=${page}`
      );
    };
    const handleBackPage = (page) => {
      router.push(
        `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.RENTAL_SPACE_COMPILATION}?page=${page}`
      );
    };
    initData();

    return {
      handleNextPage,
      handleBackPage,
      pagination,
      listCompilation,
      handleUp,
      handleDown,
      handleGotoEdit,
      handleGotoAdd,
    };
  },
};
</script>

<style scoped>
td,
th {
  border: 1px solid #ddd;
  padding: 8px;
}
</style>
