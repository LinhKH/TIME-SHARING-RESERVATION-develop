<template>
  <div class="p-3">
    <div class="flex h-8 justify-between mt-1">
      <ButtonFilter @clickBtn="handleClickSortFn" />
    </div>

    <div class="mt-4 border-b pl-4 pb-4" v-show="isShowSort">
      <form>
        <div class="form-select w-full flex items-center my-2">
          <div class="inquiries-btn-filter mr-20 w-32">
            <i class="fa fa-sort"></i>
            <span class="font-bold">
              {{ $t("list_user_manage_page.sort_by") }}
            </span>
          </div>
          <select
            v-model="selected"
            class="bg-white w-96 h-8 px-2 border border-solid border-[#dbdbdb] rounded outline-none focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50"
          >
            <option v-for="item in listSortBy" :key="item.id" :value="item.id">
              {{ item.name }}
            </option>
          </select>
        </div>

        <InputInquiries
          :title="$t('list_inquiries_page.name')"
          :listField="listField[0]"
          @clickInput="handleValueName"
        />
        <InputInquiries
          :title="$t('list_inquiries_page.space_name')"
          :listField="listField[1]"
          @clickInput="handleValueSpaceName"
        />
        <InputInquiries
          :title="$t('list_inquiries_page.company_organization')"
          :listField="listField[2]"
          @clickInput="handleValueCompany"
        />

        <SelectionCategories
          :title="$t('list_inquiries_page.final_reply')"
          :categories="optionsFinalRely"
          @handleChecked="handleFinalRely"
          :valueChecked="valueFinalRely"
        />

        <RadioBase
          :title="$t('list_inquiries_page.reservation_system')"
          :value="listReservation"
          @valueChecked="handleReservation"
        />
        <RadioBase
          :title="$t('list_inquiries_page.completed')"
          :value="listCompleted"
          @valueChecked="handleCompleted"
        />
        <RadioBase
          :title="$t('list_inquiries_page.initial_inquiry_response')"
          :value="listInitialInquiry"
          @valueChecked="handleInitial"
        />
        <RadioBase
          :title="$t('list_inquiries_page.inquiry_agent')"
          :value="listInitialInquiry"
          @valueChecked="handleInitialInquiry"
        />

        <div class="flex items-center my-4">
          <div class="mr-20 w-32">
            <span class="font-bold">
              {{ $t("list_user_manage_page.registration_date_period") }}
            </span>
          </div>
          <DatepickerBase :date="startDatePicker" />
          <DatepickerBase :date="endDatePicker" />
          <span class="text-[#737373]">例：2016-10-03</span>
        </div>
        <SelectionCategories
          :title="$t('list_inquiries_page.status_change')"
          :categories="optionsStatusChange"
          @handleChecked="handleStatusChange"
          :valueChecked="valueStatusChange"
        />
        <InputInquiries
          :title="$t('list_inquiries_page.correspondence_memo')"
          :listField="listField[3]"
          @clickInput="handleValueCorrespondence"
        />
        <InputInquiries
          :title="$t('list_inquiries_page.manager')"
          :listField="listField[4]"
          @clickInput="handleValueManager"
        />
      </form>
      <button class="px-2 py-1 rounded hover:bg-[rgba(0,0,0,.06)] border mt-3" @click="handleSearch">
        <i class="fa fa-search mr-2" aria-hidden="true"></i>
        <span class="">
          {{ $t("list_user_manage_page.search") }}
        </span>
      </button>
    </div>

    <!-- *********** -->

    <div class="block float-right justify-end">
      <ButtonDownloadCSV @onExportFile="handleExportCSV" />
      <div class="float-right">{{ lengthListApi }}件中 1 〜 {{ lengthListApi }}件</div>
    </div>
    <div class="mt-4"><TableInquiries :listData="listApi" /></div>

    <Pagination
      v-if="pagination"
      :pageCurrent="pagination.current_page"
      :totalPage="pagination.total"
      @onBack="handleBackPage"
      @onNext="handleNextPage"
    />
  </div>
</template>

<script>
import { ROUTER_PATH, MODULE_STORE, PAGE_DEFAULT } from "@/const";
import ButtonAddNew from "@/components/Buttons/ButtonAddNew";
import ButtonFilter from "@/components/Buttons/ButtonFilter";
import ButtonDownloadCSV from "@/components/Buttons/ButtonDownloadCSV";
import { ref, computed, watch, inject, reactive } from "vue";
import { useRouter, useRoute } from "vue-router";
import { useStore } from "vuex";
import Pagination from "@/components/Pagination";
import { useI18n } from "vue-i18n";
import RadioBase from "./Radio.vue";
import TableInquiries from "./TableInquiries.vue";
import InputInquiries from "./InputInquiries.vue";
import SelectionCategories from "@/components/Checkbox/SelectionCategories.vue";
import DatepickerBase from "@/components/Datepicker/DatePicker.vue";
import { getListInquiesApi, getCsvInquiries } from "@/api";
import { downloadCsv } from "@/utils";

export default {
  name: "Inquiries",
  components: {
    ButtonAddNew,
    ButtonFilter,
    ButtonDownloadCSV,
    Pagination,
    RadioBase,
    TableInquiries,
    InputInquiries,
    SelectionCategories,
    DatepickerBase,
  },

  setup(props, context) {
    const filterKey = ref({});
    const selected = ref(1);
    const isShowSort = ref(false);
    const timeDatePicker = ref(new Date());
    const startDatePicker = ref(new Date());
    const endDatePicker = ref(new Date());
    const listUserManage = ref([]);
    const listApi = ref();
    const lengthListApi = ref(1);

    const optionsFinalRely = ref([
      { id: 0, name: "ユーザー" },
      { id: 1, name: "オーナー" },
      { id: 2, name: "TIME SHARING" },
    ]);
    const optionsStatusChange = ref([
      { id: 0, name: "未対応" },
      { id: 1, name: "対応中" },
      { id: 2, name: "対応済み" },
    ]);
    const valueFinalRely = ref([]);
    const valueStatusChange = ref([]);

    const route = useRoute();
    const router = useRouter();
    const store = useStore();
    const { t } = useI18n();
    const toast = inject("$toast");
    const pagination = ref(null);
    const listSortBy = ref([
      {
        id: 1,
        name: "日時（新しい順）",
      },
      {
        id: 2,
        name: "日時（古い順）",
      },
    ]);
    const listReservation = ref([
      {
        id: "1",
        label: "公開",
        value: "公開",
      },
      {
        id: "2",
        label: "非公開",
        value: "非公開",
      },
      {
        id: "3",
        label: "すべて",
        value: "すべて",
      },
    ]);
    const listCompleted = ref([
      {
        id: "1",
        label: "完了",
        value: "完了",
      },
      {
        id: "2",
        label: "未完了",
        value: "未完了",
      },
      {
        id: "3",
        label: "すべて",
        value: "すべて",
      },
    ]);
    const listInitialInquiry = ref([
      {
        id: "1",
        label: "完了",
        value: "完了",
      },
      {
        id: "2",
        label: "なし",
        value: "なし",
      },
      {
        id: "3",
        label: "すべて",
        value: "すべて",
      },
    ]);
    const listField = ref([
      {
        id: "1",
        icon: "",
        type: "text",
        name: "name",
        modal: "",
        placeholder: "",
        class: "",
        readonly: false,
      },
      {
        id: "2",
        icon: "",
        type: "text",
        name: "spaceName",
        modal: "",
        placeholder: "",
        class: "",
        readonly: false,
      },
      {
        id: "3",
        icon: "",
        type: "text",
        name: "companyOrganization",
        modal: "",
        class: "",
        placeholder: "株式会社あどばる",
        readonly: true,
      },
      {
        id: "4",
        icon: "fa fa-user",
        type: "text",
        name: "correspondence",
        modal: "",
        class: "w-64",
        placeholder: "",
        readonly: false,
      },
      {
        id: "5",
        icon: "fa fa-user",
        type: "text",
        name: "manager",
        modal: "",
        class: "w-64",
        placeholder: "",
        readonly: false,
      },
    ]);
    const valueDataSearch = ref({
      selectSortBy: "",
      name: "",
      spaceName: "",
      company: "",
      startDate: "",
      endDate: "",
      correspondence: "",
      manager: "",
      reservation: "",
    });

    const pageCurrent = computed(() => {
      if (!route.query.page) {
        return PAGE_DEFAULT;
      }
      return Number(route.query.page);
    });

    const handleClickSortFn = () => {
      isShowSort.value = !isShowSort.value;
    };
    const handleAddUserManage = () => {
      router.push(`${ROUTER_PATH.USER_MANAGER}/${ROUTER_PATH.ADD}`);
    };
    const goToAdd = (id) => {
      router.push(`${ROUTER_PATH.USER_MANAGER}/${ROUTER_PATH.EDIT}/${id}`);
    };

    watch(pageCurrent, (page) => {
      if (route.path == ROUTER_PATH.USER_MANAGER) {
      }
    });
    const handleBackPage = (page) => {
      router.push(`${ROUTER_PATH.USER_MANAGER}?page=${page}`);
    };
    const handleNextPage = (page) => {
      router.push(`${ROUTER_PATH.USER_MANAGER}?page=${page}`);
    };
    const handleFinalRely = (listSelected) => {
      valueFinalRely.value = listSelected;
    };
    const handleStatusChange = (listSelected) => {
      valueStatusChange.value = listSelected;
    };
    const handleValueName = (val) => {
      valueDataSearch.value.name = val;
    };
    const handleValueSpaceName = (val) => {
      valueDataSearch.value.spaceName = val;
    };
    const handleValueCompany = (val) => {
      valueDataSearch.value.company = val;
    };
    const handleValueCorrespondence = (val) => {
      valueDataSearch.value.correspondence = val;
    };
    const handleValueManager = (val) => {
      valueDataSearch.value.manager = val;
    };
    const handleReservation = (val) => {
      valueDataSearch.value.reservation = val;
    };
    const handleSearch = () => {
      valueDataSearch.value.selectSortBy = selected.value;
      //ToDo: call api search
    };
    const getAllListInquiry = async (page = PAGE_DEFAULT) => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const res = await getListInquiesApi();
        listApi.value = res.data;
        lengthListApi.value = listApi.value.length;
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    getAllListInquiry();

    const handleExportCSV = async () => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const csvContent = await getCsvInquiries();
        downloadCsv(csvContent);
      } catch (err) {
        const error = err.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    return {
      filterKey,
      selected,
      isShowSort,
      listSortBy,
      listReservation,
      listCompleted,
      listInitialInquiry,
      timeDatePicker,
      startDatePicker,
      endDatePicker,
      listUserManage,
      handleClickSortFn,
      handleAddUserManage,
      goToAdd,
      pagination,
      handleBackPage,
      handleNextPage,
      listField,
      optionsFinalRely,
      optionsStatusChange,
      valueFinalRely,
      valueStatusChange,
      valueDataSearch,
      handleFinalRely,
      handleStatusChange,
      handleValueName,
      handleValueSpaceName,
      handleValueCompany,
      handleValueCorrespondence,
      handleValueManager,
      handleReservation,
      handleSearch,
      listApi,
      lengthListApi,
      handleExportCSV,
    };
  },
};
</script>

<style lang="scss" scoped>
.inquiries-btn-filter::before {
  content: "必須";
  color: rgb(255, 255, 255);
  padding-left: 2px;
  padding-right: 2px;
  font-size: 0.75rem;
  display: inline-block;
  position: relative;
  top: -0.2em;
  margin-right: 0.1em;
  background: rgb(254, 84, 87);
  border-radius: 3px;
}
.form-select {
  @media (max-width: 1200px) {
    display: block;
    select {
      width: 99%;
    }
  }
}
</style>
