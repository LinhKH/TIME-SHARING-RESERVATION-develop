<template>
  <Form v-slot="{ handleSubmit }" :initial-values="formValues">
    <div class="text-[18px] mt-5">{{ $t("system_group_add.edit_plan") }}</div>
    <LayoutInput iconPrev="fa fa-check-circle-o mr-1" :labelText="$t('rental_plan_page.status')" customCss="mt-5">
      <div class="flex w-full">
        <div class="w-1/2 flex border border-solid border-[#ddd] rounded">
          <div class="flex items-center px-4 bg-[#eee] border-r border-solid border-[#ddd]">
            <input type="radio" id="status_rental_plan_1" v-model="detailGroup.status" :value="TYPE_STATUS.ACTIVE" />
          </div>
          <label class="flex-1 p-2" for="status_rental_plan_1">
            <div>
              <i class="fa fa-check mr-1 text-[#3c763d]"></i>
              <span class="text-[#3c763d]">
                {{ $t("system_group_add.effectiveness") }}
              </span>
            </div>
            <div class="mt-2">{{ $t("system_group_add.inventory") }}</div>
          </label>
        </div>
        <div class="w-1/2 flex border border-solid border-[#ddd] rounded">
          <div class="flex items-center px-4 bg-[#eee] border-r border-solid border-[#ddd]">
            <input type="radio" id="status_rental_plan_2" v-model="detailGroup.status" :value="TYPE_STATUS.ARCHIVED" />
          </div>
          <label class="flex-1 p-2" for="status_rental_plan_2">
            <div>
              <i class="fa fa-book mr-1 text-[#8a6d3b]"></i>
              <span class="text-[#8a6d3b]">
                {{ $t("system_group_add.invalid") }}
              </span>
            </div>
            <div class="mt-2">{{ $t("system_group_add.linking") }}</div>
          </label>
        </div>
      </div>
    </LayoutInput>
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
          <input type="checkbox" :value="item.id" v-model="planSelected" :id="`${item.plan_name}_${item.id}`" />
        </div>
        <label :for="`${item.plan_name}_${item.id}`" class="flex-1 h-full ml-1 leading-9 select-none font-bold">
          {{ item.plan_name }}
        </label>
      </div>
    </LayoutInput>
    <button
      class="text-white p-2 bg-[#ffbd00] rounded hover:translate-y-1 mx-auto block mt-2"
      @click="handleSubmit($event, handleEditGroup)"
    >
      {{ $t("common.keep") }}
    </button>
  </Form>
</template>

<script>
import LayoutInput from "@/components/Layouts/LayoutInput.vue";
import JapanIcon from "@/assets/images/japan.png";
import { MODULE_STORE, STEP_EDIT_SPACE, ROUTER_PATH, TYPE_STATUS } from "@/const";
import { useStore } from "vuex";
import { getDetailGroup, getListPlan, updateRentalPlanGroup } from "@/api";
import { useI18n } from "vue-i18n";
import { inject, ref, reactive } from "vue";
import { useRoute, useRouter } from "vue-router";
import { Field, Form, ErrorMessage } from "vee-validate";
import * as yup from "yup";

export default {
  name: "SystemGroupDetail",
  components: { LayoutInput, Field, Form, ErrorMessage },
  setup() {
    const store = useStore();
    const { t } = useI18n();
    const toast = inject("$toast");
    const route = useRoute();
    const router = useRouter();
    const idGroup = route.params.idGroup;
    const idSpace = route.params.id || route.query.id;
    const listPlan = ref([]);
    const detailGroup = ref({});
    const formValues = reactive({
      plan_group_name: "",
    });
    const planSelected = ref([]);

    const handleEditGroup = async (value) => {
      const listPlanUpdate = [];
      planSelected.value.forEach((itemPlanSelected) => {
        const plan = listPlan.value.find((item) => item.id == itemPlanSelected);
        listPlanUpdate.push({
          plan_id: plan.id,
          status: plan.status,
        });
      });
      const params = {
        plan_group_name: value.plan_group_name,
        plan_group_status: detailGroup.value.status,
        plans: listPlanUpdate,
      };

      try {
        await updateRentalPlanGroup(idGroup, params);
        toast.success(t("toast_message.update_success"));
        router.push(
          `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}/${ROUTER_PATH.RENTAL_PLAN}/${ROUTER_PATH.SPACE.GROUP_MANAGE}/${idSpace}`
        );
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      }
      store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
    };

    const initData = async () => {
      store.dispatch(
        `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.ACTIONS.SET_ACTIVE_EDIT}`,
        STEP_EDIT_SPACE.RESERVATION_SYSTEM
      );
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const res = await getDetailGroup(idGroup);
        const listPlanFromApi = await getListPlan(idSpace);
        detailGroup.value = res;
        listPlan.value = listPlanFromApi?.rentalPlan;
        if (res?.rental_plans && res.rental_plans.length > 0) {
          res.rental_plans.forEach((item) => {
            planSelected.value.push(item.plan_id);
          });
        }
        formValues.plan_group_name = res?.plan_group_name;
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    const isRequired = yup.string().required(t("validation.required"));
    initData();
    return { JapanIcon, listPlan, formValues, isRequired, handleEditGroup, planSelected, detailGroup, TYPE_STATUS };
  },
};
</script>

<style></style>
