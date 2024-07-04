<template>
  <LayoutInput customCss="mt-3" :labelText="$t('setting_email.email_type')">
    <input
      type="text"
      v-model.trim="formData.email_type"
      class="px-2 border border-solid border-[#ddd] shadow-inner rounded w-[650px] max-w-full h-9 outline-none"
      :disabled="!!idEmailTemplate"
    />
    <MessagesForm v-if="error.email_type" :messages="error.email_type" />
  </LayoutInput>
  <LayoutInput customCss="mt-3" iconPrev="flag en mr-1" :labelText="$t('setting_email.email_type1')">
    <input
      v-model.trim="formData1.email_subject_en"
      type="text"
      class="px-2 border border-solid border-[#ddd] shadow-inner rounded w-full h-9 outline-none"
    />
    <MessagesForm v-if="error.email_subject_en" :messages="error.email_subject_en" />
  </LayoutInput>
  <LayoutInput customCss="mt-3" iconPrev="flag ja mr-1" :labelText="$t('setting_email.email_type1')">
    <input
      v-model.trim="formData.email_subject_jp"
      type="text"
      class="px-2 border border-solid border-[#ddd] shadow-inner rounded w-full h-9 outline-none"
    />
    <MessagesForm v-if="error.email_subject_jp" :messages="error.email_subject_jp" />
  </LayoutInput>
  <LayoutInput customCss="mt-3" iconPrev="flag en mr-1" :labelText="$t('setting_email.content')">
    <ChkEditor :formData1="formData1" name="content_en" />
    <MessagesForm v-if="error.content_en" :messages="error.content_en" />
  </LayoutInput>
  <LayoutInput customCss="mt-3" iconPrev="flag ja mr-1" :labelText="$t('setting_email.content')">
    <ChkEditor :formData="formData" name="content_jp" :isRequired="true" />
    <MessagesForm v-if="error.content_jp" :messages="error.content_jp" />
  </LayoutInput>

  <LayoutInput customCss="mt-3" iconPrev="flag en mr-1" :labelText="$t('setting_email.memo')">
    <input
      type="text"
      class="px-2 border border-solid border-[#ddd] shadow-inner rounded w-full h-9 outline-none"
      v-model.trim="formData1.memo_en"
    />
    <MessagesForm v-if="error.memo_en" :messages="error.memo_en" />
  </LayoutInput>
  <LayoutInput customCss="mt-3" iconPrev="flag ja mr-1" :labelText="$t('setting_email.memo')">
    <input
      type="text"
      class="px-2 border border-solid border-[#ddd] shadow-inner rounded w-full h-9 outline-none"
      v-model.trim="formData1.memo_jp"
    />
    <MessagesForm v-if="error.memo_jp" :messages="error.memo_jp" />
  </LayoutInput>
</template>

<script>
import LayoutInput from "@/components/Layouts/LayoutInput.vue";
import ChkEditor from "@/components/Setting/ChkEditor";
import MessagesForm from "@/components/MessagesForm";

export default {
  name: "FormSettingEmail",
  components: { LayoutInput, ChkEditor, MessagesForm },
  props: { formData: Object, formData1: Object, error: Object, idEmailTemplate: Number },
};
</script>
