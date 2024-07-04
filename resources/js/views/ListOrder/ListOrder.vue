<template>
  <div class="p-3">
    <div class="h-8 mb-1">
      <ButtonAddNew :text="$t('list_order_page.add')" @clickBtn="goToCreateSpace" />
    </div>

    <div class="flex justify-between">
      <ButtonFilter @clickBtn="handleShowFilter" />
      <ButtonDownloadCSV @onExportFile="handleExportFile" />
    </div>

    <div v-if="isShowFilter" class="p-2 mt-2">
      <FormFilter />
    </div>

    <div class="flex justify-between mt-2">
      <div>
        {{ $t("list_order_page.only_open_spaces") }}
      </div>
      <div>{{ $t("list_order_page.limit") }}</div>
    </div>

    <table class="w-full border-collapse mt-2">
      <thead>
        <tr class="">
          <th class="w-[88%] p-2">{{ $t("list_order_page.space") }}</th>
          <th class="w-[8%] p-2">{{ $t("list_order_page.public_status") }}</th>
          <th class="w-[4%] p-2"></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in listSpaces" :key="index" class="odd:bg-white even:bg-[#f9f9f9]">
          <td class="p-2">
            <div class="w-full flex items-end flex-col">
              <div class="text-[#337ab7] cursor-pointer" @click="() => goToEditSpace(item)">
                {{ item.title }}
              </div>
              <div class="my-1">{{ item.id }}</div>
              <div>{{ item.organization_information.name }}</div>
            </div>
          </td>
          <td class="">
            <div class="flex justify-center">
              <div
                class="text-[10px] w-[90%] rounded text-center py-1 bg-white border border-solid"
                :class="
                  item.status === STATUS_SPACE.PENDING || item.status === STATUS_SPACE.ARCHIVED
                    ? 'text-[red] border-[red]'
                    : 'text-[#37a200] border-[#37a200]'
                "
              >
                <span
                  v-if="item.status === STATUS_SPACE.PENDING || item.status === STATUS_SPACE.ARCHIVED"
                  class="text-[red]"
                >
                  非公開
                </span>
                <span v-else class="text-[#37a200]"> 公開中 </span>
              </div>
            </div>
          </td>
          <td class="">
            <div class="flex justify-center cursor-pointer">
              <div class="bg-white px-3 py-1 rounded border cursor-pointer" @click="() => goToEditSpace(item)">
                <i class="fa fa-pencil" aria-hidden="true"></i>
              </div>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
    <Pagination
      v-if="pagination"
      :pageCurrent="pagination.current_page"
      :totalPage="pagination.total"
      :isShowPrev="pagination.current_page != 1"
      :isShowNext="pagination.current_page != pagination.total"
      @onBack="handleBackPage"
      @onNext="handleNextPage"
    />
  </div>
</template>

<script>
import ButtonAddNew from "@/components/Buttons/ButtonAddNew";
import ButtonFilter from "@/components/Buttons/ButtonFilter";
import ButtonDownloadCSV from "@/components/Buttons/ButtonDownloadCSV";
import { ROUTER_PATH, MODULE_STORE, PAGE_DEFAULT, STEP_CREATE_SPACE_FROM_API, STATUS_SPACE } from "@/const";
import { getListAllSpaces } from "@/api";
import Pagination from "@/components/Pagination";
import FormFilter from "./FormFilter.vue";

export default {
  name: "ListOrder",
  components: {
    ButtonAddNew,
    ButtonFilter,
    ButtonDownloadCSV,
    Pagination,
    FormFilter,
  },

  data() {
    return {
      isShowFilter: false,
      listSpaces: [],
      pagination: null,
    };
  },
  computed: {
    STATUS_SPACE() {
      return STATUS_SPACE;
    },
    pageCurrent() {
      if (this.$route.query.page) {
        return this.$route.query.page;
      }
      return PAGE_DEFAULT;
    },
  },
  watch: {
    pageCurrent(page) {
      if (this.$route.path == `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}`) {
        this.getListSpaces(page);
      }
    },
  },
  methods: {
    goToEditSpace(item) {
      const { status } = item;
      const step = item["draft-step"];
      if (status == STATUS_SPACE.PUBLIC || status == STATUS_SPACE.ARCHIVED) {
        this.$store.commit(
          `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.MUTATIONS.SET_ID_EDIT_SPACE}`,
          item.id
        );
        this.$router.push(`${ROUTER_PATH.ORDER}/${ROUTER_PATH.EDIT}/${item.id}`);
        return;
      }
      this.$router.push(`${ROUTER_PATH.ORDER}/${ROUTER_PATH.ADD}/${STEP_CREATE_SPACE_FROM_API[step]}?id=${item.id}`);
    },
    handleExportFile() {
      const download = function (data) {
        const blob = new Blob([data], { type: "text/csv;" });

        const url = window.URL.createObjectURL(blob);

        const a = document.createElement("a");

        a.setAttribute("href", url);

        a.setAttribute("download", "rental_space_admin.csv");

        a.click();
      };

      const csvMaker = function (listSpaces) {
        const header = "スペースID,スペース名";
        const listSpaceConvert = listSpaces.map((item) => `${item.id},${item.title}`).join("\n");
        return `${header}\n${listSpaceConvert}`;
      };

      const get = async function () {
        const csvData = csvMaker(this.listSpaces);
        download(csvData);
      };
      get.bind(this)();
    },
    handleBackPage(page) {
      this.$router.push(`${ROUTER_PATH.ORDER}?page=${page}`);
    },
    handleNextPage(page) {
      this.$router.push(`${ROUTER_PATH.ORDER}?page=${page}`);
    },
    goToCreateSpace() {
      this.$router.push(`${ROUTER_PATH.ORDER}/${ROUTER_PATH.ADD}/${ROUTER_PATH.SPACE.GENERAL}`);
    },
    handleShowFilter() {
      this.isShowFilter = !this.isShowFilter;
    },
    async getListSpaces(page = PAGE_DEFAULT) {
      try {
        this.$store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const res = await getListAllSpaces(page);
        this.listSpaces = res.data;
        this.pagination = res.pagination;
      } catch (errors) {
        const error = errors.message || this.$t("common.has_error");
        this.$toast.error(error);
      } finally {
        this.$store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    },
  },
  async created() {
    this.getListSpaces(this.pageCurrent);
  },
};
</script>

<style class="scss" scoped>
th,
td {
  border: 1px solid #dbdbdb;
}
</style>
