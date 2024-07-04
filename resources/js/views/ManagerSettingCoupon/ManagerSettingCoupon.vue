<template>
  <div class="p-3">
    <div class="flex">
      <ButtonFilter @clickBtn="handleShowFilter" />
    </div>

    <div v-if="isShowFilter" class="p-3 mt-2 border-b-[1px] border-[#ddd]">
      <BaseFormCoupon :label="$t('setting_coupon.status')" :icon="'fa fa-flag-o'">
        <input type="radio" id="one" value="One" v-model="search.status" />
        <label class="mr-3 ml-1" for="one">{{ $t("coupon_detail.yes") }}</label>
        <input type="radio" id="two" value="Two" v-model="search.status" />
        <label class="mr-3 ml-1" for="two">{{ $t("coupon_detail.no") }}</label>
        <input type="radio" id="3" value="3" v-model="search.status" />
        <label class="mr-3 ml-1" for="3">{{ $t("coupon_detail.no") }}</label>
      </BaseFormCoupon>
      <BaseFormCoupon :label="$t('setting_coupon.discount')" :icon="'fa fa-percent'">
        <div class="flex">
          <input class="w-[170px] py-[6px] px-[12px] border border-[#ddd] rounded outline-none" type="number" />
          <span class="py-[6px] px-[12px] border border-[#ddd] bg-[#eee]"> 〜 </span>
          <input class="w-[170px] py-[6px] px-[12px] border border-[#ddd] rounded outline-none" type="number" />
        </div>
      </BaseFormCoupon>

      <BaseFormCoupon :label="$t('setting_coupon.discount_name')" :icon="'fa fa-ticket'">
        <input class="w-[380px] py-[6px] px-[12px] border border-[#ddd] rounded outline-none" type="text" />
      </BaseFormCoupon>
      <BaseFormCoupon :label="$t('setting_coupon.discount_code')" :icon="'fa fa-ticket'">
        <input class="w-[380px] py-[6px] px-[12px] border border-[#ddd] rounded outline-none" type="text" />
      </BaseFormCoupon>

      <BaseFormCoupon :label="$t('setting_coupon.Expiration_reservation_date_start')" :icon="'fa fa-calendar-plus-o'">
        <div class="flex">
          <div class="flex h-8 border rounded">
            <div class="h-full px-2 bg-[#eee] border-r border-[#dbdbdb] items-center">
              <i class="fa fa-calendar"></i>
            </div>
            <div class="flex items-center justify-center">
              <datepicker class="px-2 w-[100px] outline-none text-center text-sm" v-model="search.epxResStart1" />
            </div>
          </div>
          <div class="p-2">〜</div>
          <div class="flex h-8 border rounded">
            <div class="h-full px-2 bg-[#eee] border-r border-[#dbdbdb] item-center">
              <i class="fa fa-calendar"></i>
            </div>
            <div class="flex items-center justify-center">
              <datepicker class="px-2 w-[100px] outline-none text-center text-sm" v-model="search.epxResStart2" />
            </div>
          </div>
        </div>
      </BaseFormCoupon>

      <BaseFormCoupon :label="$t('setting_coupon.Expiration_reservation_date_end')" :icon="'fa fa-calendar-minus-o'">
        <div class="flex">
          <div class="flex h-8 border rounded">
            <div class="h-full px-2 bg-[#eee] border-r border-[#dbdbdb] items-center">
              <i class="fa fa-calendar"></i>
            </div>
            <div class="flex items-center justify-center">
              <datepicker class="px-2 w-[100px] outline-none text-center text-sm" v-model="epxResEnd1" />
            </div>
          </div>
          <div class="p-2">〜</div>
          <div class="flex h-8 border rounded">
            <div class="h-full px-2 bg-[#eee] border-r border-[#dbdbdb] item-center">
              <i class="fa fa-calendar"></i>
            </div>
            <div class="flex items-center justify-center">
              <datepicker class="px-2 w-[100px] outline-none text-center text-sm" v-model="search.epxResEnd2" />
            </div>
          </div>
        </div>
      </BaseFormCoupon>

      <BaseFormCoupon :label="$t('setting_coupon.Expiration_use_date_start')" :icon="'fa fa-calendar-plus-o'">
        <div class="flex">
          <div class="flex h-8 border rounded">
            <div class="h-full px-2 bg-[#eee] border-r border-[#dbdbdb] items-center">
              <i class="fa fa-calendar"></i>
            </div>
            <div class="flex items-center justify-center">
              <datepicker class="px-2 w-[100px] outline-none text-center text-sm" v-model="search.dateUseStart1" />
            </div>
          </div>
          <div class="p-2">〜</div>
          <div class="flex h-8 border rounded">
            <div class="h-full px-2 bg-[#eee] border-r border-[#dbdbdb] item-center">
              <i class="fa fa-calendar"></i>
            </div>
            <div class="flex items-center justify-center">
              <datepicker class="px-2 w-[100px] outline-none text-center text-sm" v-model="search.dateUseStart2" />
            </div>
          </div>
        </div>
      </BaseFormCoupon>

      <BaseFormCoupon :label="$t('setting_coupon.Expiration_use_date_end')" :icon="'fa fa-calendar-minus-o'">
        <div class="flex">
          <div class="flex h-8 border rounded">
            <div class="h-full px-2 bg-[#eee] border-r border-[#dbdbdb] items-center">
              <i class="fa fa-calendar"></i>
            </div>
            <div class="flex items-center justify-center">
              <datepicker class="px-2 w-[100px] outline-none text-center text-sm" v-model="search.dateUseEnd1" />
            </div>
          </div>
          <div class="p-2">〜</div>
          <div class="flex h-8 border rounded">
            <div class="h-full px-2 bg-[#eee] border-r border-[#dbdbdb] item-center">
              <i class="fa fa-calendar"></i>
            </div>
            <div class="flex items-center justify-center">
              <datepicker class="px-2 w-[100px] outline-none text-center text-sm" v-model="search.dateUseEnd2" />
            </div>
          </div>
        </div>
      </BaseFormCoupon>

      <BaseFormCoupon :label="$t('setting_coupon.oder')" :icon="'fa fa fa-sort'">
        <div class="flex-1">
          <Select
            :optionsSelect="optionsSelect"
            :inputKey="'input_1'"
            :currentValue="'item2'"
            @changeValue="updateValueInput"
          />
        </div>
      </BaseFormCoupon>
      <div class="mb-[10px] flex mt-2 items-center">
        <div @click="onClickSearch" class="bg-[#fff] hover:bg-slate-300 rounded">
          <button class="border border-[#ccc] border-solid rounded h-full px-4 cursor-pointer py-3">
            <i class="fa fa-search"></i>
            <span>{{ $t("list_customer_dropdown.search") }}</span>
          </button>
        </div>
      </div>
    </div>
    <div class="flex justify-end">
      <ButtonAddNew
        :text="$t('static_Page.text_button')"
        @clickBtn="goToCreateNew"
        class="shadow-[0_1px_1px_0_#a4966e] translate-y-0 hover:translate-y-1 transition-all"
      />
    </div>
    <FormCouponTable :dataTable="dataTable" :listCoupon="listCoupon" />
  </div>
</template>

<script>
import ButtonFilter from "@/components/Buttons/ButtonFilter";
import Label from "@/components/Label";
import Input from "@/components/Form/Input.vue";
import { ref } from "vue";
import Select from "@/components/Form/Select.vue";
import { useI18n } from "vue-i18n";
import BaseFormSearchExternal from "@/components/ExternalReservation/BaseFormSearchExternal.vue";
import FormCouponTable from "@/components/FormSettingCoupon/FormCouponTable";
import { useRouter } from "vue-router";
import Datepicker from "vue3-datepicker";
import ButtonAddNew from "@/components/Buttons/ButtonAddNew";
import BaseFormCoupon from "@/components/FormSettingCoupon/BaseFormCoupon/BaseFormCoupon.vue";
import { getListCouponApi } from "@/api";
import { useStore } from "vuex";
import { ROUTER_PATH, MODULE_STORE, PAGE_DEFAULT, BOOLEAN } from "@/const";
export default {
  name: "ManagerSettingCoupon",
  components: {
    ButtonFilter,
    Label,
    Input,
    Select,
    BaseFormSearchExternal,
    Datepicker,
    FormCouponTable,
    ButtonAddNew,
    BaseFormCoupon,
  },
  setup() {
    const { t } = useI18n();
    const router = useRouter();
    const isShowFilter = ref(false);
    const store = useStore();
    const listCoupon = ref({});
    const handleShowFilter = () => {
      isShowFilter.value = !isShowFilter.value;
    };
    const radioOption = [
      { id: "1radio", name: "radio", val: "1", label: "有効" },
      { id: "2radio", name: "radio", val: "2", label: "無効" },
      { id: "3radio", name: "radio", val: "3", label: "すべて" },
    ];
    const optionsSelect = [
      { id: 1, value: "register_new", label: " 登録日（新しい順） " },
      { id: 2, value: "register_old", label: " 登録日（古い順） " },
      { id: 3, value: "discount_rate_hight_lowest", label: " 割引率（高い順） " },
      { id: 4, value: "discount_rate_low_lowest", label: " 割引率（低い順）" },
    ];
    const dataTable = {
      header: [
        {
          text: t("setting_coupon.table.id"),
          width: "3%",
        },
        {
          text: t("setting_coupon.table.use_coupon_name"),
          width: "25%",
        },
        {
          text: t("setting_coupon.table.discount_rate"),
          width: "5%",
        },
        {
          text: t("setting_coupon.table.maximum_number_use"),
          width: "5%",
        },
        {
          text: t("setting_coupon.table.discount_code"),
          width: "10%",
        },
        {
          text: t("setting_coupon.table.Expiration_reservation_date"),
          width: "18%",
        },
        {
          text: t("setting_coupon.table.Expiration_use_date"),
          width: "18%",
        },
        {
          text: t("setting_coupon.table.status"),
          width: "10%",
        },
        {
          text: "",
        },
      ],

      data: [],
    };

    const search = ref({
      epxResStart1: "",
      epxResStart2: "",
      epxResEnd1: "",
      epxResEnd2: "",
      dateUseStart1: "",
      dateUseStart2: "",
      dateUseEnd1: "",
      dateUseEnd2: "",
      status: "",
    });
    const onClickSearch = () => {};
    const goToCreateNew = () => {
      router.push(`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.MANAGE_COUPON_DETAIL}`);
    };

    const getAllSettingCoupon = async () => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const res = await getListCouponApi();
        listCoupon.value = res;
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    getAllSettingCoupon();

    return {
      search,
      isShowFilter,
      handleShowFilter,
      radioOption,
      optionsSelect,
      onClickSearch,
      goToCreateNew,
      dataTable,
      getAllSettingCoupon,
      listCoupon,
    };
  },
};
</script>

<style></style>
