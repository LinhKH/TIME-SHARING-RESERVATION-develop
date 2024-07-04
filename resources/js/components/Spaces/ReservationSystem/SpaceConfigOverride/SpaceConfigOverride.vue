<template>
  <div v-if="!isUpdateCalendar">
    <div class="text-base mt-2">{{ $t("space_config_override.special_day_setting") }}</div>
    <div class="my-1">{{ $t("space_config_override.you_can_change") }}</div>
    <select v-model="idPlanCurrent" class="bg-white border border-solid border-black rounded outline-none p-1">
      <option v-for="(item, index) in listPlanFromApi" :key="index" :value="item.id">
        {{ item.plan_name }}
      </option>
    </select>
    <div class="flex flex-wrap mt-2">
      <ButtonNote
        v-for="(item, index) in Object.values(optionNotes)"
        :key="index"
        :text="item.text"
        :backGroundColor="item.backGround"
      />
    </div>
    <div class="w-full flex">
      <div
        class="ml-auto text-[#ddb849] text-base mr-2 font-bold hover:underline cursor-pointer select-none"
        @click="handleNextMonth"
      >
        {{ nextMonth }} →
      </div>
    </div>
    <div class="text-center text-lg">{{ year }}/{{ month }}</div>

    <div class="w-full">
      <button
        class="block ml-auto px-2 py-1 border border-solid border-[#ddd] rounded bg-white hover:bg-[#eee]"
        @click="selectAllTimeInMonth()"
      >
        {{ $t("space_config_override.all_hours_of_the_month") }}
      </button>
    </div>
    <div class="flex border-r border-solid border-[#ddd]">
      <div
        v-for="(item, index) in dayOfWeek"
        :key="index"
        class="w-[calc(100%/7)] flex items-center p-2 border-t border-l border-solid border-[#ddd] font-bold"
      >
        {{ item }}
      </div>
    </div>

    <div class="flex flex-wrap border-b border-r border-solid border-[#ddd]">
      <div
        v-for="(item, index) in arrayDays"
        :key="index"
        class="w-[calc(100%/7)] flex items-center p-2 border-t border-l border-solid border-[#ddd]"
      >
        <div v-if="item" class="w-full">
          <div class="font-bold text-[18px]">{{ item }}</div>
          <template v-if="listIntervalFromApi[item - 1]?.interval.length">
            <div class="my-2 flex items-center">
              <input
                type="checkbox"
                :id="listIntervalFromApi[item - 1].date"
                @click="(event) => handleCheckAll(listIntervalFromApi[item - 1], event)"
                :checked="
                  formDateSelected[listIntervalFromApi[item - 1].date].length &&
                  formDateSelected[listIntervalFromApi[item - 1].date].length ===
                    listIntervalFromApi[item - 1].interval.length
                "
              />
              <label :for="listIntervalFromApi[item - 1].date" class="ml-1 select-none cursor-pointer">
                {{ $t("space_config_override.check_all_hours") }}</label
              >
            </div>
            <div
              class="flex w-full my-1"
              v-for="(intervalItem, index) in listIntervalFromApi[item - 1].interval"
              :key="index"
            >
              <input
                type="checkbox"
                :value="{
                  interval_id: intervalItem.id,
                  day_ident: listIntervalFromApi[item - 1].date,
                  interval_start_time: intervalItem.start_time_formatted,
                  interval_end_time: intervalItem.end_time_formatted,
                }"
                v-model="formDateSelected[listIntervalFromApi[item - 1].date]"
              />
              <div
                class="ml-1 flex-1 flex justify-between"
                :class="intervalItem.isBeforeDateCurrent ? optionNotes.in_the_past.backGround : intervalItem.color"
              >
                <div class="">{{ intervalItem.start_time_formatted }}-{{ intervalItem.end_time_formatted }}</div>
                <div class="">{{ intervalItem.tenancy_price }}円<i class="fa fa-minus"></i></div>
              </div>
            </div>
          </template>
        </div>
      </div>
    </div>

    <div class="w-full flex justify-center my-2">
      <button
        class="text-white bg-[#ffbd00] p-2 rounded mr-1 hover:translate-y-1 transition-all"
        @click="handleShowUpdateInterval"
      >
        {{ $t("space_config_override.checked_frame") }}
      </button>
      <button
        class="
          text-[#d43f3a]
          border border-solid border-[#d43f3a]
          p-2
          bg-white
          rounded
          hover:bg-[#c9302c] hover:text-white
        "
        @click="handleShowModalConfirmDeleteInterval"
      >
        {{ $t("space_config_override.cancel_the_special") }}
      </button>
    </div>
  </div>
  <div v-else>
    <SlotsForBatch
      :rentalIntervals="rentalIntervals"
      :infoPlanCurrent="infoPlanCurrent"
      :listDateSelected="listDateSelected"
      @updated="handleUpdated"
    />
  </div>
  <ModalCommon v-if="isShowModal">
    <div class="max-w-[400px] p-5 bg-white m-auto">
      <div>{{ $t("space_config_override.select_time_required") }}</div>
      <button
        class="
          mt-2
          ml-auto
          block
          py-2
          hover:bg-[rgba(0,0,0,.05)]
          w-fit
          min-w-[88px]
          border border-[#ddd] border-dashed
          active:border-[red]
        "
        @click="isShowModal = false"
      >
        OK
      </button>
    </div>
  </ModalCommon>
  <ModalCommon v-if="isShowModalConfirmDeleteInterval">
    <div class="max-w-[400px] p-5 bg-white m-auto">
      <div>{{ $t("space_config_override.select_time_required") }}</div>
      <div class="flex justify-end">
        <button
          class="
            mt-2
            block
            py-2
            hover:bg-[rgba(0,0,0,.05)]
            w-fit
            min-w-[88px]
            border border-dashed border-transparent
            active:border-[red]
          "
          @click="isShowModalConfirmDeleteInterval = false"
        >
          {{ $t("space_config_override.do_not_release") }}
        </button>
        <button
          class="
            mt-2
            block
            py-2
            hover:bg-[rgba(0,0,0,.05)]
            w-fit
            min-w-[88px]
            border border-[#ddd] border-dashed
            active:border-[red]
          "
          @click="handleDeleteInterval"
        >
          {{ $t("space_config_override.release") }}
        </button>
      </div>
    </div>
  </ModalCommon>
</template>

<script>
import ButtonNote from "./child/ButtonNote.vue";
import { ref, computed, inject, reactive, watch, watchEffect } from "vue";
import { dayOfWeek, optionNotes } from "@/const/options";
import { useStore } from "vuex";
import { MODULE_STORE, STEP_EDIT_SPACE, STATUS_RESERVED } from "@/const";
import {
  getIntervalInThisDay,
  getListPlan,
  getIntervalOverride,
  getRentalSlotUnavailableCacheEntryInThisDay,
  deleteOverrideInterval,
} from "@/api";
import { useI18n } from "vue-i18n";
import { useRoute } from "vue-router";
import SlotsForBatch from "@/components/Spaces/SlotsForBatch";
import ModalCommon from "@/components/ModalCommon";

export default {
  name: "SpaceConfigOverride",
  components: { ButtonNote, SlotsForBatch, ModalCommon },
  setup() {
    const store = useStore();
    function daysInMonth(month, year) {
      return new Date(year, month, 0).getDate();
    }
    const month = ref(new Date().getMonth() + 1);
    const year = ref(new Date().getFullYear());
    const currentDate = new Date().getDate();
    const currentMonth = new Date().getMonth() + 1;
    const currentYear = new Date().getFullYear();
    const idPlanCurrent = ref();
    const isShowModal = ref(false);
    const listPlanFromApi = ref([]);
    const listDateSelected = ref({});
    const infoPlanCurrent = ref(null);
    const isShowModalConfirmDeleteInterval = ref(false);
    const listIntervalFromApi = ref([]);
    const isUpdateCalendar = ref(false);
    const countClickSelectAll = ref(0);
    let countKey = 0;
    const { t } = useI18n();
    const toast = inject("$toast");
    const route = useRoute();
    const idSpace = route.params.id;
    const formDateSelected = reactive({});
    const rentalIntervals = ref([]);
    const arrayDays = computed(() => {
      const numberDays = daysInMonth(month.value, year.value);
      const dayStart = new Date(`${month.value}/1/${year.value}`).getDay();
      const dayEnd = new Date(`${month.value}/${numberDays}/${year.value}`).getDay();
      let arrayDaysTest = [];
      if (dayStart == 0) arrayDaysTest = [...new Array(6)].concat(arrayDaysTest);
      if (dayStart > 1) arrayDaysTest = [...new Array(dayStart - 1)].concat(arrayDaysTest);
      arrayDaysTest = arrayDaysTest.concat(Array.from(Array(numberDays), (x, index) => index + 1));
      if (dayEnd < 6 && dayEnd >= 1) arrayDaysTest = arrayDaysTest.concat([...new Array(7 - dayEnd)]);
      if (dayEnd == 6) arrayDaysTest = arrayDaysTest.concat([...new Array(1)]);
      return arrayDaysTest;
    });
    const handleNextMonth = () => {
      if (month.value < 12) {
        month.value++;
      } else {
        month.value = 1;
        year.value++;
      }
    };
    const handleCheckAll = (data, event) => {
      const { date } = data;
      if (event.target.checked) {
        data.interval.forEach((item) => {
          formDateSelected[date].push({
            interval_id: item.id,
            day_ident: data.date,
            interval_start_time: item.start_time_formatted,
            interval_end_time: item.end_time_formatted,
          });
        });
      } else {
        formDateSelected[date] = [];
      }
    };
    const nextMonth = computed(() => {
      if (month.value + 1 > 12) {
        return `${year.value + 1}/1`;
      }
      return `${year.value}/${month.value + 1}`;
    });
    const compareDate = (date) => {
      const dateToCompare = new Date(date).setHours(0, 0, 0, 0);
      const dateCurrent = new Date(`${currentYear}-${currentMonth}-${currentDate}`).setHours(0, 0, 0, 0);
      return dateToCompare < dateCurrent;
    };
    const selectAllTimeInMonth = () => {
      if (Object.keys(formDateSelected).length) {
        countClickSelectAll.value += 1;
        if (countClickSelectAll.value % 2 == 0) {
          Object.keys(formDateSelected).forEach((key) => {
            formDateSelected[key] = [];
          });
        } else {
          arrayDays.value.forEach((item) => {
            if (item && listIntervalFromApi.value[item - 1].interval.length) {
              const date = listIntervalFromApi.value[item - 1].date;
              listIntervalFromApi.value[item - 1].interval.forEach((interval) => {
                if (!formDateSelected[date].find((c) => c.interval_id == interval.id)) {
                  formDateSelected[date].push({
                    interval_id: interval.id,
                    day_ident: date,
                    interval_start_time: interval.start_time_formatted,
                    interval_end_time: interval.end_time_formatted,
                  });
                }
              });
            }
          });
        }
      }
    };
    const paramsMonthAndYear = computed(() => ({
      month: month.value,
      year: year.value,
    }));
    watchEffect(async () => {
      if (idPlanCurrent.value && paramsMonthAndYear.value) {
        infoPlanCurrent.value = listPlanFromApi.value.find((item) => item.id === idPlanCurrent.value);
        countKey++;
        getInfoCalendar(idPlanCurrent.value);
      }
    });
    watch(formDateSelected, () => {
      rentalIntervals.value = [];
      listDateSelected.value = {};
      Object.keys(formDateSelected).forEach((element) => {
        if (formDateSelected[element].length) {
          listDateSelected.value[element] = formDateSelected[element];
          rentalIntervals.value = [...rentalIntervals.value, ...formDateSelected[element]];
        }
      });
    });
    const getIntervalOverrideFromApi = async (idPlan) => {
      const res = await getIntervalOverride(idSpace, idPlan, paramsMonthAndYear.value);
      if (res.data.length) {
        res.data.forEach((item, index) => {
          if (item.interval_override.length === 0) {
            return;
          }
          item.interval_override.forEach((itemIntervalOverride) => {
            const intervalFound = listIntervalFromApi.value[index].interval.find(
              (itemInterval) => itemInterval.id === itemIntervalOverride.rental_interval_id
            );
            intervalFound.tenancy_price = itemIntervalOverride.tenancy_price;
            intervalFound.color = optionNotes.special_day.backGround;
          });
        });
      }
    };
    const getRentalSlotUnavailableCacheEntryInThisDayFromApi = async (idPlan) => {
      const res = await getRentalSlotUnavailableCacheEntryInThisDay(idSpace, idPlan, paramsMonthAndYear.value);
      if (res.data.length) {
        res.data.forEach((item, index) => {
          if (item?.slots_unavailable_cache_entry.length) {
            item.slots_unavailable_cache_entry.forEach((itemSlot) => {
              const intervalFound = listIntervalFromApi.value[index].interval.find(
                (itemInterval) => itemInterval.id === itemSlot.rental_interval_id
              );
              if (itemSlot.status == STATUS_RESERVED && intervalFound) {
                intervalFound.tenancy_price = itemSlot.tenancy_price;
                intervalFound.color = optionNotes.reserved.backGround;
              }
            });
          }
        });
      }
    };
    const getIntervalInThisDayFromApi = async (idPlanCurrent) => {
      const listCalendar = await getIntervalInThisDay(idSpace, idPlanCurrent, paramsMonthAndYear.value);
      listIntervalFromApi.value = listCalendar.data.map((item) => ({
        ...item,
        interval: item.interval.map((itemInterval) => ({
          ...itemInterval,
          color: "bg-white",
          isBeforeDateCurrent: compareDate(item.date),
        })),
      }));
      listCalendar.data.forEach((item) => {
        formDateSelected[item.date] = [];
      });
    };
    const getListPlanFromApi = async () => {
      const res = await getListPlan(idSpace);
      if (res?.rentalPlan.length) {
        listPlanFromApi.value = res.rentalPlan;
        idPlanCurrent.value = res.rentalPlan[0].id;
        infoPlanCurrent.value = res.rentalPlan[0];
        await getIntervalInThisDayFromApi(idPlanCurrent.value).then(async () => {
          await getIntervalOverrideFromApi(idPlanCurrent.value);
          await getRentalSlotUnavailableCacheEntryInThisDayFromApi(idPlanCurrent.value);
        });
      }
    };

    const getInfoCalendar = async (idPlan) => {
      if (countKey === 1) return;
      store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
      try {
        await getIntervalInThisDayFromApi(idPlan).then(async () => {
          await getIntervalOverrideFromApi(idPlan);
          await getRentalSlotUnavailableCacheEntryInThisDayFromApi(idPlan);
        });
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      }
      store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
    };

    const initData = async () => {
      store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
      try {
        await getListPlanFromApi();
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      }
      store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
    };

    const handleShowUpdateInterval = () => {
      if (rentalIntervals.value.length) {
        isUpdateCalendar.value = true;
        return;
      }
      isShowModal.value = true;
    };
    const handleShowModalConfirmDeleteInterval = () => {
      if (!rentalIntervals.value.length) {
        isShowModal.value = true;
        return;
      }
      isShowModalConfirmDeleteInterval.value = true;
    };
    const handleDeleteInterval = async () => {
      const rental_interval_overrides = rentalIntervals.value.map((item) => ({
        rental_interval_id: item.interval_id,
        rental_interval_override_id: `${item.interval_id}-${item.day_ident.split("-").join("")}`,
      }));
      const params = {
        rental_interval_overrides,
      };
      store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
      try {
        await deleteOverrideInterval(params);
        isShowModalConfirmDeleteInterval.value = false;
        countKey++;
        getInfoCalendar(idPlanCurrent.value);
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      }
      store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
    };
    const handleUpdated = () => {
      isUpdateCalendar.value = false;
      Object.keys(formDateSelected).forEach((item) => {
        if (formDateSelected[item].length) formDateSelected[item] = [];
      });
      countKey++;
      getInfoCalendar(idPlanCurrent.value);
    };
    initData();
    store.dispatch(
      `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.ACTIONS.SET_ACTIVE_EDIT}`,
      STEP_EDIT_SPACE.RESERVATION_SYSTEM
    );
    return {
      dayOfWeek,
      optionNotes,
      arrayDays,
      year,
      month,
      nextMonth,
      handleNextMonth,
      listPlanFromApi,
      idPlanCurrent,
      listIntervalFromApi,
      handleCheckAll,
      formDateSelected,
      handleShowUpdateInterval,
      isUpdateCalendar,
      isShowModal,
      rentalIntervals,
      infoPlanCurrent,
      listDateSelected,
      handleUpdated,
      handleShowModalConfirmDeleteInterval,
      isShowModalConfirmDeleteInterval,
      handleDeleteInterval,
      selectAllTimeInMonth,
    };
  },
};
</script>

<style scoped></style>
