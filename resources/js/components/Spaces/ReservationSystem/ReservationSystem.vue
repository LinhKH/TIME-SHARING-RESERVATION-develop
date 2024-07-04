<template>
  <div
    v-if="!preview"
    class="flex bg-green-200 items-center border-b justify-between border-[#37a200] px-[15px] py-[10px]"
    :class="[checkPrivatePlan && 'plan-private']"
  >
    <div class="flex items-center">
      <i class="fa fa-check-circle-o text-[30px] mr-1 text-[#2d8f35]" aria-hidden="true"></i>
      <p class="text-[#2d8f35] hover:underline">{{ titleTable }} ({{ getStatusLabel }})</p>
    </div>
    <div class="">
      <template v-if="dataTableItem.rental_plan_group.length">
        <button
          class="bg-[#bcf6ff] rounded-[3px] px-[1px] py-[5px] mr-1"
          v-for="(group, indexGroup) in dataTableItem.rental_plan_group"
          :key="indexGroup"
          @click="() => gotoEditGroup(group.plan_group_id)"
        >
          {{ group.plan_group_name }}
        </button>
      </template>
      <button class="rounded-[3px] text-[#2d8f35] py-[5px] px-[10px] bg-white" @click="handleEditPlan">
        <i class="fa fa-pencil text-[#2d8f35]" aria-hidden="true"></i>
        {{ $t("reservation_system.edit_plan") }}
      </button>
    </div>
  </div>
  <div
    class="border-b"
    :class="[
      preview ? 'border-transparent p-0' : 'border-[#37a200] px-[15px] py-[10px]',
      checkPrivatePlan && 'plan-private-body',
    ]"
  >
    <div class="flex items-center justify-between">
      <div>
        <template v-if="!preview">
          <button
            class="bg-[#7EA6E0] text-white py-[6px] px-[12px] text-center rounded-[4px] hover:bg-[#e6e6e6] hover:text-[#333] font-bold"
            @click="handleIntoView"
          >
            {{ $t("reservation_system.manipulate_time_together") }}
          </button>
          <div class="mt-[7px]">
            <input type="checkbox" @click="handleCheckAll" ref="inputCheckAll" />
            {{ $t("reservation_system.check_all_times") }}
          </div>
        </template>
      </div>

      <p class="text-[#3c763d]" v-if="updateSuccess">
        <i class="fa fa-check text-[#3c763d]" aria-hidden="true"></i> {{ $t("reservation_system.update_success") }}
      </p>

      <div>
        <button
          class="bg-[#ffbd00] py-[5px] px-[10px] rounded-[3px] text-white"
          @click="(event) => handleAddInterval()"
        >
          <i class="fa fa-plus text-white" aria-hidden="true"></i>
          {{ $t("reservation_system.add_reservation_slot") }}
        </button>
      </div>
    </div>
    <table class="block w-full mt-2">
      <thead>
        <tr>
          <td class="border border-[#ddd] p-2 h-[40px]" v-if="isCheckAll"></td>
          <td
            v-for="(header, index) in tableHeader"
            :key="index"
            class="border border-[#ddd] p-2 h-[40px]"
            :class="`w-[${header.with}]`"
          >
            <i v-if="header.classIcon" :class="header.classIcon" aria-hidden="true"></i>
            {{ header.label }}
          </td>
        </tr>
      </thead>
      <tbody>
        <tr class="" v-for="(tr, index) in dataTable" :key="index">
          <td v-if="isCheckAll" class="p-2 border border-solid border-[#ddd] h-[45px]">
            <input type="checkbox" :value="tr.id" v-model="listIdTimeLine" />
          </td>
          <td class="p-2 border border-solid border-[#ddd] h-[45px]">
            <div
              class="text-[#337ab7] hover:underline cursor-pointer"
              v-if="tr.time_formatted"
              @click="() => handleEditInterval(tr.id)"
            >
              {{ tr.time_formatted }}
            </div>
          </td>
          <td class="p-2 border border-solid border-[#ddd] h-[45px]">
            <p v-if="tr.tenancy_price">{{ tr.tenancy_price }}</p>
          </td>
          <td class="p-2 border border-solid border-[#ddd] h-[45px]">
            <p v-if="tr.per_person_price">{{ tr.per_person_price }}</p>
          </td>
          <td class="p-2 border border-solid border-[#ddd] h-[45px]">
            <p v-if="tr.applicability_periods">{{ tr.applicability_periods }}</p>
            <div class="mt-1">
              <i :class="tr.holiday_applicability_type.icon" class="mr-1"></i>
              <span>{{ tr.holiday_applicability_type.text_table_show }}</span>
            </div>
          </td>
          <td class="p-2 border border-solid border-[#ddd] h-[45px]">
            <p v-if="tr.status_text == '公開'" class="text-[#3c763d]">
              <i class="fa fa-check text-[#3c763d]" aria-hidden="true"></i> {{ tr.status_text }}
            </p>
            <p v-else class="text-[#8a6d3b]">
              <i class="fa fa-book text-[#8a6d3b]" aria-hidden="true"></i> {{ tr.status_text }}
            </p>
          </td>
          <td class="p-2 border border-solid border-[#ddd] h-[45px]">
            <button
              class="hover:bg-[#e6e6e6] px-[15px] py-[10px] rounded-[3px] border"
              @click="() => handleEditInterval(tr.id)"
            >
              <i class="fa fa-pencil" aria-hidden="true"> </i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    <SpacePlanInterview
      v-if="isShowFormInterval"
      :isShowFormInterval="isShowFormInterval"
      :isUpdateInterval="true"
      @updateInterval="handleUpdateInterval"
      :idPlan="idPlan"
      :typeScreen="TYPE_SCREEN.SPACE_EDITING"
      :listIntervalId="listIdTimeLine"
    />
  </div>
</template>
<script>
import { watch, computed, ref, inject } from "vue";
import { ROUTER_PATH, MODULE_STORE, TYPE_SCREEN } from "@/const";
import { optionSettingDate, optionSettingDateFull, optionHolidayType } from "@/const/options";
import { useRouter, useRoute } from "vue-router";
import SpacePlanInterview from "@/components/Spaces/SpacePlanInterview";
import { updateInterval } from "@/api";
import { useStore } from "vuex";
import { useI18n } from "vue-i18n";

export default {
  name: "ReservationSystem",
  props: {
    dataTableItem: Object,
    detailInterval: Object,
    preview: { type: Boolean, default: false },
    idPlan: [String, Number],
  },
  components: {
    SpacePlanInterview,
  },
  emits: ["resetData"],
  setup(props, context) {
    const inputCheckAll = ref(null);
    let isCheckAll = ref(false);
    let updateSuccess = ref(false);
    const router = useRouter();
    const route = useRoute();
    const store = useStore();
    const { t } = useI18n();
    const toast = inject("$toast");
    const idPlan = props.dataTableItem?.rental_plan_id || props.idPlan;
    const idSpace = route.params.id || route.query.id;
    const titleTable = props.dataTableItem?.rental_plan_name || "";
    const isShowFormInterval = ref(false);
    const listIdTimeLine = ref([]);
    let tableHeader = ref([
      {
        label: "予約枠ごとの時間設定",
        classIcon: "fa fa-clock-o",
        with: "25%",
      },
      {
        label: "ルーム料金（税抜）",
        classIcon: "fa fa-jpy",
        with: "25%",
      },
      {
        label: "一人あたり料金（税抜）",
        classIcon: "fa fa-jpy",
        with: "25%",
      },
      {
        label: "曜日設定",
        with: "15%",
      },
      {
        label: "ステータス",
        with: "10%",
      },
      {
        label: "",
        with: "10%",
      },
    ]);
    const handleAddInterval = () =>
      router.push(
        `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}/${ROUTER_PATH.RENTAL_PLAN}/${ROUTER_PATH.SPACE.ADD_PLAN_INTERVAL}?id=${idSpace}&idPlan=${idPlan}`
      );
    const handleEditInterval = (idInterval) =>
      router.push(
        `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}/${ROUTER_PATH.RENTAL_PLAN}/${ROUTER_PATH.SPACE.EDIT_PLAN_INTERVAL}?id=${idSpace}&idPlan=${idPlan}&idInterval=${idInterval}`
      );
    const dataTable = computed(() => {
      const objMerge = [...optionSettingDate, optionSettingDateFull];
      const listArray = props.dataTableItem?.rental_intervals || props.detailInterval;
      let dataTable = listArray.map((item) => {
        item.time_formatted = `${item.start_time_formatted} >> ${item.end_time_formatted}`;
        item.tenancy_price = `${item.tenancy_price} 円`;
        item.per_person_price = `${item.per_person_price} 円／人`;
        item.applicability_periods = item.applicability_periods
          .map((itemApplicability) => objMerge.find((itemOption) => itemOption.value == itemApplicability).label)
          .join(", ");
        item.checkbox = false;
        item.holiday_applicability_type = optionHolidayType.find(
          (itemHoliday) => itemHoliday.value == item.holiday_applicability_type
        );
        if (item.status == "active") {
          item.status_text = "公開";
        } else {
          item.status_text = "非公開";
        }
        return item;
      });
      return dataTable;
    });
    const getStatusLabel = computed(() => {
      if (props.dataTableItem.rental_plan_status === "active") {
        return t("rental_plan_page.release");
      } else {
        return t("rental_plan_page.private");
      }
    });
    const checkPrivatePlan = computed(() => {
      return props.dataTableItem?.rental_plan_status !== "active";
    });
    const handleCheckAll = () => {
      isCheckAll.value = true;
      listIdTimeLine.value = [];
      if (inputCheckAll.value.checked) {
        dataTable.value.forEach((item) => listIdTimeLine.value.push(item.id));
      }
    };
    watch(listIdTimeLine, () => {
      if (listIdTimeLine.value.length) {
        isShowFormInterval.value = true;
      } else {
        isShowFormInterval.value = false;
      }
    });
    const gotoEditGroup = (idGroup) =>
      router.push(
        `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}/${ROUTER_PATH.RENTAL_PLAN}/${idSpace}/${ROUTER_PATH.SPACE.GROUP_EDIT}/${idGroup}`
      );
    const handleEditPlan = () => {
      router.push(
        `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}/${ROUTER_PATH.RENTAL_PLAN}/${ROUTER_PATH.SPACE.PLAN_EDIT}/${idSpace}?idPlan=${idPlan}`
      );
    };
    const handleIntoView = (event) => {
      isCheckAll.value = true;
      event.target.scrollIntoView({ behavior: "smooth", block: "start", inline: "nearest" });
    };
    const handleUpdateInterval = async (data) => {
      const params = {
        ids: [...listIdTimeLine.value],
        status: data.status,
        applicability_periods: [...data.applicability_periods],
        holiday_applicability_type: data.holiday_applicability_type,
        tenancy_price: data.tenancy_price,
        per_person_price: data.per_person_price,
        max_simultaneous_reservations: data.max_simultaneous_reservations,
        max_simultaneous_people: data.max_simultaneous_people,
      };
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        await updateInterval(params);
        listIdTimeLine.value = [];
        inputCheckAll.value.checked = false;
        updateSuccess.value = true;
        context.emit("resetData");
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    return {
      tableHeader,
      handleCheckAll,
      isCheckAll,
      handleAddInterval,
      inputCheckAll,
      handleEditPlan,
      titleTable,
      idPlan,
      idSpace,
      dataTable,
      isShowFormInterval,
      listIdTimeLine,
      handleIntoView,
      handleUpdateInterval,
      handleEditInterval,
      gotoEditGroup,
      TYPE_SCREEN,
      updateSuccess,
      getStatusLabel,
      checkPrivatePlan,
    };
  },
};
</script>
<style lang="scss" scoped>
.plan-private {
  background: #eee;
  border-bottom: 1px solid #555;
  p,
  i,
  button {
    color: #333 !important;
    border: 1px solid #dcdcdc;
  }
}
</style>
