<template>
  <div class="text-[18px] mt-5">{{ $t("slot_for_batch.special_day_setting") }}</div>
  <div class="my-5 p-3 rounded border border-solid border-[#bce8f1] bg-[#d9edf7]">
    <div class="flex">
      <div class="mr-2">
        <i class="fa fa-2x fa-question-circle text-[#31708f]"></i>
      </div>
      <div class="">
        <div class="text-[#31708f]">{{ $t("slot_for_batch.can_customize") }}</div>
        <div class="text-[#31708f]">{{ $t("slot_for_batch.normal_setting") }}</div>
      </div>
    </div>
  </div>
  <LayoutInput iconPrev="fa fa-table mr-1" :labelText="$t('slot_for_batch.plan_name')">
    <div class="flex justify-between">
      <div class="text-[#31708f]">{{ infoPlanCurrent.plan_name }}</div>
      <button class="border border-solid border-[#ccc] rounded p-1 bg-white">
        <i class="fa fa-pencil mr-1"> {{ $t("slot_for_batch.edit_plan") }} </i>
      </button>
    </div>
  </LayoutInput>
  <LayoutInput iconPrev="fa fa-calendar mr-1" :labelText="$t('slot_for_batch.date_reservation_slot')" customCss="mt-5">
    <div v-for="(item, index) in Object.keys(listDateSelected)" :key="index">
      <div>
        {{ item }}
      </div>
      <div>
        <span v-for="(timeSelected, indexData) in listDateSelected[item]" :key="indexData" class="mr-1">
          {{ `${timeSelected.interval_start_time}-${timeSelected.interval_end_time}` }}
        </span>
      </div>
    </div>
  </LayoutInput>
  <LayoutInput iconPrev="fa fa-sticky-note-o mr-1" :labelText="$t('slot_for_batch.remarks')" customCss="mt-5">
    <div class="relative">
      <input
        type="text"
        class="w-full h-9 rounded border border-solid border-[#ddd] shadow-inner px-2 focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 outline-none"
        v-model="formData.note"
      />
      <button class="absolute p-1 border border-solid border-[#ccc] bg-white rounded top-[calc(-100%+5px)] right-0">
        <i class="fa fa-calendar mr-1"></i>
        <span>{{ $t("slot_for_batch.back_to_calendar") }}</span>
      </button>
    </div>
    <div class="mt-2 text-[#737373]">{{ $t("slot_for_batch.note_about") }}</div>
  </LayoutInput>
  <LayoutInput iconPrev="fa fa-yen mr-1" :labelText="$t('slot_for_batch.pricing')" customCss="mt-5">
    <LayoutInput
      iconPrev="fa fa-yen mr-1"
      :labelText="$t('slot_for_batch.room_charge')"
      icon="fa fa-question-circle ml-1 text-[#337ab7]"
    >
      <div class="flex">
        <div class="w-[320px] border border-solid border-[#ddd] rounded flex">
          <div class="flex-1 shadow-inner">
            <input
              type="text"
              class="w-full h-9 rounded outline-none px-2 focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50"
              v-model="formData.tenancy_price"
            />
          </div>
          <div class="flex px-2 items-center justify-center border-l border-solid border-[#ddd] bg-[#eee]">
            {{ $t("slot_for_batch.yen_exclude_tax") }}
          </div>
        </div>
        <div class="ml-3"><span class="text-[red]">ー</span> {{ $t("slot_for_batch.yen_included_tax") }}</div>
      </div>
    </LayoutInput>
    <LayoutInput
      iconPrev="fa fa-yen mr-1"
      :labelText="$t('slot_for_batch.price_per_person')"
      icon="fa fa-question-circle ml-1 text-[#337ab7]"
    >
      <div class="flex">
        <div class="w-[320px] border border-solid border-[#ddd] rounded flex">
          <div class="flex-1 shadow-inner">
            <input
              type="text"
              class="w-full h-9 rounded outline-none px-2 focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50"
              v-model="formData.per_person_price"
            />
          </div>
          <div class="flex px-2 items-center justify-center border-l border-solid border-[#ddd] bg-[#eee]">
            {{ $t("slot_for_batch.yen_exclude_tax_person") }}
          </div>
        </div>
        <div class="ml-3"><span class="text-[red]">ー</span>{{ $t("slot_for_batch.yen_exclude_tax_person") }}</div>
      </div>
    </LayoutInput>
    <button class="block mx-auto rounded bg-[#ffbd00] p-2 text-white mt-3" @click="handleUpdateIntervalOverride">
      {{ $t("slot_for_batch.turn_on_special_day_setting") }}
    </button>
  </LayoutInput>
</template>

<script>
import LayoutInput from "@/components/Layouts/LayoutInput.vue";
import { useStore } from "vuex";
import { MODULE_STORE, STEP_EDIT_SPACE } from "@/const";
import { reactive, inject } from "vue";
import { updateIntervalOverride } from "@/api";
import { useI18n } from "vue-i18n";
import { useRoute } from "vue-router";

export default {
  components: { LayoutInput },
  props: {
    rentalIntervals: Object,
    infoPlanCurrent: Object,
    listDateSelected: Object,
  },
  emits: ["updated"],
  setup(props, context) {
    const store = useStore();
    const toast = inject("$toast");
    const route = useRoute();
    const idSpace = route.params.id;
    const { t } = useI18n();
    const formData = reactive({
      rental_intervals: props.rentalIntervals,
      note: "",
      tenancy_price: "",
      per_person_price: "",
    });
    const initData = () => {
      store.dispatch(
        `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.ACTIONS.SET_ACTIVE_EDIT}`,
        STEP_EDIT_SPACE.RESERVATION_SYSTEM
      );
    };
    const handleUpdateIntervalOverride = async () => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        await updateIntervalOverride(idSpace, props.infoPlanCurrent.id, { ...formData });
        context.emit("updated");
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      }
      store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
    };
    initData();
    return { formData, handleUpdateIntervalOverride };
  },
};
</script>
