<template>
  <Form v-slot="{ handleSubmit }">
    <div class="text-[18px] mt-5">{{ $t("system_group_add.create_a_plan_group") }}</div>
    <LayoutInput
      customCss="mt-5"
      :isRequired="true"
      iconPrev="fa fa-font mr-1"
      :labelText="$t('system_group_add.group_name')"
    >
      <div class="w-full h-9 rounded border border-solid border-[#ddd] flex shadow-inner">
        <div class="w-11 h-full border-r border-solid border-[#ddd] flex items-center justify-center bg-[#eee]">
          <img :src="JapanIcon" alt="" />
        </div>

        <Field
          type="text"
          class="flex-1 h-full outline-none px-2 focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50"
          name="plan_group_name"
          :rules="isRequired"
        />
      </div>
      <ErrorMessage name="plan_group_name" class="text-[red] mt-1 block" />
      <div class="text-[#737373] mt-2">
        {{ $t("system_group_add.please_give") }}
      </div>
    </LayoutInput>

    <LayoutInput customCss="mt-5" :labelText="$t('system_group_add.rate_plan')">
      <div
        class="w-full h-9 rounded border border-solid border-[#ddd] flex mb-2 shadow-inner"
        v-for="(item, index) in listPlan"
        :key="index"
      >
        <div class="w-11 h-full border-r border-solid border-[#ddd] flex items-center justify-center bg-[#eee]">
          <input
            type="checkbox"
            :value="item.id"
            v-model="formData.rental_plan_ids"
            :id="`${item.plan_name}_${item.id}`"
          />
        </div>
        <label :for="`${item.plan_name}_${item.id}`" class="flex-1 h-full ml-1 leading-9 select-none font-bold">
          {{ item.plan_name }}
        </label>
      </div>
    </LayoutInput>
    <button
      class="text-white p-2 bg-[#ffbd00] rounded hover:translate-y-1 mx-auto block mt-2"
      @click="handleSubmit($event, handleCreateGroup)"
    >
      {{ $t("common.keep") }}
    </button>
  </Form>
</template>

<script>
import LayoutInput from "@/components/Layouts/LayoutInput.vue";
import JapanIcon from "@/assets/images/japan.png";
import { MODULE_STORE, STEP_EDIT_SPACE, ROUTER_PATH } from "@/const";
import { useStore } from "vuex";
import { getListPlan, createGroup } from "@/api";
import { useI18n } from "vue-i18n";
import { inject, ref, reactive } from "vue";
import { useRoute, useRouter } from "vue-router";
import { Field, Form, ErrorMessage } from "vee-validate";
import * as yup from "yup";

export default {
  name: "SystemGroupAdd",
  components: { LayoutInput, Field, Form, ErrorMessage },
  setup() {
    const store = useStore();
    const { t } = useI18n();
    const toast = inject("$toast");
    const route = useRoute();
    const router = useRouter();
    const idSpace = route.params.id || route.query.id;
    const listPlan = ref([]);
    const formData = reactive({
      rental_plan_ids: [],
    });

    const handleCreateGroup = async (values) => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const params = {
          plan_group_name: values.plan_group_name,
          ...formData,
        };
        await createGroup(idSpace, params);
        router.push(
          `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}/${ROUTER_PATH.RENTAL_PLAN}/${ROUTER_PATH.SPACE.GROUP_MANAGE}/${idSpace}`
        );
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    const initData = async () => {
      store.dispatch(
        `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.ACTIONS.SET_ACTIVE_EDIT}`,
        STEP_EDIT_SPACE.RESERVATION_SYSTEM
      );
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const res = await getListPlan(idSpace);
        listPlan.value = res?.rentalPlan;
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    const isRequired = yup.string().required(t("validation.required"));
    initData();
    return { JapanIcon, listPlan, formData, handleCreateGroup, isRequired };
  },
};
</script>

<style scoped></style>