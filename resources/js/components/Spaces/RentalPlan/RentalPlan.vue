<template>
  <HeaderSpaces
    :title="$t('rental_plan_page.plan_creation')"
    :textHelp="$t('rental_plan_page.text_help')"
    :textLink="$t('spaces_image_page.preview_of_public_page')"
    :textHelpTop="$t('spaces_image_page.text_desc_1')"
    v-if="isAddScreen"
  />
  <div class="text-base" :class="!isAddScreen && 'mt-3'">
    {{ $t("rental_plan_page.reservation_plan_creation") }}
  </div>
  <div class="pr-4">
    <LayoutInput iconPrev="fa fa-check-circle-o mr-1" :labelText="$t('rental_plan_page.status')" customCss="mt-5">
      <div class="flex w-full">
        <div class="w-1/2 flex border border-solid border-[#ddd] rounded">
          <div class="flex items-center px-4 bg-[#eee] border-r border-solid border-[#ddd]">
            <input type="radio" v-model="formData.status" :value="TYPE_STATUS.ACTIVE" id="status_rental_plan_1" />
          </div>
          <label class="flex-1 p-2" for="status_rental_plan_1">
            <div>
              <i class="fa fa-check mr-1 text-[#3c763d]"></i>
              <span class="text-[#3c763d]">
                {{ $t("rental_plan_page.release") }}
              </span>
            </div>
            <div>{{ $t("rental_plan_page.help_text_11") }}</div>
          </label>
        </div>
        <div class="w-1/2 flex border border-solid border-[#ddd] rounded">
          <div class="flex items-center px-4 bg-[#eee] border-r border-solid border-[#ddd]">
            <input type="radio" v-model="formData.status" :value="TYPE_STATUS.ARCHIVED" id="status_rental_plan_2" />
          </div>
          <label class="flex-1 p-2" for="status_rental_plan_2">
            <div>
              <i class="fa fa-book mr-1 text-[#8a6d3b]"></i>
              <span class="text-[#8a6d3b]">
                {{ $t("rental_plan_page.private") }}
              </span>
            </div>
            <div>{{ $t("rental_plan_page.help_text_12") }}</div>
          </label>
        </div>
      </div>
    </LayoutInput>

    <LayoutInput
      :isRequired="true"
      iconPrev="fa fa-font"
      :labelText="$t('rental_plan_page.label_text_1')"
      customCss="mt-5"
    >
      <LayoutInputRentalPlan>
        <template v-slot:left>
          <img :src="JapanIcon" class="w-6 h-6 object-cover" alt="image" />
        </template>

        <template v-slot:right>
          <input
            type="text"
            class="w-full h-full px-2 focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 outline-none"
            v-model.trim="formData.plan_name"
            @change="handleTurnOffError"
          />
        </template>
      </LayoutInputRentalPlan>
      <div v-if="isShowError" class="mt: 8px text-[#d43f3a]">{{ $t("validation.required") }}</div>
      <span class="text-[#737373] mt-2 block">
        {{ $t("rental_plan_page.help_text_1") }}
      </span>
    </LayoutInput>

    <LayoutInput iconPrev="fa fa-picture-o mr-1" :labelText="$t('rental_plan_page.label_text_2')" customCss="mt-5">
      <div>{{ $t("rental_plan_page.label_text_2") }}</div>
      <input class="mt-2" type="file" name="" id="" />
    </LayoutInput>

    <LayoutInput :labelText="$t('rental_plan_page.label_text_3')" customCss="mt-5">
      <div class="flex w-full h-8">
        <div class="w-1/2" v-for="(item, index) in optionsBookingType" :key="index">
          <LayoutInputRentalPlan>
            <template v-slot:left>
              <input
                type="radio"
                v-model.lazy="formData.reservation_type"
                :id="`${item.value}-${index}`"
                :value="item.value"
              />
            </template>
            <template v-slot:right>
              <label class="leading-9 ml-2 block select-none" :for="`${item.value}-${index}`">
                {{ item.label }}
              </label>
            </template>
          </LayoutInputRentalPlan>
        </div>
      </div>
    </LayoutInput>

    <LayoutInput :labelText="$t('rental_plan_page.label_text_4')" icon="fa fa-question-circle ml-1" customCss="mt-5">
      <div class="flex">
        <div class="flex items-center h-[15px]" v-for="(item, index) in reservationApprovalList" :key="index">
          <input
            type="checkbox"
            v-model="formData.day_when_not_deny_request"
            :value="Number(item.value)"
            :id="`${item.value}-${index}`"
          />
          <label :for="`${item.value}-${index}`" class="ml-1 mr-3 select-none">
            {{ item.label }}
          </label>
        </div>
      </div>

      <span class="text-[#737373] mt-2 block">
        {{ $t("rental_plan_page.help_text_2") }}
      </span>
    </LayoutInput>

    <LayoutInput :labelText="$t('rental_plan_page.label_text_5')" iconPrev="fa fa-money mr-1" customCss="mt-5">
      <div v-for="(item, index) in paymentMethodList" :key="index" class="list-payment-methods">
        <LayoutInputRentalPlan>
          <template v-slot:left>
            <input
              type="checkbox"
              :disabled="item.hasOwnProperty('disabled') && item.disabled"
              v-model="formData[item.nameInput]"
              :id="`${item.value}-${index}`"
              :true-value="item.value"
              :false-value="null"
            />
          </template>
          <template v-slot:right>
            <div class="flex">
              <i v-if="item.icon" :class="`${item.icon} ml-2 leading-9`"></i>
              <label class="leading-9 block w-full select-none ml-2" :for="`${item.value}-${index}`">
                {{ item.label }}
              </label>
            </div>
          </template>
        </LayoutInputRentalPlan>
      </div>
    </LayoutInput>

    <LayoutInput
      v-if="isShowInfoBank"
      :labelText="$t('rental_plan_page.label_text_6')"
      iconPrev="fa fa-university mr-1"
      customCss="mt-5"
      :isRequired="false"
    >
      <select
        class="w-full h-9 border border-solid border-[#ddd] bg-white rounded focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 outline-none px-2"
        v-model="formData.bank_account_id"
      >
        <option value="">-- {{ $t("rental_plan_page.please_select_an_account") }} --</option>
        <option v-for="(item, index) in infoBankOfCompany" :key="index" :value="item.id">
          {{ `${item.bank_name}/${item.branch_name}/${item.account_number}` }}
        </option>
      </select>
      <span class="text-[#737373] mt-2 block">
        {{ $t("rental_plan_page.help_text_3") }}
      </span>
    </LayoutInput>

    <LayoutInput :labelText="$t('rental_plan_page.label_text_7')" iconPrev="fa fa-list mr-1" customCss="mt-5">
      <div class="" v-if="detailInterval.length">
        <ReservationSystem :detailInterval="detailInterval" :idPlan="idPlan ? idPlan : ''" :preview="true" />
      </div>
      <span class="text-[#8a6d3b]" v-if="!detailInterval.length">
        <i class="fa fa-lightbulb-o mr-1 text-[#8a6d3b]"></i>
        {{ $t("rental_plan_page.help_text_4") }}
      </span>
    </LayoutInput>

    <LayoutInput v-if="listOptionsFromApi.length" :labelText="$t('rental_plan_page.option_setting')" customCss="mt-5">
      <div>{{ $t("rental_plan_page.check_the_options") }}</div>

      <div class="flex flex-wrap">
        <div v-for="(item, index) in listOptionsFromApi" :key="index" class="w-1/2 mt-2">
          <LayoutInputRentalPlan>
            <template v-slot:left>
              <input
                type="checkbox"
                v-model="listReservationOption"
                :value="item.id"
                :id="`${item.description__ja}_${item.id}`"
              />
            </template>
            <template v-slot:right>
              <label
                class="px-2 w-full h-full leading-9 font-bold rounded block shadow-inner cursor-pointer select-none"
                :for="`${item.description__ja}_${item.id}`"
              >
                {{ item.name }}
              </label>
            </template>
          </LayoutInputRentalPlan>
        </div>
      </div>

      <button class="p-2 text-white bg-[#ffbd00] rounded mt-2">
        {{ $t("rental_plan_page.open_option_settings") }}
      </button>
    </LayoutInput>

    <LayoutInput
      :labelText="$t('rental_plan_page.label_text_8')"
      customCss="mt-5"
      iconPrev="fa fa-remove mr-1"
      icon="fa fa-question-circle ml-1"
    >
      <div class="flex w-full">
        <div class="w-1/6" v-for="(item, index) in cleaningTimeSettingOption" :key="index">
          <LayoutInputRentalPlan>
            <template v-slot:left>
              <input
                type="radio"
                v-model="formData.cleaning_duration_minutes"
                :id="`cleaning_duration_minutes_${index}`"
                :value="Number(item.value)"
              />
            </template>
            <template v-slot:right>
              <label class="ml-2 block leading-9" :for="`cleaning_duration_minutes_${index}`">
                {{ item.label }}
              </label>
            </template>
          </LayoutInputRentalPlan>
        </div>
      </div>
    </LayoutInput>

    <LayoutInput
      :isRequired="true"
      :labelText="$t('rental_plan_page.label_text_9')"
      customCss="mt-5"
      iconPrev="fa fa-download fa-rotate-270 mr-1"
      icon="fa fa-question-circle ml-1"
    >
      <div v-for="(item, index) in reservationDeadlineRequired" :key="index">
        <div class="flex mb-2">
          <div class="w-1/5">
            <i v-if="item.icon" :class="`${item.icon} mr-1`"></i>
            <span>{{ item.label }}</span>
          </div>
          <div class="flex-1">
            <div class="w-3/5 h-9 flex border border-solid border-[#ddd] rounded">
              <div class="w-1/4 h-full bg-[#eee] border-r border-solid border-[#ddd] flex items-center justify-center">
                {{ $t("rental_plan_page.reservation_application") }}
              </div>
              <div class="w-1/2 h-full">
                <input
                  type="number"
                  min="0"
                  v-model="formData[item.nameInput]"
                  class="focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 w-full h-full outline-none px-2"
                />
              </div>
              <div class="w-1/4 h-full border-l border-solid border-[#ddd]">
                <select v-model="formData[item.nameOption]" class="w-full h-full bg-white pl-2">
                  <option v-for="(item, index) in reservationDeadlineTypeOption" :key="index" :value="item.value">
                    {{ item.label }}
                  </option>
                </select>
              </div>
            </div>
            <div v-if="deadlineErrors[index].isErr" class="mt: 8px text-[#d43f3a]">{{ $t("validation.required") }}</div>
          </div>
        </div>
      </div>
      <input type="text" />
    </LayoutInput>

    <LayoutInput
      :labelText="$t('rental_plan_page.label_text_10')"
      customCss="mt-5"
      iconPrev="fa fa-check-square-o mr-1"
    >
      <div class="flex list-payment-methods">
        <div class="w-1/5">
          <i class="fa fa-cart-plus mr-1"></i>
          <span>{{ $t("rental_plan_page.multiple_slots") }}</span>
          <i class="fa fa-question-circle ml-1"></i>
        </div>
        <div class="flex-1">
          <LayoutInputRentalPlan>
            <template v-slot:left>
              <input
                type="checkbox"
                v-model="formData.reservation_setting_allowing_multi_booking"
                :true-value="BOOLEAN.YES"
                :false-value="BOOLEAN.NO"
                id="reservation_setting_allowing_multi_booking"
              />
            </template>
            <template v-slot:right>
              <label class="ml-2 block leading-9 select-none" for="reservation_setting_allowing_multi_booking">
                {{ $t("rental_plan_page.help_text_6") }}
              </label>
            </template>
          </LayoutInputRentalPlan>
        </div>
      </div>

      <div class="flex list-payment-methods">
        <div class="w-1/5">
          <i class="fa fa-link mr-1"></i>
          <span>{{ $t("rental_plan_page.help_text_7") }}</span>
          <i class="fa fa-question-circle ml-1"></i>
        </div>
        <div class="flex-1">
          <LayoutInputRentalPlan>
            <template v-slot:left>
              <input
                type="checkbox"
                v-model="formData.reservation_setting_requiring_contiguous"
                :true-value="BOOLEAN.YES"
                :false-value="BOOLEAN.NO"
                id="reservation_setting_requiring_contiguous"
              />
            </template>
            <template v-slot:right>
              <label class="ml-2 block leading-9 select-none" for="reservation_setting_requiring_contiguous">
                {{ $t("rental_plan_page.help_text_8") }}
              </label>
            </template>
          </LayoutInputRentalPlan>
        </div>
      </div>

      <div class="flex list-payment-methods">
        <div class="w-1/5">
          <i class="fa fa-puzzle-piece mr-1"></i>
          <span>{{ $t("rental_plan_page.help_text_9") }}</span>
          <i class="fa fa-question-circle ml-1"></i>
        </div>
        <div class="flex-1">
          <div class="w-[250px] h-9 flex border border-solid border-[#ddd] rounded">
            <input
              type="number"
              min="0"
              v-model="formData.reservation_setting_min_contiguous_duration_minutes"
              class="w-[210px] h-full px-2 focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 outline-none"
            />
            <div class="w-full h-full flex items-center justify-center bg-[#eee]">
              {{ $t("common.minutes") }}
            </div>
          </div>
        </div>
      </div>
    </LayoutInput>

    <LayoutInput
      :labelText="$t('rental_plan_page.label_text_11')"
      customCss="mt-5"
      iconPrev="fa fa-cart-arrow-down mr-1"
      icon="fa fa-question-circle ml-1"
    >
      <div v-for="(item, index) in formData.rental_plan_contiguous_use_discount_rules" :key="(item, index)">
        <div class="flex mb-2">
          <div class="w-1/5">
            <i class="fa fa-clock-o mr-1"></i>
            <span>{{ $t("rental_plan_page.total_time") }}</span>
          </div>
          <div class="flex-1 flex items-center">
            <div class="flex w-[42%] h-9 border border-solid border-[#ddd] rounded">
              <div class="px-2 h-full bg-[#eee] flex items-center justify-center">
                {{ $t("rental_plan_page.minimum") }}
              </div>
              <input
                type="number"
                min="0"
                class="flex-1 h-full px-2 focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 outline-none"
                v-model="item.total_minute_time_of_the_frame"
              />
              <div class="h-full bg-white">
                <select
                  v-model="item.total_minute_time_of_the_frame_type"
                  class="w-full h-full px-1 border-l-[1px] border-[#ddd]"
                >
                  <option v-for="(item, index) in timeOption" :key="index" :value="item.value">
                    {{ item.label }}
                  </option>
                </select>
              </div>
            </div>
            <div class="w-[16%] flex items-center justify-center">
              <i class="fa fa-level-down"></i>
              <span>{{ $t("rental_plan_page.discount_from_total_amount") }}</span>
            </div>
            <div class="w-[42%] flex h-9">
              <div class="w-[95%] flex border border-solid border-[#ddd] rounded">
                <div class="h-full px-3 flex items-center bg-[#eee]">
                  <i class="fa fa-minus"></i>
                </div>
                <div class="flex-1">
                  <input
                    type="number"
                    min="0"
                    class="px-2 h-full w-full focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 outline-none"
                    v-model="item.discount_from_total_amount"
                  />
                </div>
                <div class="h-full">
                  <select
                    v-model="item.discount_from_total_amount_type"
                    class="w-full h-full px-1 border-l-[1px] border-[#ddd]"
                  >
                    <option v-for="(item, index) in amountTypeOption" :key="index" :value="item.value">
                      {{ item.label }}
                    </option>
                  </select>
                </div>
              </div>
              <div class="flex-1">
                <div
                  @click="handleDeleteItemFieldDiscount(index)"
                  class="group ml-4 border-solid border border-[#d43f3a] rounded flex items-center justify-center h-full w-9 hover:bg-[#d43f3a]"
                >
                  <i class="fa fa-trash text-[#d43f3a] group-hover:text-white" data-reactid=".e.0.$2.6.0.0"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <button class="py-1 px-2 bg-[#ffbd00] rounded" @click="numberFieldDiscount++">
        <i class="fa fa-plus mr-1 text-white"></i>
        <span class="text-white">
          {{ $t("rental_plan_page.add_discount_conditions") }}
        </span>
      </button>
    </LayoutInput>

    <LayoutInput
      :labelText="$t('rental_plan_page.label_text_12')"
      customCss="mt-5"
      iconPrev="fa fa-level-down mr-1"
      icon="fa fa-question-circle ml-1"
    >
      <div class="flex items-center">
        <div class="" v-if="isDiscount">
          <i class="fa fa-check mr-1 text-[#3c763d]"></i>
          <span class="text-[#3c763d]">
            {{
              $t("rental_plan_page.has_discount", {
                discountDays: isDiscount.last_minute_book_discount_days_before_count,
                discountPercentage: isDiscount.last_minute_book_discount_percentage,
              })
            }}
          </span>
        </div>
        <div class="" v-else>
          <i class="fa fa-ban mr-1 text-[#a94442]"></i>
          <span class="text-[#a94442]">
            {{ $t("rental_plan_page.help_text_10") }}
          </span>
        </div>
        <button class="bg-white border border-solid border-[#ccc] rounded p-1" @click="goToSettingTrackingLink">
          <i class="fa fa-cog mr-1"></i>
          <span>{{ $t("rental_plan_page.change_settings") }}</span>
        </button>
      </div>
    </LayoutInput>

    <LayoutInput :labelText="$t('rental_plan_page.label_text_13')" customCss="mt-5">
      <div class="flex w-[130px] h-9 border border-solid border-[#ccc] rounded items-center">
        <input
          type="number"
          min="0"
          v-model="formData.commission_rate"
          class="focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 w-full h-full px-2 outline-none"
        />
        <span class="inline-block px-1">%</span>
      </div>
    </LayoutInput>
  </div>
  <ButtonNextStep v-if="isAddScreen" :nextPage="'予約枠作成'" @onBack="handleBack" @onNext="handleNext" />
  <button
    v-if="!isAddScreen"
    class="mx-auto mt-2 block p-2 rounded cursor-pointer text-white text-sm hover:translate-y-1 transition-all bg-[#ffbd00]"
    @click="handleSubmit"
  >
    {{ $t("common.keep") }}
  </button>
</template>

<script>
import HeaderSpaces from "@/components/HeaderSpaces";
import LayoutInput from "@/components/Layouts/LayoutInput.vue";
import JapanIcon from "@/assets/images/japan.png";
import ButtonNextStep from "@/components/Buttons/ButtonNextStep";
import ReservationSystem from "@/components/Spaces/ReservationSystem/ReservationSystem.vue";
import {
  STEP_CREATE_SPACE,
  MODULE_STORE,
  ROUTER_PATH,
  BOOLEAN,
  STEP_SPACE_CREATED,
  ACTIONS_TYPE,
  TYPE_STATUS,
} from "@/const";
import { useStore } from "vuex";
import { useRouter, useRoute } from "vue-router";
import { reactive, computed, ref, watch, inject } from "vue";
import { useI18n } from "vue-i18n";
import {
  getInfoBankCompany,
  postSpaceRentalPlan,
  getDetailSpaceRentalPlan,
  getDetailBookingSystemAdvanced,
  getDetailSpaceReservation,
  getDetainIntervalOfPlan,
  updatePlanOfSpace,
} from "@/api";
import {
  reservationApprovalList,
  paymentMethodList,
  optionsBookingType,
  cleaningTimeSettingOption,
  amountTypeOption,
  reservationDeadlineTypeOption,
  timeOption,
  optionUnitType,
} from "@/const/options";
import { handleBack as handleBackUtils } from "@/utils";

import LayoutInputRentalPlan from "./child/LayoutInputRentalPlan.vue";

export default {
  name: "RentalPlan",
  components: {
    HeaderSpaces,
    LayoutInput,
    LayoutInputRentalPlan,
    ButtonNextStep,
    ReservationSystem,
  },
  props: {
    isAddScreen: {
      type: Boolean,
      default: true,
    },
    preview: { type: Boolean, default: false },
    actionType: String,
  },
  setup(props) {
    const store = useStore();
    const router = useRouter();
    const toast = inject("$toast");
    const { t } = useI18n();
    const numberFieldDiscount = ref(0);
    const route = useRoute();
    const isShowError = ref(false);
    const idSpace = route.query.id || route.params.id;
    const idPlan =
      route.query.idPlan ||
      store.getters[`${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.GETTERS.GET_ID_PLAN}`];
    const infoBankOfCompany = ref([]);
    const listOptionsFromApi = ref([]);
    const detailInterval = ref([]);
    const isDiscount = ref(null);
    const listReservationOption = ref([]);
    const convertReservationOptions = computed(() => {
      if (!listReservationOption.value.length) {
        return [];
      }
      return listReservationOption.value.map((item, index) => ({
        reservation_option_id: item,
        order_number: index,
      }));
    });
    const reservationDeadlineOption = computed(() => {
      return [
        {
          label: "クレジットカード",
          value: "credit-card",
          icon: "fa fa-credit-card",
          isShowInReservationDeadline: formData.payment_method_creditCard,
          nameInput: "reservation_early_notice_minutes_creditCard",
          nameOption: "reservation_early_notice_minutes_creditCard_type",
          key: "payment_method_creditCard",
        },
        {
          label: "銀行振込",
          value: "bank-transfer",
          icon: "fa fa-university",
          isShowInReservationDeadline: formData.payment_method_bankTransfer,
          nameInput: "reservation_early_notice_minutes_bankTransfer",
          nameOption: "reservation_early_notice_minutes_bankTransfer_type",
          key: "payment_method_bankTransfer",
        },
        {
          label: "当日現金払い",
          value: "cash-on-site",
          icon: "fa fa-money",
          isShowInReservationDeadline: formData.payment_method_cashOnSite,
          nameInput: "reservation_early_notice_minutes_cashOnSite",
          nameOption: "reservation_early_notice_minutes_cashOnSite_type",
          key: "payment_method_cashOnSite",
        },
        {
          label: "Paid",
          value: "paid",
          icon: "",
          isShowInReservationDeadline: formData.payment_method_paid,
          nameInput: "reservation_early_notice_minutes_paid",
          nameOption: "reservation_early_notice_minutes_paid_type",
          key: "payment_method_method_paid",
        },
        {
          label: "お客様の支払い方法の選択",
          value: "choose-later-by-customer",
          icon: "",
          isShowInReservationDeadline: formData.payment_method_chooseLaterByCustomer,
          nameInput: "reservation_early_notice_minutes_chooseLaterByCustomer",
          nameOption: "reservation_early_notice_minutes_chooseLaterByCustomer_type",
          key: "payment_method_chooseLaterByCustomer",
        },
      ];
    });
    const reservationDeadlineRequired = computed(() =>
      reservationDeadlineOption.value.filter((item) => item.isShowInReservationDeadline)
    );
    const deadlineErrors = ref([
      {
        key: "reservation_early_notice_minutes_creditCard",
        isErr: false,
      },
    ]);
    // const deadlineErrors = ref([])
    const isShowInfoBank = computed(() => !!formData.payment_method_bankTransfer);
    const formData = reactive({
      plan_name: null,
      status: TYPE_STATUS.ACTIVE,
      reservation_type: optionsBookingType[1].value,
      day_when_not_deny_request: [],
      payment_method_creditCard: paymentMethodList[0].value,
      payment_method_bankTransfer: null,
      payment_method_cashOnSite: null,
      payment_method_paid: null,
      payment_method_chooseLaterByCustomer: null,
      bank_account_id: null,
      cleaning_duration_minutes: null,
      reservation_early_notice_minutes_creditCard: 5,
      reservation_early_notice_minutes_creditCard_type: 1,
      reservation_early_notice_minutes_bankTransfer: null,
      reservation_early_notice_minutes_bankTransfer_type: null,
      reservation_early_notice_minutes_cashOnSite: null,
      reservation_early_notice_minutes_cashOnSite_type: null,
      reservation_early_notice_minutes_chooseLaterByCustomer: null,
      reservation_early_notice_minutes_chooseLaterByCustomer_type: null,
      reservation_early_notice_minutes_paid: null,
      reservation_early_notice_minutes_paid_type: null,
      reservation_setting_allowing_multi_booking: BOOLEAN.NO,
      reservation_setting_requiring_contiguous: BOOLEAN.NO,
      reservation_setting_min_contiguous_duration_minutes: null,
      commission_rate: null,
      rental_plan_contiguous_use_discount_rules: [],
    });
    const mapData = (formData, data) => {
      formData.plan_name = data.rental_plan_name;
      formData.status = data.status;
      formData.reservation_type = data.reservation_type;
      formData.day_when_not_deny_request = data.day_when_not_deny_request;
      formData.payment_method_creditCard = data.payment_method_credit_card;
      formData.payment_method_bankTransfer = data.payment_method_bank_transfer;
      formData.payment_method_cashOnSite = data.payment_method_cash_on_site;
      formData.payment_method_paid = data.payment_method_paid;
      formData.payment_method_chooseLaterByCustomer = data.payment_method_choose_later_by_customer;
      formData.bank_account_id = data.bank_account_id;
      formData.cleaning_duration_minutes = data.cleaningDurationMinutes;
      formData.reservation_early_notice_minutes_creditCard = data.reservation_early_notice_minutes_credit_card;
      formData.reservation_early_notice_minutes_creditCard_type =
        data.reservation_early_notice_minutes_credit_card_type;
      formData.reservation_early_notice_minutes_bankTransfer = data.reservation_early_notice_minutes_bank_transfer;
      formData.reservation_early_notice_minutes_bankTransfer_type =
        data.reservation_early_notice_minutes_bank_transfer_type;
      formData.reservation_early_notice_minutes_cashOnSite = data.reservation_early_notice_minutes_cash_on_site;
      formData.reservation_early_notice_minutes_cashOnSite_type =
        data.reservation_early_notice_minutes_cash_on_site_type;
      formData.reservation_early_notice_minutes_chooseLaterByCustomer =
        data.reservation_early_notice_minutes_choose_later_by_customer;
      formData.reservation_early_notice_minutes_chooseLaterByCustomer_type =
        data.reservation_early_notice_minutes_choose_later_by_customer_type;
      formData.reservation_early_notice_minutes_paid = data.reservation_early_notice_minutes_paid;
      formData.reservation_early_notice_minutes_paid_type = data.reservation_early_notice_minutes_paid_type;
      formData.reservation_setting_allowing_multi_booking = data.reservation_setting_allowing_multi_booking;
      formData.reservation_setting_requiring_contiguous = data.reservation_setting_requiring_contiguous;
      formData.reservation_setting_min_contiguous_duration_minutes =
        data.reservation_setting_min_contiguous_duration_minutes;
      formData.commission_rate = data.commission_rate;
      formData.rental_plan_contiguous_use_discount_rules = data.rental_plan_contiguous_use_discount_rule;
    };
    watch(
      formData,
      (val) => {
        deadlineErrors.value = reservationDeadlineOption.value
          .filter((item) => item.isShowInReservationDeadline)
          .map((reservationType) => {
            return {
              key: reservationType.nameInput,
              isErr: false,
            };
          });
      },
      { deep: true }
    );
    const params = computed(() => ({
      ...formData,
      reservation_setting_allowing_multi_booking: Number(formData.reservation_setting_allowing_multi_booking),
      reservation_setting_requiring_contiguous: Number(formData.reservation_setting_requiring_contiguous),
      reservation_setting_min_contiguous_duration_minutes: Number(
        formData.reservation_setting_min_contiguous_duration_minutes
      ),
      reservation_options: convertReservationOptions.value,
    }));
    const handleDeleteItemFieldDiscount = (index) => {
      formData.rental_plan_contiguous_use_discount_rules.splice(index, 1);
    };
    const validateReservationDeadline = () => {
      reservationDeadlineRequired.value.forEach((item) => {
        const key = item.nameInput;
        const errIdx = deadlineErrors.value.findIndex((item) => item.key == key);
        if (!formData[key]) {
          deadlineErrors.value[errIdx].isErr = true;
        } else {
          deadlineErrors.value[errIdx].isErr = false;
        }
      });
    };
    const isPassValidate = computed(() => !deadlineErrors.value.some((item) => item.isErr));
    const handleNext = async () => {
      validateReservationDeadline();
      if (!isPassValidate.value) return;
      if (formData.plan_name) {
        try {
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
          if (idPlan) {
            await updatePlanOfSpace(idPlan, params.value);
            handleBackUtils();
          } else {
            await postSpaceRentalPlan(params.value, idSpace);
            store.commit(
              `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.MUTATIONS.SET_STEP_SPACE_CREATED}`,
              STEP_SPACE_CREATED["plan-create-reservation-frame"]
            );
          }
          router.push(`${ROUTER_PATH.SPACE.LIST_PLAN_INTERVAL}?id=${idSpace}`);
        } catch (errors) {
          const error = errors.message || t("common.has_error");
          toast.error(error);
        } finally {
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
        }
      } else {
        isShowError.value = true;
      }
    };
    const handleTurnOffError = () => {
      if (formData.plan_name) {
        return (isShowError.value = false);
      }
    };
    watch(
      formData.plan_name !== "",
      () => {
        isShowError.value = false;
      },
      {
        immediate: true,
      }
    );
    const handleSubmit = async () => {
      const idSpaceFromEdit = route.params.id;
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        if (props.actionType === ACTIONS_TYPE.UPDATE) {
          await updatePlanOfSpace(idPlan, params.value);
          handleBackUtils();
        } else {
          await postSpaceRentalPlan(params.value, idSpaceFromEdit);
          router.push(
            `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}/${ROUTER_PATH.RENTAL_PLAN}/${ROUTER_PATH.SPACE.RESERVATION_SYSTEM}/${idSpaceFromEdit}`
          );
        }
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };

    const handleBack = () => {
      router.push(`${ROUTER_PATH.SPACE.RESERVATION_OPTIONS}?id=${idSpace}`);
    };
    watch(numberFieldDiscount, () => {
      formData.rental_plan_contiguous_use_discount_rules = [
        ...formData.rental_plan_contiguous_use_discount_rules,
        {
          total_minute_time_of_the_frame: null,
          discount_from_total_amount: null,
          total_minute_time_of_the_frame_type: null,
          discount_from_total_amount_type: null,
        },
      ];
    });

    const getInfoBankCompanyFromApi = async () => {
      try {
        const res = await getInfoBankCompany();
        infoBankOfCompany.value = [...res];
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      }
    };
    const getDetailRentalPlan = async () => {
      if (idPlan) {
        try {
          const res = await getDetailSpaceRentalPlan(idSpace, idPlan);
          if (res) {
            mapData(formData, res);
            if (res?.reservation_options.length) {
              res.reservation_options.forEach((item) => {
                listReservationOption.value.push(item.reservation_option_type_id);
              });
            }
          }
        } catch (errors) {
          const error = errors.message || t("common.has_error");
          toast.error(error);
        }
      }
    };
    const getDetailBookingSystemAdvancedFromApi = async () => {
      try {
        const res = await getDetailBookingSystemAdvanced(idSpace);
        if (res.data.enable_last_minute_discount && res.data.enable_last_minute_discount == BOOLEAN.YES) {
          isDiscount.value = res.data;
        } else {
          isDiscount.value = null;
        }
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      }
    };
    const getDetainIntervalOfPlanFromApi = async () => {
      if (!idPlan) return;
      try {
        const res = await getDetainIntervalOfPlan(idSpace, idPlan);
        if (res.data.length > 0) {
          detailInterval.value = res.data;
        }
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      }
    };
    const convertDataName = (item) => {
      const typeUnit = optionUnitType.find((itemUnitType) => itemUnitType.value == item.unitType).label;
      return `${item.title__ja}:${item.price}円 / ${typeUnit}`;
    };
    const getDetailSpaceReservationFromApi = async () => {
      try {
        const res = await getDetailSpaceReservation(idSpace);
        if (res.data?.reservationOptionTypes.length) {
          const listReservationPublic = res.data?.reservationOptionTypes.filter((item) => item.active === BOOLEAN.YES);
          listOptionsFromApi.value = listReservationPublic.map((item) => ({
            ...item,
            name: convertDataName(item),
          }));
        }
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      }
    };
    const goToSettingTrackingLink = () => {
      router.push({
        path: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}/${ROUTER_PATH.SPACE.TRACKING_LINK}/${idSpace}`,
      });
    };
    const initData = async () => {
      store.dispatch(
        `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.ACTIONS.SET_ACTIVE}`,
        STEP_CREATE_SPACE.PLAN_CREATION
      );
      store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
      await Promise.all([
        getInfoBankCompanyFromApi(),
        getDetailRentalPlan(),
        getDetailBookingSystemAdvancedFromApi(),
        getDetailSpaceReservationFromApi(),
        getDetainIntervalOfPlanFromApi(),
      ]);
      store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
    };

    initData();

    return {
      goToSettingTrackingLink,
      handleBack,
      JapanIcon,
      reservationApprovalList,
      paymentMethodList,
      formData,
      optionsBookingType,
      cleaningTimeSettingOption,
      reservationDeadlineOption,
      isShowInfoBank,
      numberFieldDiscount,
      timeOption,
      reservationDeadlineTypeOption,
      amountTypeOption,
      infoBankOfCompany,
      handleNext,
      handleSubmit,
      BOOLEAN,
      isDiscount,
      listOptionsFromApi,
      detailInterval,
      idPlan,
      idSpace,
      listReservationOption,
      TYPE_STATUS,
      handleDeleteItemFieldDiscount,
      isShowError,
      handleTurnOffError,
      reservationDeadlineRequired,
      deadlineErrors,
      isPassValidate,
    };
  },
};
</script>

<style scoped>
.list-payment-methods + .list-payment-methods {
  margin-top: 8px;
}
</style>
