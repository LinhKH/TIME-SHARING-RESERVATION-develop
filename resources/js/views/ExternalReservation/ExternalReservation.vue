<template>
  <div class="p-3">
    <ul class="flex justify-content-start align-items-center border-b border-solid border-[#ddd] pt-2.5 pl-2.5 mb-5">
      <li
        class="siderbar__item"
        :class="[currentStep == siderbar.id ? 'active' : '']"
        v-for="(siderbar, index) in siderBarSteps"
        :key="index"
      >
        <a
          :class="[currentStep == siderbar.id ? classActive : '']"
          class="block py-2.5 px-4 cursor-pointer bg-white text-[#337ab7]"
          :href="`${siderbar.url}`"
          >{{ siderbar.title }}</a
        >
      </li>
    </ul>
    <div class="flex justify-between">
      <ButtonFilter @clickBtn="handleShowFilter" />
      <ButtonDownloadCSV />
    </div>

    <div v-if="isShowFilter" class="p-3 mt-2">
      <div class="mb-[10px] flex mt-2 items-center">
        <div class="w-64">
          <Label :label="$t('external_reservation.oder')" :required="true" :iconClass="'fa fa-sort'" />
        </div>
        <div class="flex-1">
          <Select
            :optionsSelect="optionsSelectExemple"
            :inputKey="'input_1'"
            :currentValue="'item2'"
            @changeValue="updateValueInput"
          />
        </div>
      </div>

      <BaseFormSearchExternal :label="$t('external_reservation.status')" :isExtend="true"
        ><MultipleCheckbox
          :optionsCheckbox="optionsCheckBoxStatus"
          :inputKey="'input_3'"
          :currentValue="currentOptionsCheckBoxStatus"
          @changeValue="updateValueCheckBox1"
      /></BaseFormSearchExternal>

      <BaseFormSearchExternal :label="$t('external_reservation.purpose_use')" :isExtend="true"
        ><MultipleCheckbox
          :optionsCheckbox="optionsCheckBoxPurposeUse"
          :inputKey="'input_3'"
          :currentValue="currentOptionsCheckBoxPurposeUse"
          @changeValue="updateValueCheckBox1"
      /></BaseFormSearchExternal>
      <BaseFormSearchExternal :label="$t('external_reservation.purpose_use_other')" :value="inputText" />
      <BaseFormSearchExternal :label="$t('external_reservation.oder_type')" :isExtend="true"
        ><MultipleCheckbox
          :optionsCheckbox="optionsCheckBoxOderType"
          :inputKey="'input_5'"
          :currentValue="currentOptionsCheckBoxOderType"
          @changeValue="updateValueCheckBox1"
      /></BaseFormSearchExternal>

      <BaseFormSearchExternal
        v-for="item in dataForm"
        :key="item.id"
        :label="item.label"
        :options="item.radioOption"
        :type="item.type"
      />
      <BaseFormSearchExternal
        :label="$t('external_reservation.people')"
        :iconClass="'fa fa-user-plus'"
        :isExtend="true"
      >
        <div class="flex items-center">
          <div class="flex">
            <input
              class="w-3/4 border border-solid border-[#ddd] rounded flex h-8 focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 outline-none px-2"
              type="text"
              name="endPeople"
              id="startPeople"
            />
            <label class="w-1/4 p-1 bg-slate-200 border border-solid border-[#ddd] rounded" for="startPeople">{{
              $t("external_reservation.start_people")
            }}</label>
          </div>
          <p class="mx-[10px]">~</p>
          <div class="flex">
            <input
              class="w-3/4 border border-solid border-[#ddd] rounded flex h-8 focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 outline-none"
              type="text"
              name="endPeople"
              id="endPeople"
            />
            <label class="w-1/4 p-1 bg-slate-200 border border-solid border-[#ddd] rounded" for="endPeople">{{
              $t("external_reservation.end_people")
            }}</label>
          </div>
          <input class="mx-2" type="checkbox" name="" id="onePeople" />
          <label for="onePeople">{{ $t("external_reservation.one_people") }}</label>
        </div>
      </BaseFormSearchExternal>
      <BaseFormSearchExternal :label="$t('external_reservation.schedule_use_day')" :isExtend="true">
        <div class="flex items-center">
          <div class="flex h-8 border rounded mr-4">
            <div class="h-full px-2 bg-[#eee] border-r border-[#dbdbdb] flex items-center justify-center">
              <i class="fa fa-calendar"></i>
            </div>
            <div class="h-full px-2 bg-[#eee] border-r border-[#dbdbdb] text-sm flex items-center justify-center">
              {{ $t("list_customer_dropdown.start_date") }}
            </div>
            <div class="flex items-center justify-center">
              <datepicker class="px-2 w-40 outline-none text-center text-sm" v-model="startDatePickerUse" />
            </div>
          </div>
          <div class="flex h-8 border rounded">
            <div class="h-full px-2 bg-[#eee] border-r border-[#dbdbdb] flex items-center justify-center">
              <i class="fa fa-calendar"></i>
            </div>
            <div class="h-full px-2 bg-[#eee] border-r border-[#dbdbdb] text-sm flex items-center justify-center">
              {{ $t("list_customer_dropdown.end_date") }}
            </div>
            <div class="flex items-center justify-center">
              <datepicker class="px-2 w-40 outline-none text-center text-sm" v-model="endDatePickerUse" />
            </div>
          </div>
        </div>
      </BaseFormSearchExternal>
      <BaseFormSearchExternal :label="$t('external_reservation.day_register')" :isExtend="true">
        <div class="flex items-center">
          <div class="flex h-8 border rounded mr-4">
            <div class="h-full px-2 bg-[#eee] border-r border-[#dbdbdb] flex items-center justify-center">
              <i class="fa fa-calendar"></i>
            </div>
            <div class="h-full px-2 bg-[#eee] border-r border-[#dbdbdb] text-sm flex items-center justify-center">
              {{ $t("list_customer_dropdown.start_date") }}
            </div>
            <div class="flex items-center justify-center">
              <datepicker class="px-2 w-40 outline-none text-center text-sm" v-model="startDatePicker" />
            </div>
          </div>
          <div class="flex h-8 border rounded">
            <div class="h-full px-2 bg-[#eee] border-r border-[#dbdbdb] flex items-center justify-center">
              <i class="fa fa-calendar"></i>
            </div>
            <div class="h-full px-2 bg-[#eee] border-r border-[#dbdbdb] text-sm flex items-center justify-center">
              {{ $t("list_customer_dropdown.end_date") }}
            </div>
            <div class="flex items-center justify-center">
              <datepicker class="px-2 w-40 outline-none text-center text-sm" v-model="endDatePicker" />
            </div>
          </div>
        </div>
      </BaseFormSearchExternal>
      <div class="mb-[10px] flex mt-2 items-center">
        <div @click="onSearch" class="bg-[#fff] hover:bg-slate-300 rounded">
          <button class="border border-[#ccc] border-solid rounded h-full px-4 cursor-pointer py-3">
            <i class="fa fa-search"></i>
            <span>{{ $t("list_customer_dropdown.search") }}</span>
          </button>
        </div>
      </div>
    </div>
    <div class="table-container">
      <ExternalReservationTable :dataTable="dataTable" />
    </div>
  </div>
</template>

<script>
import Datepicker from "vue3-datepicker";
import ButtonFilter from "@/components/Buttons/ButtonFilter";
import ButtonDownloadCSV from "@/components/Buttons/ButtonDownloadCSV";
import Label from "@/components/Label";
import Input from "@/components/Form/Input.vue";
import { ref } from "vue";
import Select from "@/components/Form/Select.vue";
import { useI18n } from "vue-i18n";
import { ROUTER_PATH } from "@/const";
import MultipleCheckbox from "@/components/Form/MultipleCheckbox.vue";
import ExternalReservationTable from "@/components/ExternalReservation/ExternalReservationTable.vue";
import { optionsCheckBoxStatus, optionsCheckBoxPurposeUse, optionsCheckBoxOderType } from "@/const/options";
import BaseFormSearchExternal from "@/components/ExternalReservation/BaseFormSearchExternal.vue";
export default {
  name: "ReservationsManage",
  components: {
    ButtonFilter,
    ButtonDownloadCSV,
    Label,
    Input,
    Select,
    MultipleCheckbox,
    Datepicker,
    ExternalReservationTable,
    BaseFormSearchExternal,
  },
  setup() {
    const { t } = useI18n();
    const currentStep = 2;
    const isShowFilter = ref(false);
    const handleShowFilter = () => {
      isShowFilter.value = !isShowFilter.value;
    };
    const classActive = [
      "rounded-t",
      "border",
      "border-solid",
      "border-[#ddd]",
      "text-[#555]",
      "border-b-[transparent]",
    ].join(" ");
    const siderBarSteps = [
      {
        id: 1,
        title: t("reservations.reservations_sider_bar.dashboard"),
        url: "",
      },
      {
        id: 2,
        title: t("reservations.reservations_sider_bar.manage"),
        url: ROUTER_PATH.RESERVATIONS_MANAGE,
      },
      {
        id: 3,
        title: t("reservations.reservations_sider_bar.calendar"),
        url: "",
      },
      {
        id: 4,
        title: t("reservations.reservations_sider_bar.billing-download"),
        url: "",
      },
    ];
    const inputText = ref("");
    const optionsSelectExemple = [
      { id: 1, value: "day_ident_ascending", label: "利用予定日 (古い順)" },
      { id: 2, value: "day_ident_descending", label: "利用予定日 (新しい順)" },
      { id: 3, value: "total_price_ascending", label: "合計金額 (安い順)" },
      { id: 4, value: "total_price_descending", label: "合計金額 (高い順)" },
      { id: 5, value: "creation_time_ascending", label: "予約完了日時 (古い順)" },
    ];
    const dataForm = [
      {
        type: "radio",
        label: t("external_reservation.oder_type_proxy"),
        radioOption: [
          { id: "1radioOderTypeProxy", name: "radioOderTypeProxy", val: "1", label: t("すべて") },
          { id: "2radioOderTypeProxy", name: "radioOderTypeProxy", val: "2", label: t("Web予約") },
          { id: "3radioOderTypeProxy", name: "radioOderTypeProxy", val: "3", label: t("電話予約(通常)") },
          { id: "4radioOderTypeProxy", name: "radioOderTypeProxy", val: "4", label: t("電話予約(延長・追加)") },
        ],
      },
      {
        type: "radio",
        icon: "'fa fa-level-up'",
        label: t("external_reservation.bringing_in_food_and_drink"),
        radioOption: [
          { id: "1radioDinkFood", name: "radioDinkFood", val: "1", label: "すべて" },
          { id: "2radioDinkFood", name: "radioDinkFood", val: "2", label: "あり" },
          { id: "3radioDinkFood", name: "radioDinkFood", val: "3", label: "なし" },
        ],
      },
      {
        type: "radio",
        icon: "'fa fa-level-up'",
        label: t("external_reservation.PR_frame"),
        radioOption: [
          { id: "1radioPrFrame", name: "radioPrFrame", val: "1", label: "すべて" },
          { id: "2radioPrFrame", name: "radioPrFrame", val: "2", label: "あり" },
          { id: "3radioPrFrame", name: "radioPrFrame", val: "3", label: "なし" },
        ],
      },
      {
        type: "radio",
        icon: "'fa fa-level-up'",
        label: t("external_reservation.flow_supenavi"),
        radioOption: [
          { id: "1radioFlowSupenavi", name: "radioFlowSupenavi", val: "1", label: "すべて" },
          { id: "2radioFlowSupenavi", name: "radioFlowSupenavi", val: "2", label: "あり" },
          { id: "3radioFlowSupenavi", name: "radioFlowSupenavi", val: "3", label: "なし" },
        ],
      },
      {
        type: "radio",
        icon: "'fa fa-level-up'",
        label: t("external_reservation.flow_owner"),
        radioOption: [
          { id: "1radioFlowOwner", name: "radioFlowOwner", val: "1", label: "すべて" },
          { id: "2radioFlowOwner", name: "radioFlowOwner", val: "2", label: "あり" },
          { id: "3radioFlowOwner", name: "radioFlowOwner", val: "3", label: "なし" },
        ],
      },
      {
        type: "radio",
        icon: "'fa fa-level-up'",
        label: t("external_reservation.ticket"),
        radioOption: [
          { id: "1radioTicket", name: "radioTicket", val: "1", label: "すべて" },
          { id: "2radioTicket", name: "radioTicket", val: "2", label: "あり" },
          { id: "3radioTicket", name: "radioTicket", val: "3", label: "なし" },
        ],
      },
      {
        type: "radio",
        icon: "'fa fa-level-up'",
        label: t("external_reservation.user_type"),
        radioOption: [
          { id: "1radioUserType", name: "radioUserType", val: "1", label: "すべて" },
          { id: "2radioUserType", name: "radioUserType", val: "2", label: "法人利用" },
          { id: "3radioUserType", name: "radioUserType", val: "3", label: "個人利用" },
          { id: "4radioUserType", name: "radioUserType", val: "4", label: "未選択" },
        ],
      },
      {
        type: "input",
        label: t("external_reservation.oderID"),
        inputText: "",
        inputKey: "input_13",
      },
      {
        type: "input",
        label: t("external_reservation.name"),
        inputText: "",
        inputKey: "input_14",
      },
      {
        type: "input",
        label: t("external_reservation.user_email"),
        inputText: "",
        inputKey: "input_15",
      },
      {
        type: "input",
        label: t("external_reservation.phone_number"),
        inputText: "",
        inputKey: "input_16",
      },
      {
        type: "input",
        label: t("external_reservation.space_name"),
        inputText: "",
        inputKey: "input_17",
      },
      {
        type: "input",
        label: t("external_reservation.spaceID"),
        inputText: "",
        inputKey: "input_18",
      },
      {
        type: "input",
        label: t("external_reservation.except_spaceID"),
        inputText: "",
        inputKey: "input_19",
      },
      {
        type: "input",
        label: t("external_reservation.text"),
        inputText: "",
        inputKey: "input_20",
      },
    ];
    const dataTable = {
      header: [
        {
          text: "予約ID",
        },
        {
          text: "ユーザー",
          width: "12%",
        },
        {
          text: "	利用スペース",
          width: "15%",
        },
        {
          text: "用途",
          width: "10%",
        },
        {
          text: "	ご利用日",
          width: "10%",
        },
        {
          text: "ステータス",
          width: "10%",
        },
        {
          text: "予約完了日時",
          width: "10%",
        },
        {
          text: "クーポン利用",
        },
        {
          text: "外部経由",
        },
        {
          text: "",
        },
      ],

      data: [
        [
          {
            textID: "6549521",
            text: "送客：なし",
            type: "linksText",
            url: "http://localhost/",
          },
          {
            text: "(予約対応：渡辺 翁名)",
            type: "linksUser",
            url1: "http://localhost/",
            url2: "http://localhost/",
          },
          {
            text: "みんなのテスト",
            type: "links",
            url: "http://localhost/",
          },
          {
            text: "パーティー",
            type: "text",
          },
          {
            text: "2022年03月24日(木)15:00 〜 16:00",
            type: "text",
          },
          {
            text: " 外部予約登録",
            type: "textIcon",
          },
          {
            text: "2022年04月08日",
            type: "links",
            url: "http://localhost/",
          },
          {
            text: "なし",
            type: "text",
          },
          {
            label: "外部経由",
            type: "text",
          },
        ],
      ],
    };
    const startDatePicker = ref(new Date());
    const endDatePicker = ref(new Date());
    const startDatePickerUse = ref(new Date());
    const endDatePickerUse = ref(new Date());
    return {
      inputText,
      optionsSelectExemple,
      optionsCheckBoxStatus,
      endDatePicker,
      startDatePicker,
      startDatePickerUse,
      dataTable,
      endDatePickerUse,
      siderBarSteps,
      currentStep,
      classActive,
      isShowFilter,
      handleShowFilter,
      optionsCheckBoxPurposeUse,
      optionsCheckBoxOderType,
      dataForm,
    };
  },
};
</script>

<style scoped></style>
