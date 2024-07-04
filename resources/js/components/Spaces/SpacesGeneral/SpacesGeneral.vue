<template>
  <div class="">
    <HeaderSpaces
      v-if="actionType === ACTIONS_TYPE.CREATE"
      :title="$t('spaces_general_page.space_information_input')"
      :textHelp="$t('spaces_general_page.register_space_information')"
    />
    <div class="mt-3 border border-[#ddd] border-solid w-full">
      <FormKit type="group" v-model="formData">
        <BasicInformation
          :messagesFormError="messagesFormError"
          :modelValue="formData"
          @updateBasicInfo="handleUpdateBasicInfo"
          :idGeneral="id"
          :statusValue="statusValue"
        />

        <Location @inputAddress="inputAddress" :messagesFormError="messagesFormError" />

        <SpaceInformation
          :general_space_information_cancellation_fee_rules="formData.general_space_information_cancellation_fee_rules"
          :messagesFormError="messagesFormError"
          @addNewCancellation="handleAddCancellation"
          @update:cancellation="formData.general_space_information_cancellation_fee_rules = $event"
          @delete:cancellation="formData.general_space_information_cancellation_fee_rules.splice($event, 1)"
          @validate:cancellation="isCancellationErr = $event"
        />

        <ContactInformation :messagesFormError="messagesFormError" />
      </FormKit>
    </div>
    <button
      v-if="actionType === ACTIONS_TYPE.CREATE"
      class="block w-fit p-2 bg-[#555] text-white mt-4 rounded-xl cursor-pointer mx-auto hover:translate-y-1 transition-all"
      @click="handleSubmit"
    >
      {{ $t("spaces_general_page.proceed_next_step") }}
    </button>
    <button
      v-else
      class="block w-fit p-2 bg-[#fdb93a] rounded text-white mt-4 cursor-pointer mx-auto hover:translate-y-1 transition-all"
      @click="handleSubmit"
    >
      {{ $t("common.keep") }}
    </button>
    <div v-if="actionType === ACTIONS_TYPE.UPDATE" class="text-center text-[#a94442] mb-[10px]">
      {{ $t("spaces_general_page.cant_delete") }}
    </div>
  </div>
</template>
<script>
import HeaderSpaces from "@/components/HeaderSpaces";
import BasicInformation from "./child/BasicInformation.vue";
import Location from "./child/Location.vue";
import SpaceInformation from "./child/SpaceInformation.vue";
import ContactInformation from "./child/ContactInformation.vue";
import { ROUTER_PATH } from "@/const";
import { reactive, inject, ref, watch, onMounted } from "vue";
import { useRouter, useRoute, onBeforeRouteLeave } from "vue-router";
import { useStore } from "vuex";
import { MODULE_STORE, STEP_CREATE_SPACE, STEP_SPACE_CREATED } from "@/const";
import { postSpaceGeneral, getDetailSpaceGeneral, updateSpaceGeneral } from "@/api";
import postalCode from "japan-postal-code";
import { ACTIONS_TYPE } from "@/const";
import { useI18n } from "vue-i18n";

export default {
  name: "SpacesGeneral",
  components: {
    HeaderSpaces,
    BasicInformation,
    Location,
    SpaceInformation,
    ContactInformation,
  },

  props: {
    actionType: {
      type: String,
      default: ACTIONS_TYPE.CREATE,
    },
  },
  async setup(props, context) {
    const router = useRouter();
    const route = useRoute();
    const store = useStore();
    const toast = inject("$toast");
    const id = route.params.id;
    const { t } = useI18n();
    const idSpaceCreated = route.params.id || route.query.id;
    const statusValue = ref();
    const isCreated =
      store.getters[`${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.GETTERS.GET_STEP_SPACE_CREATED}`] >
      STEP_CREATE_SPACE.GENERAL;
    const formData = reactive({
      general_basic_space_name_ja: null,
      general_basic_space_name_kana: null,
      general_basic_space_overview: null,
      general_basic_space_introduction: null,
      general_location_post_code: null,
      general_location_prefecture: null,
      general_location_municipality: null,
      general_location_address_ja: null,
      general_location_access_instruction_ja: null,
      general_space_information_minimum_capacity: null,
      general_space_information_maximum_capacity: null,
      general_space_information_spaciousness_description_ja: null,
      general_space_information_plan_ja: null,
      general_space_information_movie: null,
      general_space_information_terms_of_service: null,
      general_space_information_cancellation_policy: null,
      general_contact_operating_company_ja: null,
      general_contact_person_in_charge_ja: null,
      general_contact_phone_number_ja: null,
      general_contact_email: null,
      general_space_information_cancellation_fee_rules: [],
      general_basic_space_purpose_of_uses: [],
    });
    const messagesFormError = ref({});
    const isCancellationErr = ref(false);
    const formIsDirty = ref(false);
    const mapData = (formData, data) => {
      formData.general_basic_space_name_ja = data.general_basic_space_name_ja;
      formData.general_basic_space_name_kana = data.general_basic_space_name_kana;
      formData.general_basic_space_overview = data.general_basic_space_overview;
      formData.general_basic_space_introduction = data.general_basic_space_introduction;
      formData.general_location_post_code = data.general_location_post_code;
      formData.general_location_prefecture = data.general_location_prefecture;
      formData.general_location_municipality = data.general_location_municipality;
      formData.general_location_address_ja = data.general_location_address_ja;
      formData.general_location_access_instruction_ja = data.general_location_access_instruction_ja;
      formData.general_space_information_minimum_capacity = data.general_space_information_minimum_capacity;
      formData.general_space_information_maximum_capacity = data.general_space_information_maximum_capacity;
      formData.general_space_information_spaciousness_description_ja =
        data.general_space_information_spaciousness_description_ja;
      formData.general_space_information_plan_ja = data.general_space_information_plan_ja;
      formData.general_space_information_movie = data.general_space_information_movie;
      formData.general_space_information_terms_of_service = data.general_space_information_terms_of_service;
      formData.general_space_information_cancellation_policy = data.general_space_information_cancellation_policy;
      formData.general_contact_operating_company_ja = data.general_contact_operating_company_ja;
      formData.general_contact_person_in_charge_ja = data.general_contact_person_in_charge_ja;
      formData.general_contact_phone_number_ja = data.general_contact_phone_number_ja.toString();
      formData.general_contact_email = data.general_contact_email;
      formData.general_space_information_cancellation_fee_rules = data.general_space_information_cancellation_fee_rules;
      formData.general_basic_space_purpose_of_uses = data.general_basic_space_purpose_of_uses;
    };

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
        return;
      }
      if (formIsDirty.value) {
        if (confirm("このサイトを離れますか？\n行った変更が保存されない可能性があります")) {
          next();
        } else {
          next(false);
          return;
        }
      } else {
        next();
      }
    });
    const inputAddress = () => {
      if (formData.general_location_post_code.length === 7) {
        postalCode.get(formData.general_location_post_code, (address) => {
          formData.general_location_prefecture = address.prefecture;
          formData.general_location_municipality = address.city;
          formData.general_location_address_ja = address.area;
        });
      }
    };

    const handleSubmit = async () => {
      if (isCancellationErr.value) return;
      const general_space_information_cancellation_fee_rules =
        formData.general_space_information_cancellation_fee_rules.map((cancellation) => {
          return {
            start_day: cancellation.startDay,
            end_day: cancellation.endDay,
            percentage: cancellation.percentage,
            is_coupon_applicable:
              cancellation.isCouponApplicable && cancellation.isCouponApplicable != "off" ? "on" : "off",
          };
        });

      const general_basic_space_purpose_of_uses = formData.general_basic_space_purpose_of_uses.map((item) => {
        return {
          main_category: item.mainCategory,
          sub_category: item.subCategory,
          title_category: item.title_ja,
        };
      });
      const params = {
        organization_id: 1,
        general_basic_space_name_ja: formData.general_basic_space_name_ja,
        general_basic_space_name_kana: formData.general_basic_space_name_kana,
        general_basic_space_overview: formData.general_basic_space_overview,
        general_basic_space_introduction: formData.general_basic_space_introduction,
        general_basic_space_purpose_of_uses,
        general_location_post_code: formData.general_location_post_code,
        general_location_prefecture: formData.general_location_prefecture,
        general_location_municipality: formData.general_location_municipality,
        general_location_address_ja: formData.general_location_address_ja,
        general_location_access_instruction_ja: formData.general_location_access_instruction_ja,
        general_space_information_minimum_capacity: formData.general_space_information_minimum_capacity,
        general_space_information_maximum_capacity: formData.general_space_information_maximum_capacity,
        general_space_information_spaciousness_description_ja:
          formData.general_space_information_spaciousness_description_ja,
        general_space_information_plan_ja: formData.general_space_information_plan_ja,
        general_space_information_movie: formData.general_space_information_movie,
        general_space_information_terms_of_service: formData.general_space_information_terms_of_service,
        general_space_information_cancellation_fee_rules,
        general_space_information_cancellation_policy: formData.general_space_information_cancellation_policy,
        general_contact_operating_company_ja: formData.general_contact_operating_company_ja,
        general_contact_person_in_charge_ja: formData.general_contact_person_in_charge_ja,
        general_contact_phone_number_ja: formData.general_contact_phone_number_ja,
        general_contact_email: formData.general_contact_email,
      };
      const setDataLocation = async () => {
        await fetch(
          `https://maps.googleapis.com/maps/api/geocode/json?address=${formData.general_location_post_code}&key=AIzaSyBNYj1s4bkyi_o6Kh94nxXZOnHJEEhfUHw`
        )
          .then((res) => res.json())
          .then((data) => {
            if (data.results.length) {
              const checkJP = data.results.find((c) =>
                c.address_components[c.address_components.length - 1].short_name.includes("JP")
              );
              if (checkJP) {
                params.general_location_latitude = checkJP.geometry.location.lat;
                params.general_location_longitude = checkJP.geometry.location.lng;
              }
            }
          });
      };
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        await setDataLocation();
        if (isCreated) {
          await updateSpaceGeneral(idSpaceCreated, params);
          router.push(`${ROUTER_PATH.SPACE.IMAGES}?id=${idSpaceCreated}`);
        }
        if (props.actionType === ACTIONS_TYPE.UPDATE) {
          const res = await updateSpaceGeneral(idSpaceCreated, params);
          if (res.rental_space_id) {
            toast.success(t("toast_message.update_success"));
          }
        } else {
          const res = await postSpaceGeneral(params);
          store.commit(
            `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.MUTATIONS.SET_STEP_SPACE_CREATED}`,
            STEP_SPACE_CREATED.images
          );
          router.push(`${ROUTER_PATH.SPACE.IMAGES}?id=${res.rental_space_id}`);
        }
        formIsDirty.value = false;
      } catch (error) {
        if (error?.data) {
          messagesFormError.value = {};
          error?.data.forEach((item) => {
            messagesFormError.value[item.key] = item.messages[0];
          });
        } else {
          toast.error(error.message);
        }
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };

    const initCreate = async () => {
      if (idSpaceCreated && isCreated) {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        try {
          const res = await getDetailSpaceGeneral(idSpaceCreated);
          if (res?.data) {
            mapData(formData, res.data);
          }
        } catch (errors) {
          const error = errors.message || t("common.has_error");
          toast.error(error);
        }
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
      store.dispatch(
        `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.ACTIONS.SET_ACTIVE}`,
        STEP_CREATE_SPACE.GENERAL
      );
    };

    const initUpdate = async () => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const id = route.params.id;
        const res = await getDetailSpaceGeneral(id);

        if (res?.data) {
          mapData(formData, res.data);
          statusValue.value = res.data.status;
        }
        store.commit(
          `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.MUTATIONS.SET_NAME_SPACE}`,
          res.data.general_basic_space_name_ja
        );
      } catch (error) {
        toast.error(error.message);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    const handleUpdateBasicInfo = (val) => {
      formData.general_basic_space_introduction = val.general_basic_space_introduction;
      formData.general_basic_space_name_ja = val.general_basic_space_name_ja;
      formData.general_basic_space_name_kana = val.general_basic_space_name_kana;
      formData.general_basic_space_overview = val.general_basic_space_overview;
      formData.general_basic_space_purpose_of_uses = val.general_basic_space_purpose_of_uses.map((item) => ({
        mainCategory: item.main_category,
        subCategory: item.sub_category,
        title_ja: item.title_ja,
      }));
    };

    const handleAddCancellation = () => {
      formData.general_space_information_cancellation_fee_rules.push({
        startDay: null,
        endDay: null,
        isCouponApplicable: false,
        percentage: 0,
      });
    };

    switch (props.actionType) {
      case ACTIONS_TYPE.UPDATE:
        await initUpdate();
        break;
      case ACTIONS_TYPE.CREATE:
        await initCreate();
        break;
      default:
        break;
    }

    return {
      handleSubmit,
      formData,
      inputAddress,
      ACTIONS_TYPE,
      messagesFormError,
      handleUpdateBasicInfo,
      handleAddCancellation,
      isCancellationErr,
      id,
      statusValue,
      formIsDirty
    };
  },
};
</script>

<style scoped></style>
