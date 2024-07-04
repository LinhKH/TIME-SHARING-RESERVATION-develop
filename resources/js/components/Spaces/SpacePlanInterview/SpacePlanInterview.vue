<template>
  <HeaderSpaces
    :title="$t('rental_interval_modal.title_header')"
    :textHelp="$t('rental_interval_modal.text_bottom_header')"
    :textLink="$t('spaces_image_page.preview_of_public_page')"
    :textHelpTop="$t('spaces_image_page.text_desc_1')"
    v-if="!isUpdateInterval && typeScreen === TYPE_SCREEN.SPACE_ADDING"
  />
  <div class="px-2 w-full mt-5">
    <div class="flex justify-between">
      <div class="">
        <div v-if="isUpdateInterval" class="text-[18px]">{{ $t("rental_interval_modal.edit_a_reservation") }}</div>
        <div v-if="!isUpdateInterval" class="text-[18px]">{{ $t("rental_interval_modal.create_a_reservation") }}</div>
      </div>
      <div class="" v-if="!isUpdateInterval && typeScreen === TYPE_SCREEN.SPACE_ADDING">
        <ButtonCommon
          icon="fa fa-pencil"
          :text="$t('reservation_system.edit_plan')"
          class="px-2 py-1.5 hover:bg-[#eee]"
          @click="handleEditPlan"
        />
      </div>
    </div>

    <button
      v-if="isUpdateInterval"
      @click="handleGotoEditPlan"
      class="border border-solid border-[#ccc] py-1 px-2 rounded block ml-auto"
    >
      <i class="fa fa-pencil mr-1" aria-hidden="true"></i>
      <span>{{ $t("rental_interval_modal.edit_plan") }}</span>
    </button>
    <LayoutInput
      v-if="isUpdateInterval"
      :labelText="$t('rental_interval_modal.status')"
      customCss="mt-5"
      iconPrev="fa fa-check-circle-o mr-1"
    >
      <div class="flex">
        <div class="w-1/2">
          <FormRentalInterVal customCss="h-auto">
            <template v-slot:left>
              <input type="radio" v-model="formData.status" :value="TYPE_STATUS.ACTIVE" id="holiday_type_active" />
            </template>
            <template v-slot:right>
              <label class="p-2 cursor-pointer block" for="holiday_type_active">
                <div class="mb-1">
                  <i class="fa fa-check text-[#3c763d]"></i>
                  <span class="font-bold text-[#3c763d]">{{ $t("rental_plan_page.release") }}</span>
                </div>
                <div class="text-[#737373]">{{ $t("rental_interval_modal.reservation_possible") }}</div>
              </label>
            </template>
          </FormRentalInterVal>
        </div>
        <div class="w-1/2">
          <FormRentalInterVal customCss="h-auto">
            <template v-slot:left>
              <input type="radio" v-model="formData.status" :value="TYPE_STATUS.ARCHIVED" id="holiday_type_archived" />
            </template>
            <template v-slot:right>
              <label class="p-2 cursor-pointer block" for="holiday_type_archived">
                <div class="mb-1">
                  <i class="fa fa-book text-[#8a6d3b]"></i>
                  <span class="font-bold text-[#8a6d3b]">{{ $t("rental_plan_page.private") }}</span>
                </div>
                <div class="text-[#737373]">{{ $t("rental_interval_modal.required") }}</div>
              </label>
            </template>
          </FormRentalInterVal>
        </div>
      </div>
    </LayoutInput>
    <LayoutInput v-if="!isUpdateInterval" :labelText="$t('rental_interval_modal.plan_name')" customCss="mt-5">
      <span class="text-[#337ab7]">
        {{ namePlan }}
      </span>
    </LayoutInput>
    <LayoutInput
      :isRequired="!isUpdateInterval ? true : false"
      :labelText="$t('rental_interval_modal.week_setting')"
      customCss="mt-5"
    >
      <div class="flex">
        <div class="flex justify-center mr-3">
          <input
            type="checkbox"
            class="mr-[2px]"
            :value="optionSettingDateFull.value"
            :id="optionSettingDateFull.value"
            v-model.lazy="formData.applicability_periods"
          />
          <label :for="optionSettingDateFull.value" class="cursor-pointer">{{ optionSettingDateFull.label }}</label>
        </div>
        <div v-for="(item, index) in optionSettingDate" :key="index" class="flex justify-center mr-3">
          <input
            type="checkbox"
            class="mr-[2px]"
            :value="item.value"
            :id="item.value"
            v-model.lazy="formData.applicability_periods"
          />
          <label :for="item.value" class="cursor-pointer">{{ item.label }}</label>
        </div>
      </div>
      <MessagesForm v-if="error.applicability_periods" :messages="error.applicability_periods" />
    </LayoutInput>
    <LayoutInput
      :isRequired="!isUpdateInterval ? true : false"
      :labelText="$t('rental_interval_modal.holiday_setting')"
      customCss="mt-5"
      icon="fa fa-question-circle ml-1"
    >
      <div class="w-3/5 xl:w-3/5 md:w-full">
        <div class="mb-2" v-for="(item, index) in optionHolidayType" :key="index">
          <FormRentalInterVal>
            <template v-slot:left>
              <input
                type="radio"
                v-model.lazy="formData.holiday_applicability_type"
                :value="item.value"
                :id="`holiday_type_${index}`"
              />
            </template>
            <template v-slot:right>
              <div class="w-full h-full flex justify-between">
                <label
                  :for="`holiday_type_${index}`"
                  class="block h-full select-none cursor-pointer font-bold p-[10px] flex-1"
                  v-html="item.label"
                />
                <div class="h-full p-[10px]">
                  <i :class="item.icon"></i>
                </div>
              </div>
            </template>
          </FormRentalInterVal>
        </div>
        <div class="text-[#337ab7] mt-2 cursor-pointer" @click="isShowModal = true">
          {{ $t("rental_interval_modal.text_help_2") }}
        </div>
      </div>
      <MessagesForm v-if="error.holiday_applicability_type" :messages="error.holiday_applicability_type" />
    </LayoutInput>
    <LayoutInput
      :isRequired="!isShowFormInterval"
      :labelText="$t('rental_interval_modal.label_text_1')"
      customCss="mt-5"
      iconPrev="fa fa-clock-o mr-1"
      v-if="!isShowFormInterval"
    >
      <div class="flex justify-between w-3/5">
        <div class="flex p-3 rounded bg-[#a9a9a9] box-shadow" v-for="(item, index) in optionIntervalMulti" :key="index">
          <input
            type="radio"
            :value="item.value"
            v-model.lazy="formData.interval_multi"
            :id="`interval_multi_${index}`"
            class="mr-1"
            :disabled="isUpdateInterval ? true : false"
          />
          <label :for="`interval_multi_${index}`" class="text-white cursor-pointer">{{ item.label }}</label>
        </div>
      </div>
      <MessagesForm v-if="error.interval_multi" :messages="error.interval_multi" />

      <div class="flex mt-2">
        <div class="w-1/4 h-9 flex mr-4 border border-solid border-[#ddd] rounded">
          <div class="w-[80px] bg-[#eee] h-full border-r flex items-center justify-center">
            {{ $t("rental_interval_modal.start_time") }}
          </div>
          <div class="flex-1 h-full">
            <input
              type="text"
              class="w-full h-full focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 outline-none px-2 rounded-tr rounded-br"
              :placeholder="$t('rental_interval_modal.start_time')"
              v-model.lazy="formData.start_time_formatted"
              :disabled="isUpdateInterval ? true : false"
            />
          </div>
        </div>
        <div class="w-1/4 h-9 flex border border-solid border-[#ddd] rounded">
          <div class="w-[80px] bg-[#eee] h-full border-r flex items-center justify-center">
            {{ $t("rental_interval_modal.ending_time") }}
          </div>
          <div class="flex-1 h-full">
            <input
              type="text"
              class="w-full h-full focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 outline-none px-2 rounded-tr rounded-br"
              :placeholder="$t('rental_interval_modal.ending_time')"
              v-model.lazy="formData.end_time_formatted"
              :disabled="isUpdateInterval ? true : false"
            />
          </div>
        </div>
      </div>
      <MessagesForm v-if="error.time_setting" :messages="error.time_setting" />
      <div class="mt-2 text-[red]">
        {{ $t("rental_interval_modal.text_help_3") }}
        <br />
        {{ $t("rental_interval_modal.text_help_4") }}
      </div>
    </LayoutInput>
    <LayoutInput :labelText="$t('rental_interval_modal.price_setting')" customCss="mt-5" iconPrev="fa fa-yen mr-1">
      <LayoutInput
        :labelText="$t('rental_interval_modal.placeholder_3')"
        iconPrev="fa fa-yen mr-1"
        icon="fa fa-question-circle ml-1"
      >
        <div class="flex items-center">
          <div class="w-[320px] h-9 border border-solid border-[#ddd] rounded flex">
            <div class="flex-1 h-full">
              <input
                type="number"
                min="0"
                v-model="formData.tenancy_price"
                class="w-full h-full focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 outline-none px-2 rounded-tl rounded-bl"
              />
            </div>
            <div class="bg-[#eee] h-full flex items-center px-2 border-l border-solid border-[#ddd]">
              {{ $t("rental_interval_modal.excluding_tax") }}
            </div>
          </div>
          <div class="ml-2">
            {{ tenancyPriceIncludeTax + $t("rental_interval_modal.tax_included") }}
          </div>
        </div>
      </LayoutInput>
      <LayoutInput
        :labelText="$t('rental_interval_modal.price_per_person')"
        iconPrev="fa fa-yen mr-1"
        icon="fa fa-question-circle ml-1"
      >
        <div class="flex items-center">
          <div class="w-[320px] h-9 border border-solid border-[#ddd] rounded flex">
            <div class="flex-1 h-full">
              <input
                type="number"
                min="0"
                class="w-full h-full focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 outline-none px-2 rounded-tl rounded-bl"
                v-model="formData.per_person_price"
              />
            </div>
            <div class="bg-[#eee] h-full flex items-center px-2 border-l border-solid border-[#ddd]">
              {{ $t("rental_interval_modal.type_tax") }}
            </div>
          </div>
          <div class="ml-2">
            {{ perPersonPriceIncludeTax + $t("rental_interval_modal.type_tax_1") }}
          </div>
        </div>
      </LayoutInput>
    </LayoutInput>
    <LayoutInput
      :labelText="$t('rental_interval_modal.upper_limit_setting')"
      customCss="mt-5"
      iconPrev="fa fa-users mr-1"
    >
      <LayoutInput
        :labelText="$t('rental_interval_modal.maximum_number')"
        :isRequired="!isUpdateInterval ? true : false"
        iconPrev="fa fa-files-o mr-1"
      >
        <input
          type="number"
          min="0"
          class="w-[168px] h-9 focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 outline-none px-2 rounded border border-solid border-[#ddd]"
          v-model="formData.max_simultaneous_reservations"
        />
        <div class="my-2 text-[red]">
          {{ $t("rental_interval_modal.text_help_5") }}
        </div>
        <div>
          {{ $t("rental_interval_modal.text_help_6") }}
        </div>
        <div>
          {{ $t("rental_interval_modal.text_help_7") }}
        </div>
        <div>
          {{ $t("rental_interval_modal.text_help_8") }}
        </div>
        <div>
          {{ $t("rental_interval_modal.text_help_9") }}
        </div>
      </LayoutInput>
      <LayoutInput
        :labelText="$t('rental_interval_modal.maximum_capacity')"
        iconPrev="fa fa-users mr-1"
        icon="fa fa-question-circle ml-1"
      >
        <input
          type="number"
          min="0"
          class="w-[168px] h-9 focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 outline-none px-2 rounded border border-solid border-[#ddd]"
          v-model="formData.max_simultaneous_people"
        />
      </LayoutInput>
      <div class="text-center mt-2" @click="handlePostSpaceRentalPlanInterval" v-if="!idInterval">
        <button class="p-2 bg-[#ffbd00] text-white rounded mx-auto block" @click="handleUpdateInterval">
          {{ $t("common.keep") }}
        </button>
      </div>
      <div class="w-full mt-2 flex flex-wrap justify-center" v-else>
        <button
          class="py-2 px-3 text-white block rounded bg-[#7EA6E0] font-bold hover:bg-[#e6e6e6] border border-solid hover:text-black hover:border-[#ccc] mr-5"
          @click="handleUpdateInterval"
        >
          {{ $t("rental_interval_modal.change_overwrite") }}
        </button>
        <button
          class="p-2 rounded border border-solid border-[#d43f3a] text-[#d43f3a] hover:text-white hover:bg-[#d43f3a]"
          @click="handleDeleteInterval"
          v-if="showDelete"
        >
          {{ $t("common.delete_all") }}
        </button>
        <div class="text-center text-[#a94442] mt-1 w-[100%]" v-else>
          {{ $t("rental_interval_modal.currently") }}
        </div>
      </div>
    </LayoutInput>
    <LayoutModal :isShowModal="isShowModal" @onClose="isShowModal = false" customCss="top-1/4">
      <HolidayModal @close:modal="isShowModal = false" />
    </LayoutModal>
  </div>
</template>

<script>
import LayoutInput from "@/components/Layouts/LayoutInput.vue";
import LayoutModal from "@/components/Layouts/LayoutModal.vue";
import HolidayModal from "./child/HolidayModal.vue";
import HeaderSpaces from "@/components/HeaderSpaces";
import ButtonCommon from "@/components/Buttons/ButtonCommon";
import FormRentalInterVal from "./child/FormRentalInterVal.vue";
import { inject, reactive, watch, ref, computed } from "vue";
import {
  postSpaceRentalPlanInterval,
  getDetailInterval,
  updateInterval,
  getDetailSpaceRentalPlan,
  deleteInterval,
  checkUsedSpace,
} from "@/api";
import { MODULE_STORE, STEP_CREATE_SPACE, TYPE_SCREEN, STEP_EDIT_SPACE, TYPE_STATUS, ROUTER_PATH } from "@/const";
import { useStore } from "vuex";
import { optionSettingDate, optionHolidayType, optionIntervalMulti, optionSettingDateFull } from "@/const/options";
import { useI18n } from "vue-i18n";
import { useRoute, useRouter } from "vue-router";
import MessagesForm from "@/components/MessagesForm";
import { handleBack, isRequired } from "@/utils";
import { TAX_RATIO } from "@/const";

export default {
  name: "SpacePlanInterview",
  components: {
    LayoutInput,
    FormRentalInterVal,
    MessagesForm,
    HeaderSpaces,
    ButtonCommon,
    LayoutModal,
    HolidayModal,
  },
  props: {
    typeScreen: String,
    isUpdateInterval: { type: Boolean, default: false },
    idPlan: [String, Number],
    listIntervalId: Array,
    isShowFormInterval: {
      type: Boolean,
      default: () => false,
    },
  },
  emits: ["updateInterval"],
  setup(props, context) {
    const { t } = useI18n();
    const store = useStore();
    const toast = inject("$toast");
    const route = useRoute();
    const router = useRouter();
    const idSpace = route.params.id || route.query.id;
    const _idPlan = route.query.idPlan || props.idPlan;
    const idInterval = route.query.idInterval;
    const namePlan = ref(
      store.getters[`${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.GETTERS.GET_NAME_PLAN_CURRENT}`]
    );
    const initialState = {
      applicability_periods: [],
      holiday_applicability_type: null,
      interval_multi: null,
      start_time_formatted: null,
      end_time_formatted: null,
      tenancy_price: null,
      per_person_price: null,
      max_simultaneous_reservations: 1,
      status: null,
      max_simultaneous_people: null,
    };
    const formData = reactive({ ...initialState });
    const tenancyPriceIncludeTax = computed(() =>
      formData.tenancy_price ? (formData.tenancy_price * (1 + TAX_RATIO)).toFixed(2) : ""
    );
    const perPersonPriceIncludeTax = computed(() =>
      formData.per_person_price ? (formData.per_person_price * (1 + TAX_RATIO)).toFixed(2) : ""
    );
    const showDelete = ref(false);
    const isShowModal = ref(false);
    const error = reactive({
      start_time_formatted: "",
      interval_multi: "",
      holiday_applicability_type: "",
      applicability_periods: "",
    });
    const checkUsedSpaceMth = async () => {
      const res = await checkUsedSpace(idSpace);
      if (!res || !res.data) {
        showDelete.value = true;
      }
    };
    checkUsedSpaceMth();
    const handleValidateTime = (key, value) => {
      error[key] = t("validation.date_time");
      if (!value || !value.includes(":")) {
        return;
      }
      if (value.split(":").length > 2 || value.split(":")[0].length > 2 || value.split(":")[1].length > 2) {
        return;
      }
      const hour = Number(value.split(":")[0]);
      const minute = Number(value.split(":")[1]);
      if (
        hour == NaN ||
        minute == NaN ||
        (hour != NaN && hour > 24) ||
        (minute != NaN && minute >= 60) ||
        !Number.isInteger(hour) ||
        !Number.isInteger(minute)
      ) {
        return;
      }
      error[key] = "";
    };
    const validateSelectionInput = () => {
      const fields = [
        {
          value: "applicability_periods",
          type: "checkbox",
        },
        {
          value: "holiday_applicability_type",
          type: "radio",
        },
      ];

      fields.forEach((field) => {
        const key = field.value;
        let failCase;

        if (field.type == "checkbox") {
          failCase = formData[key].length == 0;
        }
        if (field.type == "radio") {
          failCase = !formData[key];
        }

        if (failCase) {
          error[key] = `必須項目です。 `;
        } else {
          error[key] = "";
        }
      });
    };
    watch(formData, () => {
      if (
        formData.applicability_periods.length > 1 &&
        formData.applicability_periods[0] == optionSettingDateFull.value
      ) {
        formData.applicability_periods.splice(0, 1);
        return;
      }
      if (
        formData.applicability_periods[formData.applicability_periods.length - 1] == optionSettingDateFull.value &&
        formData.applicability_periods.length > 1
      ) {
        formData.applicability_periods = [optionSettingDateFull.value];
      }
    });
    const isPassValidate = computed(() => !Object.values(error).some((item) => item));
    const handlePostSpaceRentalPlanInterval = async () => {
      validateSelectionInput();
      handleValidateTime("time_setting", formData.start_time_formatted);
      handleValidateTime("time_setting", formData.end_time_formatted);
      isRequired({ interval_multi: formData.interval_multi }, error);
      if (!isPassValidate.value) return;
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        await postSpaceRentalPlanInterval({ ...formData }, idSpace, _idPlan);
        Object.assign(formData, initialState);
        handleBack();
      } catch (errors) {
        const error = errors[0]?.title || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    const handleUpdateInterval = async () => {
      if (props.isUpdateInterval && idInterval) {
        const params = {
          ids: props.listIntervalId?.length ? props.listIntervalId : [idInterval],
          status: formData.status,
          applicability_periods: [...formData.applicability_periods],
          holiday_applicability_type: formData.holiday_applicability_type,
          tenancy_price: formData.tenancy_price,
          per_person_price: formData.per_person_price,
          max_simultaneous_reservations: formData.max_simultaneous_reservations,
          max_simultaneous_people: formData.max_simultaneous_people,
        };
        try {
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
          await updateInterval(params);
          if (props.typeScreen === TYPE_SCREEN.SPACE_ADDING) {
            router.push(
              `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}/${ROUTER_PATH.ADD}/${ROUTER_PATH.SPACE.LIST_PLAN_INTERVAL}?id=${idSpace}`
            );
          } else {
            handleBack();
          }
        } catch (errors) {
          const error = errors.message || t("common.has_error");
          toast.error(error);
        } finally {
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
        }
        return;
      }
      context.emit("updateInterval", { ...formData });
    };
    const getDetailIntervalFromApi = async (idInterval) => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const res = await getDetailInterval(idInterval);
        formData.applicability_periods = res.data.applicability_periods;
        formData.holiday_applicability_type = res.data.holiday_applicability_type;
        formData.tenancy_price = res.data.tenancy_price;
        formData.per_person_price = res.data.per_person_price;
        formData.max_simultaneous_reservations = res.data.max_simultaneous_reservations;
        formData.max_simultaneous_people = res.data.max_simultaneous_people;
        formData.start_time_formatted = res.data.start_time_formatted;
        formData.end_time_formatted = res.data.end_time_formatted;
        formData.status = res.data.status;
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    const handleDeleteInterval = async () => {
      try {
        if (idInterval) {
          await deleteInterval(idSpace, _idPlan, idInterval);
          toast.success(t("toast_message.delete_success"));
          handleBack();
        } else if (props.listIntervalId.length) {
          for (let i = 0; i < props.listIntervalId.length; i++) {
            await deleteInterval(idSpace, _idPlan, props.listIntervalId[i]);
          }
          toast.success(t("toast_message.delete_success"));
        }
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    const initData = async () => {
      if (!namePlan.value) {
        try {
          const res = await getDetailSpaceRentalPlan(idSpace, _idPlan);
          namePlan.value = res.rental_plan_name;
        } catch (errors) {
          const error = errors.message || t("common.has_error");
          toast.error(error);
        } finally {
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
        }
      }
      if (idInterval) getDetailIntervalFromApi(idInterval);
      if (props.typeScreen === TYPE_SCREEN.SPACE_ADDING) {
        store.dispatch(
          `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.ACTIONS.SET_ACTIVE}`,
          STEP_CREATE_SPACE.PLAN_CREATE_RESERVATION_FRAME
        );
      }
      if (props.typeScreen === TYPE_SCREEN.SPACE_EDITING) {
        store.dispatch(
          `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.ACTIONS.SET_ACTIVE_EDIT}`,
          STEP_EDIT_SPACE.RESERVATION_SYSTEM
        );
      }
    };
    const handleEditPlan = () =>
      router.push(
        `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}/${ROUTER_PATH.ADD}/${ROUTER_PATH.RENTAL_PLAN}?id=${idSpace}&idPlan=${_idPlan}`
      );
    const handleGotoEditPlan = () =>
      router.push(
        `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}/${ROUTER_PATH.EDIT}/${ROUTER_PATH.SPACE.PLAN_EDIT}/${idSpace}?idPlan=${_idPlan}`
      );
    initData();
    return {
      optionSettingDate,
      handleEditPlan,
      optionIntervalMulti,
      formData,
      optionHolidayType,
      handlePostSpaceRentalPlanInterval,
      optionSettingDateFull,
      handleUpdateInterval,
      TYPE_STATUS,
      namePlan,
      error,
      handleGotoEditPlan,
      TYPE_SCREEN,
      handleDeleteInterval,
      tenancyPriceIncludeTax,
      perPersonPriceIncludeTax,
      _idPlan,
      showDelete,
      idInterval,
      isShowModal,
    };
  },
};
</script>
