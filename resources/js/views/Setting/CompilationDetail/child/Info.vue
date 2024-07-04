<template>
  <Form :validation-schema="schema" v-slot="{ handleSubmit }" :initial-values="formValues">
    <LayoutInput :labelText="$t('compilation_setting.effectiveness')">
      <InputRadio
        :optionProps="optionEffectiveness"
        :modelValue="formData.active"
        @update:modelValue="(newValue) => (formData.active = newValue)"
      ></InputRadio>
    </LayoutInput>

    <LayoutInput :isRequired="true" :labelText="$t('compilation_setting.access_key')">
      <Field
        type="text"
        name="access_key"
        class="px-2 w-full h-9 outline-none focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 transition-all shadow-inner rounded border border-solid border-[#ddd]"
      />
      <ErrorMessage class="text-[red] mt-1 block" name="access_key" />
      <MessagesFormError v-if="messagesFormError?.access_key" :messages="messagesFormError.access_key" />
      <span class="text-[red] mt-1 block" v-if="isShowErrorRegex">アクセスキーが無効です。</span>
    </LayoutInput>

    <LayoutInput :isRequired="true" :labelText="$t('compilation_setting.title')">
      <Field
        type="text"
        name="title_ja"
        class="px-2 w-full h-9 outline-none focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 transition-all shadow-inner rounded border border-solid border-[#ddd]"
      />
      <ErrorMessage class="text-[red] mt-1 block" name="title_ja" />
      <MessagesFormError v-if="messagesFormError?.title_ja" :messages="messagesFormError.title_ja" />
    </LayoutInput>

    <LayoutInput :isRequired="true" :labelText="$t('compilation_setting.use')">
      <InputRadio
        :optionProps="optionUse"
        :modelValue="formData.use_purpose_category"
        @update:modelValue="(newValue) => (formData.use_purpose_category = newValue)"
      ></InputRadio>
    </LayoutInput>

    <LayoutInput :isRequired="true" :labelText="$t('compilation_setting.subtitle')">
      <Field
        type="text"
        name="subtitle_ja"
        class="px-2 w-full h-9 outline-none focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 transition-all shadow-inner rounded border border-solid border-[#ddd]"
      />
      <ErrorMessage class="text-[red] mt-1 block" name="subtitle_ja" />
      <MessagesFormError v-if="messagesFormError?.subtitle_ja" :messages="messagesFormError.subtitle_ja" />
    </LayoutInput>

    <LayoutInput :labelText="$t('compilation_setting.catchphrase')">
      <textarea
        type="text"
        class="px-2 w-full h-16 outline-none focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 transition-all shadow-inner rounded border border-solid border-[#ddd] resize-none"
        v-model="formData.catch_ja"
      />
    </LayoutInput>

    <LayoutInput :labelText="$t('compilation_setting.wrap_up')" :isRequired="true">
      <Field name="summary_ja" v-slot="{ field }">
        <textarea
          type="textarea"
          v-bind="field"
          class="px-2 w-full h-16 outline-none focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 transition-all shadow-inner rounded border border-solid border-[#ddd] resize-none"
        />
      </Field>
      <ErrorMessage class="text-[red] mt-1 block" name="summary_ja" />
      <MessagesFormError v-if="messagesFormError?.summary_ja" :messages="messagesFormError.summary_ja" />
    </LayoutInput>

    <LayoutInput :labelText="$t('compilation_setting.area')">
      <select
        v-model="formData.area_id"
        class="h-9 bg-white rounded border border-solid border-[#ddd] px-2 outline-none"
      >
        <option disabled value="">都道府県を選択してください。（東京23区の場合は区名）</option>
        <option :value="item.value" v-for="(item, index) in optionArea" :key="index">{{ item.label }}</option>
      </select>
    </LayoutInput>

    <LayoutInput :labelText="$t('compilation_setting.final_update')">
      <div class="inline-flex border border-solid border-[#ddd] max-w-full rounded">
        <div class="bg-[#eee] w-[40px] border-r border-solid border-[#ddd] flex items-center justify-center">
          <i class="fa fa-calendar"></i>
        </div>
        <Datepicker
          class="px-2 h-8 outline-none text-center cursor-pointer shadow-inner"
          v-model="formData.last_update"
          :upperLimit="dateChoice"
        />
      </div>
    </LayoutInput>

    <LayoutInput :labelText="$t('compilation_setting.meta_keyword')">
      <textarea
        type="text"
        v-model="formData.meta_keywords"
        class="px-2 w-full h-16 outline-none focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 transition-all shadow-inner rounded border border-solid border-[#ddd] resize-none"
      />
    </LayoutInput>

    <LayoutInput :labelText="$t('compilation_setting.meta_information')">
      <textarea
        type="text"
        v-model="formData.meta_description"
        class="px-2 w-full h-16 outline-none focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50 transition-all shadow-inner rounded border border-solid border-[#ddd] resize-none"
      />
    </LayoutInput>

    <LayoutInput
      :labelText="$t('compilation_setting.space_id', { id: index + 1 })"
      v-for="(item, index) in Object.keys(formData.rental_space_id)"
      :key="index"
    >
      <div class="inline-flex border border-solid border-[#ddd] w-full rounded">
        <div class="bg-[#eee] w-[40px] border-r border-solid border-[#ddd] flex items-center justify-center">
          <i class="fa fa-search"></i>
        </div>
        <input
          type="text"
          class="w-full h-9 border border-solid border-transparent outline-none px-2 shadow-inner focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50"
          :placeholder="$t('compilation_setting.placeholder')"
          v-model="formData.rental_space_id[item]"
        />
      </div>
    </LayoutInput>

    <button
      class="block bg-[#FFBD00] p-2 rounded"
      @click="(event) => handleAddField(event, Object.keys(formData.rental_space_id).length)"
    >
      <i class="fa fa-plus text-white mr-1" aria-hidden="true"></i>
      <span class="text-white"> {{ $t("compilation_setting.add_space") }} </span>
    </button>

    <button
      class="block mx-auto mt-2 p-2 bg-[#ffbd00] rounded text-white"
      @click="handleSubmit($event, handleSubmitForm)"
    >
      {{ $t("common.keep") }}
    </button>
  </Form>
</template>

<script>
import LayoutInput from "@/components/Layouts/LayoutInput.vue";
import InputRadio from "@/components/Form/InputRadio.vue";
import { reactive, ref, inject, watch } from "vue";
import Datepicker from "vue3-datepicker";
import { optionUse, optionArea, optionEffectiveness } from "@/const/options";
import { MODULE_STORE } from "@/const";
import { Form, Field, ErrorMessage } from "vee-validate";
import * as yup from "yup";
import { useI18n } from "vue-i18n";
import moment from "moment";
import { useStore } from "vuex";
import { createSettingSummary, updateSummary } from "@/api";
import { useRoute } from "vue-router";
import MessagesFormError from "@/components/MessagesForm";
import { handleBack } from "@/utils";

export default {
  name: "Info",
  components: { LayoutInput, InputRadio, Datepicker, Form, Field, ErrorMessage, MessagesFormError },
  props: { isUpdate: Boolean, formDataInfo: Object },
  setup(props) {
    const { t } = useI18n();
    const messagesFormError = ref();
    const toast = inject("$toast");
    const store = useStore();
    const route = useRoute();
    const dateChoice = new Date();
    const idCompilation = route.query.idSummary;
    const isShowErrorRegex = ref();
    const formData = reactive({
      active: null,
      use_purpose_category: null,
      catch_ja: null,
      area_id: null,
      last_update: null,
      meta_keywords: null,
      meta_description: null,
      rental_space_id: {},
    });
    const formValues = reactive({
      access_key: null,
      title_ja: null,
      subtitle_ja: null,
      summary_ja: null,
    });
    const mapData = () => {
      formData.active = props.formDataInfo.active;
      formData.use_purpose_category = props.formDataInfo.use_purpose_category;
      formData.catch_ja = props.formDataInfo.catch_ja;
      formData.area_id = props.formDataInfo.area_id;
      formData.last_update = props.formDataInfo.last_update;
      formData.meta_keywords = props.formDataInfo.meta_keywords;
      formData.meta_description = props.formDataInfo.meta_description;
      if (Object.keys(props.formDataInfo.rental_space_id).length == 0) {
        formData.rental_space_id = {
          rental_space_ids__1: "",
        };
      } else {
        formData.rental_space_id = props.formDataInfo.rental_space_id;
      }
      formValues.access_key = props.formDataInfo.access_key;
      formValues.title_ja = props.formDataInfo.title_ja;
      formValues.subtitle_ja = props.formDataInfo.subtitle_ja;
      formValues.summary_ja = props.formDataInfo.summary_ja;
    };
    watch(
      () => props.formDataInfo,
      () => {
        mapData();
      },
      { immediate: true }
    );
    const handleAddField = (event, index) => {
      event.preventDefault();
      formData.rental_space_id[`rental_space_ids__${index + 1}`] = "";
    };

    // const formatKey = () => {
    //   const regex = "^[a-zA-Z0-9]*$";
    //   if (string.match(regex)) {
    //     return false;
    //   } else {
    //     return true;
    //   }
    // };

    const handleSubmitForm = async (value) => {
      const firstKeyRentalSpaceId = Object.keys(formData.rental_space_id)[0];
      if (Object.keys(formData.rental_space_id).length == 1 && !formData.rental_space_id[firstKeyRentalSpaceId]) {
        formData.rental_space_id = {};
      }
      // if (formatKey(value.access_key) === true) {
      //   isShowErrorRegex.value = true;
      //   return;
      // }
      const params = {
        ...value,
        ...formData,
        last_update: moment(formData.last_update).format("MM/DD/YYYY"),
      };
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        if (props.isUpdate && idCompilation) {
          await updateSummary(idCompilation, params);
        } else {
          await createSettingSummary(params);
        }
        handleBack();
      } catch (errors) {
        if (errors?.data) {
          messagesFormError.value = {};
          errors.data.forEach((item) => {
            messagesFormError.value[item.key] = item.messages[0];
          });
        } else {
          const error = errors.message || t("common.has_error");
          toast.error(error);
        }
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    const schema = yup.object({
      access_key: yup.string().required(t("validation.required").trim()),
      title_ja: yup.string().required(t("validation.required").trim()),
      subtitle_ja: yup.string().required(t("validation.required").trim()),
      summary_ja: yup.string().required(t("validation.required").trim()),
    });
    return {
      handleSubmitForm,
      optionEffectiveness,
      formData,
      optionUse,
      optionArea,
      handleAddField,
      schema,
      messagesFormError,
      formValues,
      dateChoice,
      isShowErrorRegex,
      // formatKey,
    };
  },
};
</script>
