<template>
  <div class="text-[18px] mt-3 mb-4">{{ $t("booking_system_advanced_setting.advanced_reservation_settings") }}</div>

  <LayoutInput
    :labelText="$t('booking_system_advanced_setting.last_minute_discount')"
    iconPrev="fa fa-level-down mr-1"
    customCss="mt-2"
  >
    <div class="flex w-full h-9 rounded border border-solid border-[#ddd]">
      <div class="w-10 h-full flex items-center justify-center border-r border-solid border-[#ddd] bg-[#eee]">
        <input
          type="checkbox"
          v-model="formData.enable_last_minute_discount"
          id="js-checkbox-enable-last-minute"
          :true-value="BOOLEAN.YES"
          :false-value="BOOLEAN.NO"
        />
      </div>
      <label for="js-checkbox-enable-last-minute" class="flex-1 pl-2 leading-9 font-bold select-none shadow-inner"
        >{{ $t("booking_system_advanced_setting.activate_last_minute_discount") }}
      </label>
    </div>
    <div class="my-1 text-[#737373]">
      {{ $t("booking_system_advanced_setting.minute_deals") }}
    </div>
    <div class="text-[#737373]">
      {{ $t("booking_system_advanced_setting.discount_settings") }}
    </div>
    <div class="" v-if="formData.enable_last_minute_discount === BOOLEAN.YES">
      <LayoutInput :labelText="$t('booking_system_advanced_setting.start_discount')">
        <div class="w-[252px]">
          <Input
            :label="$t('booking_system_advanced_setting.day_before')"
            type="number"
            min="0"
            inputKey="last_minute_book_discount_days_before_count"
            @changeValue="handleInput"
            :inputText="formData.last_minute_book_discount_days_before_count"
          />
          <MessagesFormError :messages="errorFormDiscountCount" />
        </div>
        <div class="mt-1 text-[#737373]">{{ $t("booking_system_advanced_setting.set_in_days") }}</div>
        <div class="mt-1 text-[#737373]">{{ $t("booking_system_advanced_setting.set_how_many") }}</div>
      </LayoutInput>
      <LayoutInput :labelText="$t('booking_system_advanced_setting.discount_rate')">
        <div class="w-[252px]">
          <Input
            label="%"
            type="number"
            min="0"
            inputKey="last_minute_book_discount_percentage"
            @changeValue="handleInput"
            :inputText="formData.last_minute_book_discount_percentage"
          />
          <MessagesFormError :messages="errorFormDiscountPercentage" />
        </div>
        <div class="mt-1 text-[#737373]">{{ $t("booking_system_advanced_setting.set_discount_rate") }}</div>
        <div class="mt-1 text-[#737373]">{{ $t("booking_system_advanced_setting.set_the_percentage") }}</div>
        <div class="mt-1 text-[#737373]">
          {{ $t("booking_system_advanced_setting.other_discounts_may") }}
        </div>
      </LayoutInput>
    </div>
  </LayoutInput>

  <LayoutInput
    :labelText="$t('booking_system_advanced_setting.tracking_url')"
    iconPrev="fa fa-link mr-1"
    customCss="mt-2"
  >
    <template v-if="listTrackingLinks.length">
      <div class="font-bold">{{ $t("booking_system_advanced_setting.create_tracking") }}</div>
      <div class="text-[#737373] my-4">
        <div class="font-bold">{{ $t("booking_system_advanced_setting.after_creating") }}</div>
      </div>
      <button class="p-2 rounded hover:translate-y-1 bg-[#ffbd00] block mt-3 mb-1" @click="handleAddTrackingLink">
        <i class="fa fa-plus text-white mr-1" aria-hidden="true"></i>
        <span class="text-white">{{ $t("booking_system_advanced_setting.add_new") }}</span>
      </button>
      <table class="w-full">
        <tr>
          <th class="w-[30%]">{{ $t("booking_system_advanced_setting.tracking_url_name") }}</th>
          <th class="w-3/5">{{ $t("booking_system_advanced_setting.tracking_url") }}</th>
          <th class="w-[10%]"></th>
        </tr>
        <tr v-for="(item, index) in listTrackingLinks" :key="index">
          <td>{{ item.tracking_link_name }}</td>
          <td>
            <div class="">
              <i class="fa fa-link mr-1"></i>
              <span>{{ $t("booking_system_advanced_setting.link_space_top_page") }}</span>
            </div>

            <div class="flex rounded border border-solid border-[#ddd] w-full h-11 my-2">
              <div class="flex-1 h-full">
                <textarea
                  name=""
                  id="topTrackingLink"
                  :value="item.tracking_link_to_space_top_page"
                  readonly
                  class="shadow-inner bg-[#eee] w-full h-full outline-none focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 resize-none p-2"
                />
              </div>
              <div
                class="w-[52px] h-full bg-[#ffbd00] flex items-center justify-center cursor-pointer"
                @click="() => handleCopyToClipboard('topTrackingLink')"
              >
                <i class="fa fa-files-o text-white"></i>
              </div>
            </div>

            <div class="">
              <i class="fa fa-link mr-1"></i>
              <span> {{ $t("booking_system_advanced_setting.link_space_reservation_page") }}</span>
            </div>

            <div class="flex rounded border border-solid border-[#ddd] w-full h-11 my-2">
              <div class="flex-1 h-full">
                <textarea
                  name=""
                  id="bottomTrackingLink"
                  readonly
                  :value="item.tracking_link_to_space_reservation_page"
                  class="shadow-inner bg-[#eee] w-full h-full outline-none focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 resize-none p-2"
                />
              </div>
              <div
                class="w-[52px] h-full bg-[#ffbd00] flex items-center justify-center cursor-pointer"
                @click="() => handleCopyToClipboard('bottomTrackingLink')"
              >
                <i class="fa fa-files-o text-white"></i>
              </div>
            </div>
          </td>
          <td>
            <div
              @click="handleEditLink(item.id)"
              class="w-full py-2 flex justify-center border border-solid border-[#ddd] rounded cursor-pointer hover:bg-[#eee]"
            >
              <i class="fa fa-pencil"></i>
            </div>
          </td>
        </tr>
      </table>
      <div class="text-[#737373] my-5">{{ $t("booking_system_advanced_setting.a_mark") }}</div>
    </template>
    <template v-else>
      <div class="font-bold">{{ $t("booking_system_advanced_setting.can_create_tracking") }}</div>
      <div class="text-[#737373] my-3">
        {{ $t("booking_system_advanced_setting.text_help") }}
      </div>
      <div>
        {{ $t("booking_system_advanced_setting.no_tracking")
        }}<span class="text-[#337ab7] hover:underline cursor-pointer" @click="handleAddTrackingLink"
          >{{ $t("booking_system_advanced_setting.create_new") }}
        </span>
      </div>
    </template>
    <div v-if="isAdding">
      <div class="w-fit mx-auto">
        <button class="text-white p-2 bg-[#898989] rounded-xl mr-2" @click="handleBack">
          {{ $t("common.return") }}
        </button>
        <button class="text-white p-2 bg-[#ffbd00] rounded" @click="handlePostBookingAdvanced">
          {{ $t("common.keep") }}
        </button>
      </div>
    </div>
    <div v-else>
      <button class="block mx-auto text-white p-2 bg-[#ffbd00] rounded" @click="handlePostBookingAdvanced">
        {{ $t("common.keep") }}
      </button>
    </div>
  </LayoutInput>
</template>

<script>
import { useStore } from "vuex";
import { MODULE_STORE, STEP_EDIT_SPACE, STEP_CREATE_SPACE, ROUTER_PATH, BOOLEAN } from "@/const";
import LayoutInput from "@/components/Layouts/LayoutInput.vue";
import { getDetailTrackLink, postBookingSystemAdvanced, getDetailBookingSystemAdvanced } from "@/api";
import { useRouter, useRoute } from "vue-router";
import { inject, reactive, ref } from "vue";
import { useI18n } from "vue-i18n";
import Input from "@/components/Form/Input.vue";
import MessagesFormError from "@/components/MessagesForm";

export default {
  name: "BookingSystemAdvancedSetting",
  components: { LayoutInput, Input, MessagesFormError },
  props: {
    isAdding: {
      type: Boolean,
      default: false,
    },
  },
  setup(props) {
    const store = useStore();
    const route = useRoute();
    const router = useRouter();
    const idSpace = route.params.id || route.query.id;
    const toast = inject("$toast");
    const { t } = useI18n();
    const listTrackingLinks = ref([]);
    const errorFormDiscountCount = ref(null);
    const errorFormDiscountPercentage = ref(null);
    const formData = reactive({
      enable_last_minute_discount: null,
      last_minute_book_discount_days_before_count: null,
      last_minute_book_discount_percentage: null,
    });

    const handleCopyToClipboard = (idInputElement) => {
      const inputElement = document.getElementById(idInputElement);
      inputElement.select();
      navigator.clipboard.writeText(inputElement.value);
    };
    const handleAddTrackingLink = () => {
      if (props.isAdding) {
        router.push(`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}/${ROUTER_PATH.SPACE.ADD_TRACKING_LINK}/${idSpace}`);
      } else {
        router.push(
          `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}/${ROUTER_PATH.RENTAL_PLAN}/${ROUTER_PATH.SPACE.DETAIL_ADD_TRACKING_LINK}/${idSpace}`
        );
      }
    };

    const initData = async () => {
      if (props.isAdding) {
        store.dispatch(
          `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.ACTIONS.SET_ACTIVE}`,
          STEP_CREATE_SPACE.PLAN_CREATION
        );
      } else {
        store.dispatch(
          `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.ACTIONS.SET_ACTIVE_EDIT}`,
          STEP_EDIT_SPACE.RESERVATION_SYSTEM
        );
      }
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const res = await getDetailTrackLink(idSpace);
        const detailBookingSystemAdvanced = await getDetailBookingSystemAdvanced(idSpace);
        formData.enable_last_minute_discount = detailBookingSystemAdvanced.data.enable_last_minute_discount;
        formData.last_minute_book_discount_days_before_count =
          detailBookingSystemAdvanced.data.last_minute_book_discount_days_before_count;
        formData.last_minute_book_discount_percentage =
          detailBookingSystemAdvanced.data.last_minute_book_discount_percentage;
        listTrackingLinks.value = res.data;
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    const handleInput = ({ key, value }) => {
      formData[key] = value;
      errorFormDiscountCount.value = null;
      errorFormDiscountPercentage.value = null;
    };

    const handleEditLink = linkId => {
      router.push({name: 'AdminEditTrackingUrl', params:{spaceId: idSpace, linkId}})
    }

    const handleBack = () => {
      if (props.isAdding) {
        router.push(
          `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}/${ROUTER_PATH.ADD}/${ROUTER_PATH.RENTAL_PLAN}?id=${idSpace}`
        );
      } else {
        router.push(
          `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}/${ROUTER_PATH.RENTAL_PLAN}/${ROUTER_PATH.SPACE.RESERVATION_SYSTEM}/${idSpace}`
        );
      }
    };

    const handlePostBookingAdvanced = async () => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        let params = {};
        if (formData.enable_last_minute_discount === BOOLEAN.YES) {
          params = {
            ...formData,
          };
        }
        await postBookingSystemAdvanced(idSpace, params);
        handleBack();
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
        errorFormDiscountCount.value = errors?.data?.find(
          (item) => item.key == "last_minute_book_discount_days_before_count"
        )?.messages[0];
        errorFormDiscountPercentage.value = errors?.data?.find(
          (item) => item.key == "last_minute_book_discount_percentage"
        )?.messages[0];
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    initData();
    return {
      handleCopyToClipboard,
      listTrackingLinks,
      handleAddTrackingLink,
      formData,
      BOOLEAN,
      Input,
      handleInput,
      handleBack,
      handlePostBookingAdvanced,
      errorFormDiscountCount,
      errorFormDiscountPercentage,
      handleEditLink
    };
  },
};
</script>

<style scoped>
td,
th {
  border: 1px solid #ddd;
  padding: 8px;
}
</style>