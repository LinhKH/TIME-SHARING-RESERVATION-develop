<template>
  <Form v-slot="{ values }" :class="!isAdding && 'mt-5'">
    <div class="text-[18px] font-bold">{{ $t("add_tracking_link.add_tracking_link") }}</div>
    <LayoutInput customCss="mt-5" :labelText="$t('add_tracking_link.tracking_url_name')" :isRequired="true">
      <Field
        type="text"
        name="name"
        :rules="requiredRule"
        class="border border-solid border-[#ddd] rounded shadow-inner focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 h-9 outline-none px-2 w-[336px] max-w-full"
      />
      <ErrorMessage name="name" class="text-[red] block mt-2" />
      <div class="my-3 text-[#737373]">
        {{ $t("add_tracking_link.the_name_url") }}
      </div>
      <div>{{ $t("add_tracking_link.save_button") }}</div>
    </LayoutInput>
    <div class="w-fit mx-auto mt-2">
      <button class="p-2 rounded-xl text-white bg-[#898989] mr-2" @click="handleBack">{{ $t("common.return") }}</button>
      <button class="p-2 rounded text-white bg-[#ffbd00]" @click="(event) => handleCreateTrackingLink(values, event)">
        {{ $t("common.keep") }}
      </button>
    </div>
  </Form>
</template>

<script>
import { useStore } from "vuex";
import { MODULE_STORE, STEP_CREATE_SPACE, ROUTER_PATH, STEP_EDIT_SPACE } from "@/const";
import LayoutInput from "@/components/Layouts/LayoutInput.vue";
import { postTrackingLink } from "@/api";
import { useRoute, useRouter } from "vue-router";
import { inject } from "vue";
import { useI18n } from "vue-i18n";
import { Field, Form, ErrorMessage } from "vee-validate";
import * as yup from "yup";

export default {
  name: "AddTrackLink",
  props: {
    isAdding: {
      type: Boolean,
      default: false,
    },
  },
  components: { LayoutInput, Field, Form, ErrorMessage },
  setup(props) {
    const store = useStore();
    const route = useRoute();
    const router = useRouter();
    const id = route.params.id;
    const toast = inject("$toast");
    const { t } = useI18n();

    const requiredRule = yup.string().required("This is a required field");

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
    const handleBack = () => {
      if (props.isAdding) {
        router.push(`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}/${ROUTER_PATH.SPACE.TRACKING_LINK}/${id}`);
      } else {
        router.push(
          `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}/${ROUTER_PATH.RENTAL_PLAN}/${ROUTER_PATH.SPACE.BOOKING_SYSTEM_ADVANCED_SETTINGS}/${id}`
        );
      }
    };
    const handleCreateTrackingLink = async (values, event) => {
      event.preventDefault();
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const params = {
          name: values.name,
          type: "1",
        };
        await postTrackingLink(id, params);
        handleBack();
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    return { handleCreateTrackingLink, requiredRule, handleBack };
  },
};
</script>

<style lang="scss" scoped></style>
