<template>
  <HeaderSpaces
    :title="$t('rental_plan_interval_page.reservation_frame_creation')"
    :textHelp="$t('rental_plan_interval_page.text_help_1')"
    :textLink="$t('spaces_image_page.preview_of_public_page')"
    :textHelpTop="$t('spaces_image_page.text_desc_1')"
  />
  <div
    v-if="isShowAddPlanButton"
    class="p-2 mt-5 w-[120px] max-w-fit bg-[#FFBD00] rounded text-center cursor-pointer mb-2"
    @click="handleAddPlan"
  >
    <div class="text-white">{{ $t("rental_plan_interval_page.add_new_plan") }}</div>
    <div class="text-white">{{ $t("rental_plan_interval_page.create_reservation_slot") }}</div>
  </div>
  <template v-if="listRentalPlan.length">
    <div
      class="pb-3 w-full border border-solid mb-2"
      :class="
        item.isShowInterval && item.rental_plan_status == 'active'
          ? 'border-[#37a200]'
          : item.isShowInterval && item.rental_plan_status == 'archived'
          ? 'border-[#525454]'
          : 'border-[red]'
      "
      v-for="(item, index) in listRentalPlan"
      :key="index"
    >
      <div
        class="h-10 w-full border-b border-solid mb-2 flex"
        :class="
          item.isShowInterval && item.rental_plan_status == 'active'
            ? 'border-[#37a200] bg-[#caffc9]'
            : item.isShowInterval && item.rental_plan_status == 'archived'
            ? 'border-[#333333] bg-[#e3e3e3]'
            : 'border-[red] bg-[#fed8da]'
        "
      >
        <div class="flex">
          <span
            v-if="item.isShowInterval && item.rental_plan_status == 'active'"
            class="fa-stack fa-lg h-full flex items-center ml-2"
          >
            <i class="fa fa-circle-thin fa-stack-2x text-[#33903d]"></i>
            <i class="fa-stack-1x fa fa-check text-[#33903d]"></i>
          </span>
          <span
            v-else-if="item.isShowInterval && item.rental_plan_status == 'archived'"
            class="fa-stack fa-lg h-full flex items-center ml-2"
          >
            <i class="fa fa-circle-thin fa-stack-2x text-[#525454]"></i>
            <i class="fa-stack-1x fa fa fa-book text-[#525454]"></i>
          </span>
          <span v-else class="fa-stack fa-lg h-full flex items-center ml-2">
            <i class="fa fa-circle-thin fa-stack-2x text-[#b10017]"></i>
            <i class="fa-stack-1x fa fa-hourglass-half text-[#b10017]"></i>
          </span>
          <div
            :class="
              item.isShowInterval && item.rental_plan_status == 'active'
                ? 'text-[#2d8f35]'
                : item.isShowInterval && item.rental_plan_status == 'archived'
                ? 'text-[#525454]'
                : 'text-[#b30000]'
            "
            class="leading-10 ml-1"
          >
            {{ item.rental_plan_name }}
            {{
              item.isShowInterval && item.rental_plan_status == "active"
                ? "(公開)"
                : item.isShowInterval && item.rental_plan_status == "archived"
                ? "(非公開)"
                : ""
            }}
          </div>
        </div>
        <div class="ml-auto flex items-center mr-2">
          <button class="px-2 py-1.5 bg-white rounded" @click="() => handleEditPlan(item.rental_plan_id)">
            <i
              class="fa fa-pencil mr-1"
              :class="
                item.isShowInterval && item.rental_plan_status == 'active'
                  ? 'text-[#2d8f35]'
                  : item.isShowInterval && item.rental_plan_status == 'archived'
                  ? 'text-[#525454]'
                  : 'text-[#b30000]'
              "
              aria-hidden="true"
            ></i>
            <span
              :class="
                item.isShowInterval && item.rental_plan_status == 'active'
                  ? 'text-[#2d8f35]'
                  : item.isShowInterval && item.rental_plan_status == 'archived'
                  ? 'text-[#525454]'
                  : 'text-[#b30000]'
              "
            >
              {{ $t("reservation_system.edit_plan") }}
            </span>
          </button>
        </div>
      </div>
      <div class="px-2">
        <div class="flex justify-end">
          <ButtonAddNew
            :text="$t('rental_plan_interval_page.add_reservation_frame')"
            @click="() => handleAddInterval(idSpace, item.rental_plan_id, item.rental_plan_name)"
          />
        </div>
        <table v-if="item.isShowInterval" class="w-full mt-2">
          <tr>
            <th>
              <i class="fa fa-clock-o mr-1" aria-hidden="true"></i>
              <span> {{ $t("rental_plan_interval_page.time_setting") }} </span>
            </th>
            <th class="w-1/5">
              <i class="fa fa-yen"></i>
              <span> {{ $t("rental_plan_interval_page.room_charge") }} </span>
            </th>
            <th class="w-1/5">
              <i class="fa fa-yen"></i>
              <span>
                {{ $t("rental_plan_interval_page.price_per_person") }}
              </span>
            </th>
            <th class="w-1/5">
              <span> {{ $t("rental_plan_interval_page.day_setting") }} </span>
            </th>
            <th class="w-[10%]">
              <span> {{ $t("rental_plan_interval_page.status") }} </span>
            </th>
            <th class="w-[10%]"></th>
          </tr>
          <tr v-for="(itemInterval, index) in item.rental_space_rental_interval" :key="index">
            <td
              @click="() => gotoEditInterval(item.rental_plan_id, itemInterval.id)"
              class="bg-white px-3 py-1 rounded border cursor-pointer"
            >
              <span class="text-[#337ab7]">
                {{ itemInterval.start_time_formatted }}
                <span class="text-[#337ab7]">»</span>
                {{ itemInterval.end_time_formatted }}
              </span>
            </td>
            <td>
              <span> {{ itemInterval.tenancy_price }} </span>
              {{ $t("rental_plan_interval_page.circle") }}
            </td>
            <td>
              <span> {{ itemInterval.per_person_price }} </span>
              {{ $t("rental_plan_interval_page.yen_person") }}
            </td>
            <td>
              <div>
                <span v-for="(item, index) in itemInterval.applicability_periods" :key="index">
                  {{ item }}
                </span>
              </div>
              <div class="mt-1">
                <i :class="itemInterval.holiday_applicability_type.icon" class="mr-1"></i>
                <span>{{ itemInterval.holiday_applicability_type.text_table_show }}</span>
              </div>
            </td>
            <td>
              <i class="fa fa-check ml-1 text-[#3c763d]"></i>
              <span class="text-[#3c763d]">
                {{ $t("rental_plan_interval_page.release") }}
              </span>
            </td>
            <td>
              <div class="flex justify-center">
                <div
                  @click="() => gotoEditInterval(item.rental_plan_id, itemInterval.id)"
                  class="bg-white px-3 py-1 rounded border cursor-pointer hover:bg-[#eee]"
                >
                  <i class="fa fa-pencil" aria-hidden="true"></i>
                </div>
              </div>
            </td>
          </tr>
        </table>
        <div v-else>
          <div class="w-full text-[#a94442] text-center pb-2">
            {{ $t("rental_plan_interval_page.text_help_2") }}
          </div>
          <button
            class="block mx-auto border border-solid border-[#ddd] rounded bg-white p-2"
            @click="isShowInfo[item.rental_plan_id] = !isShowInfo[item.rental_plan_id]"
          >
            <i class="fa fa-question-circle mr-1"></i>
            <span>{{ $t("rental_plan_interval_page.example") }}</span>
          </button>
          <InfoCalendar v-if="isShowInfo[item.rental_plan_id]" />
        </div>
      </div>
    </div>
  </template>
  <MessagesForm v-if="isShowErr" class="text-center" messages="1つ以上の時間枠を登録して下さい" />
  <ButtonNextStep :nextPage="'規約・メッセージ入力'" @onBack="handleBack" @onNext="handleNext" />
</template>

<script>
import { STEP_CREATE_SPACE, MODULE_STORE, ROUTER_PATH, STEP_SPACE_CREATED } from "@/const";
import { useStore } from "vuex";
import HeaderSpaces from "@/components/HeaderSpaces";
import ButtonNextStep from "@/components/Buttons/ButtonNextStep";
import ButtonAddNew from "@/components/Buttons/ButtonAddNew";
import { ref, inject, computed } from "vue";
import { useRouter, useRoute } from "vue-router";
import { optionSettingDateFull, optionSettingDate, optionHolidayType } from "@/const/options";
import { useI18n } from "vue-i18n";
import { getDetailSpaceReservationSystem, getDetailSpaceRentalPlan } from "@/api";
import InfoCalendar from "./InfoCalendar.vue";
import MessagesForm from "@/components/MessagesForm";

export default {
  name: "RentalPlanInterval",
  props: {
    maxPlan: {
      type: Number,
      default: () => 0,
    },
  },
  components: {
    ButtonAddNew,
    HeaderSpaces,
    ButtonNextStep,
    InfoCalendar,
    MessagesForm,
  },
  setup(props) {
    const router = useRouter();
    const store = useStore();
    const route = useRoute();
    const toast = inject("$toast");
    const idSpace = route.params.id || route.query.id;
    const idPlan = ref(0);
    const listRentalPlan = ref([]);
    const isShowInfo = ref({});
    const isShowErr = ref(false);
    const { t } = useI18n();

    const validateTimeSlot = () => {
      isShowErr.value = !listRentalPlan.value.some((plan) => plan.rental_intervals.length > 0);
    };
    const isShowAddPlanButton = computed(() => listRentalPlan.value.some((plan) => plan.rental_intervals.length > 0));
    const handleAddPlan = () => {
      if (listRentalPlan.value.length < props.maxPlan) {
        store.commit(`${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.MUTATIONS.SET_ID_PLAN}`, null);
        router.push(`${ROUTER_PATH.SPACE.RENTAL_PLAN}?id=${idSpace}`);
      }
    };
    const handleBack = () => {
      router.push(`${ROUTER_PATH.SPACE.RENTAL_PLAN}?id=${idSpace}`);
    };
    const handleNext = () => {
      validateTimeSlot();
      if (isShowErr.value) return;
      store.commit(
        `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.MUTATIONS.SET_STEP_SPACE_CREATED}`,
        STEP_SPACE_CREATED["page-and-email-message"]
      );
      router.push(`${ROUTER_PATH.SPACE.EMAIL_MESSAGE}?id=${idSpace}`);
    };
    const handleAddInterval = (idSpaceRental, idPlanRental, namePlan) => {
      store.commit(
        `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.MUTATIONS.SET_NAME_PLAN_CURRENT}`,
        namePlan
      );
      router.push(
        `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}/${ROUTER_PATH.ADD}/${ROUTER_PATH.SPACE.ADD_PLAN_INTERVAL}?id=${idSpaceRental}&idPlan=${idPlanRental}`
      );
    };
    const getListPlanFromApi = async (id) => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const res = await getDetailSpaceReservationSystem(id);
        // console.log(res);
        // idPlan.value = res[0].rental_plan_id;
        listRentalPlan.value = res.map((item) => {
          isShowInfo.value[item.rental_plan_id] = false;
          return {
            ...item,
            isShowInterval: !!item.rental_intervals.length,
            rental_space_rental_interval: item.rental_intervals.map((itemInterval) => ({
              ...itemInterval,
              applicability_periods: itemInterval.applicability_periods.map((itemPeriod) => {
                const itemDate = optionSettingDate.find((optionDate) => optionDate.value == itemPeriod);
                if (itemDate) {
                  return `${itemDate.label}, `;
                }
                return `${optionSettingDateFull.label}, `;
              }),
              holiday_applicability_type: optionHolidayType.find(
                (itemHoliday) => itemHoliday.value == itemInterval.holiday_applicability_type
              ),
            })),
          };
        });
        const lastPlanId = listRentalPlan.value.slice(-1)[0].rental_plan_id;
        store.commit(
          `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.MUTATIONS.SET_ID_PLAN}`,
          lastPlanId
        );
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    const handleEditPlan = (idPlan) => {
      router.push(
        `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}/${ROUTER_PATH.EDIT}/${ROUTER_PATH.SPACE.PLAN_EDIT}/${idSpace}?idPlan=${idPlan}`
      );
    };
    const gotoEditInterval = (idPlan, idInterval) => {
      router.push(
        `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}/${ROUTER_PATH.EDIT}/${ROUTER_PATH.SPACE.ADD_PLAN_INTERVAL}?id=${idSpace}&idPlan=${idPlan}&idInterval=${idInterval}`
      );
    };
    const initData = async () => {
      await getListPlanFromApi(idSpace);
      //   await getDetailRentalPlan();
      store.dispatch(
        `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.ACTIONS.SET_ACTIVE}`,
        STEP_CREATE_SPACE.PLAN_CREATE_RESERVATION_FRAME
      );
    };
    // const getDetailRentalPlan = async () => {
    //   if (idPlan) {
    //     try {
    //       const res = await getDetailSpaceRentalPlan(idSpace, idPlan.value);
    //       if (res) {
    //         listRentalPlan.value[0].rental_plan_status = res.status;
    //       }
    //     } catch (errors) {
    //       const error = errors.message || t("common.has_error");
    //       toast.error(error);
    //     }
    //   }
    // };
    initData();
    return {
      handleNext,
      handleBack,
      idPlan,
      listRentalPlan,
      handleAddInterval,
      gotoEditInterval,
      idSpace,
      handleEditPlan,
      isShowInfo,
      isShowErr,
      handleAddPlan,
      isShowAddPlanButton,
      //   getDetailRentalPlan,
    };
  },
};
</script>

<style scoped>
table,
td,
th {
  border: 1px solid #ddd;
  padding: 8px 8px;
}
</style>
