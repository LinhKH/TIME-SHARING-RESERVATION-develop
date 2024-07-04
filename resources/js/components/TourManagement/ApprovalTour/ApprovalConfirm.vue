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

                  <div class="min-w-[200px]">
                    <div>
                      <label
                        class="mt-1.5 border border-solid border-[#ccc] p-1.5 rounded font-medium inline-block flex items-center"
                      >
                        <span class="font-bold">{{ tourItem[tourItem.tourDate] }}</span>
                      </label>
                    </div>
                  </div>
                  <!-- <ChoiceDateVue :option="tourItem" @confirmChoiceDate="confirmChoiceDate" /> -->
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
    <div class="w-[100%] text-center mt-[20px]">
      <button
        @click="() => postDataApproval(tourItem)"
        class="button btn-approval w-[90%] py-3 px-9 border border-solid border-[#ccc] rounded mb-1 text-[#fff] cursor-pointer bg-[#52c195]"
      >
        {{ $t("tour_manager.approval") }}
      </button>
    </div>
  </div>
</template>
<script>
import { useI18n } from "vue-i18n";
import { useRouter, useRoute } from "vue-router";
import { ref, inject, onMounted } from "vue";
import { ROUTER_PATH, MODULE_STORE, ROUTE_NAME } from "@/const";
import ChoiceDateVue from "@/components/TourManagement/Tour/ChoiceDate.vue";
import { postApprovalTour } from "@/api";
import { useStore } from "vuex";

export default {
  name: "ApprovalConfirm",
  components: {
    ChoiceDateVue,
  },

  setup(props, { emit }) {
    const { t } = useI18n();
    const choiceDate = ref("123");
    const router = useRouter();
    const route = useRoute();
    const toast = inject("$toast");
    const store = useStore();
    const tourItem = ref();
    const tour_date = ref();
    tourItem.value = store.getters[`tour/getTourDetailItem`];
    const tourHeaders = [
      t("tour_manager.id_tour"),
      t("tour_manager.space_name"),
      t("tour_manager.space_content"),
      t("tour_manager.status"),
    ];
    const postDataApproval = async (item) => {
      try {
        const params = {
          _method: "PUT",
          tour_date: item.tourDate,
        };
        const id = item.id;
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        if (item.tourDate) {
          await postApprovalTour(params, id);
        }
        router.push({ name: ROUTE_NAME.ADMIN.TOUR_LIST });
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    const confirmChoiceDate = (date) => {
      tour_date.value = date;
    };
    return {
      tourHeaders,
      choiceDate,
      postDataApproval,
      tourItem,
      confirmChoiceDate,
      tour_date,
    };
  },
};
</script>

<style></style>
