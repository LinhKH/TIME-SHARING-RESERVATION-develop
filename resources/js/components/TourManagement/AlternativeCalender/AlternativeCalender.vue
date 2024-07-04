<template>
  <div class="font-serif p-2.5">
    <div>
      <table class="table w-full border border-solid border-black border-collapse" cellspacing="1">
        <thead>
          <tr>
            <th
              class="border border-solid border-black border-collapse p-2.5 text-center min-w-[160px]"
              v-for="(tourHeader, index) in tourHeaders"
              scope="col"
              :key="index"
            >
              {{ tourHeader }}
            </th>
          </tr>
        </thead>
        <tbody>
          <tr class="bg-[#fffaf4]">
            <th class="border border-solid border-black border-collapse p-2.5 text-center min-w-[160px]" scope="row">
              {{ tourItem.id }}
            </th>
            <td class="border border-solid border-black border-collapse p-2.5 text-center min-w-[160px]">
              {{ tourItem.space_name }}
            </td>
            <td
              class="tour__content border border-solid border-black border-collapse p-2.5 text-center min-w-[160px] text-start"
            >
              <div class="tour__content-list">
                <div class="tour__content-item mb-2.5">
                  <span class="text-[#333] font-bold">{{ $t(`tour_manager.date`) }}</span>
                  <ChoiceDateVue :option="tourItem" :isPreviewAlternative="true" />
                </div>
                <div class="tour__content-item mb-2.5">
                  <span class="text-[#333] font-bold">{{ $t("tour_manager.preferred_time") }}</span
                  >{{ tourItem.use_plans_date }}
                </div>
                <div class="tour__content-item mb-2.5">
                  <span class="text-[#333] font-bold">{{ $t("tour_manager.number_people") }}</span
                  >{{ tourItem.use_plans_people }}
                </div>
                <div class="tour__content-item mb-2.5">
                  <span class="text-[#333] font-bold">{{ $t("tour_manager.purpose_use") }}</span
                  >{{ tourItem.use_purpose }}
                </div>
                <div class="tour__content-item mb-2.5">
                  <span class="text-[#333] font-bold">{{ $t("tour_manager.purpose_detail") }}</span
                  >{{ tourItem.use_purpose_detail }}
                </div>
                <div class="tour__content-item mb-2.5">
                  <span class="text-[#333] font-bold">{{ $t("tour_manager.space_check") }}</span
                  >{{ tourItem.checklist }}
                </div>
              </div>
            </td>
            <td class="border border-solid border-black border-collapse p-2.5 text-center min-w-[160px]">
              {{ tourItem.status }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div>
      <div v-for="(Alternative, index) in AlternativeList" :key="index">
        <div class="flex items-center mt-[10px]">
          <span
            v-if="Alternative.required"
            class="bg-red-500 text-white px-[6px] py-[1px] rounded mr-[4px] text-[10px]"
            >{{ $t("tour_detail.required") }}</span
          >
          <span>{{ $t("tour_detail.reason") }}</span>
        </div>
        <div class="mt-[5px]">
          <select
            v-if="Alternative.type == 'select_input'"
            name=""
            id=""
            class="border border-solid border-[#ccc] p-[5px]"
            v-model="selected"
          >
            <option v-for="(childAlternative, index) in Alternative.child" :key="index" :value="childAlternative.title">
              {{ childAlternative.title }}
            </option>
          </select>
          <div v-if="Alternative.type == 'calender_input' && showCalender" class="bg-[#bce8f1] p-[10px] w-[50%]">
            <div>
              <div class="mb-[8px]">
                <div class="flex items-center">
                  <span class="bg-red-400 text-white px-[6px] py-[1px] rounded mr-[4px] text-[10px]">{{
                    $t("tour_detail.required")
                  }}</span>
                  <span>{{ $t("tour_detail.reason") }}</span>
                </div>
                <div class="flex w-full mt-[5px]">
                  <div class="flex-1 mr-[8px]">
                    <DatePicker
                      placeholder="2022/01/01"
                      v-model="formDate.substitute_first_choice_date"
                      startingView="date"
                      class="w-full flex-1 border border-slate-300 focus:outline-none rounded block px-[12px] py-[6px] border border-[#ccc] h-[34px]"
                    />
                  </div>
                  <div class="flex-1">
                    <DatePicker
                      placeholder="09:30"
                      v-model="formDate.substitute_first_choice_time"
                      startingView="time"
                      inputFormat="HH:mm"
                      minimumView="time"
                      class="w-full flex-1 border border-slate-300 focus:outline-none rounded block px-[12px] py-[6px] border border-[#ccc] h-[34px]"
                    />
                  </div>
                </div>
              </div>
              <div class="mb-[8px]">
                <div class="flex items-center">
                  <span>{{ $t("tour_detail.reason") }}</span>
                </div>
                <div class="flex w-full mt-[5px]">
                  <div class="flex-1 mr-[8px]">
                    <DatePicker
                      placeholder="2022/01/01"
                      v-model="formDate.substitute_second_choice_date"
                      startingView="date"
                      class="w-full flex-1 border border-slate-300 focus:outline-none rounded block px-[12px] py-[6px] border border-[#ccc] h-[34px]"
                    />
                  </div>
                  <div class="flex-1">
                    <DatePicker
                      placeholder="09:30"
                      v-model="formDate.substitute_second_choice_time"
                      startingView="time"
                      inputFormat="HH:mm"
                      minimumView="time"
                      class="w-full flex-1 border border-slate-300 focus:outline-none rounded block px-[12px] py-[6px] border border-[#ccc] h-[34px]"
                    />
                  </div>
                </div>
              </div>
              <div class="mb-[8px]">
                <div class="flex items-center">
                  <span>{{ $t("tour_detail.reason") }}</span>
                </div>
                <div class="flex w-full mt-[5px]">
                  <div class="flex-1 mr-[8px]">
                    <DatePicker
                      placeholder="2022/01/01"
                      v-model="formDate.substitute_third_choice_date"
                      startingView="date"
                      class="w-full flex-1 border border-slate-300 focus:outline-none rounded block px-[12px] py-[6px] border border-[#ccc] h-[34px]"
                    />
                  </div>
                  <div class="flex-1">
                    <DatePicker
                      placeholder="09:30"
                      v-model="formDate.substitute_third_choice_time"
                      startingView="time"
                      inputFormat="HH:mm"
                      minimumView="time"
                      class="w-full flex-1 border border-slate-300 focus:outline-none rounded block px-[12px] py-[6px] border border-[#ccc] h-[34px]"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="w-[100%] text-center mt-[20px]">
      <button
        @click="() => postDataNoneApproval(tourItem)"
        class="button btn-non-approval w-[90%] py-3 px-9 border border-solid border-[#ccc] rounded mb-1 text-[#fff] cursor-pointer bg-[#8f8f8f]"
      >
        {{ $t("tour_manager.non-approval") }}
      </button>
    </div>
  </div>
</template>
<script>
import { useI18n } from "vue-i18n";
import { ref, watch, inject } from "vue";
import ChoiceDateVue from "@/components/TourManagement/Tour/ChoiceDate.vue";
import { postNoneApprovalTour } from "@/api";
import { useStore } from "vuex";
import { ROUTER_PATH, MODULE_STORE, ROUTE_NAME } from "@/const";
import DatePicker from "vue3-datepicker";
import moment from "moment";
import { useRoute, useRouter } from "vue-router";
export default {
  name: "AlternativeCalender",
  components: {
    ChoiceDateVue,

    DatePicker,
  },
  props: {
    tourItem: {
      type: Object,
      default: () => {},
    },
  },
  setup(props, { emit }) {
    const { t } = useI18n();
    const choiceDate = ref("123");
    const selected = ref(t("tour_detail.reason1"));
    const showCalender = ref(true);
    const router = useRouter();
    const route = useRoute();
    const store = useStore();
    const toast = inject("$toast");
    const date = ref();
    const time = ref();
    const tourItem = ref();
    tourItem.value = store.getters[`tour/getTourDetailItem`];
    const test = ref();
    const formDate = ref({
      substitute_first_choice_date: null,
      substitute_first_choice_time: null,
      substitute_second_choice_date: null,
      substitute_second_choice_time: null,
      substitute_third_choice_date: null,
      substitute_third_choice_time: null,
    });
    const tourHeaders = [
      t("tour_manager.id_tour"),
      t("tour_manager.space_name"),
      t("tour_manager.space_content"),
      t("tour_manager.status"),
    ];
    const AlternativeList = [
      {
        id: 1,
        title: t("tour_detail.reason"),
        required: true,
        type: "select_input",
        child: [
          {
            id: 1,
            value: 1,
            title: t("tour_detail.reason1"),
          },
          {
            id: 2,
            value: 2,
            title: t("tour_detail.reason2"),
          },
          {
            id: 3,
            value: 3,
            title: t("tour_detail.reason2"),
          },
        ],
      },
      {
        id: 2,
        title: t("tour_detail.reason"),
        required: true,
        type: "calender_input",
        child: [
          {
            id: 1,
            title: t("tour_detail.reason1"),
            required: true,
          },
          {
            id: 2,
            title: t("tour_detail.reason1"),
            required: false,
          },
          {
            id: 3,
            title: t("tour_detail.reason1"),
            required: false,
          },
        ],
      },
    ];
    const handleTime = (data) => {
      time.value = data;
    };
    const handleDate = (data) => {
      date.value = data;
    };
    watch(selected, (value) => {
      if (value === t("tour_detail.reason1")) {
        showCalender.value = true;
      } else {
        showCalender.value = false;
      }
    });
    const postDataNoneApproval = async (data) => {
      if (selected.value.includes("ご希望の日程では、ご見学いただけません")) {
        try {
          const params = {
            status: "change_date_time",
            substitute_first_choice_date: null,
            substitute_first_choice_time: null,
            substitute_second_choice_date: null,
            substitute_second_choice_time: null,
            substitute_third_choice_date: null,
            substitute_third_choice_time: null,
          };
          if (
            formDate.value.substitute_first_choice_date !== null &&
            formDate.value.substitute_first_choice_time !== null
          ) {
            (params.substitute_first_choice_date = moment(formDate.value.substitute_first_choice_date).format(
              "YYYY-MM-DD"
            )),
              (params.substitute_first_choice_time = moment(formDate.value.substitute_first_choice_time).format(
                "HH:mm"
              ));
          }
          if (
            formDate.value.substitute_second_choice_date !== null &&
            formDate.value.substitute_second_choice_time !== null
          ) {
            (params.substitute_second_choice_date = moment(formDate.value.substitute_second_choice_date).format(
              "YYYY-MM-DD"
            )),
              (params.substitute_second_choice_time = moment(formDate.value.substitute_second_choice_time).format(
                "HH:mm"
              ));
          }
          if (
            formDate.value.substitute_third_choice_date !== null &&
            formDate.value.substitute_third_choice_time !== null
          ) {
            (params.substitute_third_choice_date = moment(formDate.value.substitute_third_choice_date).format(
              "YYYY-MM-DD"
            )),
              (params.substitute_third_choice_time = moment(formDate.value.substitute_third_choice_time).format(
                "HH:mm"
              ));
          }
          const id = tourItem.value.id;
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
          await postNoneApprovalTour(params, id);
          router.push({ name: ROUTE_NAME.ADMIN.TOUR_LIST });
        } catch (errors) {
          const error = errors.message || t("common.has_error");
          toast.error(error);
        } finally {
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
        }
      } else {
        try {
          const id = tourItem.value.id;
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
          await postNoneApprovalTour(
            {
              status: "observation_NG",
            },
            id
          );
          router.push({ name: ROUTE_NAME.ADMIN.TOUR_LIST });
        } catch (errors) {
          const error = errors.message || t("common.has_error");
          toast.error(error);
        } finally {
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
        }
      }
    };
    return {
      tourHeaders,
      choiceDate,
      AlternativeList,
      selected,
      showCalender,
      postDataNoneApproval,
      handleTime,
      handleDate,
      date,
      time,
      tourItem,
      formDate,
      test,
    };
  },
};
</script>

<style></style>
