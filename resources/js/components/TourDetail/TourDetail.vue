<template>
  <div class="font-serif p-2.5">
    <div class="flex justify-between items-center pb-[20px] border-b border-b-solid border-[#eee]">
      <h1 class="text-[30px]">{{ $t("tour_detail.visit_id") }}{{ detailTour.id }}</h1>
      <button
        class="py-[5px] px-[10px] border border-solid border-[#ccc] rounded hover:bg-[#e6e6e6] hover:border-[#adadad]"
      >
        <i class="fa fa-arrow-left mr-[3px]"></i>{{ $t("tour_detail.return") }}
      </button>
    </div>
    <div class="py-[20px]">
      <div class="flex">
        <div class="font-bold flex-[1_1_0%]">{{ $t("tour_manager.status") }}</div>
        <!-- <p class="flex-[5_5_0%]">{{ replaceStatus(detailTour.status) }}</p> -->

        <p class="flex-[5_5_0%]" v-if="detailTour.status === 'pending_request'">オーナー回答待ち</p>
        <p class="flex-[5_5_0%]" v-if="detailTour.status === 'fix_date_time'">日時確定</p>
        <p class="flex-[5_5_0%]" v-if="detailTour.status === 'waiting_response_user'">ユーザー回答待ち</p>
        <p class="flex-[5_5_0%]" v-if="detailTour.status === 'user_cancel'">利用者キャンセル</p>
        <p class="flex-[5_5_0%]" v-if="detailTour.status === 'change_date_time'">日時変更</p>
        <p class="flex-[5_5_0%]" v-if="detailTour.status === 'observation_NG'">見学NG</p>
      </div>
      <div class="flex mt-[10px]">
        <div class="font-bold flex-[1_1_0%]"></div>
        <div class="flex-[5_5_0%]">
          <div v-if="detailTour.status === 'change_date_time'" class="mb-[10px]">
            <p>{{ detailTour.substitute_first_choice_date }} {{ detailTour.substitute_first_choice_time }}</p>
            <p>{{ detailTour.substitute_second_choice_date }} {{ detailTour.substitute_second_choice_time }}</p>
            <p>{{ detailTour.substitute_third_choice_date }} {{ detailTour.substitute_third_choice_time }}</p>
          </div>
          <div v-if="detailTour.status === 'fix_date_time'" class="mb-[10px]">
            <div v-if="detailTour.status === 'fix_date_time'">
              <div
                v-if="
                  detailTour.fix_choice_date_column_date === 'first_choice_date' ||
                  detailTour.fix_choice_date_column_date === 'second_choice_date' ||
                  detailTour.fix_choice_date_column_date === 'third_choice_date'
                "
              ></div>
              <div v-else>
                <div>{{ detailTour.fix_choice_date_column_date }} {{ detailTour.fix_choice_date_column_time }}</div>
              </div>
            </div>
          </div>
          <div>
            <button
              v-if="detailTour.status === 'pending_request'"
              @click="() => approvalConfirm1(detailTour)"
              class="button btn-approval py-2.5 px-4 border border-solid border-[#ccc] rounded mb-1 text-[#fff] cursor-pointer bg-[#52c195] mr-[6px]"
            >
              {{ $t("tour_manager.approval") }}
            </button>
            <button
              v-if="detailTour.status !== 'user_cancel'"
              @click="showModal = true"
              class="button btn-non-approval py-2.5 px-4 border border-solid border-[#ccc] rounded mb-1 text-[#fff] cursor-pointer bg-[#8f8f8f]"
            >
              {{ $t("tour_manager.non-approval") }}
            </button>
          </div>
        </div>
      </div>
      <div class="flex mt-[10px]">
        <div class="font-bold flex-[1_1_0%]">{{ $t("tour_manager.id_tour") }}</div>
        <p class="flex-[5_5_0%]">{{ detailTour.tour_id }}</p>
      </div>
      <div class="flex mt-[10px]">
        <div class="font-bold flex-[1_1_0%]">{{ $t("tour_manager.space_name") }}</div>
        <p class="flex-[5_5_0%]">{{ detailTour.space_name }}</p>
      </div>
      <div class="flex mt-[10px]">
        <div class="font-bold flex-[1_1_0%]">{{ $t(`tour_detail.desired_time`) }}</div>
        <div class="flex-[5_5_0%] flex justify-start">
          <ChoiceDateVue
            :option="detailTour"
            @changeChoiceDate="handleChangeDate"
            @confirmChoiceDate="confirmChoiceDate"
          />
        </div>
      </div>
      <div class="flex mt-[10px]">
        <div class="font-bold flex-[1_1_0%]">{{ $t("tour_detail.desired_date") }}</div>
        <div class="flex-[5_5_0%]">{{ detailTour.use_plans_date }}</div>
      </div>
      <div class="flex mt-[10px]">
        <div class="font-bold flex-[1_1_0%]">{{ $t("tour_detail.number_people") }}</div>
        <div class="flex-[5_5_0%]">{{ detailTour.use_plans_people }}名</div>
      </div>
      <div class="flex mt-[10px]">
        <div class="font-bold flex-[1_1_0%]">{{ $t("tour_detail.purpose_of_use") }}</div>
        <div class="flex-[5_5_0%]">{{ detailTour.use_purpose }}</div>
      </div>
      <div class="flex mt-[10px]">
        <div class="font-bold flex-[1_1_0%]">{{ $t("tour_detail.purpose_detail") }}</div>
        <div class="flex-[5_5_0%]">{{ detailTour.use_purpose_detail }}</div>
      </div>
      <div class="flex mt-[10px]">
        <div class="font-bold flex-[1_1_0%]">{{ $t("tour_detail.space_check") }}</div>
        <div class="flex-[5_5_0%]">{{ detailTour.check_list }}</div>
      </div>
    </div>
    <div class="flex justify-between items-center">
      <div class="flex-1">
        <div class="flex mt-[10px]">
          <div class="font-bold flex-[1_1_0%]">{{ $t("tour_detail.member_type") }}</div>
          <p class="flex-[2_2_0%]">{{ getUserTypeLabel(detailTour.membership_type) }}</p>
        </div>
        <div class="flex mt-[10px]">
          <div class="font-bold flex-[1_1_0%]">{{ $t("tour_detail.sex") }}</div>
          <p class="flex-[2_2_0%]">{{ detailTour.gender == 1 ? "男性" : "女性" }}</p>
        </div>
        <div class="flex mt-[10px]">
          <div class="font-bold flex-[1_1_0%]">{{ $t("tour_detail.name_conpany") }}</div>
          <p class="flex-[2_2_0%]">{{ detailTour.company_name }}</p>
        </div>
        <div class="flex mt-[10px]">
          <div class="font-bold flex-[1_1_0%]">{{ $t("tour_detail.phone_number") }}</div>
          <p class="flex-[2_2_0%]">{{ detailTour.phone }}</p>
        </div>
        <div class="flex mt-[10px]">
          <div class="font-bold flex-[1_1_0%]">{{ $t("tour_detail.address") }}</div>
          <p class="flex-[2_2_0%]">{{ detailTour.address }}</p>
        </div>
      </div>
      <div class="flex-1">
        <div class="flex mt-[10px]">
          <div class="font-bold flex-[1_1_0%]">{{ $t("tour_detail.name") }}</div>
          <p class="flex-[2_2_0%]">{{ detailTour.customer_name }}</p>
        </div>
        <div class="flex mt-[10px]">
          <div class="font-bold flex-[1_1_0%]">{{ $t("tour_detail.birthday") }}</div>
          <p class="flex-[2_2_0%]">{{ convertBirthday }}</p>
        </div>
        <div class="flex mt-[10px]">
          <div class="font-bold flex-[1_1_0%]">{{ $t("tour_detail.company_name") }}</div>
          <p class="flex-[2_2_0%]">{{ detailTour.company_name_kana }}</p>
        </div>
        <div class="flex mt-[10px]">
          <div class="font-bold flex-[1_1_0%]">{{ $t("tour_detail.email") }}</div>
          <p class="flex-[2_2_0%]">{{ detailTour.email }}</p>
        </div>
        <div class="flex mt-[10px]">
          <div class="font-bold flex-[1_1_0%]">{{ $t("tour_detail.registration_date") }}</div>
          <p class="flex-[2_2_0%]">{{ convertEntryDate }}</p>
        </div>
      </div>
    </div>
    <div class="mt-[10px]">
      <!-- <div class="text-[18px] text-center p-[15px] font-extrabold bg-[#ececec]">
        {{ $t("tour_detail.message_history") }}
      </div>
      <p class="mt-[5px]">{{ $t("tour_detail.noti") }}</p> -->
      <div class="inquiries-detail-message-history">
        <h2 class="mt-4 text-[18px] text-center p-[15px] font-extrabold bg-[#ececec]">
          {{ $t("tour_detail.message_history") }}
        </h2>
        <div class="grid inquiries-detail-reply" v-if="listReply && listReply.length > 0">
          <MessageHistory :listReply="listReply" />
        </div>
        <p v-else class="mt-[5px]">{{ $t("tour_detail.noti") }}</p>
      </div>
      <textarea
        v-model="valueReply"
        type="textarea"
        class="bg-[#ececec] outline-none p-[10px] w-[100%] border border-solid border-[#ccc] rounded mt-[5px] focus:border-[#66afe9] focus:shadow-md"
      />
    </div>
    <div>
      <button
        class="bg-[#ffbd00] text-[white] px-[10px] py-[8px] border border-solid border-[#ddd] rounded font-bold"
        @click="handleSubmit"
      >
        送信
      </button>
    </div>
  </div>
  <div>
    <transition name="fade" appear>
      <div class="modal-overlay" v-if="showModal" @click="showModal = false"></div>
    </transition>
    <transition name="pop" appear>
      <div class="modal" role="dialog" v-if="showModal">
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
                <option
                  v-for="(childAlternative, index) in Alternative.child"
                  :key="index"
                  :value="childAlternative.title"
                >
                  {{ childAlternative.title }}
                </option>
              </select>
              <div v-if="Alternative.type == 'calender_input' && showCalender" class="bg-[#bce8f1] p-[10px]">
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
    </transition>
  </div>
</template>

<script>
import { useRoute, useRouter } from "vue-router";
import ChoiceDateVue from "@/components/TourManagement/Tour/ChoiceDate.vue";
import { ref, inject, watch, computed } from "vue";
import { getDetailTourApi, getListTourReplyApi, addTourReplyApi, postNoneApprovalTour } from "@/api";
import { useI18n } from "vue-i18n";
import { useStore } from "vuex";
import { MODULE_STORE, ROUTER_PATH, ROUTE_NAME } from "@/const";
import MessageHistory from "./MessageHistory.vue";
import DatePicker from "vue3-datepicker";
import moment from "moment";
import { convertDateOfBirth, convertDate } from "@/utils";
export default {
  name: "TourDetail",
  components: {
    ChoiceDateVue,
    DatePicker,
    MessageHistory,
  },
  setup() {
    const route = useRoute();
    const router = useRouter();
    const store = useStore();
    const choiceDate = ref("");
    const choiceTime = ref("");
    const showBorder = ref(false);
    const showMargin = ref(false);
    const detailTour = ref({});
    const id = route.params.id;
    const { t } = useI18n();
    const toast = inject("$toast");
    const showCalender = ref(true);
    const selected = ref(t("tour_detail.reason1"));
    const showModal = ref(false);
    const listReply = ref([]);
    const valueReply = ref();
    const idReply = ref();
    const tourDate = ref();
    const formDate = ref({
      substitute_first_choice_date: null,
      substitute_first_choice_time: null,
      substitute_second_choice_date: null,
      substitute_second_choice_time: null,
      substitute_third_choice_date: null,
      substitute_third_choice_time: null,
    });
    const replaceStatus = (stringValue) => {
      if (stringValue) {
        return stringValue.replace(/_/g, " ");
      }
    };
    const convertBirthday = computed(() => {
      return convertDateOfBirth(detailTour.value?.customer?.birthday) || "";
    });
    const convertEntryDate = computed(() => {
      return convertDate(detailTour.value?.customer?.registration_date) || "";
    });
    const getDetailTour = async () => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const res = await getDetailTourApi(id);
        detailTour.value = res;

        getListTourReply(detailTour.value.id);
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    getDetailTour();

    const getListTourReply = async (id) => {
      try {
        const res = await getListTourReplyApi(id);

        listReply.value = res.data;
        // customer_name.value = listReply.value[0].customer_name;
      } catch (errors) {
        // const error = errors.message || t("common.has_error");
        // toast.error(error);
      } finally {
        // store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };

    const AlternativeList = [
      {
        id: 1,
        title: t("tour_detail.reason"),
        required: true,
        type: "select_input",
        child: [
          {
            id: 1,
            title: t("tour_detail.reason1"),
          },
          {
            id: 2,
            title: t("tour_detail.reason2"),
          },
          {
            id: 3,
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
    watch(selected, (value) => {
      if (value === t("tour_detail.reason1")) {
        showCalender.value = true;
      } else {
        showCalender.value = false;
      }
    });
    const approvalConfirm1 = (item) => {
      const itemData = { ...item, tourDate: tourDate.value };
      if (confirm("リクエストを承認します。よろしいですか？")) {
        if (tourDate.value) {
          store.commit(`tour/setTourDetailItem`, itemData);
          router.push(`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.TOUR}/${ROUTER_PATH.APPROVAL_CONFIRM_TOUR}`);
        } else {
          alert("見学日時を選択してください。");
        }
      }
    };
    const radioOption = [
      { val: "1", label: "すべて" },
      { val: "2", label: "法人利用" },
      { val: "3", label: "個人利用" },
      { val: "4", label: "未選択" },
    ];
    const getUserTypeLabel = (val) => {
      return radioOption.find((c) => c.val == val)?.label || "すべて";
    };
    const postDataNoneApproval = async (data) => {
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
            (params.substitute_first_choice_time = moment(formDate.value.substitute_first_choice_time).format("HH:mm"));
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
            (params.substitute_third_choice_time = moment(formDate.value.substitute_third_choice_time).format("HH:mm"));
        }

        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        await postNoneApprovalTour(params, id);
        router.push({ name: ROUTE_NAME.ADMIN.TOUR_LIST });
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    const handleSubmit = () => {
      const addTourReply = async (data) => {
        try {
          await addTourReplyApi(data);
          getListTourReply(detailTour.value.id);
          valueReply.value = "";
        } catch (errors) {
          const error = errors.message || t("common.has_error");
          toast.error(error);
        } finally {
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
        }
      };
      addTourReply({
        tour_id: detailTour.value.id,
        description: valueReply.value,
      });
    };
    const confirmChoiceDate = (date) => {
      tourDate.value = date;
    };
    return {
      showModal,
      id,
      choiceDate,
      showBorder,
      showMargin,
      getDetailTour,
      detailTour,
      choiceTime,
      replaceStatus,
      AlternativeList,
      showCalender,
      selected,
      approvalConfirm1,
      formDate,
      postDataNoneApproval,
      listReply,
      valueReply,
      handleSubmit,
      idReply,
      getListTourReply,
      tourDate,
      confirmChoiceDate,
      getUserTypeLabel,
      convertBirthday,
      convertEntryDate,
    };
  },
};
</script>

<style lang="scss" scoped>
.button-modal {
  border: none;
  color: #fff;
  background: #42b983;
  appearance: none;
  font: inherit;
  font-size: 1.8rem;
  padding: 0.5em 1em;
  border-radius: 0.3em;
  cursor: pointer;
}

.modal {
  position: absolute;
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  margin: auto;
  text-align: center;
  width: fit-content;
  height: fit-content;
  max-width: 21rem;
  padding: 2rem;
  border-radius: 1rem;
  box-shadow: 0 5px 5px rgba(0, 0, 0, 0.2);
  background: #fff;
  z-index: 999;
  transform: none;
}
.modal h1 {
  margin: 0 0 1rem;
}

.modal-overlay {
  content: "";
  position: absolute;
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  z-index: 998;
  background: #2c3e50;
  opacity: 0.6;
  cursor: pointer;
}

/* ---------------------------------- */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 1s ease-out;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

.pop-enter-active,
.pop-leave-active {
  transition: transform 0.4s cubic-bezier(0.5, 0, 0.5, 1), opacity 0.4s linear;
}

.pop-enter-from,
.pop-leave-to {
  opacity: 0;
  transform: scale(0.3) translateY(-50%);
}
.inquiries-detail-message-history {
  margin: 18px 0 20px;
}
// .inquiries-detail-message-history h2 {
//   text-align: center;
//   padding: 10px 0px;
//   background-color: #ffc07f;
// }
.inquiries-detail-reply {
  height: 500px;
  overflow-y: scroll;
  border: 1px solid #f1f1f1;
}
</style>
