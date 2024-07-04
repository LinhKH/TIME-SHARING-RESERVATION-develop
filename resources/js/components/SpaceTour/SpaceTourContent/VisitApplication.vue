<template>
  <div class="visit-application mt-[-3px]">
    <div class="bg-[#555]">
      <span class="text-white py-[16.5px] block text-center text-[16.5px]">{{
        $t("space_tour.visit_application")
      }}</span>
    </div>
    <div class="w-[60%] p-[15px] text-center m-auto">
      <h2 class="mb-8 text-[24px] text-[#7f8084] mt-[10px] block">{{ $t("space_tour.city_building") }}</h2>
      <div v-if="!isEmpty(errors)">
        <div class="text-start text-[16px] bg-[#f2dede] p-2.5 mb-[10px]">
          <h1 class="text-[#a94442]">{{ $t("space_tour.error_notification") }}</h1>
        </div>
        <div class="text-start text-[16px] mb-[5px]">
          <p class="text-[#a94442] my-[5px]" v-for="(error, index) in errors" :key="index">{{ error }}</p>
        </div>
      </div>
      <form @submit="submitForm">
        <div v-for="(visitItem, index) in visitApplications" :key="index">
          <InputDate :visitItem="visitItem" v-if="visitItem.type === 'inputDate'" />
          <InputDescript :visitItem="visitItem" v-if="visitItem.type === 'inputDescript'" />
          <InputNumber :visitItem="visitItem" v-if="visitItem.type === 'inputNumber'" />
          <InputSelect :visitItem="visitItem" v-if="visitItem.type === 'inputSelect'" />
        </div>
        <div class="flex items-center justify-around text-[16px] mb-[15px]">
          <div>
            <button class="px-[55px] py-[9px] text-white rounded font-bold bg-[#5cb85c] hover:bg-[#398439]">
              {{ $t("space_tour.success") }}
            </button>
          </div>
        </div>
      </form>
      <span class="text-[16px] text-left">{{ $t("space_tour.request_approved") }}</span>
    </div>
  </div>
</template>
<script>
import { isEmpty } from "lodash";
import InputDate from "./InputDate.vue";
import InputDescript from "./InputDescript.vue";
import InputNumber from "./InputNumber.vue";
import InputSelect from "./InputSelect.vue";
import { useForm } from "vee-validate";
import * as Yup from "yup";
import { useI18n } from "vue-i18n";
export default {
  name: "VisitApplication",
  components: {
    InputDate,
    InputDescript,
    InputNumber,
    InputSelect,
  },
  props: {
    visitApplications: {
      type: Array,
      default: () => [],
    },
    errorList: {
      type: Array,
      default: () => [],
    },
  },
  setup(props, { emit }) {
    const { t } = useI18n();
    const { handleSubmit, errors } = useForm({
      initialValues: {},
      validationSchema: Yup.object().shape({
        inputDescript1: Yup.string().required(t("space_tour.message_date_time")),
        inputDescript2: Yup.string().required(t("space_tour.message_usage_details")),
        inputDescript3: Yup.string().required(t("space_tour.message_check_points")),
        inputNumber1: Yup.number().required(t("space_tour.message_expected_number")).max(1000).min(0),
        inputDate1: Yup.string().required(t("space_tour.message_choose1_time")),
      }),
    });
    const submitForm = handleSubmit(async (values) => {
      // submit form
    });
    return {
      submitForm,
      errors,
      isEmpty,
    };
  },
};
</script>
<style></style>
