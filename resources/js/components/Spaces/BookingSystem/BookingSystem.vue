<template>
  <HeaderSpaces
    :title="'予約システム登録'"
    :textHelp="$t('booking_system_components.text_help_1')"
    :textLink="$t('spaces_image_page.preview_of_public_page')"
    :textHelpTop="$t('spaces_image_page.text_desc_1')"
  />
  <!-- <LayoutInput
    customCss="mt-5"
    :labelText="$t('booking_system_components.text_label_2')"
    iconPrev="fa fa-check-circle-o mr-1"
  >
    <span class="text-[#8a6d3b]">
      {{ $t("booking_system_components.text_help_2") }}
    </span>
  </LayoutInput> -->

  <LayoutInput
    customCss="mt-5"
    :isRequired="true"
    :labelText="$t('booking_system_components.text_label_1')"
    iconPrev="fa fa-file-text-o mr-1"
  >
  </LayoutInput>

  <LayoutInput customCss="mt-5">
    <div class="flex items-center h-[21px]">
      <input
        type="checkbox"
        v-model="agreeingToTerms"
        :true-value="BOOLEAN.YES"
        :false-value="BOOLEAN.NO"
        id="agreeing_to_terms_id"
      />
      <label for="agreeing_to_terms_id" class="font-bold ml-1 select-none">{{
        $t("booking_system_components.text_label_3")
      }}</label>
      <button
        v-if="fasle"
        class="block ml-auto mr-4 py-1 px-2 bg-white border border-solid border-[#ccc] rounded hover:bg-[#ccc] hover:border-[#959494]"
      >
        {{ $t("booking_system_components.open_new_page") }}
      </button>
    </div>
  </LayoutInput>
  <LayoutInput customCss="mt-5" :isRequired="true" :labelText="'スペースの利用規約'" iconPrev="fa fa-file-text-o mr-1">
    <input type="textarea" :value="terms" readonly class="w-[98%]" />
    <div>このレンタルスペースの利用規約を記載してください。「規約等」からいつでも編集できます。</div>
  </LayoutInput>
  <ButtonNextStep :nextPage="'オプション登録'" @onBack="handleBack" @onNext="handleNext" />
</template>

<script>
import HeaderSpaces from "@/components/HeaderSpaces";
import ButtonNextStep from "@/components/Buttons/ButtonNextStep";
import LayoutInput from "@/components/Layouts/LayoutInput.vue";
import { ROUTER_PATH, MODULE_STORE, STEP_CREATE_SPACE, BOOLEAN, STEP_SPACE_CREATED } from "@/const";
import { postSpaceBookingSystem, getDetailSpaceBookingSystem, getDetailSpaceGeneral } from "@/api";
import { ref, inject, computed } from "vue";
import { useStore } from "vuex";
import { useRouter, useRoute } from "vue-router";
import { useI18n } from "vue-i18n";

export default {
  name: "BookingSystem",
  components: {
    HeaderSpaces,
    ButtonNextStep,
    LayoutInput,
  },
  setup() {
    const terms = ref("");
    const agreeingToTerms = ref(BOOLEAN.NO);
    const store = useStore();
    const route = useRoute();
    const idSpace = route.params.id || route.query.id;
    const { t } = useI18n();
    const router = useRouter();
    const toast = inject("$toast");
    const isCreated =
      store.getters[`${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.GETTERS.GET_STEP_SPACE_CREATED}`] >
      STEP_CREATE_SPACE.BOOKING_SYSTEM;

    const handleNext = async () => {
      if (isCreated) {
        router.push(`${ROUTER_PATH.SPACE.RESERVATION_OPTIONS}?id=${idSpace}`);
        return;
      }
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        await postSpaceBookingSystem({ agreeing_to_terms: agreeingToTerms.value }, idSpace);
        store.commit(
          `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.MUTATIONS.SET_STEP_SPACE_CREATED}`,
          STEP_SPACE_CREATED["reservation-options"]
        );
        router.push(`${ROUTER_PATH.SPACE.RESERVATION_OPTIONS}?id=${idSpace}`);
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };

    const handleBack = () => {
      router.push(`${ROUTER_PATH.SPACE.EQUIPMENT_INFORMATION}?id=${idSpace}`);
    };
    const initData = async () => {
      if (isCreated) {
        try {
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
          const res = await getDetailSpaceBookingSystem(idSpace);
          agreeingToTerms.value = res.data?.agreeing_to_terms;
        } catch (errors) {
          const error = errors.message || t("common.has_error");
          toast.error(error);
        } finally {
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
        }
      }
      store.dispatch(
        `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.ACTIONS.SET_ACTIVE}`,
        STEP_CREATE_SPACE.BOOKING_SYSTEM
      );
    };
    const initUpdate = async () => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const id = idSpace;
        const res = await getDetailSpaceGeneral(id);
        terms.value = res.data.general_space_information_terms_of_service;
      } catch (error) {
        toast.error(error.message);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    initUpdate();
    initData();
    return {
      agreeingToTerms,
      handleNext,
      handleBack,
      BOOLEAN,
      terms,
    };
  },
};
</script>

<style scoped>
input[type="textarea"] {
  border: 1px solid #999;
  outline: none;
  resize: both;
  border-radius: 4px;
  padding: 10px;
}
</style>
