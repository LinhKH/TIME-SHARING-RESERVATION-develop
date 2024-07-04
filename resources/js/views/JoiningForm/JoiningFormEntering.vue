<template>
  <joining-form-base-layout :alert-message="$t('joining.about-privacy')">
    <json-form
      :definition="definition"
      v-model:contents="contents"
      v-model:errors="errors"
      :serverErrors="serverErrors"
      :meta="meta"
    ></json-form>
    <Button class="apply" rounded @click="apply" :disabled="hasError">
      {{ $t("apply") }}
    </Button>
  </joining-form-base-layout>
  <toast-message type="warning" v-model:show="showValidationErrorMessage" :hide-in="Infinity">
    入力エラーがあります
  </toast-message>
  <toast-message type="error" v-model:show="showSystemErrorMessage" :hide-in="Infinity">
    システムエラーが発生しました
  </toast-message>
</template>

<script lang="ts">
import { computed, defineComponent, PropType, ref, toRefs, watch } from "vue";
import debounce from "just-debounce-it";

import JoiningFormBaseLayout from "@/views/JoiningForm/JoiningFormBaseLayout.vue";
import JsonForm from "@/components/JsonForm/JsonForm.vue";
import Button from "@/components/Buttons/Button.vue";
import ToastMessage from "@/components/Popups/ToastMessage.vue";

import { JSONFormDefinition, JSONFormMetaData } from "@/types/JSONForm";
import { JSONFormContents } from "@/types/JSONFormContents";
import { hasError, JSONFormError, normalizeError } from "@/types/JSONFormError";
import { fromJSONApiResponseErrorBody, JSONFormServerError } from "@/types/JSONFormServerError";
import { showSystemError } from "@/router";
import { putForm } from "@/api/join/form";
import { putFormDraft } from "@/api/join/form-draft";

export default defineComponent({
  components: {
    JoiningFormBaseLayout,
    JsonForm,
    Button,
    ToastMessage,
  },
  emits: ["update:status"],
  props: {
    status: {
      type: String,
      required: true,
    },
    definition: {
      type: Object as PropType<JSONFormDefinition>,
      required: true,
    },
    defaultContents: {
      type: Object as PropType<JSONFormContents>,
      required: true,
    },
    meta: {
      type: Object as PropType<JSONFormMetaData>,
      required: true,
    },
  },
  setup(props, { emit }) {
    const { definition, defaultContents, meta } = toRefs(props);

    const contents = ref<JSONFormContents>(defaultContents.value);
    const errors = ref<JSONFormError>(
      normalizeError(definition.value, contents.value, {}, meta.value, {
        autoValidate: true,
      })
    );
    const serverErrors = ref<JSONFormServerError[]>([]);
    const loading = ref(false);
    const showValidationErrorMessage = ref(false);
    const showSystemErrorMessage = ref(false);

    const debug = (x, label) => console.log(label, JSON.parse(JSON.stringify(x)));

    debug(contents.value, "contents");
    debug(errors.value, "errors");
    debug(serverErrors.value, "server-errors");

    // debug
    watch(contents, (x) => debug(x, "contents"));
    watch(errors, (x) => debug(x, "errors"));
    watch(serverErrors, (x) => debug(x, "server-errors"));

    watch(
      contents,
      debounce(async (contents) => {
        const response = await putFormDraft(meta.value.secureId, contents);

        switch (response.status) {
          case 200:
            break;
          case 404:
            console.error("failed to save this draft unexpectedlly.");
            break;
          default: {
            const check: never = response;
            return check;
          }
        }
      }, 500)
    );

    return {
      loading,
      showValidationErrorMessage,
      showSystemErrorMessage,
      contents,
      errors,
      hasError: computed(() => hasError(errors.value)),
      serverErrors,
      async apply() {
        try {
          loading.value = true;
          showValidationErrorMessage.value = false;
          showSystemErrorMessage.value = false;
          serverErrors.value = [];

          const response = await putForm(meta.value.secureId, contents.value);

          switch (response.status) {
            case 200:
              emit("update:status", "pending");
              break;
            case 400:
              serverErrors.value = fromJSONApiResponseErrorBody(response.data);
              showValidationErrorMessage.value = true;
              break;
            case 404:
              showSystemErrorMessage.value = true;
              console.error("failed to save this draft unexpectedlly.");
              break;
            default: {
              const check: never = response;
              return check;
            }
          }
        } catch (error) {
          showSystemError(error);
        } finally {
          loading.value = false;
        }
      },
    };
  },
});
</script>

<style lang="scss" scoped>
.apply {
  margin: 80px 0;
}
</style>
