<template>
  <div v-if="formData">
    <div class="flex">
      <div class="w-[260px] font-[700] text-[12px]">
        <i class="fa fa-book"></i>
        {{ $t(`form_setting.title.reservation_setting`) }}
      </div>
      <div class="flex-1">
        <div class="mb-3">
          <InputGroup
            icon="fa fa-list"
            :label="$t(`form_setting.maximum_rate_plans`)"
            :subText="$t(`form_setting.sub_text.maximum_rate_plans`)"
            width="25%"
            :value="formData.max_rental_plans_count"
            model="max_rental_plans_count"
            @onInput="setDataForm"
          />
        </div>
        <div class="mb-3">
          <InputGroup
            icon="fa fa-list"
            :label="$t(`form_setting.maximum_rental_hours`)"
            :subText="$t(`form_setting.sub_text.maximum_rental_hours`)"
            width="25%"
            :value="formData.max_rental_plan_intervals_count"
            model="max_rental_plan_intervals_count"
            @onInput="setDataForm"
          />
        </div>
        <div class="mb-3">
          <InputGroup
            icon="fa fa-globe"
            :label="$t(`form_setting.details_link`)"
            :subText="$t(`form_setting.sub_text.details_link`)"
            type="text"
            width="100%"
            :value="formData.booking_system_information_link"
            model="booking_system_information_link"
            @onInput="setDataForm"
          />
        </div>
        <div class="flex flex-col gap-1 mb-3">
          <InputGroup
            icon="fa fa-percent"
            :label="$t(`form_setting.percent_1`)"
            width="15%"
            :tag="$t(`form_setting.tag.percent_1`)"
            :value="formData.handling_fee_percentage"
            model="handling_fee_percentage"
            @onInput="setDataForm"
          />
          <InputGroup
            icon="fa fa-percent"
            :label="$t(`form_setting.percent_2`)"
            width="15%"
            :tag="$t(`form_setting.tag.percent_2`)"
            :value="formData.cc_charging_fee_percentage"
            model="cc_charging_fee_percentage"
            @onInput="setDataForm"
          />
          <InputGroup
            icon="fa fa-list"
            :label="$t(`form_setting.approval_deadline`)"
            :subText="$t(`form_setting.sub_text.approval_deadline`)"
            width="25%"
            :tag="$t(`form_setting.tag.approval_deadline`)"
            :value="formData.reservation_requests_confirmation_timeout"
            model="reservation_requests_confirmation_timeout "
            @onInput="setDataForm"
          />
        </div>
        <div class="mb-3">
          <InputGroup
            icon="fa fa-list"
            :label="$t(`form_setting.approval_alert_email_1`)"
            :subText="$t(`form_setting.sub_text.approval_alert_email_1`)"
            type="number"
            width="25%"
            :tag="$t(`form_setting.tag.approval_alert_email_1`)"
            :value="formData.reservation_requests_first_confirmation_reminder_sending_time"
            model="reservation_requests_first_confirmation_reminder_sending_time"
            @onInput="setDataForm"
          />
        </div>
        <div class="mb-3">
          <InputGroup
            icon="fa fa-list"
            :label="$t(`form_setting.approval_alert_email_2`)"
            :subText="$t(`form_setting.sub_text.approval_alert_email_2`)"
            type="number"
            width="25%"
            :tag="$t(`form_setting.tag.approval_alert_email_2`)"
            :value="formData.reservation_requests_second_confirmation_reminder_sending_time"
            model="reservation_requests_second_confirmation_reminder_sending_time"
            @onInput="setDataForm"
          />
        </div>
        <div class="mb-3">
          <InputGroup
            icon="fa fa-list"
            :label="$t(`form_setting.reservation_reminder_email`)"
            :subText="$t(`form_setting.sub_text.reservation_reminder_email`)"
            type="number"
            width="25%"
            :tag="$t(`form_setting.tag.remind_email`)"
            :value="formData.space_usage_reminder_sending_hour"
            model="space_usage_reminder_sending_hour"
            @onInput="setDataForm"
          />
        </div>
        <div class="mb-3">
          <InputGroup
            icon="fa fa-list"
            :label="$t(`form_setting.space_id`)"
            :subText="$t(`form_setting.sub_text.space_id`)"
            type="text"
            :value="formData.exclude_space_ids_initial_value"
            model="exclude_space_ids_initial_value"
            @onInput="setDataForm"
          />
        </div>
      </div>
    </div>
    <div class="flex flex-col mt-2">
      <div class="mb-3">
        <InputGroup
          icon="fa fa-star"
          :label="$t(`form_setting.remind_mail_sending`)"
          :subText="$t(`form_setting.sub_text.remind_mail_sending`)"
          min="0"
          type="number"
          width="25%"
          :tag="$t(`form_setting.tag.remind_mail_sending`)"
          :value="formData.inquiry_reminder_for_not_respond_yet_hours"
          model="inquiry_reminder_for_not_respond_yet_hours"
          @onInput="setDataForm"
        />
      </div>
      <div class="mb-3">
        <InputGroup
          icon="fa fa-star"
          :label="$t(`form_setting.auto_denial_time`)"
          :subText="$t(`form_setting.sub_text.auto_denial_time`)"
          type="number"
          width="25%"
          :tag="$t(`form_setting.tag.auto_denial_time`)"
          :value="formData.tour_request_denial_period"
          model="tour_request_denial_period"
          @onInput="setDataForm"
        />
      </div>
      <div class="mb-3">
        <TextArea
          icon="fa fa-google"
          :label="$t(`form_setting.tracking_code_analytics`)"
          :subText="$t(`form_setting.sub_text.tracking_code_analytics`)"
          :value="formData.frontend_tracking_code_html"
          model="frontend_tracking_code_html"
          @onInput="setDataForm"
        />
      </div>
      <div class="mb-3">
        <TextArea
          icon="fa fa-google"
          :label="$t(`form_setting.tracking_code_management`)"
          :subText="$t(`form_setting.sub_text.tracking_code_management`)"
          :value="formData.backend_tracking_code_html"
          model="backend_tracking_code_html"
          @onInput="setDataForm"
        />
      </div>
    </div>
    <div class="flex justify-between">
      <div class="w-[260px] font-[700] text-[12px]">
        <i class="fa fa-clock-o"></i>
        {{ $t(`form_setting.title.concierge_available_hours`) }}
      </div>
      <div class="flex-1">
        <!-- for in 7 => render 7 row timepicker -->
        <div v-for="(item, index) in constructorWeek" :key="index" class="flex flex-wrap pr-[20%]">
          <div class="mb-1 w-[50%]">
            <TimePickerCustomer
              :label="$t(`form_setting.${item.start}`)"
              type="text"
              gap="20%"
              :value="formData[item.start]"
              :model="item.start"
              @onInput="setDataForm"
            />
          </div>
          <div class="mb-1 w-[50%]">
            <TimePickerCustomer
              :label="$t(`form_setting.end_time`)"
              type="text"
              gap="20%"
              :value="formData[item.end]"
              :model="item.end"
              @onInput="setDataForm"
            />
          </div>
        </div>
      </div>
    </div>
    <div class="flex mt-2">
      <div class="w-[260px] font-[700] text-[12px]">
        <i class="fa fa-clock-o"></i>
        {{ $t(`form_setting.title.tentative_reservation_setting`) }}
      </div>
      <div class="flex-1">
        <div class="mb-3">
          <InputGroup
            icon="fa fa-list"
            :label="$t(`form_setting.reservation_deadline`)"
            :subText="$t(`form_setting.sub_text.reservation_deadline`)"
            type="number"
            width="25%"
            :tag="$t(`form_setting.tag.reservation_deadline`)"
            :value="formData.allowed_days_ahead"
            model="allowed_days_ahead"
            @onInput="setDataForm"
          />
        </div>
        <div class="mb-3">
          <InputGroup
            icon="fa fa-list"
            :label="$t(`form_setting.cancel_deadline`)"
            :subText="$t(`form_setting.sub_text.cancel_deadline`)"
            type="number"
            width="25%"
            :tag="$t(`form_setting.tag.cancel_deadline`)"
            :value="formData.due_days_cancel"
            model="due_days_cancel"
            @onInput="setDataForm"
          />
        </div>

        <div class="mb-3">
          <InputGroup
            icon="fa fa-list"
            :label="$t(`form_setting.tentative_reservation`)"
            :subText="$t(`form_setting.sub_text.tentative_reservation`)"
            type="number"
            width="25%"
            :tag="$t(`form_setting.tag.tentative_reservation`)"
            :value="formData.months_as_longterm"
            model="months_as_longterm"
            @onInput="setDataForm"
          />
        </div>
        <div class="mb-3">
          <InputGroup
            icon="fa fa-list"
            :label="$t(`form_setting.number_month_cancel`)"
            :subText="$t(`form_setting.sub_text.number_month_cancel`)"
            type="number"
            width="25%"
            :tag="$t(`form_setting.tag.number_month_cancel`)"
            :value="formData.due_months_cancel"
            model="due_months_cancel"
            @onInput="setDataForm"
          />
        </div>
        <div class="mb-3">
          <InputGroup
            icon="fa fa-list"
            :label="$t(`form_setting.cancel_notice_day`)"
            :subText="$t(`form_setting.sub_text.cancel_notice_day`)"
            type="number"
            width="25%"
            :tag="$t(`form_setting.tag.cancel_notice_day`)"
            :value="formData.days_notify_cancelation"
            model="days_notify_cancelation"
            @onInput="setDataForm"
          />
        </div>
      </div>
    </div>
    <div class="flex justify-center my-3">
      <button class="px-3 py-2 bg-[#ffbd00] text-white block rounded-lg" @click="submitForm">
        {{ $t(`form_setting.button_text`) }}
      </button>
    </div>
  </div>
</template>
<script>
import { ref, inject } from "vue";
import InputGroup from "./child/InputGroup.vue";
import TextArea from "./child/TextArea.vue";
import TimePickerCustomer from "./child/TimePickerCustomer.vue";
import { getFormSettingFromApi, updateFormSetting } from "@/api";
import { useI18n } from "vue-i18n";

export default {
  components: {
    InputGroup,
    TextArea,
    TimePickerCustomer,
  },

  setup() {
    const toast = inject("$toast");
    const formData = ref(null);
    const { t } = useI18n();
    const constructorWeek = [
      { start: "start_monday", end: "end_monday" },
      { start: "start_tuesday", end: "end_tuesday" },
      { start: "start_wednesday", end: "end_wednesday" },
      { start: "start_thursday", end: "end_thursday" },
      { start: "start_friday", end: "end_friday" },
      { start: "start_saturday", end: "start_saturday" },
      { start: "start_sunday", end: "end_sunday" },
    ];
    const setDataForm = ({ key, value }) => {
      if (formData.value.hasOwnProperty(key)) {
        formData.value[key] = value;
        return;
      }
    };
    const getFormSetting = async () => {
      try {
        const response = await getFormSettingFromApi();
        formData.value = response;
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      }
    };
    getFormSetting();
    const submitForm = async () => {
      try {
        await updateFormSetting(formData.value);
        await getFormSetting();
        toast.success("保存しました。");
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      }
    };
    return {
      formData,
      setDataForm,
      submitForm,
      constructorWeek,
    };
  },
};
</script>
