<template>
  <HeaderSpaces
    v-if="!isUpdate"
    :title="$t('spaces_image_page.equipment_information_registration')"
    :textHelp="$t('equipment_information_components.title')"
    :textLink="$t('spaces_image_page.preview_of_public_page')"
    :textHelpTop="$t('spaces_image_page.text_desc_1')"
  />
  <p
    class="text-[#3c763d] px-[10px] py-[15px] bg-[#dff0d8] border border-solid border-[#d6e9c6] mt-[10px]"
    v-if="checkSuccess && !!isUpdate"
  >
    <i class="fa fa-check text-[#3c763d]" aria-hidden="true"></i> {{ $t("reservation_system.update_success") }}
  </p>
  <div class="w-full border border-solid border-[#ddd] mt-3">
    <BasicInformation v-model="formDataBasicInfo" />
    <GeneralEquipment v-model="formDataGeneralEquipment" />
    <ConferenceEquipment v-model="formDataConferenceEquipment" />
    <ShootingEquipment v-model="formDataShootingEquipment" />
    <EventEquipment v-model="formDataEventEquipment" />
    <PartyEquipment v-model="formDataPartyEquipment" />
    <Share v-model="formDataShare" />
  </div>
  <div class="w-full text-center" v-if="!!isUpdate">
    <button
      class="px-[15px] py-[8px] bg-[#ffbd00] mt-[10px] rounded text-[white] hover:translate-y-1 transition-all"
      @click="saveInfo"
    >
      保存
    </button>
  </div>
  <ButtonNextStep :nextPage="'予約システム登録'" @onBack="handleBack" @onNext="handleNext" v-else />
</template>

<script>
import HeaderSpaces from "@/components/HeaderSpaces";
import ButtonNextStep from "@/components/Buttons/ButtonNextStep";
import { ROUTER_PATH, STEP_CREATE_SPACE } from "@/const";
import { useRouter, useRoute, onBeforeRouteLeave } from "vue-router";
import { inject, computed, ref, onMounted, watch } from "vue";
import { useStore } from "vuex";
import { MODULE_STORE, ACTIONS_TYPE, FORM_DATA_GENERAL_FROM_API, STEP_SPACE_CREATED } from "@/const";
import { postSpaceEquipment, getDetailSpaceEquipmentInfo } from "@/api";
import useEquipmentInformation from "@/uses/equipmentInformation";
import { useI18n } from "vue-i18n";

import BasicInformation from "./child/BasicInformation.vue";
import GeneralEquipment from "./child/GeneralEquipment.vue";
import ConferenceEquipment from "./child/ConferenceEquipment.vue";
import ShootingEquipment from "./child/ShootingEquipment.vue";
import EventEquipment from "./child/EventEquipment.vue";
import PartyEquipment from "./child/PartyEquipment.vue";
import Share from "./child/Share.vue";

export default {
  name: "EquipmentInformation",
  components: {
    HeaderSpaces,
    ButtonNextStep,
    BasicInformation,
    GeneralEquipment,
    ConferenceEquipment,
    ShootingEquipment,
    EventEquipment,
    PartyEquipment,
    Share,
  },
  props: {
    actionType: String,
    dataFill: Object,
  },
  setup(props) {
    const router = useRouter();
    const store = useStore();
    const isUpdate = computed(() => props.actionType === ACTIONS_TYPE.UPDATE);
    const route = useRoute();
    const { t } = useI18n();
    const checkSuccess = ref(false);
    const idSpace = route.params.id || route.query.id;
    const isCreated =
      store.getters[`${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.GETTERS.GET_STEP_SPACE_CREATED}`] >
      STEP_CREATE_SPACE.EQUIPMENT_INFORMATION;
    const toast = inject("$toast");
    const {
      formDataBasicInfo,
      formDataGeneralEquipment,
      formDataConferenceEquipment,
      formDataShootingEquipment,
      formDataEventEquipment,
      formDataShare,
      formDataPartyEquipment,
    } = useEquipmentInformation();

    const formData = computed(() => {
      return {
        formDataBasicInfo,
        formDataGeneralEquipment,
        formDataConferenceEquipment,
        formDataShootingEquipment,
        formDataEventEquipment,
        formDataShare,
        formDataPartyEquipment,
      };
    });
    const formIsDirty = ref(false);
    onMounted(() => {
      watch(
        formData,
        (val) => {
          formIsDirty.value = true;
        },
        { deep: true }
      );
    });
    onBeforeRouteLeave((to, from, next) => {
      if (props.actionType != ACTIONS_TYPE.UPDATE) {
        next();
        return
      }
      if (formIsDirty.value) {
        if (confirm("このサイトを離れますか？\n行った変更が保存されない可能性があります")) {
          next();
        } else {
          next(false);
        }
      } else {
        next();
      }
    });

    const mapData = (
      arrayData,
      {
        formDataBasicInfo,
        formDataGeneralEquipment,
        formDataConferenceEquipment,
        formDataShootingEquipment,
        formDataEventEquipment,
        formDataShare,
        formDataPartyEquipment,
      }
    ) => {
      Object.keys(arrayData).forEach((item) => {
        switch (item) {
          case FORM_DATA_GENERAL_FROM_API.EQUIPMENT_BASIC_INFORMATION:
            Object.keys(formDataBasicInfo).forEach((itemBasicInfo) => {
              formDataBasicInfo[itemBasicInfo] = arrayData[item][itemBasicInfo];
            });
            break;
          case FORM_DATA_GENERAL_FROM_API.EQUIPMENT_GENERAL_INFORMATION:
            Object.keys(formDataGeneralEquipment).forEach((itemGeneral) => {
              formDataGeneralEquipment[itemGeneral] = arrayData[item][itemGeneral];
            });
            break;
          case FORM_DATA_GENERAL_FROM_API.EQUIPMENT_CONFERENCE_INFORMATION:
            Object.keys(formDataConferenceEquipment).forEach((itemConference) => {
              formDataConferenceEquipment[itemConference] = arrayData[item][itemConference];
            });
            break;
          case FORM_DATA_GENERAL_FROM_API.EQUIPMENT_SHOOTING_INFORMATION:
            Object.keys(formDataShootingEquipment).forEach((itemShooting) => {
              formDataShootingEquipment[itemShooting] = arrayData[item][itemShooting];
            });
            break;
          case FORM_DATA_GENERAL_FROM_API.EQUIPMENT_EVENT_INFORMATION:
            Object.keys(formDataEventEquipment).forEach((itemEventEquipment) => {
              formDataEventEquipment[itemEventEquipment] = arrayData[item][itemEventEquipment];
            });
            break;
          case FORM_DATA_GENERAL_FROM_API.EQUIPMENT_PARTY_INFORMATION:
            Object.keys(formDataPartyEquipment).forEach((itemPartyEquipment) => {
              formDataPartyEquipment[itemPartyEquipment] = arrayData[item][itemPartyEquipment];
            });
            break;
          case FORM_DATA_GENERAL_FROM_API.EQUIPMENT_SHARE_INFORMATION:
            Object.keys(formDataShare).forEach((itemShare) => {
              formDataShare[itemShare] = arrayData[item][itemShare];
            });
            break;
          default:
            break;
        }
      });
    };
    if (isUpdate && props.dataFill) {
      mapData(props.dataFill, {
        formDataBasicInfo,
        formDataGeneralEquipment,
        formDataConferenceEquipment,
        formDataShootingEquipment,
        formDataEventEquipment,
        formDataShare,
        formDataPartyEquipment,
      });
    }
    const handleBack = () => {
      router.push(`${ROUTER_PATH.SPACE.IMAGES}?id=${idSpace}`);
    };
    const handleNext = async () => {
      // if (isCreated) {
      //   router.push(`${ROUTER_PATH.SPACE.BOOKING_SYSTEM}?id=${idSpace}`);
      //   return;
      // }
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        await postSpaceEquipment(
          {
            ...formDataBasicInfo,
            ...formDataGeneralEquipment,
            ...formDataConferenceEquipment,
            ...formDataShootingEquipment,
            ...formDataEventEquipment,
            ...formDataShare,
            ...formDataPartyEquipment,
          },
          idSpace
        );
        if (!isCreated) {
          store.commit(
            `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.MUTATIONS.SET_STEP_SPACE_CREATED}`,
            STEP_SPACE_CREATED["booking-system"]
          );
        }
        formIsDirty.value = false
        router.push(`${ROUTER_PATH.SPACE.BOOKING_SYSTEM}?id=${idSpace}`);
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    const scrollToTop = () => {
      window.scrollTo({
        top: 0,
        behavior: "smooth",
      });
    };
    const saveInfo = async () => {
      // if (isCreated) {
      //   router.push(`${ROUTER_PATH.SPACE.BOOKING_SYSTEM}?id=${idSpace}`);
      //   return;
      // }
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        await postSpaceEquipment(
          {
            ...formDataBasicInfo,
            ...formDataGeneralEquipment,
            ...formDataConferenceEquipment,
            ...formDataShootingEquipment,
            ...formDataEventEquipment,
            ...formDataShare,
            ...formDataPartyEquipment,
          },
          idSpace
        );
        // store.commit(
        //   `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.MUTATIONS.SET_STEP_SPACE_CREATED}`,
        //   STEP_SPACE_CREATED["booking-system"]
        // );
        // router.push(`${ROUTER_PATH.SPACE.BOOKING_SYSTEM}?id=${idSpace}`);
        checkSuccess.value = true;
        formIsDirty.value = false
        scrollToTop();
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    const initData = async () => {
      if (isCreated) {
        try {
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
          const res = await getDetailSpaceEquipmentInfo(idSpace);
          mapData(res.data, {
            formDataBasicInfo,
            formDataGeneralEquipment,
            formDataConferenceEquipment,
            formDataShootingEquipment,
            formDataEventEquipment,
            formDataShare,
            formDataPartyEquipment,
          });
        } catch (errors) {
          const error = errors.message || t("common.has_error");
          toast.error(error);
        } finally {
          store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
        }
      }
      store.dispatch(
        `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.ACTIONS.SET_ACTIVE}`,
        STEP_CREATE_SPACE.EQUIPMENT_INFORMATION
      );
    };

    initData();

    return {
      handleBack,
      handleNext,
      formDataBasicInfo,
      formDataConferenceEquipment,
      formDataGeneralEquipment,
      formDataShootingEquipment,
      formDataEventEquipment,
      formDataShare,
      formDataPartyEquipment,
      isUpdate,
      saveInfo,
      scrollToTop,
      checkSuccess,
    };
  },
};
</script>

<style scoped></style>
